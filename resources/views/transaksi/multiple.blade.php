@extends($layout)

@section('title', 'Daftar Transaksi Checkout')

@section('content')
<div class="max-w-4xl mx-auto mt-6 space-y-10">
    <h2 class="text-2xl font-bold text-center">Berikut adalah daftar transaksi Anda:</h2>

    @foreach ($transaksis as $transaksi)
    <div class="bg-white p-6 shadow rounded">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold">Invoice #{{ $transaksi->transaksi_id }}</h3>
        </div>

        <div class="mb-6">
            <p><strong>Nama:</strong> {{ $transaksi->User->username }}</p>
            <p><strong>Email:</strong> {{ $transaksi->User->email }}</p>

            <p><strong>Status Pembayaran:</strong>
                <span class="inline-block px-2 py-1 rounded
                    {{ match($transaksi->status) {
                        'Menunggu Pembayaran' => 'bg-yellow-200 text-yellow-800',
                        'Selesai', 'Lunas' => 'bg-green-200 text-green-800',
                        'Batal' => 'bg-red-200 text-red-800',
                        default => 'bg-gray-200 text-gray-800'
                    } }}">
                    {{ $transaksi->status }}
                </span>
            </p>

            <p><strong>Status Pesanan:</strong>
                @php
                    $statusPesanan = $transaksi->detailTransaksi->first()->status ?? '-';
                @endphp

                <span class="inline-block px-2 py-1 rounded text-sm
                    @switch($statusPesanan)
                        @case('Menunggu') bg-gray-200 text-gray-800 @break
                        @case('Diproses') bg-yellow-100 text-yellow-700 @break
                        @case('Dikirim') bg-blue-100 text-blue-700 @break
                        @case('Selesai') bg-green-200 text-green-800 @break
                        @case('Batal') bg-red-200 text-red-800 @break
                        @default bg-gray-100 text-gray-600
                    @endswitch">
                    {{ $statusPesanan }}
                </span>
            </p>
        </div>

        <h4 class="font-semibold text-lg mb-2">Detail Produk:</h4>
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">Produk</th>
                    <th class="border px-4 py-2 text-center">Jumlah</th>
                    <th class="border px-4 py-2 text-right">Harga Satuan</th>
                    <th class="border px-4 py-2 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->detailTransaksi as $detail)
                    <tr>
                        <td class="border px-4 py-2">{{ $detail->produk->nama_produk }}</td>
                        <td class="border px-4 py-2 text-center">{{ $detail->jumlah }}</td>
                        <td class="border px-4 py-2 text-right">Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                        <td class="border px-4 py-2 text-right">Rp{{ number_format($detail->jumlah * $detail->harga_satuan, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="bg-gray-50 font-bold">
                    <td colspan="3" class="border px-4 py-2 text-right">Total</td>
                    <td class="border px-4 py-2 text-right">Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        @if ($transaksi->status === 'Pending')
            <div class="mt-6">
                <h4 class="text-lg font-semibold mb-2">Pilih Metode Pembayaran:</h4>
                <form action="{{ route('transaksi.bayar', $transaksi->transaksi_id) }}" method="POST">
                    @csrf
                    <div class="space-y-2">
                        <label class="block">
                            <input type="radio" name="metode_pembayaran" value="Transfer Bank" required>
                            <span class="ml-2">Transfer Bank (BCA, BRI, Mandiri)</span>
                        </label>
                        <label class="block">
                            <input type="radio" name="metode_pembayaran" value="E-Wallet" required>
                            <span class="ml-2">E-Wallet (OVO, GoPay, Dana)</span>
                        </label>
                        <label class="block">
                            <input type="radio" name="metode_pembayaran" value="COD" required>
                            <span class="ml-2">Bayar di Tempat (COD)</span>
                        </label>
                    </div>
                    <button type="submit"
                        class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        @endif

        @if (in_array($transaksi->status, ['Pending', 'Menunggu Pembayaran']))
            <form action="{{ route('transaksi.batal', $transaksi->transaksi_id) }}" method="POST" class="mt-4"
                onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                @csrf
                @method('PUT')
                <button type="submit"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Batalkan Pesanan
                </button>
            </form>
        @endif
    </div>
    @endforeach

    <div class="text-center">
        <a href="{{ route('belanja.index') }}"
           class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
            ← Kembali ke Belanja
        </a>
    </div>
</div>
@endsection
