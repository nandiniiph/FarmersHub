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
<main class="p-6">

    <div class="bg-white shadow-md rounded-lg p-8 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Edit Profil</h2>

        <div class="flex justify-center">
            @if ($errors->any())
                <div class="mb-4 text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <form action="{{ route('updateProfil') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6 mt-4">
                <div>
                    <label class="block font-semibold text-gray-700">Username</label>
                    <input type="text" name="username" value="{{ $user->username }}" class="w-full border border-green-700 rounded px-3 py-2 mt-1" required>

                    <label class="block font-semibold text-gray-700 mt-4">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full border border-green-700 rounded px-3 py-2 mt-1" required>

                    <label class="block font-semibold text-gray-700 mt-4">Sandi</label>
                    <input type="password" name="password" class="w-full border border-green-700 rounded px-3 py-2 mt-1" placeholder="Masukkan sandi baru jika ingin mengubah">
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <a href="{{ route('profil.index') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Batal</a>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan</button>
            </div>
        </form>
    </div>

</main>

@endsection
