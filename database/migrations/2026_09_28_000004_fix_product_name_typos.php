<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Corrects product names (the on-page H1) that were misspelled or identical
 * to another product's. Each update only applies while the name still has
 * the old value, so later edits made in the admin panel are never overwritten.
 * Slugs are left unchanged so no URLs move.
 */
return new class extends Migration
{
    /** slug => [old name, new name] */
    private array $names = [
        'digtal-centrifige-dlab' => ['Digtal Centrifige DLab', 'DLAB Digital Centrifuge'],
        'hydrafafacial-aqua-star-10-in-1' => ['Hydrafafacial Aqua Star 10-in-1', 'Hydrafacial Aqua Star 10-in-1'],
        'co2-fractional' => ['Co2 Fractional', 'CO2 Fractional Laser (Metal Tube)'],
        'co2-fractional-laser' => ['Co2 Fractional Laser', 'CO2 Fractional Laser'],
        'soprano-titanium' => ['Soprano Titanium (1600W)', 'Soprano Titanium Dual Handle (1600W)'],
        'soprano-titanium-1600w' => ['Soprano Titanium (1600W)', 'Soprano Titanium Single Handle (1600W)'],
        'mole-removal-pen-plasma-pen' => ['Mole Removal Pen / Plasma Pen', 'Plasma Pen 9-Step (Mole Removal Pen)'],
        'plasma-pen-mole-removal-pen' => ['Plasma Pen / Mole Removal Pen', 'Plasma Pen 19-Step High Power'],
        'j-cain' => ['J Cain', 'J-Cain'],
        'neo-cain-jar' => ['Neo Cain Jar', 'Neo-Cain Jar'],
        'neo-cain-tube' => ['Neo Cain Tube', 'Neo-Cain Tube'],
        'dr-pen-a1' => ['Dr Pen A1', 'Dr. Pen A1'],
        'dr-pen-a6' => ['Dr Pen A6', 'Dr. Pen A6'],
        'dr-pen-a6s' => ['Dr Pen A6S', 'Dr. Pen A6S'],
        'dr-pen-a10' => ['Dr Pen A10', 'Dr. Pen A10'],
        'dr-pen-m8' => ['Dr Pen M8', 'Dr. Pen M8'],
        'dr-pen-a6a1-cartridges' => ['Dr Pen A6/A1 Cartridges', 'Dr. Pen A6/A1 Cartridges'],
        'dr-pen-m8-cartridges' => ['Dr Pen M8 Cartridges', 'Dr. Pen M8 Cartridges'],
        'emsculpt' => ['EmSculpt', 'Emsculpt'],
        'lidocaine-spray' => ['Lidocaine/Numbing Spray', 'Lidocaine 10% Numbing Spray'],
    ];

    /** Text fixes inside SEO fields: [column, search, replace] */
    private array $replacements = [
        ['seo_description', 'Pakistanfrom', 'Pakistan from'],
        ['seo_title', 'Pakistan| ', 'Pakistan | '],
        ['seo_title', 'Lahore| ', 'Lahore | '],
    ];

    public function up(): void
    {
        foreach ($this->names as $slug => [$old, $new]) {
            DB::table('products')->where('slug', $slug)->where('name', $old)->update(['name' => $new]);
        }

        foreach ($this->replacements as [$column, $search, $replace]) {
            DB::table('products')
                ->where($column, 'like', '%' . $search . '%')
                ->update([$column => DB::raw('REPLACE(' . $column . ', ' . DB::getPdo()->quote($search) . ', ' . DB::getPdo()->quote($replace) . ')')]);
        }
    }

    public function down(): void
    {
        foreach ($this->names as $slug => [$old, $new]) {
            DB::table('products')->where('slug', $slug)->where('name', $new)->update(['name' => $old]);
        }
    }
};
