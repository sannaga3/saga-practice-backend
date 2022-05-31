<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Middleware\HandleSession;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errorMessages' => $validator->errors()->toArray()], 401);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = HandleSession::setSession($request, $credentials);
            Auth::login($user);
            return $user;
        }

        $validator->errors()->add('error', 'パスワードもしくはメールアドレスが一致しません');
        return response()->json(['errorMessages' => $validator->errors()->toArray()], 401);
    }
}