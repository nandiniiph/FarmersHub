@php
    use Carbon\Carbon;
@endphp

@extends('layouts.appAdmin')

@section("content")
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 text-center rounded">
        {{ session('success') }}
    </div>
@endif

<main class="p-6">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-6xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">List Permohonan Upgrade Akun</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="text-left py-3 px-4">ID</th>
                        <th class="text-left py-3 px-4">Tanggal</th>
                        <th class="text-left py-3 px-4">Username</th>
                        <th class="text-left py-3 px-4">Nama Lengkap</th>
                        <th class="text-left py-3 px-4">Nomor HP</th>
                        <th class="text-left py-3 px-4">Nama Usaha</th>
                        <th class="text-left py-3 px-4">Alamat Lengkap</th>
                        <th class="text-center py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Permohonans as $permohonan)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-2 px-4">{{ $permohonan->permohonan_id }}</td>
                        <td class="py-2 px-4">{{ \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d M Y') }}</td>
                        <td class="py-2 px-4">{{ $permohonan->username }}</td>
                        <td class="py-2 px-4">{{ $permohonan->nama_lengkap }}</td>
                        <td class="py-2 px-4">{{ $permohonan->nomor_hp }}</td>
                        <td class="py-2 px-4">{{ $permohonan->nama_usaha }}</td>
                        <td class="py-2 px-4">{{ $permohonan->alamat_lengkap }}</td>
                        <td class="flex justify-center">
                            <form action="" method="" style="display:inline;">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 my-2 mx-1 rounded hover:bg-red-700 transition">Tolak</button>
                            </form>
                            <form action="" method="" style="display:inline;">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 my-2 mx-1 rounded hover:bg-green-700 transition">Setujui</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative bg-white rounded-lg shadow-lg p-6 max-w-sm w-full z-50">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Penghapusan Akun</h2>
        <p>Apakah Anda yakin ingin menghapus akun ini?</p>
        <div class="flex justify-end mt-4">
            <button id="cancelDelete" class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2">Batal</button>
            <button id="confirmDelete" class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('deleteModal');
        const cancelBtn = document.getElementById('cancelDelete');
        const confirmBtn = document.getElementById('confirmDelete');
        let deleteForm = null;

        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function () {
                deleteForm = this.closest('form');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        confirmBtn.addEventListener('click', () => {
            if (deleteForm) {
                deleteForm.submit();
            }
        });
    });
</script>
@endsection
