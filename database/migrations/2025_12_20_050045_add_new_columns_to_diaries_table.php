<?php

use App\Enums\Privacy;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('diaries', static function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('mood', 30)->nullable()->after('entry');
            $table->string('privacy', 20)->default(Privacy::Private->value)->after('mood');
            $table->boolean('is_featured')->default(false)->after('privacy');
            $table->boolean('allow_comments')->default(true)->after('is_featured');
            $table->unsignedInteger('likes_count')->default(0)->after('allow_comments');
            $table->unsignedInteger('comments_count')->default(0)->after('likes_count');
            $table->unsignedInteger('views_count')->default(0)->after('comments_count');

            $table->index('mood');
            $table->index('privacy');
            $table->index('is_featured');
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('diaries', function (Blueprint $table) {
            $table->dropColumn(['title', 'mood', 'privacy', 'is_featured', 'allow_comments', 'likes_count', 'comments_count', 'views_count']);
        });
    }
};
