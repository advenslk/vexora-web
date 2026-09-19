<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApplicationSmokeTest extends TestCase
{
    public function test_laravel_application_boots(): void
    {
        $this->assertNotNull($this->app);
        $this->assertSame('Lunar Hosting', $this->app['config']->get('app.name'));
    }
}
