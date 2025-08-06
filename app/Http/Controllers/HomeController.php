<?php

namespace App\Http\Controllers;

use App\Services\PackageService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $packageService;

    public function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
    }

    public function index()
    {
        $packages = $this->packageService->getAllPackages();
        $companyInfo = $this->packageService->getCompanyInfo();
        $features = $this->packageService->getFeatures();

        return view('home', compact('packages', 'companyInfo', 'features'));
    }

    public function packages()
    {
        $packages = $this->packageService->getAllPackages();
        $companyInfo = $this->packageService->getCompanyInfo();

        return view('packages', compact('packages', 'companyInfo'));
    }

    public function about()
    {
        $features = $this->packageService->getFeatures();
        $companyInfo = $this->packageService->getCompanyInfo();

        return view('about', compact('features', 'companyInfo'));
    }

    public function contact()
    {
        $companyInfo = $this->packageService->getCompanyInfo();

        return view('contact', compact('companyInfo'));
    }
}
