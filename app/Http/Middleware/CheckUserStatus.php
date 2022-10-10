<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{

    public function handle(Request $request, Closure $next)
    {

        if(Auth::check()){
            $user = User::find(Auth::user()->id);
            if($user->status =='غير مفعل'){
                Auth::logout();
                return redirect()->back()->withErrors(['حسابك غير مفعل الرجاء التواصل مع الادمن لمعرفة سبب المشكلة']);
            }
        }

       return $next($request);
    }
}
