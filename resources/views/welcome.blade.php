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

    <nav class="py-4 bg-white shadow-sm">
        <div class="flex items-center justify-between w-full px-4 mx-auto max-w-7xl">
            <div class="flex items-center">
                <img src="{{ asset('images/logo_polhas.png') }}" alt="Logo Politeknik Hasnur" class="h-10"> 
            </div>
            <div class="items-center hidden space-x-8 text-base md:flex">
                <a href="{{ url('/') }}" class="font-medium text-gray-700 hover:text-polihasnur-blue">Home</a>
                <a href="#" class="font-medium text-gray-700 hover:text-polihasnur-blue">Profil</a>
                <a href="#" class="font-medium text-gray-700 hover:text-polihasnur-blue">Program Studi</a>
                <a href="#" class="font-medium text-gray-700 hover:text-polihasnur-blue">About Us</a>
            </div>
            <div class="flex items-center space-x-3 text-sm">
                <a href="{{ route('login') }}" class="px-5 py-2 font-semibold transition-all border rounded-md border-polihasnur-blue text-polihasnur-blue hover:bg-polihasnur-blue hover:text-white">Log In</a>
                <a href="{{ route('register') }}" class="px-5 py-2 font-semibold text-white transition-all border rounded-md bg-polihasnur-blue border-polihasnur-blue hover:bg-blue-700">Register</a>
            </div>
        </div>
    </nav>

    <main class="w-full px-4 mx-auto max-w-7xl">
        
        <div class="relative mt-6 overflow-hidden rounded-lg shadow-xl bg-gradient-hero">
            <div class="relative inline-block text-center campus-badge whitespace-nowrap">
                <span class="text-xl text-red-600">KAMPUS BARU</span>
                <span class="text-3xl font-extrabold">POLIHASNUR</span>
                <span class="text-lg text-gray-800">DI HANDIL BAKTI</span>
            </div>

            <div class="relative flex flex-col items-start p-8 hero-content md:flex-row md:p-12">
                <div class="z-10 text-left md:w-2/3 lg:w-1/2">
                    <h1 class="mb-4 text-4xl font-extrabold leading-tight lg:text-5xl text-polihasnur-blue">Selamat Datang di <br> Sistem Informasi Ujian Politeknik Hasnur <br>(SIU-POLIHASNUR)</h1>
                    <p class="max-w-lg mb-8 text-base text-gray-700">Melalui sistem ini, calon mahasiswa dapat melakukan pendaftaran dan mengikuti tes secara praktis dalam satu tempat. Mari mulai perjalananmu bersama Politeknik Hasnur dan raih cita-cita melalui pendidikan vokasi terbaik.</p>
                    <div class="flex space-x-4">
                        <a href="{{ route('register') }}" class="inline-block px-8 py-3 text-base font-semibold text-white transition-all rounded-md bg-polihasnur-blue hover:bg-blue-700">Daftar Sekarang</a>
                        <a href="#" class="inline-block px-8 py-3 text-base font-semibold transition-all border rounded-md border-polihasnur-blue text-polihasnur-blue hover:bg-blue-50">Pelajari Lebih Lanjut</a>
                    </div>
                </div>
            </div>

            <img 
                src="{{ asset('images/proyek 3.png') }}" 
                alt="Gedung Politeknik Hasnur" 
                class="hero-building-image" 
            />
        </div>
        
        <div class="p-8 mt-6 mb-12 bg-white border border-gray-200 rounded-lg shadow-xl md:p-12">
            <div class="mb-8 text-center">
                <h2 class="mb-1 text-xl font-bold text-polihasnur-blue">VISI</h2>
                <p class="max-w-4xl mx-auto text-base text-gray-700 whitespace-nowrap">Menjadikan Politeknik yang Unggul Berbasis Kompetensi Kerja dan Berkarakter Kewirausahaan serta Profesional di Bidangnya.</p>
            </div>
            <hr class="my-6 border-gray-200">
            <div>
                <h2 class="mb-4 text-xl font-bold text-center text-polihasnur-blue">MISI</h2>
                <p class="mb-4 text-base text-gray-700">Untuk mewujudkan visi Polihasnur, ditetapkan misi sebagai berikut :</p>
                <ol class="pl-4 space-y-3 text-base text-gray-700 list-decimal list-inside">
                    <li>Menyelenggarakan program pendidikan vokasi integrative dan bermutu, memiliki relevansi kompetensi kerja yang sesuai kebutuhan dunia usaha maupan industri serta didukung oleh leadership, managerial skills, entrepreneurship.</li>
                    <li>Melaksankan penelitian terapan maupun risert inovasi IPTEKS dalam produk atau konsep yang berdaya guna untuk kegiatan produktif lembaga, pengembangan keilmuan, peningkatan mutu perekonomian masyarakat serta industri.</li>
                    <li>Berperan aktif dalam program pengabdian masyarakat dengan memberikan solusi dari segi kepraktisan dan kemanfaatan, untuk mendorong daya saing.</li>
                    <li>Meningkatkan mutu lembaga secara berkelanjutan dengan system tata kelola yang baik (good governance) melalui standarisasi secara internal dan eksternal.</li>
                </ol>
            </div>
        </div>
        
        <div class="mb-12">
            <h2 class="mb-10 text-3xl font-extrabold text-center text-polihasnur-blue">7 Program Studi Unggulan</h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <a href="#" class="study-card" style="background-image: url('{{ asset('images/TO.jpg') }}');">
                    <div class="study-card-content"><span class="text-xl font-semibold">Teknik Otomotif</span><div class="flex items-center justify-center w-8 h-8 bg-white rounded-full text-polihasnur-blue"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div></div>
                </a>
                <a href="#" class="study-card" style="background-image: url('{{ asset('images/btp.jpg') }}');">
                    <div class="study-card-content"><span class="text-xl font-semibold">Budidaya Tanaman Perkebunan</span><div class="flex items-center justify-center w-8 h-8 bg-white rounded-full text-polihasnur-blue"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div></div>
                </a>
                <a href="#" class="study-card" style="background-image: url('{{ asset('images/TI.jpg') }}');">
                    <div class="study-card-content"><span class="text-xl font-semibold">Teknik Informatika</span><div class="flex items-center justify-center w-8 h-8 bg-white rounded-full text-polihasnur-blue"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></div></div>
                </a>
            </div>
        </div>
        
        <div class="py-16 mb-12 rounded-lg shadow-xl bg-dark-blue">
            <h2 class="mb-4 text-3xl font-extrabold text-center text-white">Apa kata Alumni?</h2>
            <p class="max-w-2xl mx-auto mb-10 text-center text-white text-opacity-80">Kisah nyata dari mereka yang telah merasakan pelayanan terbaik dari tim kami</p>
            <div class="grid grid-cols-1 gap-6 px-8 md:grid-cols-3">
                <div class="overflow-hidden bg-white rounded-lg shadow-lg"><img src="{{ asset('images/1.jpg') }}" alt="Testimoni Alumni 1" class="object-cover w-full h-40"><div class="p-6"><p class="italic text-gray-700">"Dosennya asik"</p></div></div>
                <div class="overflow-hidden bg-white rounded-lg shadow-lg"><img src="{{ asset('images/2.jpg') }}" alt="Testimoni Alumni 2" class="object-cover w-full h-40"><div class="p-6"><p class="italic text-gray-700">"Pelayanannya sangat ramah dan dokternya sangat sabar menjelaskan. Saya merasa tenang selama perawatan. Sangat direkomendasikan!"</p></div></div>
                <div class="overflow-hidden bg-white rounded-lg shadow-lg"><img src="{{ asset('images/3.jpg') }}" alt="Testimoni Alumni 3" class="object-cover w-full h-40"><div class="p-6"><p class="italic text-gray-700">"Pelayanannya sangat ramah dan dokternya sangat sabar menjelaskan. Saya merasa tenang selama perawatan. Sangat direkomendasikan!"</p></div></div>
            </div>
        </div>

    </main>
    
    <section class="mb-12">
        <div class="relative w-full px-4 mx-auto max-w-7xl">
            <div 
                x-data="{ activeSlide: 0, totalSlides: 3, 
                            next() { this.activeSlide = (this.activeSlide + 1) % this.totalSlides }, 
                            prev() { this.activeSlide = (this.activeSlide - 1 + this.totalSlides) % this.totalSlides } }"
                class="overflow-hidden rounded-lg shadow-xl carousel-container" 
                style="height: 450px;">
                
                <div class="h-full carousel-wrapper" :style="`transform: translateX(-${activeSlide * 100}%)`">
                    <div class="h-full carousel-item"><img src="{{ asset('images/Polihasnur_1.png') }}" alt="Acara Politeknik Hasnur 1" class="object-cover w-full h-full" /></div>
                    <div class="h-full carousel-item"><img src="{{ asset('images/DiesNatalis.png') }}" alt="Acara Politeknik Hasnur 2" class="object-cover w-full h-full" /></div>
                    <div class="h-full carousel-item"><img src="{{ asset('images/Leadership.jpg') }}" alt="Acara Politeknik Hasnur 3" class="object-cover w-full h-full" /></div>
                </div>

                <button @click="prev()" class="absolute z-20 p-2 text-white transition-all transform -translate-y-1/2 bg-white rounded-full top-1/2 left-4 bg-opacity-30 hover:bg-opacity-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="next()" class="absolute z-20 p-2 text-white transition-all transform -translate-y-1/2 bg-white rounded-full top-1/2 right-4 bg-opacity-30 hover:bg-opacity-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
                
                <div class="absolute left-0 right-0 z-20 flex justify-center space-x-2 bottom-4">
                    <template x-for="i in totalSlides" :key="i">
                        <span 
                            @click="activeSlide = i - 1"
                            :class="{ 'opacity-100': activeSlide === i - 1, 'opacity-50': activeSlide !== i - 1 }"
                            class="w-3 h-3 transition-opacity bg-white rounded-full cursor-pointer">
                        </span>
                    </template>
                </div>
            </div>
        </div>
    </section>
    
    <footer class="py-12 bg-dark-blue">
        <div class="w-full px-4 mx-auto text-white max-w-7xl">
            <div class="grid grid-cols-2 gap-8 text-sm md:grid-cols-4">
                
                <div class="pr-4">
                    <h3 class="mb-4 text-base font-bold">Fallow</h3>
                    <p class="mb-4 text-white text-opacity-80">
                        We work with passion of taking challenges and creating new ones in advertising sector
                    </p>
                    <div class="flex space-x-3">
                        <a href="https://facebook.com/polihasnur" target="_blank" class="flex items-center justify-center w-8 h-8 bg-white rounded-full bg-opacity-20 hover:bg-opacity-40">F</a>
                        <a href="https://twitter.com/polihasnur_" target="_blank" class="flex items-center justify-center w-8 h-8 bg-white rounded-full bg-opacity-20 hover:bg-opacity-40">T</a>
                        <a href="https://instagram.com/polihasnur" target="_blank" class="flex items-center justify-center w-8 h-8 bg-white rounded-full bg-opacity-20 hover:bg-opacity-40">I</a>
                        <a href="https://youtube.com/@politeknikhasnur" target="_blank" class="flex items-center justify-center w-8 h-8 bg-white rounded-full bg-opacity-20 hover:bg-opacity-40">Y</a>
                    </div>
                </div>
                
                <div>
                    <h3 class="mb-4 text-base font-bold">Program Studi</h3>
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
                    <h3 class="mb-4 text-base font-bold">Lokasi</h3>
                    <p class="mb-2 font-semibold">Kampus 1</p>
                    <p class="mb-4 text-white text-opacity-80">Jl. Brigjen H. Hasan Basri, Handil Bakti, Ray 5, Kec. Alalak, Kab. Barito Kuala, Prov. Kalimantan Selatan</p>
                    <p class="mb-2 font-semibold">Kampus 2</p>
                    <p class="text-white text-opacity-80">Jl. Jend. Ahmad Yani KM.3,5 No.115A, Kota Banjarmasin, Kalimantan Selatan 70234</p>
                </div>
                
                <div>
                    <h3 class="mb-4 text-base font-bold">Official Info</h3>
                    <div class="flex items-start mb-2 space-x-3">
                        <div class="flex-shrink-0 w-5 h-5 bg-white rounded-full bg-opacity-30"></div>
                        <p class="text-white text-opacity-80">Phone: 0851-0015-6666</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-5 h-5 bg-white rounded-full bg-opacity-30"></div>
                        <p class="text-white text-opacity-80">Email: polihasnur@polihasnur.ac.id</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>