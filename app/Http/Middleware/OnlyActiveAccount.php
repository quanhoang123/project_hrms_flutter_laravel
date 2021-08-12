<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OnlyActiveAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( Auth::check() && Auth::user()->active ){
            return $next($request);
        }else{
            $email = Auth::user()->email;
            Auth::logout();
            Log::error('Email: '.$email.' đăng nhập thất bại, tài khoản chưa được kích hoạt');
            return response()->json([
                "success" => false,
                "message" => "That Bai",
                "data" => $email,
            ]);
        }
       
    }
}
