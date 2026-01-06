<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Profile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

final class MigrateProfileImagesFromS3 extends Command
{
    protected $signature = 'media:migrate-profile-images
        {--dry-run : Do not copy or delete anything}
        {--delete-missing : Set DB image to null if file missing on S3}
        {--delete-s3 : Delete S3 object only after local verification}';

    protected $description = 'Migrate profile images from S3 to local public storage with verification and safe cleanup';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $deleteMissing = (bool) $this->option('delete-missing');
        $deleteS3 = (bool) $this->option('delete-s3');

        $this->info('🚀 Starting profile image migration');
        $this->info($dryRun ? '🧪 DRY-RUN mode' : '🔥 LIVE mode');

        $profiles = Profile::query()
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->cursor();

        $migrated = 0;
        $missing = 0;
        $deleted = 0;
        $skipped = 0;

        DB::beginTransaction();

        try {
            foreach ($profiles as $profile) {
                $path = $profile->getRawOriginal('image');

                if (! is_string($path)) {
                    $skipped++;

                    continue;
                }

                if (! Storage::disk('s3')->exists($path)) {
                    $missing++;
                    $this->warn("❌ Missing on S3: {$path}");

                    if ($deleteMissing && ! $dryRun) {
                        $profile->update(['image' => null]);
                    }

                    continue;
                }

                if (! Storage::disk('public')->exists($path)) {
                    if (! $dryRun) {
                        $stream = Storage::disk('s3')->readStream($path);
                        Storage::disk('public')->put($path, $stream);

                        if (is_resource($stream)) {
                            fclose($stream);
                        }
                    }

                    $this->info("📦 Copied: {$path}");
                } else {
                    $this->line("✔ Already local: {$path}");
                }

                $s3Size = Storage::disk('s3')->size($path);
                $localSize = Storage::disk('public')->size($path);

                if ($s3Size !== $localSize) {
                    $this->error("⚠ Size mismatch, skipping delete: {$path}");

                    continue;
                }

                if ($deleteS3) {
                    if ($dryRun) {
                        $this->comment("🧪 Would delete S3: {$path}");
                    } else {
                        Storage::disk('s3')->delete($path);
                        $this->warn("🗑 Deleted from S3: {$path}");
                        $deleted++;
                    }
                }

                $migrated++;
            }

            if ($dryRun) {
                DB::rollBack();
                $this->comment('🧪 Dry-run complete — no changes persisted.');
            } else {
                DB::commit();
                $this->info('✅ Migration completed successfully.');
            }
        } catch (Throwable $e) {
            DB::rollBack();
            $this->error('💥 Migration failed: ' . $e->getMessage());

            return self::FAILURE;
        }

        $this->table(
            ['Metric', 'Count'],
            [
                ['Migrated', $migrated],
                ['Missing on S3', $missing],
                ['Deleted from S3', $deleted],
                ['Skipped', $skipped],
            ],
        );

        return self::SUCCESS;
    }
}
