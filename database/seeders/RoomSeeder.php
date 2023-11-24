<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rooms = [
            [
                'number' => '101',
                'type' => 'single',
                'status' => 'available',
                'price' => 500.00,
                'image' => 'single1.jpg',
            ],
            [
                'number' => '102',
                'type' => 'double',
                'status' => 'pending',
                'price' => 600.00,
                'image' => 'double1.jpg',
            ],
            [
                'number' => '201',
                'type' => 'suite',
                'status' => 'booked',
                'price' => 700.00,
                'image' => 'suite1.jpg',
            ],
            [
                'number' => '202',
                'type' => 'single',
                'status' => 'available',
                'price' => 1000.00,
                'image' => 'single2.jpg',
            ],
            [
                'number' => '301',
                'type' => 'double',
                'status' => 'pending',
                'price' => 1100.00,
                'image' => 'double2.jpg',
            ],
            [
                'number' => '302',
                'type' => 'suite',
                'status' => 'booked',
                'price' => 1200.00,
                'image' => 'suite2.jpg',
            ],
            [
                'number' => '401',
                'type' => 'single',
                'status' => 'available',
                'price' => 1300.00,
                'image' => 'single3.jpg',
            ],
            [
                'number' => '402',
                'type' => 'double',
                'status' => 'pending',
                'price' => 1400.00,
                'image' => 'double3.jpg',
            ],
            [
                'number' => '501',
                'type' => 'suite',
                'status' => 'booked',
                'price' => 1500.00,
                'image' => 'suite3.jpg',
            ],
            [
                'number' => '502',
                'type' => 'single',
                'status' => 'available',
                'price' => 1600.00,
                'image' => 'single4.jpg',
            ],
        ];

        foreach ($rooms as $roomData) {
            Room::create($roomData);
        }
    }
}
