<?php

namespace App\Http\Controllers;

use App\Packages\SnapChat\Snapchat;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SnapchatController extends Controller
{

    public function login1(){
//        dd(config('services.snapchat.client_id'),config('services.snapchat.client_secret'),config('services.snapchat.redirect'));
        return  Socialite::driver('snapchat')->redirect();
//        return response()->json($snapchat);
    }

    public function callback(){
        return  Socialite::driver('snapchat')->user();
    }
}
