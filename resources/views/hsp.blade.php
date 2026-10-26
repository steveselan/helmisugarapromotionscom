<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('img/iconhsp.ico') }}">
    <title>Helmi Sugara Promotions</title>
   <!-- 1. Preload gambar banner utama agar LCP maksimal -->
    @if(isset($eventbaru) && $eventbaru->isNotEmpty())
        <link rel="preload" as="image" href="{{ asset('gambar_banner/' . $eventbaru->first()->image) }}">
    @endif

    @if(isset($eventbaru) && $eventbaru->isNotEmpty())
        <link rel="preload" as="image" href="{{ asset('gambar_banner/' . $eventbaru->first()->image) }}">
    @endif

    <!-- 2. Panggil Laravel Vite (CSS & JS lokal yang ringan dan bebas render-blocking) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@700&display=swap" rel="stylesheet">
    <!-- CSS ANIMASI BACKGROUND & INFINITE LOGO SLIDER -->
    <style>
        @keyframes neonPulse {
            0%, 100% {
                filter: drop-shadow(0 0 8px rgba(255, 215, 0, 0.6)) drop-shadow(0 0 20px rgba(236, 72, 153, 0.4));
                transform: scale(1);
            }
            50% {
                filter: drop-shadow(0 0 12px rgba(255, 215, 0, 0.9)) drop-shadow(0 0 30px rgba(56, 189, 248, 0.6));
                transform: scale(1.02);
            }
        }

        .logo-neon-modern {
            animation: neonPulse 4s ease-in-out infinite;
            transition: transform 0.3s ease;
        }

        .logo-neon-modern:hover {
            transform: scale(1.05);
            filter: drop-shadow(0 0 15px rgba(255, 215, 1)) drop-shadow(0 0 35px rgba(236, 72, 153, 0.8));
        }

        /* Background Statis yang Ringan dan Bersih */
        .static-bg {
            background-color: #0b0f19;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(249, 115, 22, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(147, 51, 234, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(56, 189, 248, 0.08) 0%, transparent 50%);
        }

        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: max-content;
            animation: marquee 30s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }

        .menu-mono {
            font-family: 'Space Mono', monospace;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }
        </style>
