<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'site_name' => 'Cosmex Pvt Ltd',
            'site_tagline' => 'Professional Aesthetic Products & Machines',
            'contact_email' => 'info@thecosmex.com',
            'contact_phone' => '0328-4333364',
            'whatsapp_number' => '923284333364',
            'address' => '21-B, G Block, Johar Town, Lahore, Pakistan',
            'facebook_url' => '',
            'instagram_url' => '',
            'tiktok_url' => ''
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
