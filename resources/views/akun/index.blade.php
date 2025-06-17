@extends('layouts.appAdmin')

@section("content")
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 text-center rounded">
        {{ session('success') }}
    </div>
@endif

<main class="p-6">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-6xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">List Akun yang Terdaftar</h2>

        <form action="{{ route('FilterAkun') }}" method="GET" class="flex justify-end mb-4">
            <select name="filter" id="filter" class="border border-gray-300 rounded px-3 py-2 mr-2">
                <option value="semua">Semua</option>
                <option value="petani">Petani</option>
                <option value="konsumen">Konsumen</option>
            </select>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Filter</button>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-green-700 text-white">
                    <tr>
                        <th class="text-left py-3 px-4">ID User</th>
                        <th class="text-left py-3 px-4">Username</th>
                        <th class="text-left py-3 px-4">Email</th>
                        <th class="text-left py-3 px-4">Password</th>
                        <th class="text-left py-3 px-4">Role</th>
                        <th class="text-center py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($akun as $user)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-2 px-4">{{ $user->user_id }}</td>
                        <td class="py-2 px-4">{{ $user->username }}</td>
                        <td class="py-2 px-4">{{ $user->email }}</td>
                        <td class="py-2 px-4">{{ $user->password }}</td>
                        <td class="py-2 px-4">{{ $user->role }}</td>
                        <td class="flex justify-center">
                            <form class="deleteForm" action="{{ route('HapusAkun', $user->user_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="button" class="deleteButton bg-red-600 text-white px-4 py-2 my-2 rounded hover:bg-red-700 transition">Hapus</button>
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
