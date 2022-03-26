<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //check if header is present
        $header = trim($request->header('authorization'));
        if (is_null($header) || empty($header))
            return response()->json(['message' => 'MISSING authorization HEADER'], 400);

        //decode and extract email and password from string
        $credentials = explode(":", base64_decode(substr($header, 6)));
        if (count($credentials) < 2)
            return response()->json(['message' => 'MISSING EMAIL OR PASSWORD'], 400);

        $email = trim($credentials[0]);
        $password = trim($credentials[1]);

        $user = User::where('email', $email)->first();

        if (is_null($user))
            return response()->json(['message' => 'INCORRECT CREDENTIALS'], 401);

        if (!Hash::check($password, $user->password))
            return response()->json(['message' => 'INCORRECT CREDENTIALS'], 401);

        Auth::setUser($user);
        return $next($request);
    }
}
