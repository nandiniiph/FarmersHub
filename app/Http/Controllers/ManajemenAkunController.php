<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ManajemenAkunController extends Controller
{
    public function Profile()
    {
        $user = Auth::user();
        return view('profile.index', ['akun' => $user]);
    }
}
