<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'store_name' => Setting::get('store_name', ''),
            'store_address' => Setting::get('store_address', ''),
            'store_phone' => Setting::get('store_phone', ''),
            'store_email' => Setting::get('store_email', ''),
            'low_stock_threshold' => Setting::get('low_stock_threshold', '10'),
        ];

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'nullable|string',
            'store_phone' => 'nullable|string|max:20',
            'store_email' => 'nullable|email|max:255',
            'low_stock_threshold' => 'required|integer|min:1',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}
