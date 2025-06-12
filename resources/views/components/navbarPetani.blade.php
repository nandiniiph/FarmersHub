<nav class="bg-green-700 text-white shadow-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center text-2xl font-bold">
                    <a href="{{ route('showDashboardPetani') }}">FarmersHub</a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8 ml-10">
                    <a href="{{ route('akun.petani') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Akun</a>
                    <a href="{{ route('penjualan.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Belanja</a>
                    <a href="{{ route('riwayat.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Riwayat</a>
                    <a href="{{ route('produk.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Produk</a>
                    <a href="{{ route('pesanan.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Pesanan</a>
                </div>
            </div>
            <div class="flex items-center">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
<div class="h-16"></div> <!-- Spacer agar konten tidak tertutup navbar -->
