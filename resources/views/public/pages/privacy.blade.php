@extends('layouts.app')
@section('title', 'Privacy Policy | Cosmex Pvt Ltd')
@section('meta_description', 'Read the Cosmex Pvt Ltd privacy policy. Learn how we collect, use, and protect your personal information.')
@section('canonical', url('/privacy-policy'))

@section('content')
    <div class="bg-[var(--color-black)] py-14 text-white">
        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
            <h1 class="font-heading text-5xl text-white">Privacy Policy</h1>
            <p class="mt-3 text-sm text-white/50">Last updated: {{ date('F Y') }}</p>
        </div>
    </div>
    <section class="bg-white py-16">
        <div class="mx-auto max-w-[800px] px-4 sm:px-6 prose prose-zinc max-w-none">
            <h2>1. Information We Collect</h2>
            <p>When you contact us via WhatsApp or our contact form, we may collect your name, phone number, and email address for the purpose of processing your order or inquiry.</p>

            <h2>2. How We Use Your Information</h2>
            <p>We use your information solely to fulfill orders, respond to inquiries, and improve our services. We do not sell or share your personal data with third parties, except as required by law.</p>

            <h2>3. WhatsApp Communications</h2>
            <p>Orders are processed via WhatsApp. When you message us, your information is subject to WhatsApp's privacy policy in addition to ours. We only use WhatsApp conversations to fulfill your order.</p>

            <h2>4. Cookies</h2>
            <p>Our website uses essential session cookies to maintain your browsing session. We may also use Google Analytics cookies to understand how visitors use our site. You can opt out of Google Analytics tracking using the Google Analytics Opt-out Browser Add-on.</p>

            <h2>5. Google Analytics</h2>
            <p>We use Google Analytics to analyze website traffic. This service collects anonymized data about your visit (pages viewed, time spent, device type). No personally identifiable information is shared with Google Analytics.</p>

            <h2>6. Data Security</h2>
            <p>We implement reasonable security measures to protect your information. However, no method of transmission over the internet is 100% secure.</p>

            <h2>7. Third-Party Links</h2>
            <p>Our website may contain links to third-party websites. We are not responsible for the privacy practices of those websites.</p>

            <h2>8. Children's Privacy</h2>
            <p>Our services are not directed at children under 13. We do not knowingly collect personal information from children.</p>

            <h2>9. Contact Us</h2>
            <p>If you have questions about this privacy policy, contact us at <a href="mailto:info@cosmexpvtltd.com" class="text-primary">info@cosmexpvtltd.com</a> or via WhatsApp.</p>
        </div>
    </section>
@endsection
