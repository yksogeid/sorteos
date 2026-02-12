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
            'favicon' => Setting::get('favicon'),
            'banner' => Setting::get('banner'),
            'site_title' => Setting::get('site_title', 'Sorteos Premium'),
            'site_slogan' => Setting::get('site_slogan', 'Tu oportunidad de ganar hoy'),
            'whatsapp' => Setting::get('whatsapp'),
            'instagram' => Setting::get('instagram'),
            'facebook' => Setting::get('facebook'),
            'site_email' => Setting::get('site_email', 'ventas@ejemplo.com'),
            'site_description' => Setting::get('site_description', 'Únete a nuestra comunidad y sé el próximo gran ganador de premios extraordinarios.'),
            'footer_about' => Setting::get('footer_about', 'La mejor plataforma de sorteos online con transparencia y seguridad.'),
            'footer_copyright' => Setting::get('footer_copyright', 'Todos los derechos reservados'),
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
        
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('settings', 'public');
            Setting::set('favicon', $path);
        }

        if ($request->hasFile('banner')) {
            $path = $request->file('banner')->store('settings', 'public');
            Setting::set('banner', $path);
        }

        // Handle text fields
        $fields = ['site_title', 'site_slogan', 'site_email', 'whatsapp', 'instagram', 'facebook', 'site_description', 'footer_about', 'footer_copyright'];
        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field));
            }
        }

        return redirect()->back()->with('success', 'Configuración actualizada correctamente.');
    }
}
