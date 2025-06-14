@extends($layout)

@section('title', 'Detail Transaksi')

@section('content')
<div class="container mt-4">
    <h2 class="text-xl font-semibold mb-4">Detail Transaksi</h2>

    <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y') }}</p>
    <p><strong>Status:</strong> {{ $transaksi->status }}</p>
    <p><strong>Total:</strong> Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>

    <h3 class="mt-4 mb-2 font-semibold">Produk:</h3>
    <table class="w-full table-auto border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">Nama Produk</th>
                <th class="px-4 py-2">Jumlah</th>
                <th class="px-4 py-2">Harga Satuan</th>
                <th class="px-4 py-2">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->detailTransaksi as $detail)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $detail->produk->nama_produk }}</td>
                    <td class="px-4 py-2">{{ $detail->jumlah }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($detail->jumlah * $detail->harga_satuan, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
