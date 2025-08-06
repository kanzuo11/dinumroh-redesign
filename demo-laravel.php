<?php
/**
 * Laravel Implementation for PT Din Banyutengah
 * This file demonstrates the dynamic package loading and content rendering.
 */

// Simulate Laravel environment
class PackageService {
    private $data;
    
    public function __construct() {
        $this->loadData();
    }
    
    private function loadData() {
        $jsonContent = file_get_contents('storage/app/packages.json');
        $this->data = json_decode($jsonContent, true);
    }
    
    public function getAllPackages() {
        return array_filter($this->data['packages'], function($package) {
            return $package['status'] === 'active';
        });
    }
    
    public function getCompanyInfo() {
        return $this->data['company_info'];
    }
    
    public function getFeatures() {
        return $this->data['features'];
    }
    
    public function getWhatsAppLink($packageId = null) {
        $whatsappNumber = $this->data['company_info']['whatsapp'];
        
        if ($packageId) {
            $package = $this->getPackageById($packageId);
            $message = "Halo, saya tertarik dengan paket {$package['title']} dengan harga {$package['price_formatted']}. Mohon informasi lebih lanjut.";
        } else {
            $message = "Halo, saya tertarik dengan paket umrah dari PT Din Banyutengah. Mohon informasi lebih lanjut.";
        }
        
        return "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);
    }
    
    public function getPackageById($id) {
        foreach ($this->data['packages'] as $package) {
            if ($package['id'] == $id) {
                return $package;
            }
        }
        return null;
    }
}

// Initialize service
$packageService = new PackageService();
$packages = $packageService->getAllPackages();
$companyInfo = $packageService->getCompanyInfo();
$features = $packageService->getFeatures();

