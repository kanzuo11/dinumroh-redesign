@extends('layouts.app')

@section('title', 'PT Din Banyutengah - Umrah & Haji Travel Specialist')
@section('description', 'Wujudkan perjalanan suci Anda bersama PT Din Banyutengah. Travel umrah terpercaya dengan izin resmi Kemenag sejak 2020.')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient min-h-screen flex items-center justify-center text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    <div class="container mx-auto px-4 text-center relative z-10">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight">
            Umrah Maulid Surabaya-Jeddah
        </h1>
        <p class="text-xl md:text-2xl mb-8 opacity-95">
            Wujudkan Perjalanan Suci Anda Bersama Kami
        </p>
        <a href="#packages" class="inline-block bg-white text-primary-700 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors shadow-lg">
            Lihat Paket Umrah
        </a>
    </div>
    
    <!-- Decorative elements -->
    <div class="absolute top-20 left-10 w-20 h-20 bg-white opacity-10 rounded-full"></div>
    <div class="absolute bottom-20 right-10 w-32 h-32 bg-white opacity-5 rounded-full"></div>
    <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white opacity-10 rounded-full"></div>
</section>

<!-- Packages Section -->
<section id="packages" class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-4">
                Paket Umrah Terbaik
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Pilih paket yang sesuai dengan kebutuhan perjalanan suci Anda
            </p>
        </div>

        @php
            $packagesByProgram = $packages->groupBy('program');
        @endphp

        @foreach($packagesByProgram as $program => $programPackages)
            <div class="mb-16">
                <div class="text-center mb-8">
                    <h3 class="text-2xl md:text-3xl font-bold text-primary-700 mb-2">
                        PROGRAM UMROH {{ $program }}
                    </h3>
                    @if($programPackages->first()['subtitle'])
                        <p class="text-lg text-gray-600 font-medium">
                            {{ $programPackages->first()['subtitle'] }}
                        </p>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($programPackages as $package)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover relative">
                            @if($package['featured'])
                                <div class="absolute top-4 right-4 bg-primary-700 text-white px-3 py-1 rounded-full text-sm font-semibold z-10">
                                    POPULER
                                </div>
                            @elseif($package['premium'])
                                <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold z-10">
                                    PREMIUM
                                </div>
                            @endif

                            <!-- Package Header -->
                            <div class="bg-primary-700 text-white p-6 text-center">
                                <h4 class="text-xl font-bold">{{ $package['title'] }}</h4>
                            </div>

                            <!-- Package Details -->
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-4 pb-4 border-b">
                                    <span class="font-semibold text-gray-800">{{ $package['route'] }} | {{ $package['duration'] }}</span>
                                    <span class="text-sm text-gray-600">by {{ $package['airline'] }}</span>
                                </div>

                                <div class="text-center mb-4">
                                    <p class="font-semibold text-primary-700 mb-1">
                                        Keberangkatan: {{ $package['departure_date'] }}
                                    </p>
                                    @if(isset($package['return_info']))
                                        <p class="text-sm text-gray-600">{{ $package['return_info'] }}</p>
                                    @endif
                                </div>

                                <div class="text-center mb-6">
                                    <div class="text-3xl font-bold text-primary-700 mb-2">
                                        {{ $package['price_formatted'] }}
                                    </div>
                                    <p class="text-xs text-gray-500 italic">
                                        *Harga & Jadwal sewaktu-waktu dapat berubah menyesuaikan dengan regulasi, kenaikan harga airlines, visa dan lain-lain
                                    </p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                    <h5 class="font-semibold text-primary-700 mb-2">HOTEL</h5>
                                    <p class="text-sm mb-1"><strong>Mekkah:</strong> {{ $package['hotel_mekkah'] }}</p>
                                    <p class="text-sm"><strong>Madinah:</strong> {{ $package['hotel_madinah'] }}</p>
                                </div>

                                <div class="space-y-3">
                                    <a href="{{ app(\App\Services\PackageService::class)->getWhatsAppLink($package['id']) }}" 
                                       target="_blank"
                                       class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-lg font-semibold transition-colors">
                                        Konsultasi Sekarang
                                    </a>
                                    <a href="{{ route('packages.show', $package['id']) }}" 
                                       class="block w-full bg-primary-700 hover:bg-primary-800 text-white text-center py-3 rounded-lg font-semibold transition-colors">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Package Inclusions -->
        <div class="mt-16 bg-white rounded-xl shadow-lg p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <h4 class="text-xl font-bold text-primary-700 mb-4">Harga Sudah Termasuk:</h4>
                    <ul class="space-y-2">
                        @if(isset($packages->first()['inclusions']))
                            @foreach($packages->first()['inclusions'] as $inclusion)
                                <li class="flex items-start">
                                    <span class="text-green-600 mr-2 mt-1">✓</span>
                                    <span class="text-gray-700">{{ $inclusion }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-primary-700 mb-4">Harga Belum Termasuk:</h4>
                    <ul class="space-y-2 mb-6">
                        @if(isset($packages->first()['exclusions']))
                            @foreach($packages->first()['exclusions'] as $exclusion)
                                <li class="flex items-start">
                                    <span class="text-red-600 mr-2 mt-1">✗</span>
                                    <span class="text-gray-700">{{ $exclusion }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    
                    <h4 class="text-xl font-bold text-primary-700 mb-4">Rute Penerbangan:</h4>
                    <ul class="space-y-2">
                        @if(isset($packages->first()['flight_route']))
                            @foreach($packages->first()['flight_route'] as $route)
                                <li class="flex items-start">
                                    <span class="text-primary-700 mr-2 mt-1">→</span>
                                    <span class="text-gray-700">{{ $route }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-4">
                Mengapa Harus PT Din Banyutengah?
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Alasan mengapa PT Din Banyutengah dapat menjadi pilihan travel Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($features as $feature)
                <div class="bg-gray-50 p-6 rounded-xl text-center card-hover">
                    <div class="w-16 h-16 bg-primary-700 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                        {{ $feature['icon'] }}
                    </div>
                    <h3 class="text-xl font-bold text-primary-700 mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $feature['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Documentation Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-primary-700 mb-4">
                Dokumentasi Perjalanan
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Momen berharga jamaah bersama PT Din Banyutengah
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="h-48 hero-gradient flex items-center justify-center text-white font-semibold text-center p-4">
                    Keberangkatan dari Bandara Juanda
                </div>
                <div class="p-6">
                    <h4 class="text-xl font-bold text-primary-700 mb-2">Keberangkatan dari Bandara Juanda</h4>
                    <p class="text-gray-600">Jamaah bersiap untuk berangkat dari Bandara Internasional Juanda Surabaya menuju tanah suci.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="h-48 hero-gradient flex items-center justify-center text-white font-semibold text-center p-4">
                    Manasik di Aula Kantor
                </div>
                <div class="p-6">
                    <h4 class="text-xl font-bold text-primary-700 mb-2">Manasik di Aula Kantor</h4>
                    <p class="text-gray-600">Jamaah mengikuti manasik umroh di aula kantor Din Travel untuk persiapan ibadah.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="h-48 hero-gradient flex items-center justify-center text-white font-semibold text-center p-4">
                    Istirahat Setelah ke Roudlo
                </div>
                <div class="p-6">
                    <h4 class="text-xl font-bold text-primary-700 mb-2">Istirahat Setelah ke Roudlo</h4>
                    <p class="text-gray-600">Jamaah beristirahat setelah menyelesaikan ziarah ke Roudloh Nabi Muhammad SAW.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-16 bg-primary-700 text-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Hubungi Kami</h2>
            <p class="text-lg opacity-90 max-w-2xl mx-auto">
                Konsultasikan perjalanan umroh Anda bersama kami
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-4xl mx-auto">
            <div class="bg-white bg-opacity-10 p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                    👤
                </div>
                <h3 class="text-xl font-bold mb-2">{{ $companyInfo['leader']['name'] }}</h3>
                <p class="opacity-90 mb-4">{{ $companyInfo['leader']['title'] }}</p>
                <div class="space-y-2 text-sm">
                    <p>📞 {{ $companyInfo['phone'] }}</p>
                    <p>📍 {{ $companyInfo['address'] }}</p>
                    <p>🏛️ PPIU: {{ $companyInfo['ppiu'] }}</p>
                </div>
            </div>

            <div class="bg-white text-primary-700 p-8 rounded-xl text-center">
                <div class="w-16 h-16 bg-primary-700 text-white rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                    🏢
                </div>
                <h3 class="text-xl font-bold mb-2">{{ $companyInfo['name'] }}</h3>
                <p class="text-gray-600 mb-4">DIN TOUR & TRAVEL</p>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>🕐 Jam Operasional: {{ $companyInfo['operating_hours'] }}</p>
                    <p>📧 Email: {{ $companyInfo['email'] }}</p>
                    <p>🌐 Website: {{ $companyInfo['website'] }}</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ app(\App\Services\PackageService::class)->getWhatsAppLink() }}" 
               target="_blank"
               class="inline-block btn-whatsapp text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-opacity-90 transition-colors">
                💬 Chat via WhatsApp
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Smooth scroll to packages section
    document.querySelector('a[href="#packages"]').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('packages').scrollIntoView({
            behavior: 'smooth'
        });
    });

    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe cards for animation
    document.querySelectorAll('.card-hover').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
</script>
@endpush
