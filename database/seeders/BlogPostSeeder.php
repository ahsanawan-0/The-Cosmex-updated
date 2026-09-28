<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * Creates the launch blog posts. Posts that already exist (matched by slug)
 * are left untouched, so edits made in the admin panel are never overwritten.
 *
 * Run: php artisan db:seed --class=BlogPostSeeder --force
 */
class BlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'slug' => 'hydrafacial-machine-price-in-pakistan',
                'title' => 'HydraFacial Machine Price in Pakistan (2026): 7-in-1 to 17-in-1 Compared',
                'excerpt' => 'What a hydrafacial machine costs in Pakistan, what the extra handpieces on 9-in-1 to 17-in-1 models actually do, and how to choose one that pays for itself.',
                'seo_title' => 'HydraFacial Machine Price in Pakistan 2026: 7-in-1 to 17-in-1',
                'seo_description' => 'Hydrafacial machine prices in Pakistan compared, from portable 7-in-1 units to 17-in-1 systems with skin analysers, plus running costs and a buying checklist.',
                'category_slug' => 'hydrafacial',
            ],
            [
                'slug' => 'diode-laser-machine-price-in-pakistan',
                'title' => 'Diode Laser Hair Removal Machine Price in Pakistan: 2026 Buyer\'s Guide',
                'excerpt' => 'Single or dual handle, 1200W or 1600W, diode or IPL: what changes the price of a laser hair removal machine in Pakistan, and a checklist to take to any supplier.',
                'seo_title' => 'Diode Laser Machine Price in Pakistan (2026 Buyer\'s Guide)',
                'seo_description' => 'Diode laser hair removal machine prices in Pakistan compared: single vs dual handle, 1200W vs 1600W, diode vs IPL and Alexandrite, plus a clinic checklist.',
                'category_slug' => 'laser-machines',
            ],
            [
                'slug' => 'hifu-machine-price-in-pakistan',
                'title' => 'HIFU Machine Price in Pakistan: 7D vs 9D vs 12D, Which Should Your Clinic Buy?',
                'excerpt' => 'What really differs between HIFU 7D, 9D and 12D machines, what cartridges cost to run, how HIFU compares with RF microneedling, and what to check before you buy.',
                'seo_title' => 'HIFU Machine Price in Pakistan: 7D vs 9D vs 12D Compared',
                'seo_description' => 'HIFU machine prices in Pakistan compared: 7D, 9D and 12D, cartridges and depths, running costs, HIFU vs RF microneedling, and a buying checklist.',
                'category_slug' => 'other-machines',
            ],
            [
                'slug' => 'dr-pen-price-in-pakistan',
                'title' => 'Dr. Pen Price in Pakistan: A1 vs A6 vs A6S vs M8 vs A10 (+ Cartridge Guide)',
                'excerpt' => 'Dr. Pen microneedling pens compared: prices, power, speed settings, which cartridges fit which pen, and the difference between 1P, 12P, 36P and nano cartridges.',
                'seo_title' => 'Dr. Pen Price in Pakistan: A1, A6, A6S, M8 & A10 Compared',
                'seo_description' => 'Dr. Pen prices in Pakistan compared: A1, A6, A6S, M8 and A10, which cartridges fit which pen, 1P vs 12P vs 36P vs nano, and how to choose for your clinic.',
                'category_slug' => 'tools-devices',
            ],
            [
                'slug' => 'how-to-open-aesthetic-clinic-in-pakistan',
                'title' => 'How to Open an Aesthetic Clinic in Pakistan: Machines, Budget and Checklist',
                'excerpt' => 'A practical, step-by-step guide to opening an aesthetic clinic in Pakistan: registration, rooms, which machines to buy first, budgeting and a launch checklist.',
                'seo_title' => 'How to Open an Aesthetic Clinic in Pakistan (2026 Guide)',
                'seo_description' => 'How to open an aesthetic clinic in Pakistan: registration, staff, which aesthetic machines to buy first, budget planning and a step-by-step launch checklist.',
                'category_slug' => 'aesthetic-machines',
            ],
        ];

        $publishedAt = now();

        foreach ($posts as $data) {
            if (Post::where('slug', $data['slug'])->exists()) {
                continue;
            }

            Post::create($data + [
                'body' => file_get_contents(__DIR__ . '/blog/' . $data['slug'] . '.html'),
                'cover_image' => '/images/blog/' . $data['slug'] . '.jpg',
                'status' => 'published',
                'published_at' => $publishedAt,
            ]);
        }
    }
}
