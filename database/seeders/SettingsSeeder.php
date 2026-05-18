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
            'contact_email' => 'info@cosmexpvtltd.com',
            'contact_phone' => '+92 300 1234567',
            'whatsapp_number' => '923001234567',
            'address' => 'Lahore, Pakistan',
            'facebook_url' => '',
            'instagram_url' => '',
            'tiktok_url' => ''
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
