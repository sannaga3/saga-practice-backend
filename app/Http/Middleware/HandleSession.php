<?php

namespace App\Http\Middleware;

use App\Models\User;

class HandleSession
{
  public static function setSession($request, $credentials)
  {
    $request->session()->regenerate();
    $user = User::where('email', $credentials['email'])->select(['id', 'name', 'email'])->first();
    $request->session()->put('user', $user);

    return $user;
  }
}