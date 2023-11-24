<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\RoomsController;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiRoomsControllerTest extends TestCase
{
   use DatabaseTransactions;

   /** @test */
   public function it_returns_a_list_of_rooms()
   {
        Room::factory()->count(3)->create();

        $response = $this->get('api/rooms');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['status', 'message', 'data' => [['id', 'number', 'type', 'status', 'price', 'image']]]);
   }

    /** @test */
    public function authenticated_users_can_book_rooms()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Test123@'),
        ]);

        $room = Room::factory()->create();

        $token = $user->generateApiToken();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post("/api/rooms/$room->id/book");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['status', 'message']);


        $room->refresh();
        $this->assertEquals($room->status, 'pending');
        $this->assertEquals($room->user_id, $user->id);
    }

    /** @test */
    public function authenticated_users_can_not_book_unavailable_rooms()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Test123@'),
        ]);

        $room = Room::factory()->create();
        $room->status = 'booked';
        $room->save();

        $token = $user->generateApiToken();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post("/api/rooms/$room->id/book");

        $response->assertStatus(Response::HTTP_EXPECTATION_FAILED)
            ->assertJsonStructure(['status', 'message']);
    }

    /** @test */
    public function authenticated_users_can_not_book_unon_existing_rooms()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('Test123@'),
        ]);

        $token = $user->generateApiToken();

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->post("/api/rooms/9999999999999999999999/book");

        $response->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonStructure(['status', 'message']);
    }

    /** @test */
    public function unauthenticated_users_can_not_book_rooms()
    {
        $room = Room::factory()->create();

        $response = $this->withHeader('Authorization', 'Bearer ')
            ->post("/api/rooms/$room->id/book");

        $response->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/login');
    }
}
