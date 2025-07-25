<nav class="bg-green-700 text-white shadow-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center text-2xl font-bold">
                    <a href="{{ route('showDashboardPetani') }}">FarmersHub</a>
                </div>
            </div>
            <div class="flex items-center">
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8 ml-10">
                    <a href="{{ route('belanja.index') }}"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded hover:underline
                                {{ Route::is('belanja.index') ? 'bg-green-100 text-green-800' : '' }}">
                        Belanja
                        </a>

                        <a href="{{ route('keranjang.lihat') }}"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded hover:underline
                                {{ Route::is('keranjang.lihat') ? 'bg-green-100 text-green-800' : '' }}">
                        Keranjang
                        </a>

                        <a href="{{ route('pesanan.saya') }}"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded hover:underline
                                {{ Route::is('pesanan.saya') ? 'bg-green-100 text-green-800' : '' }}">
                        Pesanan Saya
                        </a>

                        <a href="{{ route('transaksi.riwayat') }}"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded hover:underline
                                {{ Route::is('transaksi.riwayat') ? 'bg-green-100 text-green-800' : '' }}">
                        Riwayat
                        </a>

                        <a href="{{ route('produk.index') }}"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded hover:underline
                                {{ Route::is('produk.index') ? 'bg-green-100 text-green-800' : '' }}">
                        Produk
                        </a>

                        <a href="{{ route('pesanan.masuk') }}"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded hover:underline
                                {{ Route::is('pesanan.masuk') ? 'bg-green-100 text-green-800' : '' }}">
                        Pesanan Masuk
                        </a>

                        <a href="{{ route('profil.index') }}"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded hover:underline
                                {{ Route::is('profil.index') ? 'bg-green-100 text-green-800' : '' }}">
                        Profil
                        </a>

                </div>
            </div>
        </div>
    </div>
</nav>
<div class="h-16"></div>
