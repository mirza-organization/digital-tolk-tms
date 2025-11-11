<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Force in-memory database for tests to prevent wiping real data
        if (config('database.default') === 'sqlite') {
            config(['database.connections.sqlite.database' => ':memory:']);
        }
    }
}
