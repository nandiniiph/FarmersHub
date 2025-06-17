@extends($layout)

@section('title', 'Invoice')

@section('content')
<div class="container mx-auto py-6 px-4">
    <div class="bg-white p-6 rounded shadow-md border">
        <h2 class="text-2xl font-bold mb-4">Invoice Transaksi</h2>

        <div class="mb-4">
            <p><strong>ID Transaksi:</strong> {{ $transaksi->transaksi_id }}</p>
            <p><strong>Nama Pembeli:</strong> {{ $transaksi->User->username }}</p>
            <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y - H:i') }}</p>
            <p><strong>Status:</strong> {{ $transaksi->status }}</p>
        </div>

        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Produk</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Harga Satuan</th>
                    <th class="px-4 py-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($transaksi->DetailTransaksi as $item)
                    @php $subtotal = $item->jumlah * $item->Produk->harga; $total += $subtotal; @endphp
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->Produk->nama_produk }}</td>
                        <td class="px-4 py-2">{{ $item->jumlah }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($item->Produk->harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr class="font-bold border-t bg-gray-50">
                    <td colspan="3" class="px-4 py-2 text-right">Total</td>
                    <td class="px-4 py-2">Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="mt-6">
            <a href="{{ url()->previous() }}" class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded">Kembali</a>
        </div>
    </div>
</div>
@endsection
