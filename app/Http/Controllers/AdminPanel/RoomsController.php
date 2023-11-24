<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Alert;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Room::get();
            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $action = "";
                    $action.="<a class='btn btn-xs btn-warning' id='btnEdit' href='".route('rooms.edit', $row->id)."'><i class='fas fa-edit'></i></a>";
                    $action.="  <button class='btn btn-xs btn-outline-danger' id='btnDel' data-id='".$row->id."'><i class='fas fa-trash'></i></button>";
                    return $action;
                })
                ->make(true);
        }
        return view('rooms.index');
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
        $this->validate($request, [
            'number' => 'required | min:3 | max:20 | unique:rooms',
            'type' => 'required',
            'status' => 'required',
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('', $imageName, 'public');
        }

        $room = Room::create([
            "number" => $request->number,
            "type" => $request->type,
            "status" => $request->status,
            "price" => $request->price,
            "image" => $imageName ?? '',
        ]);

        if($room){
            Alert::success('Success', 'room saved successfully');
            return view('rooms.index');
        }
        else{
            Alert::error('Error', 'error in saving the room');
            return back()->withInput();
        }
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
    public function edit(Room $room)
    {
        return view('rooms.edit')->with(['room'=>$room]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $this->validate($request, [
            'number' => 'required | min:3 | max:20 |unique:rooms,number, ' . $room->id,
            'type' => 'required',
            'status' => 'required',
            'price' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('', $imageName, 'public');

            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }
        }

        $room->update([
            "number" => $request->number,
            "type" => $request->type,
            "status" => $request->status,
            "price" => $request->price,
            "image" => $request->hasFile('image') ? $imageName : $room->image,
        ]);

        if($room){
            Alert::success('Success', 'Room updated successfully');
            return redirect()->route('rooms.index');
        }
        else{
            Alert::error('Error', 'error in updating the room');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Room $room)
    {
        if($request->ajax() && $room->delete())
        {
            return response(["message" => "Room Deleted Successfully"], 200);
        }
        return response(["message" => "Room Delete Error! Please Try again"], 201);
    }
}
