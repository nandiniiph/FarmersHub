@extends('layouts.appPetani')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Manajemen Produk</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('produk.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">+ Tambah Produk</a>
    </div>

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-green-200">
                <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                <th class="border border-gray-300 px-4 py-2">Harga</th>
                <th class="border border-gray-300 px-4 py-2">Stok</th>
                <th class="border border-gray-300 px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($produk as $item)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $item->nama_produk }}</td>
                    <td class="border border-gray-300 px-4 py-2">Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $item->stok }}</td>
                    <td class="border border-gray-300 px-4 py-2 space-x-2">
                        <a href="{{ route('produk.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('produk.destroy', $item->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin hapus produk?')" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center border border-gray-300 px-4 py-2">Belum ada produk</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
