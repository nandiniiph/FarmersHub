@extends($layout)

@section('title', 'Belanja - FarmersHub')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($produk as $item)
        <div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
            <h2 class="text-lg font-semibold">{{ $item->nama_produk }}</h2>
            <p class="text-gray-600 mb-2">{{ $item->deskripsi }}</p>
            <p class="font-bold text-green-700 mb-4">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>

            <form action="{{ route('keranjang.tambah', $item->product_id) }}" method="POST">
                @csrf
                <input type="number" name="jumlah" value="1" min="1" class="border rounded px-2 py-1 w-16 mr-2" required>
                <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">
                    Tambah ke Keranjang
                </button>
            </form>
        </div>
        @endforeach
    </div>
</div>
@endsection