// Group packages by program
$packagesByProgram = [];
foreach ($packages as $package) {
    $packagesByProgram[$package['program']][] = $package;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $companyInfo['name'] ?> - Informasi Paket Umrah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            700: '#5a2d82',
                            800: '#4a1a6b'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .hero-gradient { background: linear-gradient(135deg, #5a2d82 0%, #7c4dff 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="font-sans">
    <!-- Header -->
    <header class="bg-primary-700 text-white py-4 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-xl font-bold"><?= $companyInfo['name'] ?></h1>
                    <span class="text-sm opacity-90"><?= $companyInfo['tagline'] ?></span>
                </div>
                <div class="bg-green-600 px-4 py-2 rounded-lg text-sm font-semibold">
                    ✨ Solusi Travel Umrah Profesional
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20 text-center">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold mb-4">Selamat Datang di PT Din Banyutengah</h2>
            <p class="text-xl mb-8">Temukan paket umrah terbaik dan layanan travel yang terpercaya</p>
        </div>
    </section>

    <!-- Packages Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-primary-700 mb-4">Paket Umrah Unggulan</h2>
                <p class="text-gray-600">Temukan paket umrah terbaik yang telah dipilih khusus untuk Anda</p>
            </div>

            <?php foreach ($packagesByProgram as $program => $programPackages): ?>
                <div class="mb-16">
                    <h3 class="text-2xl font-bold text-primary-700 text-center mb-8">
                        PROGRAM UMROH <?= $program ?>
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach ($programPackages as $package): ?>
                            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover relative">
                                <?php if ($package['featured']): ?>
                                    <div class="absolute top-4 right-4 bg-primary-700 text-white px-3 py-1 rounded-full text-sm font-semibold z-10">
                                        POPULER
                                    </div>
                                <?php elseif ($package['premium']): ?>
                                    <div class="absolute top-4 right-4 bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-semibold z-10">
                                        PREMIUM
                                    </div>
                                <?php endif; ?>

                                <div class="bg-primary-700 text-white p-4 text-center">
                                    <h4 class="text-lg font-bold"><?= $package['title'] ?></h4>
                                </div>

                                <div class="p-6">
                                    <div class="flex justify-between items-center mb-4 pb-4 border-b">
                                        <span class="font-semibold"><?= $package['route'] ?> | <?= $package['duration'] ?></span>
                                        <span class="text-sm text-gray-600">by <?= $package['airline'] ?></span>
                                    </div>

                                    <div class="text-center mb-4">
                                        <p class="font-semibold text-primary-700 mb-1">
                                            Keberangkatan: <?= $package['departure_date'] ?>
                                        </p>
                                    </div>

                                    <div class="text-center mb-6">
                                        <div class="text-2xl font-bold text-primary-700 mb-2">
                                            <?= $package['price_formatted'] ?>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                        <h5 class="font-semibold text-primary-700 mb-2">HOTEL</h5>
                                        <p class="text-sm mb-1"><strong>Mekkah:</strong> <?= $package['hotel_mekkah'] ?></p>
                                        <p class="text-sm"><strong>Madinah:</strong> <?= $package['hotel_madinah'] ?></p>
                                    </div>

                                    <a href="<?= $packageService->getWhatsAppLink($package['id']) ?>" 
                                       target="_blank"
                                       class="block w-full bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-lg font-semibold transition-colors">
                                        Konsultasi Sekarang
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-primary-700 text-center mb-12">
                Mengapa Memilih PT Din Banyutengah?
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($features as $feature): ?>
                    <div class="bg-gray-50 p-6 rounded-xl text-center card-hover">
                        <div class="w-16 h-16 bg-primary-700 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">
                            <?= $feature['icon'] ?>
                        </div>
                        <h3 class="text-xl font-bold text-primary-700 mb-3"><?= $feature['title'] ?></h3>
                        <p class="text-gray-600"><?= $feature['description'] ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Service Excellence Section -->
    <section class="py-16 bg-primary-700 text-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Fitur Unggulan Kami</h2>
                <p class="text-lg opacity-90">Solusi yang scalable dan reliable untuk pelayanan travel umrah</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white bg-opacity-10 p-6 rounded-xl text-center">
                    <div class="text-3xl mb-4">📊</div>
                    <h3 class="font-bold mb-2">Sistem Manajemen Paket</h3>
                    <p class="text-sm opacity-90">Pengelolaan paket umrah yang terorganisir dan mudah diakses</p>
                </div>
                
                <div class="bg-white bg-opacity-10 p-6 rounded-xl text-center">
                    <div class="text-3xl mb-4">🎨</div>
                    <h3 class="font-bold mb-2">Tampilan Terintegrasi</h3>
                    <p class="text-sm opacity-90">Interface yang user-friendly dan responsif</p>
                </div>
                
                <div class="bg-white bg-opacity-10 p-6 rounded-xl text-center">
                    <div class="text-3xl mb-4">🔍</div>
                    <h3 class="font-bold mb-2">Kemudahan Pencarian</h3>
                    <p class="text-sm opacity-90">Fitur pencarian dan filter paket yang canggih</p>
                </div>
                
                <div class="bg-white bg-opacity-10 p-6 rounded-xl text-center">
                    <div class="text-3xl mb-4">📱</div>
                    <h3 class="font-bold mb-2">Siap untuk Integrasi Mobile</h3>
                    <p class="text-sm opacity-90">Platform yang siap dikembangkan untuk aplikasi mobile</p>
                </div>
            </div>

            <div class="mt-12 text-center">
                <div class="bg-white bg-opacity-10 rounded-xl p-8 max-w-4xl mx-auto">
                    <h3 class="text-2xl font-bold mb-4">Keunggulan Layanan Kami</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                        <div>
                            <h4 class="font-bold mb-2">🚀 Skalabilitas</h4>
                            <ul class="text-sm space-y-1 opacity-90">
                                <li>• Mudah menambah paket baru</li>
                                <li>• Arsitektur modular yang fleksibel</li>
                                <li>• Siap untuk pertumbuhan masa depan</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold mb-2">🛠️ Kemudahan Maintenance</h4>
                            <ul class="text-sm space-y-1 opacity-90">
                                <li>• Pemisahan fungsi yang jelas</li>
                                <li>• Komponen yang dapat digunakan ulang</li>
                                <li>• Manajemen konten yang mudah</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold mb-2">📊 Konten Dinamis</h4>
                            <ul class="text-sm space-y-1 opacity-90">
                                <li>• Data paket yang selalu terkini</li>
                                <li>• Update konten real-time</li>
                                <li>• Tidak perlu perubahan kode</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold mb-2">🔧 Fitur Lengkap</h4>
                            <ul class="text-sm space-y-1 opacity-90">
                                <li>• Penanganan form kontak</li>
                                <li>• Integrasi WhatsApp</li>
                                <li>• URL yang SEO-friendly</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-primary-700 mb-8">Hubungi Kami</h2>
            <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">
                <h3 class="text-xl font-bold mb-4"><?= $companyInfo['leader']['name'] ?></h3>
                <p class="text-gray-600 mb-4"><?= $companyInfo['leader']['title'] ?></p>
                <div class="space-y-2 text-sm text-gray-600 mb-6">
                    <p>📞 <?= $companyInfo['phone'] ?></p>
                    <p>📧 <?= $companyInfo['email'] ?></p>
                    <p>📍 <?= $companyInfo['address'] ?></p>
                    <p>🕐 <?= $companyInfo['operating_hours'] ?></p>
                </div>
                <a href="<?= $packageService->getWhatsAppLink() ?>" 
                   target="_blank"
                   class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    💬 Chat via WhatsApp
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-primary-700 text-white py-8 text-center">
        <p>&copy; <?= date('Y') ?> <?= $companyInfo['name'] ?>. All rights reserved.</p>
        <p class="text-sm opacity-75 mt-2">PPIU: <?= $companyInfo['ppiu'] ?></p>
    </footer>
</body>
</html>
