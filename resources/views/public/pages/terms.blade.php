@extends('layouts.app')
@section('title', 'Terms & Conditions | Cosmex Pvt Ltd')
@section('meta_description', 'Read the Cosmex Pvt Ltd terms and conditions. Learn about our ordering process, pricing, delivery, and return policies.')
@section('canonical', url('/terms-conditions'))

@section('content')
    <div class="bg-[var(--color-black)] py-14 text-white">
        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
            <h1 class="font-heading text-5xl text-white">Terms &amp; Conditions</h1>
            <p class="mt-3 text-sm text-white/50">Last updated: {{ date('F Y') }}</p>
        </div>
    </div>
    <section class="bg-white py-16">
        <div class="mx-auto max-w-[800px] px-4 sm:px-6 prose prose-zinc max-w-none">
            <h2>1. Ordering Process</h2>
            <p>Cosmex Pvt Ltd is a product catalog website. All orders are placed via WhatsApp. By clicking "Order on WhatsApp," you initiate a conversation with our team to confirm availability, pricing, and delivery details. An order is only confirmed once acknowledged by our team.</p>

            <h2>2. Pricing</h2>
            <p>All prices displayed are in Pakistani Rupees (PKR) and include applicable taxes. Prices are subject to change without notice. The price at the time of order confirmation is the final price.</p>

            <h2>3. Product Authenticity</h2>
            <p>All products listed on Cosmex Pvt Ltd are sourced from authorized distributors and are 100% authentic. We do not sell counterfeit or replica products.</p>

            <h2>4. Delivery</h2>
            <p>Delivery is available nationwide across Pakistan. Estimated delivery times are 3–7 business days. Lahore orders may qualify for same-day or next-day delivery. Delivery timelines are estimates and may vary due to courier or weather conditions.</p>

            <h2>5. Payment</h2>
            <p>We accept Cash on Delivery (COD) as the primary payment method. Bank transfer may be available for select orders — confirm with our team via WhatsApp.</p>

            <h2>6. Returns & Refunds</h2>
            <p>If you receive a damaged, defective, or incorrect product, contact us within 3 days of delivery via WhatsApp with photos. We will arrange a replacement or refund at our discretion. Opened or used products cannot be returned unless defective.</p>

            <h2>7. Disclaimer</h2>
            <p>Cosmex Pvt Ltd acts as a reseller. We are not the manufacturer of any products listed. Product descriptions are provided for informational purposes. Always read product labels before use. We are not liable for allergic reactions or misuse of products.</p>

            <h2>8. Intellectual Property</h2>
            <p>All content on this website including text, images, and design is the property of Cosmex Pvt Ltd and may not be reproduced without written permission.</p>

            <h2>9. Changes to Terms</h2>
            <p>We reserve the right to update these terms at any time. Continued use of our website constitutes acceptance of the updated terms.</p>

            <h2>10. Contact</h2>
            <p>Questions? Contact us at <a href="mailto:info@cosmexpvtltd.com" class="text-primary">info@cosmexpvtltd.com</a> or via WhatsApp.</p>
        </div>
    </section>
@endsection
