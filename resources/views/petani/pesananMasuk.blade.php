@extends($layout)

@section('title', 'Pesanan Masuk')

@section('content')
<div class="container py-5">
    <h2 class="text-2xl font-bold mb-4">Pesanan Masuk</h2>

    @if($pesananMasuk->isEmpty())
        <p class="text-gray-500">Belum ada pesanan untuk produk Anda.</p>
    @else
        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2">Nama Produk</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Pembeli</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesananMasuk as $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $item->Produk->nama_produk }}</td>
                        <td class="px-4 py-2">{{ $item->jumlah }}</td>
                        <td class="px-4 py-2">{{ $item->Transaksi->User->username ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->status }}</td>
                        <td class="px-4 py-2 space-y-1">
                            {{-- Tombol Proses / Kirim --}}
                            @if($item->status === 'Menunggu')
                                <form action="{{ route('transaksi.updateStatus', $item->detail_transaksi_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Diproses">
                                    <button class="bg-yellow-400 px-2 py-1 rounded text-sm">Proses</button>
                                </form>
                            @elseif($item->status === 'Diproses')
                                <form action="{{ route('transaksi.updateStatus', $item->detail_transaksi_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="Dikirim">
                                    <button class="bg-blue-500 text-white px-2 py-1 rounded text-sm">Kirim</button>
                                </form>
                            @elseif($item->status === 'Dikirim')
                                <span class="text-green-600 font-semibold">Dikirim</span>
                            @else
                                <span class="text-gray-500 italic">Selesai</span>
                            @endif

                            {{-- Tombol Lihat Invoice --}}
                            <a href="{{ route('transaksi.invoice', $item->Transaksi->transaksi_id) }}"
                            class="bg-green-600 text-white px-2 py-1 rounded text-sm hover:bg-green-700 block">Lihat Invoice</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
