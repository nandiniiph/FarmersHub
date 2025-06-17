@extends($layout)

@section('title', 'Belanja Produk')

@section('content')
<div class="container py-5">
    <h2 class="text-2xl font-bold mb-4">Daftar Produk</h2>

    {{-- Form Pencarian Produk --}}
    <form action="{{ route('belanja.index') }}" method="GET" class="mb-6">
        <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
            class="border rounded px-3 py-2 w-full md:w-1/3 focus:outline-none focus:ring focus:border-green-400">
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
                <p class="text-sm text-gray-600 mb-1">{{ Str::limit($item->deskripsi, 80) }}</p>
                <p class="font-bold text-green-600 mb-1">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-700 mb-2">Stok: <span class="font-semibold">{{ $item->stok }}</span></p>

                @if ($item->stok == 0)
                    <button disabled class="w-full bg-gray-400 text-white py-2 rounded text-sm cursor-not-allowed">
                        STOK HABIS
                    </button>
                @else
                    {{-- Form Tambah ke Keranjang --}}
                    <form action="{{ route('keranjang.tambah', $item->product_id) }}" method="POST" class="flex items-center gap-2 produk-form mb-2" data-stok="{{ $item->stok }}">
                        @csrf
                        <button type="button" class="minus bg-gray-200 px-2 py-1 text-lg rounded">−</button>
                        <input type="number" name="jumlah" value="1" min="1" max="{{ $item->stok }}" class="w-12 text-center border rounded jumlah-input text-sm">
                        <button type="button" class="plus bg-gray-200 px-2 py-1 text-lg rounded">+</button>

                        <button type="submit" class="ml-2 bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition text-sm">
                            Tambah ke keranjang
                        </button>
                    </form>

                    {{-- Form Beli Sekarang --}}
                    <form action="{{ route('checkout') }}" method="POST" class="checkout-form">
                    @csrf
                    <input type="hidden" name="checkout_from" value="langsung"> {{-- Ini yang ditambahkan --}}
                    <input type="hidden" name="produk_terpilih[]" value="{{ $item->product_id }}">
                    <input type="hidden" name="jumlah[]" class="jumlah-beli-sekarang" value="1">
                    <button type="submit" class="w-full bg-blue-600 text-white py-1 rounded hover:bg-blue-700 text-sm">
                        Beli Sekarang
                    </button>
                </form>


                @endif
            </div>
        @empty
            <p class="text-gray-500">Tidak ada produk tersedia.</p>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.produk-form').forEach(form => {
        const stok = parseInt(form.dataset.stok);
        const jumlahInput = form.querySelector('.jumlah-input');
        const plus = form.querySelector('.plus');
        const minus = form.querySelector('.minus');
        const checkoutForm = form.nextElementSibling;
        const checkoutJumlah = checkoutForm.querySelector('.jumlah-beli-sekarang');

        function syncJumlah() {
            let val = parseInt(jumlahInput.value);
            if (isNaN(val) || val < 1) val = 1;
            if (val > stok) {
                alert('Jumlah melebihi stok!');
                val = stok;
            }
            jumlahInput.value = val;
            checkoutJumlah.value = val;
        }

        plus.addEventListener('click', function () {
            let val = parseInt(jumlahInput.value) || 1;
            if (val < stok) {
                jumlahInput.value = val + 1;
                syncJumlah();
            } else {
                alert('Jumlah melebihi stok!');
            }
        });

        minus.addEventListener('click', function () {
            let val = parseInt(jumlahInput.value) || 1;
            if (val > 1) {
                jumlahInput.value = val - 1;
                syncJumlah();
            }
        });

        jumlahInput.addEventListener('input', syncJumlah);
        checkoutForm.addEventListener('submit', function (e) {
            e.preventDefault();
            syncJumlah();
            this.submit();     
        });
    });
});
</script>
@endsection
