<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:30',
            'email' => 'required|email|string|max:200|unique:users,email',
            'password' => 'required|string|min:8|max:100|confirmed'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        Mail::to($user->email)->send(new WelcomeMail($user));
        return response()->json([
            'message' => 'User registered successfully',
            'User' => $user
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
        if (!Auth::attempt($request->only('email', 'password')))
            return response()->json(
                [
                    'mesaage' => 'invalid email or password'
                ],
                401
            );
        $user = User::where('email', $request->email)->FirstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(
            [
                'message' => 'Login successfully',
                'User' => $user,
                'Token' => $token
            ],
            401
        );
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successfully'
        ]);
    }







    public function getProfile($id)
    {
        $profile = User::findOrFail($id)->profile;
        return response()->json($profile, 200);
    }
    public function getUserTask($id)
    {
        $Tasks = User::findOrFail($id)->Tasks;
        return response()->json($Tasks, 200);
    }
    public function getUser()
    {
        $user_id=Auth::user()->id;
        $user = User::with('profile')->findOrFail($user_id);
        return new UserResource($user);
    }
    public function getAllUsersWithProfiles()
    {
        $user = User::with('profile')->get();
        return UserResource::collection($user);

    }




}
