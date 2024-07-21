<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Quiz;
use App\Models\Invitation;

class AuthTest extends TestCase
{
     
    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function a_user_can_register_successfully()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'password' => 'never mind',
            'dob' => '2010-01-01',
            'occupation' => 'Trader',
            'address' => '2 Aba road'
        ];

        $response = $this->post('/auth/register', $data);
        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'User registration was successful, kindly check your mail to verify your account',
            'data' => ['first_name' => 'John', 'occupation' => 'Trader']
        ]);

        $this->assertDatabaseHas('users', ['email' => 'john@doe.com']);
    }

    /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function first_name_first_is_required_for_registration()
    {
        $data = [
            'last_name' => 'Doe',
            'email' => 'john@doe.com',
            'password' => 'never mind'
        ];

        $response = $this->post('/auth/register', $data);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Validation failed',
            'data' => ['first_name' => ['The first name field is required.']]
        ]);
    }

     /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function last_name_first_is_required_for_registration()
    {
        $data = [
            'first_name' => 'Doe',
            'email' => 'john@doe.com',
            'password' => 'never mind'
        ];

        $response = $this->post('/auth/register', $data);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Validation failed',
            'data' => ['last_name' => ['The last name field is required.']]
        ]);
    }

     /**
     * A basic feature test example.
     *
     * @test
     * @return void
     */
    public function email_must_be_unique()
    {
        $data = [
            'first_name' => 'John',
            'first_name' => 'Doe',
            'email' => 'john@doe.com',
            'password' => 'never mind'
        ];

        User::factory()->create($data);

        $data = [
            'first_name' => 'Mike',
            'last_name' => 'Tom',
            'email' => 'john@doe.com',
            'password' => 'never mind'
        ];

        $response = $this->post('/auth/register', $data);

        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'Validation failed',
            'data' => ['email' => ['The email has already been taken.']]
        ]);
    }

}
