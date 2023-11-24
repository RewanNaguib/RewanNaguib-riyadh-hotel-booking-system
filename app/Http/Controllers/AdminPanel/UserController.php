<?php

namespace App\Http\Controllers\AdminPanel;

use Alert;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        if($request->ajax()){
            $data = User::with('roles')->get();
            return Datatables::of($data)
                ->addColumn('password', function ($user) {
                    return ($user->password);
                })
                ->addColumn('action', function ($row) {
                    $action = "";
                    $action.="<a class='btn btn-xs btn-warning' id='btnEdit' href='".route('users.edit', $row->id)."'><i class='fas fa-edit'></i></a>";
                    $action.="  <button class='btn btn-xs btn-outline-danger' id='btnDel' data-id='".$row->id."'><i class='fas fa-trash'></i></button>";
                    return $action;
                })
                ->make(true);
        }
        return view('users.index', [
            'roles' => $roles
        ]);
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
            'name' => 'required | min:3 | max:20',
            'email' => 'email | required | unique:users',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z0-9@$!%*#?&]{8,20}$/',
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        $user->assignRole($request->roles);

        if($user){
            Alert::success('Success', 'user saved successfully');
            return view('users.index');
        }
        else{
            Alert::error('Error', 'error in saving the user');
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
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit')->with([
            'user'  => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required | min:3 | max:20',
            'email' => 'email | required | unique:users,email,' . $user->id,
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z0-9@$!%*#?&]{8,20}$/',

        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->syncRoles($request->roles);

        if($user){
            Alert::success('Success', 'user updated successfully');
            return redirect()->route('users.index');
        }
        else{
            Alert::error('Error', 'error in updating the user');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if($request->ajax() && $user->delete())
        {
            return response(["message" => "User Deleted Successfully"], 200);
        }
        return response(["message" => "User Delete Error! Please Try again"], 201);
    }
}
