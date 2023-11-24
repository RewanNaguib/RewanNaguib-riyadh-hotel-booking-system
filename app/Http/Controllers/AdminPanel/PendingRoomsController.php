<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Alert;

class PendingRoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Room::where('status', 'pending')->get();
            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $action = "";
                    $action.="<button class='btn btn-xs btn-success btnConfirm' data-id='".$row->id."'><i class='fas fa-check'></i> Confirm</button>";
                    $action.=" <button class='btn btn-xs btn-danger btnReject' data-id='".$row->id."'><i class='fas fa-times'></i> Reject</button>";
                    return $action;
                })
                ->make(true);
        }
        return view('rooms.pending');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function confirmBooking($id)
    {
        $room = Room::findOrFail($id);
        $room->status = 'booked';
        $room->save();

        return response()->json(['message' => 'Room confirmed successfully']);
    }

    public function rejectBooking($id)
    {
        $room = Room::findOrFail($id);
        $room->status = 'available';
        $room->save();

        return response()->json(['message' => 'Room rejected successfully']);
    }
}
