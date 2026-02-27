<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::all()->groupBy('group');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->settings as $key => $value) {
            \App\Models\Setting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function initialize()
    {
        try {
            \Artisan::call('db:seed', [
                '--class' => 'Database\\Seeders\\SettingSeeder',
                '--force' => true
            ]);
            return back()->with('success', 'Data pengaturan dasar berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal inisialisasi: ' . $e->getMessage());
        }
    }
}
