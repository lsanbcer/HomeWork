<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     *
     * Login.
     *
     */
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $apiToken = Str::random(10);

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response(['message' => 'Login failed! Please check email.'], 400);
        }
        if (!Hash::check($password, $user->password)) {
            return response(['message' => 'Login failed! Please check password.'], 400);
        }
        $user->update(['api_token' => $apiToken]);
        return response(['message' => 'Login successfully!',  'api_token' => $apiToken]);

    }

    /**
     *
     * Logout.
     *
     */
    public function logout()
    {
        Auth::user()->update(['api_token' => 'logged out']);
        return response(['message' => 'You are logged out!']);
    }

    /**
     *
     * Display a listing of the resource.
     * 
     */
    public function index()
    {
        $admins = User::all();
        $user = User::find(Auth::user()->id);

        if (Auth::user()->isAdmin) {
            return response(['data' => $admins]);
        } else {
            return response(['data' => $user]);
        }
    }

    /**
     *
     * User Register.
     *
     */
    public function register(Request $request)
    {
        $rules = ([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:12'],
        ]);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response(['message' => $validator->errors()], 400);
        }

        $apiToken = Str::random(10);
        $create = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isAdmin' => $request->isAdmin,
            'api_token' => $apiToken,
        ]);

        if ($create) {
            if ($request->isAdmin) {
                return response(['message' => 'Register as a admin.', 'data' => $create, 'api_token' => $apiToken]);
            } else {
                return response(['message' => 'Register as a user.', 'data' => $create, 'api_token' => $apiToken]);
            }
        }
    }
}
