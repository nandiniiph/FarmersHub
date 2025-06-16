@extends($layout)

@section('title', 'Belanja Produk')

@section('content')
<div class="container py-5">
    <h2 class="text-2xl font-bold mb-4">Daftar Produk</h2>

    {{-- Form Pencarian Produk --}}
    <form action="{{ route('belanja.index') }}" method="GET" class="mb-6">
        <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
            class="border rounded px-3 py-2 w-full md:w-1/3 focus:outline-none focus:ring focus:border-green-400"
        >
    </form>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($produk as $item)
            <div class="border rounded-lg p-4 shadow hover:shadow-lg transition">
                @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-40 object-cover rounded mb-3" alt="{{ $item->nama_produk }}">
                @else
                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center mb-3 rounded text-gray-500">
                        Tidak ada gambar
                    </div>
                @endif

                <h3 class="font-semibold text-lg mb-1">{{ $item->nama_produk }}</h3>
                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($item->deskripsi, 80) }}</p>
                <p class="font-bold text-green-600 mb-3">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>

                <form action="{{ route('keranjang.tambah', $item->product_id) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    <button type="button" class="minus bg-gray-200 px-2 py-1 text-lg rounded">−</button>
                    <input type="number" name="jumlah" value="1" min="1" class="w-12 text-center border rounded jumlah-input text-sm">
                    <button type="button" class="plus bg-gray-200 px-2 py-1 text-lg rounded">+</button>

                    <button type="submit" class="ml-2 bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition text-sm">
                        Tambah
                    </button>
                </form>
            </div>
        @empty
            <p class="text-gray-500">Tidak ada produk tersedia.</p>
        @endforelse
    </div>
</div>

{{-- untuk tombol + dan - --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.plus').forEach(btn => {
            btn.addEventListener('click', function () {
                const input = this.parentNode.querySelector('.jumlah-input');
                input.value = parseInt(input.value) + 1;
            });
        });

        document.querySelectorAll('.minus').forEach(btn => {
            btn.addEventListener('click', function () {
                const input = this.parentNode.querySelector('.jumlah-input');
                const val = parseInt(input.value);
                if (val > 1) input.value = val - 1;
            });
        });
    });
</script>
@endsection
