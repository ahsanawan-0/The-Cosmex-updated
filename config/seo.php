<?php

/*
|--------------------------------------------------------------------------
| Default category SEO copy
|--------------------------------------------------------------------------
|
| Used when a category's own seo_title / seo_description / description /
| content fields are empty in the admin panel, so anything typed there
| wins. Placeholders filled from live data: {count} active products,
| {min} and {max} lowest and highest price in PKR.
|
*/

return [

    'categories' => [

        'aesthetic-machines' => [
            'title' => 'Aesthetic Machines in Pakistan: Prices & Supplier',
            'description' => '{count} aesthetic machines for clinics: diode and Pico lasers, HydraFacial, HIFU, RF microneedling, Emsculpt and cryolipolysis, with PKR prices.',
            'lead' => 'Laser, HydraFacial, skin-tightening and body-contouring machines imported for clinics, dermatologists and aesthetic centres in Pakistan.',
            'content' => <<<'HTML'
<h2>Find the right machine for your clinic</h2>
<ul>
<li><a href="/category/laser-machines">Laser machines</a>: diode hair removal (Soprano Titanium, Diode 810), Pico and Q-switch, CO2 fractional and IPL systems.</li>
<li><a href="/category/hydrafacial">HydraFacial machines</a>: from portable 7-in-1 units to 17-in-1 systems with skin analysers.</li>
<li><a href="/category/other-machines">Skin tightening and body contouring</a>: HIFU 7D, 9D and 12D, RF microneedling, Morpheus 8, Emsculpt and cryolipolysis.</li>
</ul>
<p>The {count} machines in this range are priced from PKR {min} to PKR {max}. Every product page lists its price; for wholesale rates, installation and staff training, send the model name to the team on WhatsApp.</p>
HTML,
        ],

        'laser-machines' => [
            'title' => 'Laser Machine Price in Pakistan: Diode, Pico, CO2',
            'description' => 'Compare {count} laser machines for clinics, from Soprano Titanium and Diode 810 to Candela Pico and CO2 fractional. Prices from PKR {min}.',
            'lead' => 'Diode hair-removal, Pico, Q-switch, CO2 fractional and IPL systems for aesthetic clinics, with PKR prices and delivery across Pakistan.',
            'content' => <<<'HTML'
<h2>Choosing a laser machine for your clinic</h2>
<p>Most clinics start with the treatment they sell most. Diode systems such as the Soprano Titanium range and Diode 810 are built for laser hair removal. Pico and Q-switch lasers are used for tattoo and pigmentation work, CO2 fractional lasers for resurfacing, and IPL machines for hair reduction and photo-rejuvenation at a lower entry price.</p>
<h3>What to compare</h3>
<ul>
<li><strong>Wavelengths:</strong> which wavelengths the handpiece offers (many diode systems combine 755, 808 and 1064 nm) and which skin types the manufacturer specifies.</li>
<li><strong>Handle and machine power:</strong> the handle output, for example 1200W or 1600W, and whether the machine has one or two handles.</li>
<li><strong>Cooling:</strong> the cooling method and how long the machine can run continuously.</li>
<li><strong>Warranty and service:</strong> what is covered, for how long, and who services the machine in Pakistan.</li>
<li><strong>Training:</strong> whether operator training is included at installation.</li>
</ul>
<h3>Prices and ordering</h3>
<p>The {count} laser machines listed here range from PKR {min} to PKR {max}. Send the model name on WhatsApp for current stock, wholesale rates and delivery to your city.</p>
HTML,
        ],

        'hydrafacial' => [
            'title' => 'HydraFacial Machine Price in Pakistan',
            'description' => 'Compare {count} HydraFacial machines for clinics and salons, from 7-in-1 portable units to 17-in-1 systems with skin analysers. PKR {min} to {max}.',
            'lead' => 'Multi-handpiece hydra-dermabrasion systems, from compact 7-in-1 units to 17-in-1 machines with built-in skin analysers.',
            'content' => <<<'HTML'
<h2>How HydraFacial machines differ</h2>
<p>The number in the name (7-in-1, 12-in-1, 17-in-1) is the number of handpieces or functions supplied. Portable units suit salons adding their first facial treatment. Larger systems add more handpieces, commonly RF, ultrasound, oxygen spray and cold therapy, and some models (12-in-1, 15-in-1 and Aqua Star 10-in-1) include a skin analyser.</p>
<h3>What to compare</h3>
<ul>
<li>Which handpieces are included, and which you will use in your treatment menu.</li>
<li>Whether a skin analyser is built in.</li>
<li>Number of solution bottles and how much solution each facial uses.</li>
<li>Availability of replacement tips and solutions.</li>
<li>Warranty, installation and staff training.</li>
</ul>
<p>HydraFacial machines here range from PKR {min} to PKR {max}. Ask on WhatsApp for wholesale pricing on more than one unit.</p>
HTML,
        ],

        'other-machines' => [
            'title' => 'HIFU, RF Microneedling & Body Contouring Machines',
            'description' => 'HIFU 7D, 9D and 12D, Morpheus 8 and RF microneedling, Emsculpt and cryolipolysis machines for clinics in Pakistan. {count} models from PKR {min}.',
            'lead' => 'Non-surgical skin tightening and body contouring equipment: HIFU, RF microneedling, Emsculpt and cryolipolysis.',
            'content' => <<<'HTML'
<h2>Skin tightening and body contouring equipment</h2>
<p>HIFU systems (7D, 9D and 12D) deliver focused ultrasound at set depths through interchangeable cartridges. RF microneedling machines, including the Morpheus 8 system, combine microneedles with radiofrequency. Emsculpt uses electromagnetic muscle stimulation, and cryolipolysis machines use controlled cooling applicators.</p>
<h3>HIFU 7D, 9D or 12D</h3>
<p>The HIFU generations mainly differ in the number and depths of cartridges supplied and in treatment speed. Compare the cartridge depths included, the number of shots each cartridge delivers and the cost of replacements.</p>
<h3>Before you buy</h3>
<ul>
<li>Running costs: HIFU cartridges, microneedle tips and cryolipolysis membranes.</li>
<li>Number of applicators or handles.</li>
<li>Warranty, installation and training.</li>
</ul>
<p>Machines in this range cost from PKR {min} to PKR {max}.</p>
HTML,
        ],

        'aesthetic-products' => [
            'title' => 'Aesthetic Clinic Products: Exosomes, PDRN & More',
            'description' => 'Exosomes, PDRN and mesotherapy solutions, botulinum toxin and numbing creams for licensed clinics in Pakistan. {count} products with PKR prices.',
            'lead' => 'Consumables and injectables for licensed practitioners: exosomes, PDRN and mesotherapy solutions, botulinum toxin and topical numbing creams.',
            'content' => <<<'HTML'
<h2>Browse by product type</h2>
<ul>
<li><a href="/category/exosomes">Exosomes</a> for skin and scalp treatments.</li>
<li><a href="/category/otesaly-meso-serum">Mesotherapy serums and PDRN</a>, including Dermaheal, Otesaly and Lapuroon.</li>
<li><a href="/category/botox">Botulinum toxin brands</a> for licensed practitioners.</li>
<li><a href="/category/numbing-creams">Numbing creams and sprays</a> for use before procedures.</li>
</ul>
<p>These products are supplied to dermatologists, aesthetic physicians and licensed practitioners only. Always follow the manufacturer's instructions for storage and use.</p>
HTML,
        ],

        'botox' => [
            'title' => 'Botulinum Toxin (Botox) Brands for Clinics',
            'description' => 'Botulinum toxin type A brands (Botulax, Nabota, Nextoxin, Wellstox) supplied to licensed dermatologists and aesthetic clinics in Pakistan.',
            'lead' => 'Botulinum toxin type A products, supplied only to licensed medical professionals.',
            'content' => <<<'HTML'
<h2>For licensed practitioners only</h2>
<p>Botulinum toxin is a prescription medicine. These products are supplied to dermatologists, aesthetic physicians and clinics only, and every order is confirmed with the buyer directly on WhatsApp.</p>
<h3>Comparing brands</h3>
<ul>
<li><strong>Units per vial</strong> as stated on the pack.</li>
<li><strong>Storage:</strong> keep refrigerated as the manufacturer specifies, and ask how the product is kept cold in transit.</li>
<li><strong>Batch and expiry:</strong> ask for the batch number and expiry date before ordering.</li>
</ul>
<p>This page does not give treatment advice. Dosing and suitability are decisions for a qualified practitioner.</p>
HTML,
        ],

        'exosomes' => [
            'title' => 'Exosomes for Skin & Scalp Treatments in Pakistan',
            'description' => '{count} professional exosome products for clinics, including ASCE+ HRLV, Exovex, Exohealer, Hanheal and GFC Cell. Prices from PKR {min}.',
            'lead' => 'Professional exosome solutions for skin and scalp treatments, supplied to clinics and licensed practitioners.',
            'content' => <<<'HTML'
<h2>Choosing an exosome product</h2>
<p>Exosome products differ in source, concentration and intended area. This range includes skin-focused lines such as Exohealer and Hanheal, concentration options such as Exovex Rejuv (1 billion) and Exovex Revive (5 billion), and scalp-focused products such as ASCE+ HRLV.</p>
<h3>What to check</h3>
<ul>
<li>Concentration and vial volume on the pack.</li>
<li>Storage requirements and expiry date.</li>
<li>Whether the product is intended for skin, scalp or both.</li>
<li>The application methods the manufacturer lists, for example with <a href="/category/tools-devices">microneedling pens</a>.</li>
</ul>
<p>Exosome products here range from PKR {min} to PKR {max}.</p>
HTML,
        ],

        'numbing-creams' => [
            'title' => 'Numbing Cream Price in Pakistan (Lidocaine 10.56%)',
            'description' => 'Topical numbing creams and sprays for clinics: Neo-Cain, J-Cain, Nexcain, Leed Frost and 10% lidocaine spray. {count} products from PKR {min}.',
            'lead' => 'Topical anaesthetic creams and sprays used before microneedling, PMU, laser and other aesthetic procedures.',
            'content' => <<<'HTML'
<h2>Choosing a numbing cream</h2>
<p>The range includes 10.56% lidocaine creams in jars and tubes (Neo-Cain, J-Cain and Nexcain), Leed Frost for PMU and tattoo work, and a 10% lidocaine spray.</p>
<h3>What to compare</h3>
<ul>
<li>Pack size (jar or tube) and cost per procedure.</li>
<li>The application and contact time the manufacturer recommends.</li>
<li>Expiry date and storage.</li>
</ul>
<p>Often ordered with <a href="/category/tools-devices">microneedling pens and cartridges</a>. Topical anaesthetics should be used according to the manufacturer's instructions and under professional supervision.</p>
HTML,
        ],

        'otesaly-meso-serum' => [
            'title' => 'Mesotherapy Serums, PDRN & Skin Boosters',
            'description' => 'Dermaheal, Otesaly PDRN, Lapuroon PDRN, MesoHeal and Stayve BB Glow solutions for clinics in Pakistan. {count} products from PKR {min}.',
            'lead' => 'Mesotherapy solutions, PDRN ampoules and BB Glow kits for professional skin and scalp treatments.',
            'content' => <<<'HTML'
<h2>Mesotherapy and PDRN solutions</h2>
<p>This range covers Dermaheal solutions (SB for brightening, HSR for rejuvenation and HL for the scalp), Otesaly PDRN in W, H and R versions, Lapuroon PDRN, MesoHeal Pink Glow, and Stayve BB Glow starter and booster kits.</p>
<h3>What to compare</h3>
<ul>
<li>Active ingredients and concentration listed on the pack.</li>
<li>Vials per box and cost per session.</li>
<li>The application method the manufacturer specifies, for example microneedling or a mesotherapy gun.</li>
<li>Storage and expiry.</li>
</ul>
<p>Products here range from PKR {min} to PKR {max}.</p>
HTML,
        ],

        'tools-devices' => [
            'title' => 'Microneedling Pens, Plasma Pens & PRP Centrifuges',
            'description' => 'Dr. Pen microneedling pens and cartridges, plasma pens, PMU devices, LED masks and PRP centrifuges for clinics in Pakistan. {count} products from PKR {min}.',
            'lead' => 'Microneedling pens and cartridges, PMU and plasma pens, LED devices and PRP centrifuges for clinics and salons.',
            'content' => <<<'HTML'
<h2>Clinic tools and devices</h2>
<h3>Microneedling pens</h3>
<p>Dr. Pen A1, A6, A6S, A10 and M8, with matching A6/A1 and M8 cartridges in 1-pin, 12-pin, 36-pin and nano sizes, plus the Hydra Pen H3 for serum infusion. Check that the cartridges match your pen model before ordering.</p>
<h3>PRP centrifuges</h3>
<p>Benchtop centrifuges for PRP and plasma preparation, including the 80-1, 80-2, 800D, TD4C and DLAB 5000 RPM models. Compare maximum speed, tube capacity and rotor type.</p>
<h3>PMU, plasma and facial devices</h3>
<p>Charmant PMU pen, microblading pen, Neatcell Pico pen, 9-step and 19-step plasma pens, LED masks, PDT light, oxygen bubble pen, ultrasonic scrubber, high-frequency tool and an LED moon light for treatment rooms.</p>
<p>Products in this range cost from PKR {min} to PKR {max}. Pair microneedling pens with <a href="/category/numbing-creams">numbing creams</a> and <a href="/category/otesaly-meso-serum">mesotherapy solutions</a>.</p>
HTML,
        ],

    ],

];
