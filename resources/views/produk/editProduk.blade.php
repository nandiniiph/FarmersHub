@extends('layouts.appPetani')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded shadow mt-6">
    <h2 class="text-xl font-bold mb-4">Edit Produk</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('produk.update', $produk->product_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold mb-1">Nama Produk</label>
            <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="deskripsi" class="w-full border rounded px-3 py-2" rows="4" required>{{ $produk->deskripsi }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Harga</label>
            <input type="number" name="harga" value="{{ $produk->harga }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Stok</label>
            <input type="number" name="stok" value="{{ $produk->stok }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block font-semibold mb-1">Gambar Produk</label>
            @if ($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Produk" class="w-32 mb-2">
            @endif
            <input type="file" name="gambar" class="w-full border rounded px-3 py-2">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        <a href="{{ route('produk.index') }}" class="ml-3 text-gray-600 hover:underline">Kembali</a>
    </form>
</div>
@endsection
