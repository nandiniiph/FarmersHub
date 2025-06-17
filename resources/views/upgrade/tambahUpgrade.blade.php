@php
    use Carbon\Carbon;
@endphp

@extends('layouts.appKonsumen')

@section('content')
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 text-center rounded">
        {{ session('success') }}
    </div>
@endif

<main class="p-6">
    @if(isset($lastRequest))
    <div class="bg-white shadow-md rounded-lg p-8 max-w-2xl mx-auto">
        <h3 class="text-xl font-bold mb-6 text-center border-b pb-2">Status Permohonan Upgrade</h3>
        <div class="space-y-3 text-gray-700 text-sm">
            <div><span class="font-semibold">Tanggal Permohonan:</span> {{ Carbon::parse($lastRequest->tanggal_permohonan)->format('d M Y') }}</div>
            <div><span class="font-semibold">Nama Lengkap:</span> {{ $lastRequest->nama_lengkap }}</div>
            <div><span class="font-semibold">Nomor HP:</span> {{ $lastRequest->nomor_hp }}</div>
            <div><span class="font-semibold">Nama Usaha:</span> {{ $lastRequest->nama_usaha }}</div>
            <div><span class="font-semibold">Alamat Lengkap:</span> {{ $lastRequest->alamat_lengkap }}</div>
            <div><span class="font-semibold">Status:</span>
                <span class="@if($lastRequest->status === 'Menunggu') text-yellow-600
                             @elseif($lastRequest->status === 'Disetujui') text-green-600
                             @elseif($lastRequest->status === 'Ditolak') text-red-600 @endif font-semibold">
                    {{ $lastRequest->status }}
                </span>
            </div>
            <div><span class="font-semibold">Catatan Admin:</span> {{ $lastRequest->catatan_admin ?: '-' }}</div>
        </div>
    </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-8 max-w-2xl mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-2 text-center">Upgrade Akun Menjadi Petani</h2>
        <p class="text-sm text-gray-600 text-center opacity-75 mb-6">Silakan lengkapi data diri Anda untuk mengajukan permohonan upgrade akun.</p>

        <div class="flex justify-center">
            @if ($errors->any())
                <div class="mb-4 text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <form action="{{ route('createPengajuan') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6 mt-4">
                <div>
                    <label class="block font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full border border-green-700 rounded px-3 py-2 mt-1" required {{ (isset($lastRequest) && $lastRequest->status === 'Menunggu') ? 'disabled' : '' }}>

                    <label class="block font-semibold text-gray-700 mt-4">Nomor HP</label>
                    <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" class="w-full border border-green-700 rounded px-3 py-2 mt-1" required {{ (isset($lastRequest) && $lastRequest->status === 'Menunggu') ? 'disabled' : '' }}>

                    <label class="block font-semibold text-gray-700 mt-4">Nama Usaha</label>
                    <input type="text" name="nama_usaha" value="{{ old('nama_usaha') }}" class="w-full border border-green-700 rounded px-3 py-2 mt-1" required {{ (isset($lastRequest) && $lastRequest->status === 'Menunggu') ? 'disabled' : '' }}>

                    <label class="block font-semibold text-gray-700 mt-4">Alamat Lengkap</label>
                    <input type="text" name="alamat_lengkap" value="{{ old('alamat_lengkap') }}" class="w-full border border-green-700 rounded px-3 py-2 mt-1" required {{ (isset($lastRequest) && $lastRequest->status === 'Menunggu') ? 'disabled' : '' }}>
                </div>
            </div>

            <div class="flex justify-center mt-8">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                    {{ (isset($lastRequest) && $lastRequest->status === 'Menunggu') ? 'disabled' : '' }}>
                    Ajukan Permohonan Upgrade
                </button>
            </div>
        </form>
    </div>
</main>
@endsection
