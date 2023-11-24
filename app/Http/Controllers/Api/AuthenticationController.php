<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        try {

            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[a-zA-Z0-9@$!%*#?&]{8,20}$/',
            ]);

            if ($validateUser->fails()) {
                return $this->sendErrorResponse(
                    'Validation Error',
                    Response::HTTP_BAD_REQUEST,
                    ['errors' => $validateUser->errors()]
                );
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $role = Role::where('name', 'guest')->first();

            $user->assignRole($role);

            return $this->sendSuccessResponse(
                'User created successfully',
                Response::HTTP_OK,
                ['token' => $user->generateApiToken()]
            );
        } catch (\Throwable $th) {
            return $this->sendErrorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validateUser->fails()) {
                return $this->sendErrorResponse(
                    'Validation Error',
                    Response::HTTP_BAD_REQUEST,
                    ['errors' => $validateUser->errors()]
                );
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return $this->sendErrorResponse('Invalid login credentials. Please check your email address and password and try again.', Response::HTTP_BAD_REQUEST);
            }

            $user = User::where('email', $request->email)->first();

            return $this->sendSuccessResponse(
                'Logged in successfully',
                Response::HTTP_OK,
                ['token' => $user->generateApiToken()]
            );
        } catch (\Throwable $th) {
            return $this->sendErrorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return $this->sendSuccessResponse('Logged out successfully');
        } catch (\Throwable $th) {
            return $this->sendErrorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
