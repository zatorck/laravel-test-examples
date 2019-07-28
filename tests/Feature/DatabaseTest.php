<?php

namespace Tests\Feature;

use App\User;
use App\UserAttribute;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class DatabaseTest
 *
 * @url https://laravel.com/docs/5.8/database-testing
 *
 * @package Tests\Feature
 */
class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * NO 1. Introduction
     */
    public function testDatabase()
    {
        /*
         * make() method only creates users
         */
        $user = factory(User::class)->make();

        $this->assertNotNull($user->email);

        /*
         * while create() persist them to DB
         */
        $user = factory(User::class)->states('with_token', 'admin')->create();

        $this->assertEquals('piotr.zat@gmail.com', $user->email);

        $this->assertDatabaseHas('users', [
            'email' => 'piotr.zat@gmail.com',
        ]);
    }

    /**
     * NO 2. Relationship
     */
    public function testRelationship()
    {
        // this saves to db new user with new attribute
        $users = factory(User::class, 3)
            ->create()
            ->each(function ($user) {
                $user->userAttributes()->save(factory(UserAttribute::class)->make());
            });

        $this->assertTrue(true);
    }

    /**
     * NO 3. Available Assertions
     */
    public function testAvailableAssertions()
    {
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => '100%noemailinDB@db.pl',
        ]);


        // This is last type of assertion
        // $this->assertSoftDeleted($table, array $data);
    }
}
