@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="container mx-auto mt-6 px-4">
    <h2 class="text-xl font-semibold mb-4">Pesanan Saya</h2>

    {{-- Flash message jika ada --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($transaksi->isEmpty())
        <div class="text-gray-600">Belum ada pesanan.</div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-md text-sm">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">#</th>
                        <th class="py-2 px-4 text-left">Tanggal</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Total</th>
                        <th class="py-2 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-4">{{ $loop->iteration }}</td>
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                            <td class="py-2 px-4">{{ $item->status ?? 'Pending' }}</td>
                            <td class="py-2 px-4">Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('transaksi.show', $item->transaksi_id) }}" class="text-blue-600 hover:underline">Lihat</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
