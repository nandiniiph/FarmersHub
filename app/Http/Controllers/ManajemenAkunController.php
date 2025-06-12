<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ManajemenAkunController extends Controller
{
    public function Profil()
    {
        $user = Auth::user();
        return view('profil.index', compact('user'));
    }

    public function showEditProfil()
    {
        $user = Auth::user();
        return view('profil.editProfil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:30|unique:user,username,' . Auth::id(),
            'email' => 'required|email|unique:user,email,' . Auth::id(),
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $userId = Auth::id();
        $newData = [
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $newData['password'] = $request->password;
        }

        DB::table('user')
            ->where('user_id', $userId)
            ->update($newData);

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diedit!');
    }

}
