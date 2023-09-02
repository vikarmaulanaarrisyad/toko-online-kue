<?php

namespace Tests\Feature;

use Database\Seeders\UserTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a new order.
     */
    public function test_users_can_be_created(): void
    {
        // Run the DatabaseSeeder...
        $this->seed();

        // Run a specific seeder...
        $this->seed(UserTableSeeder::class);

        // Run an array of specific seeders...
        $this->seed([
            UserTableSeeder::class,
            // ...
        ]);
    }
}
