<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Keys must match exactly what the views read via Setting::get().
        // Values default to config/site.php, so .env drives production.
        $settings = [
            'site_name'        => config('site.name'),
            'site_tagline'     => config('site.tagline'),
            'contact_email'    => config('site.contact_email'),
            'contact_phone'    => config('site.contact_phone'),
            'whatsapp_number'  => config('site.whatsapp'),
            'address'          => config('site.address'),
            'social_facebook'  => config('site.social_facebook'),
            'social_instagram' => config('site.social_instagram'),
            'social_tiktok'    => config('site.social_tiktok'),
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        // Drop rows from the old naming scheme so they cannot shadow the above.
        Setting::whereIn('key', ['facebook_url', 'instagram_url', 'tiktok_url'])->delete();
    }
}
