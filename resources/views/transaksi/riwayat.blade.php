@extends($layout)

@section('title', 'Riwayat Pemesanan')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Riwayat Pemesanan</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($transaksiList->count())
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-green-700 text-white">
                    <th class="p-2 text-left">Tanggal</th>
                    <th class="p-2 text-left">Total</th>
                    <th class="p-2 text-left">Jumlah Item</th>
                    <th class="p-2 text-left">Status</th>
                    <th class="p-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksiList as $item)
                    @php
                        $statusPesanan = $item->detailTransaksi->first()->status ?? '-';
                    @endphp
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }}
                        </td>
                        <td class="p-2">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td class="p-2">{{ $item->detailTransaksi->count() }} item</td>

                        {{-- Status Final --}}
                        <td class="p-2">
                            @if($item->status === 'Batal')
                                <span class="inline-block bg-red-200 text-red-800 px-2 py-1 rounded text-sm">Batal</span>
                            @elseif($statusPesanan === 'Selesai')
                                <span class="inline-block bg-green-200 text-green-800 px-2 py-1 rounded text-sm">Selesai</span>
                            @endif
                        </td>

                        <td class="p-2">
                            <a href="{{ route('transaksi.show', $item->transaksi_id) }}"
                               class="text-green-700 hover:underline">Lihat Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">Belum ada riwayat pemesanan.</p>
    @endif
</div>
@endsection
