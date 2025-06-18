<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\PermohonanUpgrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ManajemenAkunController extends Controller
{
    public function Profil()
    {
        $user = Auth::user();
        $latestUpgradeRequest = null;

        if ($user->role === 'Petani') {
            $latestUpgradeRequest = PermohonanUpgrade::where('user_id', $user->user_id)
                ->orderBy('created_at', 'desc')
                ->first();
        }

        return view('profil.index', compact('user', 'latestUpgradeRequest'));
    }

    public function showEditProfil()
    {
        $user = Auth::user();
        return view('profil.editProfil', compact('user'));
    }

    public function showAkun(){
        $akun = Akun::where('status', true)
                    ->where('role', '!=', 'Admin')
                    ->get();
        return view('akun.index', compact('akun'));
    }

    public function showIsiSaldo()
    {
        $saldo = Auth::user();
        return view('profil.isiSaldo', compact('saldo'));
    }

    public function updateProfil(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:30|unique:user,username,' . Auth::id() .',user_id',
            'email' => 'required|email|unique:user,email,' . Auth::id() .',user_id',
            'password' => 'nullable|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['error' => 'Gagal mengedit profil'])->withInput();
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

    public function tambahSaldo(Request $request)
    {
        $request->validate([
            'saldo' => 'required|numeric|min:1',
        ]);

        $userId = Auth::id();
        Akun::where('user_id', $userId)->update([
            'saldo' => DB::raw("saldo + {$request->saldo}")
        ]);
        return redirect()->route('profil.index')->with('success', 'Saldo berhasil ditambahkan!');
    }


    public function HapusAkun($id)
    {
        $akun = Akun::findOrFail($id);
        if ($akun) {
            $akun->status = 0;
            $akun->save();
        }
        return redirect()->route('akun.index')->with('success', 'Akun berhasil dihapus.');
    }

    public function FilterAkun(Request $request)
    {
        $filter = $request->input('filter', 'semua');
        if ($filter === 'petani') {
            $akun = Akun::where('role', 'Petani')
                        ->where('status', 1)
                        ->get();
        } elseif ($filter === 'konsumen') {
            $akun = Akun::where('role', 'Konsumen')
                        ->where('status', 1)
                        ->get();
        } else {
            $akun = Akun::where('status', 1)->get();
        }
        return view('akun.index', compact('akun'));
    }
}
