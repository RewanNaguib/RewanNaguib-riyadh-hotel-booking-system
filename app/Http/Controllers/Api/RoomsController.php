<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RoomsController extends Controller
{
    public function index(Request $request)
    {
        try {
            return $this->sendSuccessResponse(
                'List of rooms', 
                Response::HTTP_OK, 
                [
                    'data' => Room::select(['id', 'number', 'type', 'status', 'price', 'image'])->get(),
                ]
            );
        } catch (\Throwable $th) {
            return $this->sendErrorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function bookRoom(Request $request, $roomId)
    {
        try {
            $room = Room::find($roomId);

            if (!$room) return $this->sendErrorResponse('Room is not found', Response::HTTP_NOT_FOUND);
            
            if ($room->status !== 'available') return $this->sendErrorResponse('Room is not available', Response::HTTP_EXPECTATION_FAILED);
    
            $room->status = 'pending';
            $room->user_id = Auth::user()->id;
            $room->save();
    
            return $this->sendSuccessResponse('Booked successfully. Waiting for Hotel confirmation.', Response::HTTP_OK);
        } catch (\Throwable $th) {
            return $this->sendErrorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
