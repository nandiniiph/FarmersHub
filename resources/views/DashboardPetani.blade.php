@extends('layouts.appPetani')

@section('content')
<div class="p-6">
    <!-- Welcoming -->
    <h1 class="text-2xl font-bold mb-2">Selamat datang, {{ Auth::user()->username }}</h1>
    <p class="text-gray-600 mb-6">Berikut adalah daftar produk anda</p>

    @if($produk->isEmpty())
        <p class="text-gray-600">Belum ada produk yang ditambahkan.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($produk as $item)
                <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-md transition p-4">
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Produk" class="w-full h-40 object-cover rounded mb-4">
                    <h2 class="text-lg font-semibold">{{ $item->nama_produk }}</h2>
                    <p class="text-green-700 font-medium">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                    <p class="text-sm text-gray-600">Stok: {{ $item->stok }}</p>

                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
