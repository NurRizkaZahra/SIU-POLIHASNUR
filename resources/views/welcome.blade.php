<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Politeknik Hasnur - SIU</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" /> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Gaya Kustom Utama */
        body { font-family: 'Instrument Sans', sans-serif; background-color: #FDFDFC; }
        .text-polihasnur-blue { color: #1A56A8; }
        .bg-polihasnur-blue { background-color: #1A56A8; }
        .border-polihasnur-blue { border-color: #1A56A8; }
        .bg-dark-blue { background-color: #1A56A8; }
        .bg-gradient-hero { background: linear-gradient(135deg, #A8E8FD 0%, #DFF8FF 100%); position: relative; overflow: hidden; min-height: 400px; }
        .hero-building-image { position: absolute; bottom: 0; left: 50%; width: 120%; max-width: 1500px; height: auto; transform: translateX(-50%); z-index: 0; opacity: 0.5; }
        .hero-content { position: relative; z-index: 10; padding-bottom: 180px; }
        .campus-badge { background-color: #FFFFFF; color: #1A56A8; font-weight: 800; padding: 1rem 1.5rem; border-radius: 0.5rem; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transform: rotate(7deg); position: absolute; top: 50px; right: 50px; z-index: 15; }
        .campus-badge::before { content: ''; position: absolute; top: -10px; left: -10px; right: -10px; bottom: -10px; background: linear-gradient(45deg, #FFA0B0, #FFE6D6); z-index: -1; border-radius: 0.75rem; filter: blur(8px); }
        .campus-badge span { position: relative; z-index: 1; display: block; }

        /* Gaya Khusus Card Program Studi */
        .study-card { background-size: cover; background-position: center; height: 300px; border-radius: 0.75rem; position: relative; overflow: hidden; display: flex; align-items: flex-end; padding: 1.5rem; color: white; transition: transform 0.3s ease; }
        .study-card::before { content: ''; position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 50%); }
        .study-card:hover { transform: translateY(-5px); }
        .study-card-content { position: relative; z-index: 20; width: 100%; display: flex; justify-content: space-between; align-items: center; }
        
        /* Gaya untuk Carousel/Slider */
        .carousel-wrapper {
            display: flex;
            transition: transform 0.3s ease-in-out;
        }
        .carousel-item {
            flex-shrink: 0;
            width: 100%;
        }

        /* Gaya untuk Footer */
        .footer-link {
            @apply text-white text-opacity-80 hover:text-white transition-colors duration-200;
        }
    </style>
</head>
<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen">

    <nav class="bg-white shadow-sm py-4">
        <div class="flex items-center justify-between w-full max-w-7xl mx-auto px-4">
            <div class="flex items-center">
                <img src="{{ asset('images/logo polhas.png') }}" alt="Logo Politeknik Hasnur" class="h-10"> 
            </div>
            <div class="hidden md:flex items-center space-x-8 text-base">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-polihasnur-blue font-medium">Home</a>
                <a href="#" class="text-gray-700 hover:text-polihasnur-blue font-medium">Profil</a>
                <a href="#" class="text-gray-700 hover:text-polihasnur-blue font-medium">Program Studi</a>
                <a href="#" class="text-gray-700 hover:text-polihasnur-blue font-medium">About Us</a>
            </div>
            <div class="flex items-center space-x-3 text-sm">
                <a href="{{ route('login') }}" class="px-5 py-2 border border-polihasnur-blue text-polihasnur-blue hover:bg-polihasnur-blue hover:text-white rounded-md transition-all font-semibold">Log In</a>
                <a href="{{ route('register') }}" class="px-5 py-2 bg-polihasnur-blue border border-polihasnur-blue text-white hover:bg-blue-700 rounded-md transition-all font-semibold">Register</a>
            </div>
        </div>
    </nav>

    <main class="w-full max-w-7xl mx-auto px-4">
        
        <div class="bg-gradient-hero rounded-lg overflow-hidden relative shadow-xl mt-6">
            <div class="campus-badge relative inline-block text-center whitespace-nowrap">
                <span class="text-xl text-red-600">KAMPUS BARU</span>
                <span class="text-3xl font-extrabold">POLIHASNUR</span>
                <span class="text-lg text-gray-800">DI HANDIL BAKTI</span>
            </div>

            <div class="hero-content flex flex-col md:flex-row items-start p-8 md:p-12 relative">
                <div class="text-left md:w-2/3 lg:w-1/2 z-10">
                    <h1 class="text-4xl lg:text-5xl font-extrabold mb-4 leading-tight text-polihasnur-blue">Selamat Datang di <br>SIU (Sistem Informasi Ujian) <br>Politeknik Hasnur</h1>
                    <p class="text-base text-gray-700 mb-8 max-w-lg">Sistem ini adalah sarana pendukung pelaksanaan Ujian Akhir Semester, UTS, Ujian Susulan, dan Ujian Lainnya. Melalui platform ini, mahasiswa dapat mengikuti ujian secara online, aman, dan mudah diakses di mana saja.</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-polihasnur-blue text-white font-semibold rounded-md hover:bg-blue-700 transition-all text-base">Daftar Sekarang</a>
                        <a href="#" class="inline-block px-8 py-3 border border-polihasnur-blue text-polihasnur-blue font-semibold rounded-md hover:bg-blue-50 transition-all text-base">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>

            <img 
                src="{{ asset('images/proyek 3.png') }}" 
                alt="Gedung Politeknik Hasnur" 
                class="hero-building-image" 
            />
        </div>
        
        <div class="bg-white p-8 md:p-12 mt-6 mb-12 rounded-lg shadow-xl border border-gray-200">
            <div class="text-center mb-8">
                <h2 class="text-xl font-bold mb-1 text-polihasnur-blue">VISI</h2>
                <p class="text-base text-gray-700 max-w-4xl mx-auto">Menjadikan Politeknik yang Unggul Berbasis Kompetensi Kerja dan Berkarakter Kewirausahaan serta Profesional di Bidangnya.</p>
            </div>
            <hr class="my-6 border-gray-200">
            <div>
                <h2 class="text-xl font-bold mb-4 text-center text-polihasnur-blue">MISI</h2>
                <p class="text-base text-gray-700 mb-4">Untuk mewujudkan visi Polihasnur, ditetapkan misi sebagai berikut :</p>
                <ol class="list-decimal list-inside space-y-3 pl-4 text-base text-gray-700">
                    <li>Menyelenggarakan program pendidikan vokasi integratif dengan mutu, memiliki relevansi kompetensi keunggulan, serta didukung oleh *leadership*, *output* yang bermutu, dan *outcome* yang mantap.</li>
                    <li>Melaksanakan penelitian terapan maupun riset inovasi IPTEKS dengan keilmuan yang berdaya guna untuk kegiatan produktif lembaga, pemerintah dan ringan.</li>
                    <li>Meningkatkan sistem kelembagaan pengabdian masyarakat yang terintegrasi dan berkelanjutan.</li>
                </ol>
            </div>
        </div>
        
        <div class="mb-12">
            <h2 class="text-3xl font-extrabold text-center mb-10 text-polihasnur-blue">7 Program Studi Unggulan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="#" class="study-card" style="background-image: url('{{ asset('images/TO.jpg') }}');">
                    <div class="study-card-content"><span class="text-xl font-semibold">Teknik Otomotif</span><div class="w-8 h-8 bg-white text-polihasnur-blue rounded-full flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div></div>
                </a>
                <a href="#" class="study-card" style="background-image: url('{{ asset('images/btp.jpg') }}');">
                    <div class="study-card-content"><span class="text-xl font-semibold">Budidaya Tanaman Perkebunan</span><div class="w-8 h-8 bg-white text-polihasnur-blue rounded-full flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div></div>
                </a>
                <a href="#" class="study-card" style="background-image: url('{{ asset('images/TI.jpg') }}');">
                    <div class="study-card-content"><span class="text-xl font-semibold">Teknik Informatika</span><div class="w-8 h-8 bg-white text-polihasnur-blue rounded-full flex items-center justify-center"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div></div>
                </a>
            </div>
        </div>
        
        <div class="bg-dark-blue py-16 rounded-lg shadow-xl mb-12">
            <h2 class="text-3xl font-extrabold text-center text-white mb-4">Apa kata Alumni?</h2>
            <p class="text-center text-white text-opacity-80 mb-10 max-w-2xl mx-auto">Kisah nyata dari mereka yang telah merasakan pelayanan terbaik dari tim kami</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-8">
                <div class="bg-white rounded-lg overflow-hidden shadow-lg"><img src="{{ asset('images/1.jpg') }}" alt="Testimoni Alumni 1" class="w-full h-40 object-cover"><div class="p-6"><p class="text-gray-700 italic">"Dosennya asik"</p></div></div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg"><img src="{{ asset('images/2.jpg') }}" alt="Testimoni Alumni 2" class="w-full h-40 object-cover"><div class="p-6"><p class="text-gray-700 italic">"Pelayanannya sangat ramah dan dokternya sangat sabar menjelaskan. Saya merasa tenang selama perawatan. Sangat direkomendasikan!"</p></div></div>
                <div class="bg-white rounded-lg overflow-hidden shadow-lg"><img src="{{ asset('images/3.jpg') }}" alt="Testimoni Alumni 3" class="w-full h-40 object-cover"><div class="p-6"><p class="text-gray-700 italic">"Pelayanannya sangat ramah dan dokternya sangat sabar menjelaskan. Saya merasa tenang selama perawatan. Sangat direkomendasikan!"</p></div></div>
            </div>
        </div>

    </main>
    
    <section class="mb-12">
        <div class="w-full max-w-7xl mx-auto px-4 relative">
            <div 
                x-data="{ activeSlide: 0, totalSlides: 3, 
                            next() { this.activeSlide = (this.activeSlide + 1) % this.totalSlides }, 
                            prev() { this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides } }"
                class="carousel-container rounded-lg shadow-xl overflow-hidden" 
                style="height: 450px;">
                
                <div class="carousel-wrapper h-full" :style="`transform: translateX(-${activeSlide * 100}%)`">
                    <div class="carousel-item h-full"><img src="{{ asset('images/acara 1.jpg') }}" alt="Acara Politeknik Hasnur 1" class="w-full h-full object-cover" /></div>
                    <div class="carousel-item h-full"><img src="{{ asset('images/acara 2.jpg') }}" alt="Acara Politeknik Hasnur 2" class="w-full h-full object-cover" /></div>
                    <div class="carousel-item h-full"><img src="{{ asset('images/acara 3.jpg') }}" alt="Acara Politeknik Hasnur 3" class="w-full h-full object-cover" /></div>
                </div>

                <button @click="prev()" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white bg-opacity-30 hover:bg-opacity-50 text-white p-2 rounded-full z-20 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="next()" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-white bg-opacity-30 hover:bg-opacity-50 text-white p-2 rounded-full z-20 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
                
                <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2 z-20">
                    <template x-for="i in totalSlides" :key="i">
                        <span 
                            @click="activeSlide = i - 1"
                            :class="{ 'opacity-100': activeSlide === i - 1, 'opacity-50': activeSlide !== i - 1 }"
                            class="w-3 h-3 bg-white rounded-full cursor-pointer transition-opacity">
                        </span>
                    </template>
                </div>
            </div>
        </div>
    </section>
    
    <footer class="bg-dark-blue py-12">
        <div class="w-full max-w-7xl mx-auto px-4 text-white">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-sm">
                
                <div class="pr-4">
                    <h3 class="text-base font-bold mb-4">Fallow</h3>
                    <p class="text-white text-opacity-80 mb-4">
                        We work with passion of taking challenges and creating new ones in advertising sector
                    </p>
                    <div class="flex space-x-3">
                        <a href="https://facebook.com/polihasnur" target="_blank" class="w-8 h-8 flex items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-40 rounded-full">F</a>
                        <a href="https://twitter.com/polihasnur" target="_blank" class="w-8 h-8 flex items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-40 rounded-full">T</a>
                        <a href="https://instagram.com/polihasnur" target="_blank" class="w-8 h-8 flex items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-40 rounded-full">I</a>
                        <a href="https://youtube.com/polihasnur" target="_blank" class="w-8 h-8 flex items-center justify-center bg-white bg-opacity-20 hover:bg-opacity-40 rounded-full">Y</a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-base font-bold mb-4">Program Studi</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="footer-link">D3 Teknik Otomotif</a></li>
                        <li><a href="#" class="footer-link">D3 Teknik Informatika</a></li>
                        <li><a href="#" class="footer-link">D3 Budidaya Tanaman Perkebunan</a></li>
                        <li><a href="#" class="footer-link">Sarjana Terapan Bisnis Digital (D4)</a></li>
                        <li><a href="#" class="footer-link">Sarjana Terapan Manajemen Pemasaran Internasional (D4)</a></li>
                        <li><a href="#" class="footer-link">Sarjana Terapan Akuntansi Bisnis Digital</a></li>
                        <li><a href="#" class="footer-link">Program Studi Teknologi Rekayasa Multimedia</a></li>
                    </ul>
                </div>
                
                <div class="pr-4">
                    <h3 class="text-base font-bold mb-4">Lokasi</h3>
                    <p class="font-semibold mb-2">Kampus 1</p>
                    <p class="text-white text-opacity-80 mb-4">Jl. Brigjen H. Hasan Basri, Handil Bakti, Ray 5, Kec. Alalak, Kab. Barito Kuala, Prov. Kalimantan Selatan</p>
                    <p class="font-semibold mb-2">Kampus 2</p>
                    <p class="text-white text-opacity-80">Jl. Jend. Ahmad Yani KM.3,5 No.115A, Kota Banjarmasin, Kalimantan Selatan 70234</p>
                </div>
                
                <div>
                    <h3 class="text-base font-bold mb-4">Official Info</h3>
                    <div class="flex items-start space-x-3 mb-2">
                        <div class="w-5 h-5 flex-shrink-0 bg-white bg-opacity-30 rounded-full"></div>
                        <p class="text-white text-opacity-80">30 Comercial Road Frattion, Australia</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-5 h-5 flex-shrink-0 bg-white bg-opacity-30 rounded-full"></div>
                        <p class="text-white text-opacity-80">+123456789012</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>