</head>
<body class="static-bg text-slate-100 font-sans antialiased relative overflow-x-hidden" x-data="{ openModal: false, activeEvent: {}, mobileMenu: false }">

    <!-- EFEK CAHAYA LAMPU PANGGUNG -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-32 -left-32 w-[35rem] h-[35rem] bg-orange-500/30 rounded-full blur-[100px] spotlight-1"></div>
        <div class="absolute top-1/3 -right-32 w-[40rem] h-[40rem] bg-fuchsia-600/25 rounded-full blur-[130px] spotlight-2"></div>
        <div class="absolute -bottom-32 left-1/4 w-[35rem] h-[35rem] bg-sky-500/25 rounded-full blur-[120px] spotlight-3"></div>
    </div>

    <!-- NAVBAR -->
    <nav class="fixed top-0 left-0 w-full z-50 bg-slate-900/80 backdrop-blur-md border-b border-slate-700/50 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="#" class="text-xl font-bold tracking-wider text-amber-400 logo-neon-modern"><img src="{{ asset('img/LOGOhspNeon.png') }}" 
             alt="Logo Helmi Sugara Promotions" 
             style="max-height: 60px; width: auto;"></a>
            
            <!-- Menu Desktop -->
           <!-- Contoh Menu Desktop menggunakan gaya font khusus -->
            <div class="hidden md:flex space-x-8 items-center">
                <a href="#home" class="menu-mono text-slate-300 hover:text-amber-400 transition">Home</a>
                <a href="#about" class="menu-mono text-slate-300 hover:text-amber-400 transition">About</a>
                <a href="#portfolio" class="menu-mono text-slate-300 hover:text-amber-400 transition">Our Works</a>
                <a href="#team" class="menu-mono text-slate-300 hover:text-amber-400 transition">Team</a>
                <a href="#clients" class="menu-mono text-slate-300 hover:text-amber-400 transition">Clients</a>
                <a href="#contact" class="menu-mono text-slate-300 hover:text-amber-400 transition">Contact</a>
            </div>

            <!-- Tombol Hamburger Menu HP -->
            <button @click="mobileMenu = !mobileMenu" class="md:hidden text-slate-200 hover:text-amber-400 focus:outline-none p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
                </svg>
            </button>
        </div>

        <!-- Dropdown Menu HP -->
        <div x-show="mobileMenu" class="md:hidden bg-slate-900/95 border-b border-slate-700 px-4 pt-2 pb-6 space-y-3 shadow-xl" style="display: none;" x-transition>
            <a @click="mobileMenu = false" href="#home" class="block menu-mono text-slate-200 hover:text-amber-400 py-2 font-medium">Home</a>
            <a @click="mobileMenu = false" href="#about" class="block menu-mono text-slate-200 hover:text-amber-400 py-2 font-medium">About</a>
            <a @click="mobileMenu = false" href="#portfolio" class="block menu-mono text-slate-200 hover:text-amber-400 py-2 font-medium">Our Works</a>
            <a @click="mobileMenu = false" href="#team" class="block menu-mono text-slate-200 hover:text-amber-400 py-2 font-medium">Team</a>
            <a @click="mobileMenu = false" href="#clients" class="block menu-mono text-slate-200 hover:text-amber-400 py-2 font-medium">Clients</a>
            <a @click="mobileMenu = false" href="#contact" class="block menu-mono text-slate-200 hover:text-amber-400 py-2 font-medium">Contact</a>
        </div>
    </nav>

    <!-- HERO / HOME SECTION -->
    <section id="home" class="relative w-full overflow-hidden bg-black z-10 pt-20">
        <div class="relative w-full">
            @foreach($eventbaru as $index => $newevent)
                <!-- CONTAINER SATU SLIDE -->
                <div class="hero-slide transition-opacity duration-1000 {{ $index === 0 ? 'opacity-100 relative' : 'opacity-0 absolute inset-0' }}">
                    
                    <!-- 1. TAMPILAN DESKTOP (Landscape 1000x361) -->
                    <!-- Menggunakan tag <img> asli dengan 'w-full h-auto object-cover' agar proporsional tanpa terpaksa kepotong berlebihan -->
                    <div class="hidden md:block w-full">
                        <img src="{{ asset('gambar_banner/' . $newevent->gambar1) }}" alt="Desktop Banner" class="w-full h-auto max-h-[85vh] object-cover mx-auto" fetchpriority="high" loading="eager">
                    </div>

                    <!-- 2. TAMPILAN MOBILE / HP (Square) -->
                    <!-- Menggunakan tag <img> asli dengan 'w-full h-auto object-contain' agar gambar kotak tampil pas di tengah tanpa spasi hitam berlebih -->
                    <div class="block md:hidden w-full bg-black py-0">
                        <img src="{{ asset('gambar_banner/' . $newevent->gambar2) }}" alt="Mobile Banner" class="w-full h-auto object-contain mx-auto" fetchpriority="high" loading="eager">
                    </div>

                </div>
            @endforeach
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="pt-40 px-4 relative z-10">
        <div class="max-w-5xl mx-auto text-center bg-slate-950/50 backdrop-blur-xl p-8 sm:p-12 rounded-3xl border border-slate-700/60 shadow-2xl">
            <h2 class="text-3xl font-bold mb-6 text-amber-400">About Helmi Sugara Promotions</h2>
            <p class="text-slate-200 text-base sm:text-lg leading-relaxed max-w-3xl mx-auto text-left">
                Helmi Sugara Promotions is an independent PR, promotions, and sponsorship agency. Our team of experts specializes in managing events for promoter companies, as well as private and corporate setups. We understand your event management needs, whether for local or international events. We have a proven track record of delivering successful events as planned.
                <br><br>
                Let us work for you and support your event. We specialize in media promotions and sponsor/client servicing. Our experienced and knowledgeable team assists clients with event planning and promotions across cities in Indonesia, utilizing radio, print, and digital media. We bridge the gap between promoters and sponsors/clients, making the process smoother and ensuring client satisfaction. <b>Yes, we are good at what we do.</b>
            </p>
        </div>
    </section>

    <!-- PORTFOLIO SECTION -->
    <section id="portfolio" class="pt-32 px-4 max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-2 text-amber-400">A Glimpse Into Our Work</h2>
            <p class="text-slate-300">Take a look at the events and discover more about our previous work.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2">
            <!-- Event 1 -->
            @foreach ($eventlama as $pastevent )
                <div @click="activeEvent = { 
                    title: '{{ $pastevent->judul_event }}', 
                    category: '{{  $pastevent->nama_kategori }}', 
                    image: '{{ asset('gambar_banner/' . $pastevent->gambar2) }}', 
                    date: '{{ \Carbon\Carbon::parse($pastevent->tanggal)->format('j F Y') }}', 
                    location: '{{ Str::title($pastevent->lokasi) }}' 
                }; openModal = true" 
                class="relative aspect-square rounded-xl overflow-hidden cursor-pointer group shadow-xl border border-slate-700/60 bg-black">
                
                <div class="absolute inset-0 bg-contain bg-no-repeat bg-center group-hover:scale-110 transition duration-500" style="background-image: url('{{ asset('gambar_banner/' . $pastevent->gambar2) }}')"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-transparent opacity-90 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                    <span class="text-[10px] text-amber-400 font-bold uppercase tracking-widest px-2 py-0.5 bg-amber-400/20 rounded w-max mb-1">{{  $pastevent->nama_kategori }}</span>
                    <h3 class="text-base font-bold text-white leading-snug">{{ $pastevent->judul_event }}</h3>
                    <p class="text-slate-300 text-xs mt-1">Detail &rarr;</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- SECTION MEET OUR TEAM (MIXED GEOMETRIC SHAPES & EQUAL) -->
    <section id="team" class="pt-32 pb-20 px-4 max-w-7xl mx-auto relative z-10">
        <div class="text-center mb-16">
            <span class="text-xs text-amber-400 font-bold uppercase tracking-widest px-3 py-1 bg-amber-400/10 rounded-full border border-amber-400/20">The Powerhouse Team</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold mt-3 mb-2 text-white">Meet Our Core Team</h2>
        </div>

        <!-- Grid 4 Kolom Setara dengan Bentuk Foto Berbeda-beda -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <!-- Team Member 1 (Helmi Sugara) - Bentuk Hexagon / Segi Enam -->
            <div class="relative bg-slate-900/60 backdrop-blur-xl rounded-3xl p-6 border border-slate-700/60 shadow-xl group hover:border-amber-400 hover:-translate-y-2 transition-all duration-300 text-center flex flex-col items-center">
                <div class="w-40 h-40 mx-auto mb-6 bg-cover bg-center shadow-lg group-hover:scale-105 transition duration-500 border-2 border-amber-400/30" 
                     style="background-image: url('{{ asset('team/HelmiSugara.webp') }}?auto=format&fit=crop&w=600&q=80'); clip-path: polygon(25% 6.7%, 75% 6.7%, 100% 50%, 75% 93.3%, 25% 93.3%, 0% 50%);">
                </div>
                <div>
                    <span class="text-[10px] text-amber-400 font-bold uppercase tracking-widest px-2.5 py-1 bg-amber-400/10 rounded-full border border-amber-400/20 inline-block mb-2">Founder</span>
                    <h3 class="text-xl font-bold text-white mb-1">Helmi Sugara</h3>
                </div>
            </div>

            <!-- Team Member 2 (Reza Pratama) - Bentuk Lingkaran Sempurna -->
            <div class="relative bg-slate-900/60 backdrop-blur-xl rounded-3xl p-6 border border-slate-700/60 shadow-xl group hover:border-amber-400 hover:-translate-y-2 transition-all duration-300 text-center flex flex-col items-center">
                <div class="w-40 h-40 mx-auto mb-6 bg-cover bg-center rounded-full shadow-lg group-hover:scale-105 transition duration-500 border-2 border-amber-400/30" 
                     style="background-image: url('{{ asset('team/AininditaDumashanti.webp') }}?auto=format&fit=crop&w=600&q=80');">
                </div>
                <div>
                    <span class="text-[10px] text-amber-400 font-bold uppercase tracking-widest px-2.5 py-1 bg-amber-400/10 rounded-full border border-amber-400/20 inline-block mb-2">Radio Promotions</span>
                    <h3 class="text-xl font-bold text-white mb-1">Ainindita D</h3>
                </div>
            </div>

            <!-- Team Member 3 (Dimas Anggara) - Bentuk Organik / Squircle Unik -->
            <div class="relative bg-slate-900/60 backdrop-blur-xl rounded-3xl p-6 border border-slate-700/60 shadow-xl group hover:border-amber-400 hover:-translate-y-2 transition-all duration-300 text-center flex flex-col items-center">
                <div class="w-40 h-40 mx-auto mb-6 bg-cover bg-center shadow-lg group-hover:scale-105 transition duration-500 border-2 border-amber-400/30" 
                     style="background-image: url('{{ asset('team/MarthaSerepina.webp') }}?auto=format&fit=crop&w=600&q=80'); border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;">
                </div>
                <div>
                    <span class="text-[10px] text-amber-400 font-bold uppercase tracking-widest px-2.5 py-1 bg-amber-400/10 rounded-full border border-amber-400/20 inline-block mb-2">Print Promotions</span>
                    <h3 class="text-xl font-bold text-white mb-1">Martha Serepina</h3>
                </div>
            </div>

            <!-- Team Member 4 (Sarah Maharani) - Bentuk Berlian / Diamond -->
            <div class="relative bg-slate-900/60 backdrop-blur-xl rounded-3xl p-6 border border-slate-700/60 shadow-xl group hover:border-amber-400 hover:-translate-y-2 transition-all duration-300 text-center flex flex-col items-center">
                <div class="w-40 h-40 mx-auto mb-6 bg-cover bg-center shadow-lg group-hover:scale-105 transition duration-500 border-2 border-amber-400/30" 
                     style="background-image: url('{{ asset('team/NoppiyaPrayitno.webp') }}?auto=format&fit=crop&w=600&q=80'); clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);">
                </div>
                <div>
                    <span class="text-[10px] text-amber-400 font-bold uppercase tracking-widest px-2.5 py-1 bg-amber-400/10 rounded-full border border-amber-400/20 inline-block mb-2">Online Promotions</span>
                    <h3 class="text-xl font-bold text-white mb-1">Noppiya P</h3>
                </div>
            </div>

        </div>
    </section>

    <!-- SECTION CLIENTS -->
    <section id="clients" class="pt-32 pb-20 relative z-10 overflow-hidden border-t border-b border-slate-700/40 bg-slate-950/40 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 text-center mb-12">
            <h2 class="text-3xl font-bold mb-2 text-amber-400">Our Trusted Clients & Partners</h2>
            <p class="text-slate-300 text-sm">Partnering with local and international brands across the entertainment and events industry.</p>
        </div>

       @php
            // 1. Ambil hanya kolom 'promotor', hilangkan data yang kosong, lalu acak urutannya secara random
            $promotorsRandom = $eventlama->pluck('promotor')->filter()->shuffle();
        @endphp

        <div class="relative w-full overflow-hidden [mask-image:_linear-gradient(to_right,transparent_0,_black_128px,_black_calc(100%-128px),transparent_100%)]">
            <div class="animate-marquee flex items-center space-x-4 py-4" style="animation-duration: 500s;">
                
                {{-- Lakukan perulangan pada kumpulan nama promotor yang sudah diacak --}}
                @foreach ($promotorsRandom as $promotorRaw)
                    @php
                        // Bersihkan string promotor (ambil sebelum tanda '|' atau ',')
                        $promotorClean = Str::before($promotorRaw, '|');
                        $promotorClean = Str::before($promotorClean, ',');
                        $promotorFinal = trim($promotorClean);
                    @endphp

                    @if(!empty($promotorFinal))
                        <div class="flex items-center justify-center w-40 h-20 px-3 bg-slate-900/60 border border-slate-700/50 rounded-xl shadow-lg backdrop-blur-sm grayscale hover:grayscale-0 transition duration-300 flex-shrink-0">
                            <span class="text-slate-200 font-extrabold tracking-wider text-xs text-center leading-tight line-clamp-2 p-2">
                                {{ Str::upper($promotorFinal) }}
                            </span>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </section>

    <!-- SECTION CONTACT -->
    {{-- <section id="contact" class="py-24 px-4 max-w-5xl mx-auto relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-2 text-amber-400">Get In Touch</h2>
            <p class="text-slate-300">What can we do for you?</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Info Kontak Singkat -->
            <div class="bg-slate-900/70 backdrop-blur-xl p-8 rounded-2xl border border-slate-700/60 shadow-xl flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white mb-4">Let's Collaborate</h3>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6">
                        Kami siap membantu mewujudkan event impian Anda dengan standar profesional tertinggi. Kirimkan pesan atau hubungi kontak langsung kami.
                    </p>
                    <div class="space-y-4 text-sm text-slate-300">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>contact@helmisugarapromotions.com</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Jakarta Selatan, Indonesia</span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Chat WhatsApp Cepat -->
                <div class="mt-8 pt-6 border-t border-slate-800">
                    <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center justify-center space-x-2 w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg shadow-emerald-900/30 text-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>Chat via WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Form Kontak Utama -->
            <div class="lg:col-span-2 bg-slate-900/70 backdrop-blur-xl p-8 rounded-2xl border border-slate-700/60 shadow-xl">
                <form action="#" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Nama Lengkap</label>
                            <input type="text" placeholder="Masukkan nama Anda" class="w-full bg-slate-950/60 border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 focus:outline-none focus:border-amber-400 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Email / No. WhatsApp</label>
                            <input type="text" placeholder="email@domain.com atau 08xx" class="w-full bg-slate-950/60 border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 focus:outline-none focus:border-amber-400 transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Subjek / Kategori Event</label>
                        <select class="w-full bg-slate-950/60 border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 focus:outline-none focus:border-amber-400 transition">
                            <option class="bg-slate-900">Konser Musik Internasional / Lokal</option>
                            <option class="bg-slate-900">Festival Musik</option>
                            <option class="bg-slate-900">Event / Turnamen Olahraga</option>
                            <option class="bg-slate-900">Lainnya (Sponsorship / Partnership)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-2">Pesan / Detail Kebutuhan</label>
                        <textarea rows="4" placeholder="Tuliskan detail rencana event Anda di sini..." class="w-full bg-slate-950/60 border border-slate-700 rounded-xl px-4 py-3 text-sm text-slate-100 focus:outline-none focus:border-amber-400 transition"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold py-3.5 px-6 rounded-xl transition shadow-lg shadow-amber-500/20 text-sm tracking-wide">
                        Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer Copyright -->
        <div class="mt-20 pt-8 border-t border-slate-800 text-center text-xs text-slate-400">
            &copy; 2026 Helmi Sugara Promotions. All Rights Reserved. Built with Laravel & Tailwind CSS.
        </div>
    </section> --}}
    <!-- SECTION CONTACT (DIRECT CONTACT CARDS & COPY BUTTONS) -->
    <section id="contact" class="py-24 px-4 max-w-5xl mx-auto relative z-10" x-data="{ copied: '' }">
        <div class="text-center mb-16">
            <span class="text-xs text-amber-400 font-bold uppercase tracking-widest px-3 py-1 bg-amber-400/10 rounded-full border border-amber-400/20">Direct Connection</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold mt-3 mb-2 text-white">Interested in our services?</h2>
            <p class="text-slate-300 max-w-xl mx-auto">Let's discuss how we can support your needs.</p>
        </div>

        <!-- Grid Kartu Kontak Langsung (3 Pilihan Utama) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- 1. WHATSAPP CARD -->
            <div class="bg-slate-900/60 backdrop-blur-xl p-8 rounded-3xl border border-slate-700/60 shadow-xl group hover:border-emerald-500 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between text-center">
                <div>
                    <div class="w-14 h-14 mx-auto mb-6 bg-emerald-500/10 rounded-2xl border border-emerald-500/30 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition duration-300">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1">Get in touch via Whatsapp</h3>
                    <p class="text-slate-400 text-xs mb-6">For quick inquiries, further discussions, and partnership opportunities.</p>
                </div>
                <div class="space-y-3 w-full">
                    {{-- <span class="block text-sm font-semibold text-slate-200">Chat Only</span> --}}
                    <a href="https://wa.me/628991114393" target="_blank" class="flex items-center justify-center space-x-2 w-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold py-2.5 px-4 rounded-xl transition text-xs shadow-lg shadow-emerald-900/30">
                        <span>Chat Now</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- 2. EMAIL CARD (DENGAN FUNGSI COPY OTOMATIS) -->
            <div class="bg-slate-900/60 backdrop-blur-xl p-8 rounded-3xl border border-slate-700/60 shadow-xl group hover:border-amber-400 hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between text-center">
                <div>
                    <div class="w-14 h-14 mx-auto mb-6 bg-amber-400/10 rounded-2xl border border-amber-400/30 flex items-center justify-center text-amber-400 group-hover:scale-110 transition duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1">Get in touch via Email</h3>
                    <p class="text-slate-400 text-xs mb-6">For proposals, business inquiries, partnerships, and further discussions.</p>
                </div>
                <div class="space-y-3 w-full">
                    <!-- Teks email menggunakan HTML Entities agar aman dari bot crawler -->
                    <span class="block text-xs font-semibold text-slate-200 truncate">
                        &#105;&#x6e;&#x66;&#111;&#64;&#104;&#101;&#x6c;&#x6d;&#105;&#x73;&#x75;&#103;&#x61;&#x72;&#97;&#x70;&#x72;&#x6f;&#x6d;&#111;&#x74;&#x69;&#111;&#x6e;&#115;&#46;&#x63;&#x6f;&#109;
                    </span>

                    <!-- Tombol Copy dengan Alpine.js tetap menyalin string email aslinya dengan normal -->
                    <button @click="navigator.clipboard.writeText('info@helmisugarapromotions.com'); copied = 'email'; setTimeout(() => copied = '', 2000)" 
                            class="flex items-center justify-center space-x-2 w-full bg-slate-800 hover:bg-slate-700 text-amber-400 border border-amber-400/30 font-bold py-2.5 px-4 rounded-xl transition text-xs">
                        <span x-text="copied === 'email' ? '✓ Copied!' : 'Copy Email'"></span>
                    </button>
                </div>
            </div>

        </div>

        <!-- Lokasi Singkat -->
        <div class="mt-12 text-center bg-slate-900/40 backdrop-blur-md p-6 rounded-2xl border border-slate-700/40 max-w-xl mx-auto flex items-center justify-center space-x-3 text-xs text-slate-300">
            <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span><strong>Basecamp:</strong> Jakarta Selatan, DKI Jakarta, Indonesia</span>
        </div>

        <!-- Footer Copyright -->
        <div class="mt-20 pt-8 border-t border-slate-800 text-center text-xs text-slate-400">
            &copy; 2026 Helmi Sugara Promotions. All Rights Reserved.
        </div>
    </section>

    <!-- POPUP MODAL -->
    <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/25 backdrop-blur-md" style="display: none;" x-transition.opacity>
        <div @click.away="openModal = false" class="bg-slate-900 border border-slate-700 rounded-2xl max-w-lg w-full overflow-hidden shadow-2xl relative" x-transition>
            
            <!-- Tombol Tutup -->
            <button @click="openModal = false" class="absolute top-4 right-4 z-10 bg-black/60 text-white rounded-full p-2 hover:bg-amber-500 hover:text-slate-950 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <!-- PERBAIKAN: Menggunakan h-80 sm:h-96 dengan object-cover agar gambar melebar full menutupi area kotak modal -->
            <div class="w-full h-80 sm:h-96 bg-black flex items-center justify-center overflow-hidden">
                <img :src="activeEvent.image" alt="Detail Banner" class="w-full h-full object-cover object-top">
            </div>

            <!-- Konten Detail Teks -->
            <div class="p-6 sm:p-8">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs text-amber-400 font-bold uppercase tracking-widest px-2.5 py-1 bg-amber-400/10 rounded border border-amber-400/20" x-text="activeEvent.category"></span>
                    <span class="text-xs text-slate-300 font-medium" x-text="activeEvent.date"></span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2" x-text="activeEvent.title"></h3>
                <div class="flex items-center justify-between pt-4 border-t border-slate-700 text-xs text-slate-300">
                    <span>Location: <strong class="text-white" x-text="activeEvent.location"></strong></span>
                    <button @click="openModal = false" class="bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-5 py-2 rounded-lg transition">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- SCRIPT HERO SLIDER -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const slides = document.querySelectorAll('.hero-slide');
            let currentSlide = 0;

            function nextSlide() {
                slides[currentSlide].style.opacity = 0;
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].style.opacity = 1;
            }

            setInterval(nextSlide, 4500);
        });
    </script>
     <!-- Alpine.js untuk mengatur Popup Modal & Menu Mobile -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>