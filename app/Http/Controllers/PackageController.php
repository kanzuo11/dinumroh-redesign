<?php

namespace App\Http\Controllers;

use App\Services\PackageService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    protected $packageService;

    public function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
    }

    public function index(Request $request)
    {
        $packages = $this->packageService->getAllPackages();
        
        // Filter by search query
        if ($request->has('search') && !empty($request->search)) {
            $packages = $this->packageService->searchPackages($request->search);
        }

        // Filter by price range
        if ($request->has('min_price') || $request->has('max_price')) {
            $packages = $this->packageService->filterByPrice(
                $packages,
                $request->min_price,
                $request->max_price
            );
        }

        // Filter by duration
        if ($request->has('duration')) {
            $packages = $this->packageService->filterByDuration($packages, $request->duration);
        }

        // Filter by airline
        if ($request->has('airline')) {
            $packages = $this->packageService->filterByAirline($packages, $request->airline);
        }

        $companyInfo = $this->packageService->getCompanyInfo();

        return view('packages.index', compact('packages', 'companyInfo'));
    }

    public function show($id)
    {
        $package = $this->packageService->getPackageById($id);
        
        if (!$package) {
            abort(404, 'Package not found');
        }

        $relatedPackages = $this->packageService->getRelatedPackages($package, 3);
        $companyInfo = $this->packageService->getCompanyInfo();

        return view('packages.show', compact('package', 'relatedPackages', 'companyInfo'));
    }

    public function api()
    {
        $packages = $this->packageService->getAllPackages();
        
        return response()->json([
            'success' => true,
            'data' => $packages,
            'total' => count($packages)
        ]);
    }

    public function apiShow($id)
    {
        $package = $this->packageService->getPackageById($id);
        
        if (!$package) {
            return response()->json([
                'success' => false,
                'message' => 'Package not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $package
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $packages = $this->packageService->searchPackages($query);

        return response()->json([
            'success' => true,
            'data' => $packages,
            'total' => count($packages),
            'query' => $query
        ]);
    }
}
