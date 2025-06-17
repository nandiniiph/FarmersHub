@php
    use Carbon\Carbon;
@endphp

@extends('layouts.appAdmin')

@section("content")
<div class="bg-white shadow-md rounded-lg p-8 max-w-2xl mx-auto">
    <h3 class="text-xl font-bold mb-6 text-center border-b pb-2">Menolak Permohonan Upgrade</h3>
    <form action="{{ route('TolakPermohonan', $permohonan->permohonan_id) }}" method="POST">
        @csrf
        <div class="space-y-3 text-gray-700 text-sm">
            <div><span class="font-semibold">Tanggal Permohonan:</span> {{ Carbon::parse($permohonan->tanggal_permohonan)->format('d M Y') }}</div>
            <div><span class="font-semibold">Nama Lengkap:</span> {{ $permohonan->nama_lengkap }}</div>
            <div><span class="font-semibold">Nomor HP:</span> {{ $permohonan->nomor_hp }}</div>
            <div><span class="font-semibold">Nama Usaha:</span> {{ $permohonan->nama_usaha }}</div>
            <div><span class="font-semibold">Alamat Lengkap:</span> {{ $permohonan->alamat_lengkap }}</div>

            <div>
                <span class="font-semibold">Catatan Admin:</span>
                <textarea name="catatan_admin" rows="4" class="w-full border border-gray-300 rounded p-2 mt-1" placeholder="Masukkan catatan admin di sini...">{{ $permohonan->catatan_admin }}</textarea>
            </div>
        </div>

        <div class="flex justify-between mt-4">
            <a href="{{ route('upgrade.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400 transition">Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Kirim</button>
        </div>
    </form>
</div>
@endsection
