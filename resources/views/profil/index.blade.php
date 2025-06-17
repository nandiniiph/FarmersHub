@php
    $layout = 'layouts.appKonsumen';
    if (Auth::check()) {
        if (Auth::user()->role === 'Admin') {
            $layout = 'layouts.appAdmin';
        } elseif (Auth::user()->role === 'Petani') {
            $layout = 'layouts.appPetani';
        }
    }
@endphp

@extends($layout)

@section("content")
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 text-center rounded">
        {{ session('success') }}
    </div>
@endif

<main class="p-6">

    <div class="bg-white shadow-md rounded-lg p-8 max-w-2xl mx-auto">
        <div class="flex justify-between items-start">
            <div class="flex items-center gap-4">
                <div>
                    <h3 class="text-3xl font-bold text-gray-900">{{ $user->username }}</h3>
                    <p class="text-gray-600 text-lg">{{ $user->role }}</p>
                </div>
            </div>
            <a href="{{ route('showEditProfil') }}" class="bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600">Edit</a>
        </div>

        <div class="grid grid-cols-1 gap-6 mt-8">
            <div>
                <label class="block font-semibold text-gray-700">Username</label>
                <input type="text" value="{{ $user->username }}" class="w-full border border-green-700 rounded px-3 py-2 mt-1" disabled>

                <label class="block font-semibold text-gray-700 mt-4">Email</label>
                <input type="text" value="{{ $user->email }}" class="w-full border border-green-700 rounded px-3 py-2 mt-1" disabled>

                <label class="block font-semibold text-gray-700 mt-4">Sandi</label>
                <input type="password" value="********" class="w-full border border-green-700 rounded px-3 py-2 mt-1" disabled>
            </div>
        </div>

        <div class="flex justify-center mt-8">
            <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="button" id="logoutButton" class="bg-red-600 hover:bg-red-700 text-white font-medium px-5 py-2 rounded">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div id="logoutModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative bg-white rounded-lg shadow-lg p-6 max-w-sm w-full z-50">
            <h2 class="text-lg font-bold mb-4">Konfirmasi LogOut</h2>
            <p>Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="flex justify-end mt-4">
                <button id="cancelLogout" class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2">Tidak</button>
                <button id="confirmLogout" class="bg-red-600 text-white px-4 py-2 rounded">Logout</button>
            </div>
        </div>
    </div>

</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoutBtn = document.getElementById('logoutButton');
        const modal = document.getElementById('logoutModal');
        const cancelBtn = document.getElementById('cancelLogout');
        const confirmBtn = document.getElementById('confirmLogout');
        const logoutForm = document.getElementById('logoutForm');

        logoutBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });

        cancelBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        confirmBtn.addEventListener('click', () => {
            logoutForm.submit();
        });
    });
</script>
@endsection

