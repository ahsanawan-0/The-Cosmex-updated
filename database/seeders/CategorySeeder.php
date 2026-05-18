<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $hierarchy = [
            'Laser Machines' => [],
            'HydraFacial' => [],
            'Aesthetic Products' => [
                'Exosomes',
                'Botox',
                'Dermal Fillers',
                'Numbing Creams',
                'Otesaly Meso Serum',
                'Skin Whitening Injections',
                'Stayve BB Glow',
                'Microneedling',
                'Injectables',
                'Peels & Serums',
                'Tools & Devices'
            ],
            'Other Equipment' => [],
        ];

        $sortOrder = 1;
        foreach ($hierarchy as $parentName => $children) {
            $parent = Category::updateOrCreate(
                ['slug' => Str::slug($parentName)],
                [
                    'name' => $parentName,
                    'sort_order' => $sortOrder++,
                    'parent_id' => null,
                ]
            );

            foreach ($children as $childName) {
                Category::updateOrCreate(
                    ['slug' => Str::slug($childName)],
                    [
                        'name' => $childName,
                        'sort_order' => $sortOrder++,
                        'parent_id' => $parent->id,
                    ]
                );
            }
        }
    }
}
