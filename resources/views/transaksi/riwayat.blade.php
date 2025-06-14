@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="container mt-4">
    <h2>Riwayat Pesanan</h2>

    @if ($transaksi->isEmpty())
        <div class="alert alert-info">Belum ada riwayat pesanan.</div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi as $item)
                    @if ($item->status === 'Selesai')
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M Y') }}</td>
                        <td>{{ $item->status }}</td>
                        <td>Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('transaksi.show', $item->transaksi_id) }}" class="btn btn-sm btn-secondary">Detail</a>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
