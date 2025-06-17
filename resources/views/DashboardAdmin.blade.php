@extends('layouts.appAdmin')

@section('content')
<div class="p-6">
    <h2 class="text-3xl font-bold mb-8 text-center text-gray-800">Selamat Datang, Admin</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-700 text-white shadow-lg rounded-lg p-6 flex items-center justify-between hover:scale-[1.02] transition-transform duration-300">
            <div>
                <h3 class="text-lg font-semibold">Total Users</h3>
                <p class="text-3xl font-bold">{{ $totalUsers }}</p>
            </div>
            <i class="fas fa-users text-4xl"></i>
        </div>

        <div class="bg-gradient-to-r from-red-400 to-red-600 text-white shadow-lg rounded-lg p-6 flex items-center justify-between hover:scale-[1.02] transition-transform duration-300">
            <div>
                <h3 class="text-lg font-semibold">Permohonan Menunggu</h3>
                <p class="text-3xl font-bold">{{ $totalPermohonanMenunggu }}</p>
            </div>
            <i class="fas fa-hourglass-half text-4xl"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-gradient-to-r from-green-400 to-green-600 text-white shadow-lg rounded-lg p-6 flex items-center justify-between hover:scale-[1.02] transition-transform duration-300">
            <div>
                <h3 class="text-lg font-semibold">Total Petani</h3>
                <p class="text-3xl font-bold">{{ $totalPetani }}</p>
            </div>
            <i class="fas fa-tractor text-4xl"></i>
        </div>

        <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-white shadow-lg rounded-lg p-6 flex items-center justify-between hover:scale-[1.02] transition-transform duration-300">
            <div>
                <h3 class="text-lg font-semibold">Total Konsumen</h3>
                <p class="text-3xl font-bold">{{ $totalKonsumen }}</p>
            </div>
            <i class="fas fa-shopping-basket text-4xl"></i>
        </div>
    </div>
</div>
@endsection
