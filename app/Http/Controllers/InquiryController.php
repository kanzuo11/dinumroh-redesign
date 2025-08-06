<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
            'package_id' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Mohon periksa kembali data yang Anda masukkan.');
        }

        $inquiry = [
            'id' => time() . rand(1000, 9999),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'package_id' => $request->package_id,
            'status' => 'new',
            'created_at' => now()->toISOString(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ];

        // Save to JSON file
        $this->saveInquiry($inquiry);

        // Send email notification (optional)
        $this->sendEmailNotification($inquiry);

        return back()->with('success', 'Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }

    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:1000',
            'package_id' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $inquiry = [
            'id' => time() . rand(1000, 9999),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'message' => $request->message,
            'package_id' => $request->package_id,
            'status' => 'new',
            'created_at' => now()->toISOString(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ];

        // Save to JSON file
        $this->saveInquiry($inquiry);

        // Send email notification (optional)
        $this->sendEmailNotification($inquiry);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry submitted successfully',
            'data' => $inquiry
        ]);
    }

    protected function saveInquiry($inquiry)
    {
        $inquiriesFile = 'inquiries.json';
        
        // Get existing inquiries
        $inquiries = [];
        if (Storage::exists($inquiriesFile)) {
            $existingData = Storage::get($inquiriesFile);
            $inquiries = json_decode($existingData, true) ?? [];
        }

        // Add new inquiry
        $inquiries[] = $inquiry;

        // Keep only last 1000 inquiries to prevent file from getting too large
        if (count($inquiries) > 1000) {
            $inquiries = array_slice($inquiries, -1000);
        }

        // Save back to file
        Storage::put($inquiriesFile, json_encode($inquiries, JSON_PRETTY_PRINT));
    }

    protected function sendEmailNotification($inquiry)
    {
        try {
            // Get company info
            $packageService = app(\App\Services\PackageService::class);
            $companyInfo = $packageService->getCompanyInfo();

            // Prepare email data
            $emailData = [
                'inquiry' => $inquiry,
                'company' => $companyInfo
            ];

            // Send email to admin
            Mail::send('emails.inquiry-notification', $emailData, function ($message) use ($companyInfo, $inquiry) {
                $message->to($companyInfo['email'])
                        ->subject('Inquiry Baru dari Website - ' . $inquiry['name']);
            });

            // Send confirmation email to customer
            Mail::send('emails.inquiry-confirmation', $emailData, function ($message) use ($inquiry) {
                $message->to($inquiry['email'])
                        ->subject('Terima kasih atas inquiry Anda - PT Din Banyutengah');
            });

        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send inquiry email: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $inquiriesFile = 'inquiries.json';
        $inquiries = [];

        if (Storage::exists($inquiriesFile)) {
            $data = Storage::get($inquiriesFile);
            $inquiries = json_decode($data, true) ?? [];
        }

        // Sort by created_at desc
        usort($inquiries, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function show($id)
    {
        $inquiriesFile = 'inquiries.json';
        $inquiry = null;

        if (Storage::exists($inquiriesFile)) {
            $data = Storage::get($inquiriesFile);
            $inquiries = json_decode($data, true) ?? [];
            
            foreach ($inquiries as $item) {
                if ($item['id'] == $id) {
                    $inquiry = $item;
                    break;
                }
            }
        }

        if (!$inquiry) {
            abort(404, 'Inquiry not found');
        }

        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:new,contacted,resolved,spam'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $inquiriesFile = 'inquiries.json';
        $inquiries = [];

        if (Storage::exists($inquiriesFile)) {
            $data = Storage::get($inquiriesFile);
            $inquiries = json_decode($data, true) ?? [];
        }

        // Update inquiry status
        foreach ($inquiries as &$inquiry) {
            if ($inquiry['id'] == $id) {
                $inquiry['status'] = $request->status;
                $inquiry['updated_at'] = now()->toISOString();
                break;
            }
        }

        // Save back to file
        Storage::put($inquiriesFile, json_encode($inquiries, JSON_PRETTY_PRINT));

        return back()->with('success', 'Status inquiry berhasil diupdate.');
    }
}
