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
        <form id="checkoutForm" action="{{ route('checkout') }}" method="POST" class="mt-4" onsubmit="return validateCheckout()">
            @csrf
            <table class="w-full table-auto border-collapse">
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
                    @php $total = 0; @endphp
                    @foreach($keranjang->DetailKeranjang as $item)
                        @php
                            $subtotal = $item->jumlah * $item->Produk->harga;
                            $total += $subtotal;
                        @endphp
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2">
                                <input type="checkbox" name="produk_terpilih[]" value="{{ $item->detail_keranjang_id }}" class="accent-green-600">
                            </td>
                            <td class="p-2">{{ $item->Produk->nama_produk }}</td>
                            <td class="p-2">Rp {{ number_format($item->Produk->harga, 0, ',', '.') }}</td>
                            <td class="p-2">{{ $item->jumlah }}</td>
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

            <div class="text-right mt-4">
                <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition-all duration-200">
                    Checkout Produk Terpilih
                </button>
            </div>
        </form>

        {{-- FORM HAPUS DI LUAR FORM CHECKOUT --}}
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

{{-- Script untuk validasi checkbox --}}
<script>
    function validateCheckout() {
        const checkedItems = document.querySelectorAll('input[name="produk_terpilih[]"]:checked');
        if (checkedItems.length === 0) {
            alert("Pilih minimal satu produk untuk checkout.");
            return false;
        }
        return true;
    }
</script>
@endsection
