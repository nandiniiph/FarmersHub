<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmersHub - Platform E-Commerce Pertanian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700');

        * {
            font-family: 'Inter';
        }

        .gradient-bg {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
    </style>
</head>

<body class="bg-white">
    <nav class="bg-white shadow-sm border-b fixed w-full z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16 flex-wrap">
                <div class="flex items-center">
                    <span class="text-2xl mr-2">🌾</span>
                    <span class="text-xl font-bold text-gray-900">FarmersHub</span>
                </div>
                <div class="flex items-center space-x-4 flex-wrap justify-end">
                    <a href="{{ route('showRegister') }}" class="text-green-600 hover:text-green-700 font-medium">Daftar</a>
                    <a href="{{ route('showLogin') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">Masuk</a>
                </div>
            </div>
        </div>
    </nav>

    <section id="beranda" class="pt-16 gradient-bg">
        <div class="max-w-6xl mx-auto px-4 py-20">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">
                        Hubungkan <span class="text-yellow-300">Petani</span> & <span class="text-green-200">Konsumen</span>
                    </h1>
                    <p class="text-xl text-green-100 mb-8">
                        Platform e-commerce pertanian yang mempertemukan petani dengan konsumen secara langsung.
                        Dapatkan hasil panen segar dengan harga terbaik, tanpa perantara.
                    </p>
                    <a href="#" class="inline-block bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors">
                        Mulai Berbelanja
                    </a>
                </div>
                <div class="text-center">
                    <div class="bg-white rounded-2xl p-8 shadow-lg">
                        <div class="w-16 h-16 bg-green-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Produk Segar</h3>
                        <p class="text-gray-600">Langsung dari kebun ke meja Anda</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="why-us" class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Pilih FarmersHub?</h2>
                <p class="text-lg text-gray-600">
                    Platform yang dirancang khusus untuk memudahkan petani dan konsumen dalam bertransaksi hasil pertanian
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border text-center">
                    <div class="text-4xl mb-4">🌾</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Langsung dari Petani</h3>
                    <p class="text-gray-600">
                        Tanpa perantara, harga lebih adil bagi petani & konsumen. Hubungkan konsumen langsung dengan petani lokal.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border text-center">
                    <div class="text-4xl mb-4">💰</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Terjangkau</h3>
                    <p class="text-gray-600">
                        Tanpa biaya tambahan dari pihak ketiga, FarmersHub memastikan Anda mendapatkan harga terbaik untuk hasil pertanian berkualitas.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border text-center">
                    <div class="text-4xl mb-4">📱</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Akses Mudah</h3>
                    <p class="text-gray-600">
                        Website yang mudah digunakan kapan saja, di mana saja — cocok untuk semua kalangan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section id="cara-kerja" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Kerja Platform</h2>
                <p class="text-lg text-gray-600">Proses sederhana dalam 3 langkah</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-xl font-bold">
                        1
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Daftar & Masuk</h3>
                    <p class="text-gray-600">
                        Daftar sebagai pengguna baru atau masuk jika sudah memiliki akun. Untuk menjadi petani, ajukan upgrade setelah login.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-xl font-bold">
                        2
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Jual & Beli</h3>
                    <p class="text-gray-600">
                        Petani terverifikasi dapat upload produk dengan foto dan deskripsi. Konsumen browse, pilih, dan beli produk favorit.
                    </p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-4 text-white text-xl font-bold">
                        3
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Transaksi Aman</h3>
                    <p class="text-gray-600">
                        Pembayaran aman, pengiriman terpercaya, dan sistem review untuk membangun kepercayaan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">Apa Kata Mereka?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <p class="text-gray-700 mb-4">"Sangat membantu! Saya bisa jual hasil panen langsung tanpa ribet."</p>
                    <div class="font-semibold text-green-600">Budi, Petani Sayur</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <p class="text-gray-700 mb-4">"Harganya lebih murah dan barangnya segar banget!"</p>
                    <div class="font-semibold text-green-600">Riskilia, Konsumen</div>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <p class="text-gray-700 mb-4">"FarmersHub bantu saya temukan pasar baru tiap minggu."</p>
                    <div class="font-semibold text-green-600">Pak Reno, Petani Padi</div>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Tentang FarmersHub</h2>
                    <p class="text-gray-700 mb-6">
                        FarmersHub adalah platform e-commerce pertanian yang dirancang untuk mengatasi kesenjangan antara petani dan konsumen.
                        Kami percaya bahwa teknologi dapat membantu menciptakan ekosistem pertanian yang lebih adil dan berkelanjutan.
                    </p>
                    <p class="text-gray-700 mb-6">
                        Dengan menghilangkan perantara yang merugikan, kami membantu petani mendapatkan harga yang layak untuk hasil panen mereka,
                        sementara konsumen mendapatkan produk segar dengan harga terjangkau.
                    </p>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-700">Mendukung petani lokal Indonesia</span>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-2xl p-8">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900">Untuk Petani</h4>
                            <p class="text-gray-600 text-sm">Jangkauan pasar lebih luas</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900">Untuk Konsumen</h4>
                            <p class="text-gray-600 text-sm">Produk segar harga terjangkau</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-green-600">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">Siap Bergabung dengan FarmersHub?</h2>
            <p class="text-xl text-green-100 mb-8">
                Mulai perjalanan Anda bersama komunitas petani dan konsumen yang saling mendukung
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('showRegister') }}" class="bg-white text-green-600 px-8 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors">
                    Daftar Sekarang
                </a>
                <a href="{{ route('showLogin') }}" class="border-2 border-white text-white hover:bg-white hover:text-green-600 px-8 py-3 rounded-lg font-semibold transition-colors">
                    Sudah Punya Akun? Masuk
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-6xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-2">
                    <div class="flex items-center mb-4">
                        <span class="text-xl mr-2">🌾</span>
                        <span class="text-xl font-bold">FarmersHub</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Platform e-commerce pertanian yang menghubungkan petani dengan konsumen secara langsung untuk menciptakan ekosistem pertanian yang lebih adil.
                    </p>
                </div>
                <div>
                    <h3 class="font-semibold mb-4">Platform</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Untuk Petani</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Untuk Konsumen</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Cara Kerja</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kebijakan</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-4">Dukungan</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Bantuan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kontak</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 FarmersHub</p>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
