<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $jsonDataCurrencies = file_get_contents('https://api.hilariweb.com/divisas');
        $currencies = json_decode($jsonDataCurrencies, true);

        return view('admin.settings.index', [
            'title' => 'Ajustes del Sistema',
            'currencies' => $currencies,
            'setting' => Setting::first(),
        ]);
    }

    public function store(SettingRequest $request)
    {
        try {
            $setting = Setting::first() ?? new Setting();

            $setting->name = $request->name;
            $setting->description = $request->description;
            $setting->branch = $request->branch;
            $setting->address = $request->address;
            $setting->phone1 = $request->phone1;
            $setting->phone2 = $request->phone2;
            $setting->currency = $request->currency;
            $setting->email = $request->email;
            $setting->website = $request->website;

            if ($request->hasFile('logo')) {
                if ($setting->logo && Storage::disk('public')->exists('logos/' . $setting->logo)) {
                    Storage::disk('public')->delete('logos/' . $setting->logo);
                }
                $logoPath = $request->file('logo')->store('logos', 'public');
                $setting->logo = basename($logoPath);
            }

            if ($request->hasFile('logo_auto')) {
                if ($setting->logo_auto && Storage::disk('public')->exists('logos/' . $setting->logo_auto)) {
                    Storage::disk('public')->delete('logos/' . $setting->logo_auto);
                }
                $logoAutoPath = $request->file('logo_auto')->store('logos', 'public');
                $setting->logo_auto = basename($logoAutoPath);
            }

            $setting->save();

            return redirect()->back()->with('success', '¡Configuración guardada con éxito!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'No se pudo guardar la configuración: ' . $th->getMessage());
        }
    }
}
