<nav class="bg-green-700 text-white shadow-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center text-2xl font-bold">
                    <a href="{{ route('showDashboardKonsumen') }}">FarmersHub</a>
                </div>
            </div>
            <div class="flex items-center">
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8 ml-10">
                    <a href="{{ route('belanja.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Belanja</a>
                    <a href="{{ route('keranjang.lihat') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Keranjang</a>
                    <a href="{{ route('pesanan.saya') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Pesanan Saya</a>
                    <a href="{{ route('transaksi.riwayat') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Riwayat</a>
                    <a href="{{ route('upgrade.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Upgrade</a>
                    <a href="{{ route('profil.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium hover:underline">Profil</a>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="h-16"></div>
