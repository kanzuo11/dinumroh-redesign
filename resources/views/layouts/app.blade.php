<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT Din Banyutengah - Umrah & Haji Travel Specialist')</title>
    <meta name="description" content="@yield('description', 'PT Din Banyutengah adalah travel umrah dan haji terpercaya dengan izin resmi Kemenag. Melayani perjalanan suci Anda dengan amanah sejak 2020.')">
    <meta name="keywords" content="umrah, haji, travel, indonesia, surabaya, jeddah, madinah, makkah">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f3f1ff',
                            100: '#ebe5ff',
                            200: '#d9ceff',
                            300: '#bea6ff',
                            400: '#9f75ff',
                            500: '#843dff',
                            600: '#7c2d99',
                            700: '#5a2d82',
                            800: '#4a1a6b',
                            900: '#3d1a56',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #5a2d82 0%, #7c4dff 100%);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .btn-whatsapp {
            background-color: #25d366;
        }
        
        .btn-whatsapp:hover {
            background-color: #128c7e;
        }
        
        .navbar-scrolled {
            backdrop-filter: blur(10px);
            background-color: rgba(90, 45, 130, 0.95);
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <!-- Header -->
    <header id="navbar" class="fixed top-0 left-0 right-0 z-50 bg-primary-700 text-white transition-all duration-300">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="block">
                        <h1 class="text-xl font-bold">{{ $companyInfo['name'] ?? 'PT Din Banyutengah' }}</h1>
                        <span class="text-sm opacity-90">{{ $companyInfo['tagline'] ?? 'Umrah & Haji Travel Specialist' }}</span>
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="hover:text-primary-200 transition-colors {{ request()->routeIs('home') ? 'text-primary-200' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('packages') }}" class="hover:text-primary-200 transition-colors {{ request()->routeIs('packages*') ? 'text-primary-200' : '' }}">
                        Paket Umrah
                    </a>
                    <a href="{{ route('about') }}" class="hover:text-primary-200 transition-colors {{ request()->routeIs('about') ? 'text-primary-200' : '' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('contact') }}" class="hover:text-primary-200 transition-colors {{ request()->routeIs('contact') ? 'text-primary-200' : '' }}">
                        Kontak
                    </a>
                </nav>
                
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden flex flex-col space-y-1">
                    <span class="w-6 h-0.5 bg-white transition-all"></span>
                    <span class="w-6 h-0.5 bg-white transition-all"></span>
                    <span class="w-6 h-0.5 bg-white transition-all"></span>
                </button>
            </div>
            
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="md:hidden hidden pb-4">
                <nav class="flex flex-col space-y-2">
                    <a href="{{ route('home') }}" class="block py-2 hover:text-primary-200 transition-colors {{ request()->routeIs('home') ? 'text-primary-200' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('packages') }}" class="block py-2 hover:text-primary-200 transition-colors {{ request()->routeIs('packages*') ? 'text-primary-200' : '' }}">
                        Paket Umrah
                    </a>
                    <a href="{{ route('about') }}" class="block py-2 hover:text-primary-200 transition-colors {{ request()->routeIs('about') ? 'text-primary-200' : '' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('contact') }}" class="block py-2 hover:text-primary-200 transition-colors {{ request()->routeIs('contact') ? 'text-primary-200' : '' }}">
                        Kontak
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary-700 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} {{ $companyInfo['name'] ?? 'PT Din Banyutengah' }}. All rights reserved.</p>
                <p class="text-sm opacity-75 mt-2">PPIU: {{ $companyInfo['ppiu'] ?? '912000640246200003' }}</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <a href="{{ app(\App\Services\PackageService::class)->getWhatsAppLink() }}" 
       target="_blank" 
       class="fixed bottom-6 right-6 btn-whatsapp text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all z-40">
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
        </svg>
    </a>

    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Smooth scrolling for anchor links
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
    
    @stack('scripts')
</body>
</html>
