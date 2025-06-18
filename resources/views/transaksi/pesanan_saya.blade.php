@extends($layout)

@section('title', 'Pesanan Saya')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Pesanan Saya</h1>
    <div class="mb-4">
        <a href="{{ route('transaksi.semua') }}"
            class="inline-block bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800 transition">
                Lihat Semua Transaksi
        </a>

    </div>

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
                    <th class="p-2 text-left">Status Pembayaran</th>
                    <th class="p-2 text-left">Status Pesanan</th>
                    <th class="p-2 text-left">Jumlah Item</th>
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

                        {{-- Status Pembayaran --}}
                        <td class="p-2">
                            <span class="inline-block px-2 py-1 rounded text-sm
                                @if($item->status == 'Lunas') bg-green-200 text-green-800
                                @elseif($item->status == 'Batal') bg-red-200 text-red-800
                                @else bg-gray-200 text-gray-800
                                @endif">
                                {{ $item->status }}
                            </span>
                        </td>

                        {{-- Status Pesanan --}}
                        <td class="p-2 text-sm">
                            @if($statusPesanan === 'Menunggu')
                                <span class="inline-block bg-gray-200 text-gray-800 px-2 py-1 rounded text-sm">Menunggu</span>
                            @elseif($statusPesanan === 'Diproses')
                                <span class="inline-block bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">Diproses</span>
                            @elseif($statusPesanan === 'Dikirim')
                                <form action="{{ route('transaksi.konfirmasiSelesai', $item->transaksi_id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="bg-blue-500 text-white px-3 py-1 text-sm rounded hover:bg-blue-600">
                                        Pesanan Diterima
                                    </button>
                                </form>
                            @elseif($statusPesanan === 'Selesai')
                                <span class="inline-block bg-green-200 text-green-800 px-2 py-1 rounded text-sm">Selesai</span>
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>

                        <td class="p-2">{{ $item->detail_transaksi_count }} item</td>
                        <td class="p-2">
                            <a href="{{ route('transaksi.show', $item->transaksi_id) }}"
                               class="text-green-700 hover:underline">Lihat Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-600">Belum ada pesanan.</p>
    @endif
</div>
@endsection
