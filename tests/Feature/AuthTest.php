<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, HasFactory;

    public function test_if_user_can_login()
    {
        User::factory()->create([
            'email' => 'test@gmail.com',
            'password' => 111222
        ]);

        $this->postJson(route('login'), [
            'email' => 'tes@gmail.com',
            'password' => 111222
        ])->assertUnprocessable()
            ->assertJson([
                'message' => 'The selected email is invalid.',
                'errors' => [
                    'email' => [
                        'The selected email is invalid.'
                    ]
                ]
            ]);

        $this->postJson(route('login'), [
            'email' => 'test@gmail.com',
            'password' => 111222
        ])
            ->assertOk()
            ->assertJsonStructure(['token']);
    }


    public function test_if_user_can_register()
    {
        $invalidData = [
            'first_name' => 'test',
            'last_name' => 'testov',
            'email' => 'test@gmail.com',
            'password' => 111222,
        ];

        $this->postJson(route('register'), $invalidData)
            ->assertUnprocessable();

        $validData = [
            'first_name' => 'test',
            'last_name' => 'testov',
            'email' => 'test@gmail.com',
            'password' => 111222,
            'phone' => 9054422112
        ];

        $this->postJson(route('register'), $validData)
            ->assertCreated();

        $userCheck = User::query()->where('email', 'test@gmail.com')
            ->exists();

        $this->assertTrue($userCheck);
    }
}
