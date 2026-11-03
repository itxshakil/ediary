<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Support\Timezone;
use DateTimeZone;
use PHPUnit\Framework\TestCase;

final class TimezoneTest extends TestCase
{
    /**
     * Linux system tzdata lists entries like "leapseconds" that DateTimeZone refuses to open,
     * which crashed the hourly reminder run. Windows PHP never lists them, so this only bites on Linux.
     */
    public function test_every_listed_zone_can_be_opened(): void
    {
        $zones = Timezone::identifiers();

        foreach ($zones as $zone) {
            new DateTimeZone($zone);
        }

        $this->assertContains('Asia/Kolkata', $zones);
    }

    public function test_a_browser_zone_that_cannot_be_opened_is_dropped(): void
    {
        $this->assertNull(Timezone::fromBrowser('leapseconds'));
        $this->assertSame('Europe/Paris', Timezone::fromBrowser('Europe/Paris'));
    }
}
