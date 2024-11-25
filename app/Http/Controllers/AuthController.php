<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Resources\UserResource;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    //
    use ApiResponseTrait;

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = $request->user();
            $token       = $user->createToken('API Access')->plainTextToken;
            $user->token = $token;
            return $this->successResponse($user);
        }
    }
}
