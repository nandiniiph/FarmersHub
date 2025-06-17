<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\PermohonanUpgrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UpgradeController extends Controller
{

    public function index()
    {
        $Permohonans = DB::table('permohonan_upgrade')
                        ->join('user', 'permohonan_upgrade.user_id', '=', 'user.user_id')
                        ->select('permohonan_upgrade.*', 'user.username', 'user.email', 'user.status')
                        ->where('user.status', 1)
                        ->where('permohonan_upgrade.status', "Menunggu")
                        ->get();
        return view('upgrade.index', compact('Permohonans'));
    }

    public function showTambahUpgrade()
    {
        $lastRequest = PermohonanUpgrade::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastRequest && $lastRequest->status === 'Menunggu') {
            session()->flash('success', 'Permohonan upgrade berhasil diajukan. Form dinonaktifkan untuk sementara, mohon tunggu konfirmasi dari admin.');
        }

        $formDisabled = $lastRequest && $lastRequest->status === 'Menunggu';
        return view('upgrade.tambahUpgrade', compact('lastRequest', 'formDisabled'));
    }

    public function createPengajuan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100|regex:/^[A-Za-z\s]+$/',
            'nomor_hp' => 'required|digits_between:10,15',
            'nama_usaha' => 'required|string|max:100',
            'alamat_lengkap' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return back()->withErrors(['error' => 'Format data salah'])->withInput();

        }

        PermohonanUpgrade::create([
            'user_id' => Auth::id(),
            'tanggal_permohonan' => now(),
            'nama_lengkap' => $request->nama_lengkap,
            'nomor_hp' => $request->nomor_hp,
            'nama_usaha' => $request->nama_usaha,
            'alamat_lengkap' => $request->alamat_lengkap,
            'status' => 'Menunggu',
            'catatan_admin' => '',
        ]);
        return redirect()->route('showTambahUpgrade')->with('success', 'Permohonan upgrade berhasil diajukan. Form dinonaktifkan untuk sementara, mohon tunggu konfirmasi dari admin.');
    }

    public function showUpdateUpgrade($id)
    {
        $permohonan = PermohonanUpgrade::find($id);
        if (!$permohonan) {
            return redirect()->route('upgrade.index')->with('error', 'Permohonan tidak ditemukan.');
        }
        return view('upgrade.updateUpgrade', compact('permohonan'));
    }

    public function SetujuiPermohonan($id)
    {
        $permohonan = PermohonanUpgrade::find($id);

        if ($permohonan) {
            $permohonan->status = 'Disetujui';
            $permohonan->save();

            $akun = Akun::where('user_id', $permohonan->user_id)->first();
            if ($akun) {
                $akun->role = 'Petani';
                $akun->save();
            }
            return redirect()->route('upgrade.index')->with('success', 'Permohonan telah disetujui');
        }
        return redirect()->route('upgrade.index');
    }

    public function TolakPermohonan(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:255',
        ]);

        $permohonan = PermohonanUpgrade::find($id);

        if (!$permohonan) {
            return redirect()->route('upgrade.index')->with('error', 'Permohonan tidak ditemukan.');
        }

        $permohonan->catatan_admin = $request->catatan_admin;
        $permohonan->status = 'Ditolak';
        $permohonan->save();

        return redirect()->route('upgrade.index')->with('success', 'Permohonan telah ditolak');
    }
}
