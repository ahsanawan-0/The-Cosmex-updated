<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $laserCategory = Category::where('slug', 'laser-machines')->first();
        $hydraCategory = Category::where('slug', 'hydrafacial')->first();

        $laserProducts = [
            'IPL 3-in-1',
            'IPL 4-in-1 UK Lamp',
            'Diode 810',
            'Black Swann',
            'Soprano Titanium (1600W, Chinese Bar)',
            'Soprano Titanium (1600W, USA Coherent Bar)',
            'Soprano Titanium (1600W, Diode Single Handle)',
            'Soprano Titanium New Shape',
            'Soprano Titanium (1600W, 3in1 Diode+IPL+PICO)',
            'BV Laser Single Handle Diode',
            'BV Laser 2in1 Diode+Pico',
            'BV Laser 3in1 Diode+IPL+PICO',
        ];

        foreach ($laserProducts as $name) {
            Product::updateOrCreate(
                ['name' => $name],
                [
                    'category_id' => $laserCategory?->id,
                    'price' => rand(800000, 2500000),
                    'stock' => rand(2, 10),
                    'status' => 'active',
                ]
            );
        }

        $hydraProducts = [
            'HydraFacial 7-in-1 (Dual Pump)',
            'HydraFacial 7-in-1 (Mechanical Pump)',
            'HydraFacial 9-in-1 (Mechanical Pump + Metal body)',
            'HydraFacial 11-in-1 (Mechanical Pump + Metal Body)',
            'HydraFacial 12-in-1 with Skin Analyser',
            'HydraFacial 14-in-1 (Mechanical Pump + Metal Body)',
            'HydraFacial 17-in-1 (Mechanical Pump + Metal Body + PDT Light)',
            'Alice Water Bubble',
            'Alice Water Bubble Max',
            'Hydrafacial New Face Oxygeno 10in1',
            'HydraFacial 15-in-1 with Skin Analyser',
        ];

        foreach ($hydraProducts as $name) {
            Product::updateOrCreate(
                ['name' => $name],
                [
                    'category_id' => $hydraCategory?->id,
                    'price' => rand(150000, 450000),
                    'stock' => rand(2, 15),
                    'status' => 'active',
                ]
            );
        }
    }
}
