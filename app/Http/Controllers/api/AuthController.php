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
            'email' => 'required|email',
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

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return "ログアウトしました";
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:20',
            'email' => 'required|string|email|unique:users|max:50',
            'password' => 'required|string:min6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errorMessages' => $validator->errors()->toArray()], 401);
        }

        $user = new User;
        $user->fill(array_merge(
            $request->all(),
            ['password' => Hash::make($request->password)]
        ))->save();

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