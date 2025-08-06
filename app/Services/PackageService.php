<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class PackageService
{
    protected $data;

    public function __construct()
    {
        $this->loadData();
    }

    protected function loadData()
    {
        $jsonContent = Storage::get('packages.json');
        $this->data = json_decode($jsonContent, true);
    }

    public function getAllPackages(): Collection
    {
        return collect($this->data['packages'])->where('status', 'active');
    }

    public function getPackageById($id)
    {
        return collect($this->data['packages'])
            ->where('status', 'active')
            ->firstWhere('id', (int)$id);
    }

    public function getFeaturedPackages(): Collection
    {
        return collect($this->data['packages'])
            ->where('status', 'active')
            ->where('featured', true);
    }

    public function getPremiumPackages(): Collection
    {
        return collect($this->data['packages'])
            ->where('status', 'active')
            ->where('premium', true);
    }

    public function searchPackages($query): Collection
    {
        $query = strtolower($query);
        
        return collect($this->data['packages'])
            ->where('status', 'active')
            ->filter(function ($package) use ($query) {
                return str_contains(strtolower($package['title']), $query) ||
                       str_contains(strtolower($package['subtitle']), $query) ||
                       str_contains(strtolower($package['airline']), $query) ||
                       str_contains(strtolower($package['route']), $query) ||
                       str_contains(strtolower($package['hotel_mekkah']), $query) ||
                       str_contains(strtolower($package['hotel_madinah']), $query);
            });
    }

    public function filterByPrice(Collection $packages, $minPrice = null, $maxPrice = null): Collection
    {
        return $packages->filter(function ($package) use ($minPrice, $maxPrice) {
            $price = $package['price'];
            
            if ($minPrice && $price < $minPrice) {
                return false;
            }
            
            if ($maxPrice && $price > $maxPrice) {
                return false;
            }
            
            return true;
        });
    }

    public function filterByDuration(Collection $packages, $duration): Collection
    {
        return $packages->where('program', $duration);
    }

    public function filterByAirline(Collection $packages, $airline): Collection
    {
        return $packages->where('airline', $airline);
    }

    public function getRelatedPackages($currentPackage, $limit = 3): Collection
    {
        return collect($this->data['packages'])
            ->where('status', 'active')
            ->where('id', '!=', $currentPackage['id'])
            ->where('program', $currentPackage['program'])
            ->take($limit);
    }

    public function getPackagesByProgram($program): Collection
    {
        return collect($this->data['packages'])
            ->where('status', 'active')
            ->where('program', $program);
    }

    public function getUniqueAirlines(): Collection
    {
        return collect($this->data['packages'])
            ->where('status', 'active')
            ->pluck('airline')
            ->unique()
            ->values();
    }

    public function getUniqueDurations(): Collection
    {
        return collect($this->data['packages'])
            ->where('status', 'active')
            ->pluck('program')
            ->unique()
            ->values();
    }

    public function getPriceRange(): array
    {
        $prices = collect($this->data['packages'])
            ->where('status', 'active')
            ->pluck('price');

        return [
            'min' => $prices->min(),
            'max' => $prices->max()
        ];
    }

    public function getCompanyInfo(): array
    {
        return $this->data['company_info'];
    }

    public function getFeatures(): array
    {
        return $this->data['features'];
    }

    public function formatPrice($price): string
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    public function getWhatsAppLink($packageId = null, $customMessage = null): string
    {
        $whatsappNumber = $this->data['company_info']['whatsapp'];
        
        if ($customMessage) {
            $message = $customMessage;
        } elseif ($packageId) {
            $package = $this->getPackageById($packageId);
            $message = "Halo, saya tertarik dengan paket {$package['title']} dengan harga {$package['price_formatted']}. Mohon informasi lebih lanjut mengenai paket ini.";
        } else {
            $message = "Halo, saya tertarik dengan paket umrah dari PT Din Banyutengah. Mohon informasi lebih lanjut.";
        }

        return "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);
    }

    public function getPackageStats(): array
    {
        $packages = collect($this->data['packages'])->where('status', 'active');
        
        return [
            'total_packages' => $packages->count(),
            'featured_packages' => $packages->where('featured', true)->count(),
            'premium_packages' => $packages->where('premium', true)->count(),
            'average_price' => $packages->avg('price'),
            'cheapest_price' => $packages->min('price'),
            'most_expensive_price' => $packages->max('price')
        ];
    }

    public function refreshData()
    {
        $this->loadData();
    }

    public function updatePackageData($newData)
    {
        Storage::put('packages.json', json_encode($newData, JSON_PRETTY_PRINT));
        $this->refreshData();
    }
}
