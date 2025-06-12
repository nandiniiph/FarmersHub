@extends('layouts.appPetani')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Manajemen Produk</h1>

    @if (session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('produk.create') }}" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">
        Tambah Produk
    </a>

    <table class="w-full table-auto border">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Harga</th>
                <th class="px-4 py-2">Stok</th>
                <th class="px-4 py-2">Gambar</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produk as $item)
                <tr class="text-center border-t">
                    <td class="px-4 py-2">{{ $item->nama_produk }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $item->stok }}</td>
                    <td class="px-4 py-2">
                        @if($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Produk" class="w-20 mx-auto">
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('produk.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('produk.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
