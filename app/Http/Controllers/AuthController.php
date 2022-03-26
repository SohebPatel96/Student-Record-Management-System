<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view("login");
    }

    public function authenticate(LoginRequest $request)
    {
        $email = trim($request->email);
        $password = trim($request->password);

        $user = User::where('email', $email)->first();
        if (is_null($user))
            return back()->withErrors(['USER_NOT_FOUND' => 'user not found']);

        if (Auth::attempt([
            'email' => $email, 'password' => $password
        ])) {
            return redirect('/students');
        } else {
            return back()->withErrors(['WRONG_CREDENTIALS' => 'Wrong credentials']);
        }
    }
}
