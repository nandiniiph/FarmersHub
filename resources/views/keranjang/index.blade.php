@extends($layout)

@section('title', 'Keranjang - FarmersHub')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Keranjang Belanja Saya</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($keranjang && $keranjang->DetailKeranjang && $keranjang->DetailKeranjang->count())
        <table class="w-full table-auto border-collapse mt-4">
            <thead>
                <tr class="bg-green-700 text-white">
                    <th class="p-2 text-left">Pilih</th>
                    <th class="p-2 text-left">Produk</th>
                    <th class="p-2 text-left">Harga</th>
                    <th class="p-2 text-left">Jumlah</th>
                    <th class="p-2 text-left">Subtotal</th>
                    <th class="p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($keranjang->DetailKeranjang as $item)
                    @php
                        $subtotal = $item->jumlah * $item->Produk->harga;
                    @endphp
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2">
                            <input form="checkoutForm"
                                type="checkbox"
                                name="produk_terpilih[]"
                                value="{{ $item->detail_keranjang_id }}"
                                class="accent-green-600 produk-checkbox"
                                data-harga="{{ $item->Produk->harga }}"
                                data-jumlah="{{ $item->jumlah }}">

                            <input type="hidden"
                                name="jumlah[]"
                                value="{{ $item->jumlah }}"
                                form="checkoutForm">
                        </td>
                        <td class="p-2">{{ $item->Produk->nama_produk }}</td>
                        <td class="p-2">Rp {{ number_format($item->Produk->harga, 0, ',', '.') }}</td>
                        <td class="p-2">
                            <form action="{{ route('keranjang.updateJumlah', $item->detail_keranjang_id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                <button type="submit" name="action" value="minus" class="bg-gray-300 px-2 py-1 rounded text-sm">−</button>
                                <span class="px-2">{{ $item->jumlah }}</span>
                                <button type="submit" name="action" value="plus" class="bg-gray-300 px-2 py-1 rounded text-sm">+</button>
                            </form>
                        </td>
                        <td class="p-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td class="p-2">
                            <button type="button"
                                class="text-red-600 hover:underline"
                                onclick="event.preventDefault(); document.getElementById('hapus-{{ $item->detail_keranjang_id }}').submit();">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p id="totalHargaTampil" class="text-right text-lg font-semibold mt-4">
            Total: Rp 0
        </p>

        {{-- Form Checkout --}}
        <form id="checkoutForm" action="{{ route('checkout') }}" method="POST" onsubmit="return validateCheckout()" class="text-right mt-4">
            @csrf
            <input type="hidden" name="checkout_from" value="keranjang">
            <input type="hidden" name="total_dikirim" id="total_dikirim">
            <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition-all duration-200">
                Checkout
            </button>
        </form>

        {{-- Form Hapus --}}
        @foreach($keranjang->DetailKeranjang as $item)
            <form id="hapus-{{ $item->detail_keranjang_id }}"
                  action="{{ route('keranjang.hapus', $item->detail_keranjang_id) }}"
                  method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @else
        <p class="text-gray-600">Keranjang Anda kosong.</p>
    @endif
</div>

<script>
    function validateCheckout() {
        const checkedItems = document.querySelectorAll('input[name="produk_terpilih[]"]:checked');
        if (checkedItems.length === 0) {
            alert("Pilih minimal satu produk untuk checkout.");
            return false;
        }
        return true;
    }

    function formatRupiah(angka) {
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.produk-checkbox:checked').forEach(cb => {
            const harga = parseInt(cb.dataset.harga);
            const jumlah = parseInt(cb.dataset.jumlah);
            total += harga * jumlah;
        });
        document.getElementById('totalHargaTampil').textContent = 'Total: ' + formatRupiah(total);
        document.getElementById('total_dikirim').value = total;
    }

    document.addEventListener('DOMContentLoaded', updateTotal);

    document.querySelectorAll('.produk-checkbox').forEach(cb => {
        cb.addEventListener('change', updateTotal);
    });
</script>
@endsection
