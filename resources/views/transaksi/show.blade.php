@extends($layout)

@section('title', 'Detail Transaksi')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 shadow rounded mt-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Invoice #{{ $transaksi->transaksi_id }}</h2>
    </div>

    <div class="mb-6">
        <p><strong>Nama:</strong> {{ $transaksi->User->username }}</p>
        <p><strong>Email:</strong> {{ $transaksi->User->email }}</p>
        <p><strong>Status:</strong>
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
    </div>

    <h3 class="font-semibold text-lg mb-2">Detail Produk:</h3>
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

    {{-- Metode Pembayaran --}}
    @if ($transaksi->status === 'Pending')
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-2">Pilih Metode Pembayaran:</h3>
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

    {{-- Tombol Batalkan Pesanan --}}
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
@endsection
