<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'logo' => Setting::get('logo'),
            'banner' => Setting::get('banner'),
            'site_title' => Setting::get('site_title', 'Sorteos Premium'),
            'site_slogan' => Setting::get('site_slogan', 'Tu oportunidad de ganar hoy'),
            'whatsapp' => Setting::get('whatsapp'),
            'instagram' => Setting::get('instagram'),
            'facebook' => Setting::get('facebook'),
        ];
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle files
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            Setting::set('logo', $path);
        }

        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('settings', 'public');
            Setting::set('banner', $path);
        }

        // Handle text fields
        $fields = ['site_title', 'site_slogan', 'whatsapp', 'instagram', 'facebook'];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field));
            }
        }

        return redirect()->back()->with('success', 'Configuración actualizada correctamente.');
    }
}
