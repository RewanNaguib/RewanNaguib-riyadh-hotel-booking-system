<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationControllerTest extends TestCase
{
    use DatabaseTransactions;


    /** @test */
    public function it_registers_a_user()
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'Test123@',
        ];

        $response = $this->post('/api/auth/register', $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['status', 'message', 'token']);
    }

    /** @test */
    public function it_validates_input()
    {  
        $data = [
            'name' => 'John Doe',
            'email' => 'invalid_email',
            'password' => 'weak_password',
        ];

        $response = $this->post('/api/auth/register', $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['status', 'message', 'errors']);
    }

      /** @test */
      public function it_logs_in_user()
      {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Test123@'),
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'Test123@',
        ];

        $response = $this->post('/api/auth/login', $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['status', 'message', 'token']);
    }

    /** @test */
    public function it_validates_login_inputs()
    {
        $data = [
            'password' => 'wrong_password',
        ];

        $response = $this->post('/api/auth/login', $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['status', 'message', 'errors']);
    }

    /** @test */
    public function it_does_not_login_users_with_wrong_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Test123@'),
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'wrong_password',
        ];

        $response = $this->post('/api/auth/login', $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonStructure(['status', 'message']);
    }

    /** @test */
    public function it_logs_out_users()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Test123@'),
        ]);

        $token = $user->generateApiToken();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post('/api/auth/logout');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['status', 'message']);
    }

    /** @test */
    public function it_does_not_accept_logout_from_not_authenticated_users()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Test123@'),
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ')
            ->post('/api/auth/logout');

        $response->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }
}
