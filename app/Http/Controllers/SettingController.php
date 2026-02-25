<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show the contact info settings form.
     */
    public function contactInfo()
    {
        $contact = Setting::getContactInfo();
        return view('settings.contact', compact('contact'));
    }

    /**
     * Update contact info settings.
     */
    public function updateContactInfo(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255',
            'address' => 'nullable|string|max:1000',
            'google_map_url' => 'nullable|url|max:2000',
        ]);

        Setting::set('contact_phone', $validated['phone'] ?? '');
        Setting::set('contact_email', $validated['email'] ?? '');
        Setting::set('contact_address', $validated['address'] ?? '');
        Setting::set('contact_google_map_url', $validated['google_map_url'] ?? '');

        return redirect()->route('settings.contact')->with('success', 'Contact information updated successfully!');
    }

    /**
     * Show the appearance settings form.
     */
    public function appearance()
    {
        $sidebarColor = Setting::get('sidebar_color', '#1e3a8a');
        return view('settings.appearance', compact('sidebarColor'));
    }

    /**
     * Update appearance settings.
     */
    public function updateAppearance(Request $request)
    {
        $validated = $request->validate([
            'sidebar_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        Setting::set('sidebar_color', $validated['sidebar_color']);

        return redirect()->route('settings.appearance')->with('success', 'Sidebar color updated successfully!');
    }
}
