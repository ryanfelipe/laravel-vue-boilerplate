<?php

namespace Tests\Database\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class UserModelTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }
    
    public function testUser()
    {
        $this->assertDatabaseHas('users', ['id' => $this->user->id]);
    }

    /**
     * Check if user was edited.
     *
     * @return void
     */
    public function testEditUser()
    {
        $this->user->update(
            [
                'name' => 'Alefe',
            ]
        );

        $this->assertDatabaseHas('users', ['name' => 'Alefe']);
    }

    /**
     * Check if user was deleted.
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $this->user->delete();

        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }
}
