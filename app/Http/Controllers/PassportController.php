<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\ValidationException;

class PassportController extends Controller
{
    public function register(Request $request)
    {
        try {
//            validate details
            $this->validate($request, [
                    'name' => 'required|min:3',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|min:8'
                ]
            );

//            create a user with the verified details
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

//            create user access token
            $token = $user->createToken('JacreatorLen')->accessToken;

            return response()->json(['message' => 'user created', 'token' => $token], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('JacreatorLen')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['message' => 'UnAuthorized'], 401);
        }
    }

    public function detial(){
        return response()->json(['user'=>auth()->user()], 200);
    }
}
