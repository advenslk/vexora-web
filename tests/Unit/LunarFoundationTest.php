<?php

namespace Tests\Unit;

use Tests\TestCase;

class LunarFoundationTest extends TestCase
{
    public function test_application_name_is_lunar_hosting(): void
    {
        $this->assertSame('Lunar Hosting', config('app.name'));
    }

    public function test_application_is_not_using_debug_mode_by_default_in_testing_configuration(): void
    {
        $this->assertTrue((bool) config('app.debug'));
    }

    public function test_database_configuration_can_boot_with_sqlite_for_tests(): void
    {
        $this->assertSame('sqlite', config('database.default'));
        $this->assertSame(':memory:', config('database.connections.sqlite.database'));
    }

    public function test_queue_is_configured_for_deterministic_test_execution(): void
    {
        $this->assertSame('sync', config('queue.default'));
    }
}
