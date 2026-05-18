@extends('layouts.app')

@section('title', 'Contact Cosmex Pvt Ltd | Get in Touch')
@section('meta_description', 'Contact Cosmex Pvt Ltd for product inquiries, orders, or support. Reach us via WhatsApp, phone, or our contact form.')
@section('canonical', url('/contact'))

@section('content')
    {{-- Header --}}
    <div class="bg-[var(--color-black)] py-14 text-white">
        <div class="mx-auto max-w-[1280px] px-4 text-center sm:px-6 lg:px-8">
            <p class="text-sm uppercase tracking-[0.3em] text-primary">We're here to help</p>
            <h1 class="mt-4 font-heading text-5xl text-white">Contact Us</h1>
        </div>
    </div>

    <section class="bg-bg-light py-16">
        <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-2">

                {{-- Contact Form --}}
                <div class="rounded-2xl border border-zinc-200 bg-white p-8 shadow-sm">
                    <h2 class="font-heading text-3xl text-zinc-900">Send us a message</h2>
                    <p class="mt-2 text-sm text-zinc-500">We usually respond within a few hours.</p>

                    @if(session('success'))
                        <div class="mt-4 rounded-xl bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mt-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="mt-6 space-y-5">
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-zinc-700">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                    class="mt-1 h-11 w-full rounded-xl border border-border px-4 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-zinc-700">Email Address <span class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                    class="mt-1 h-11 w-full rounded-xl border border-border px-4 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-zinc-700">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+92 300 1234567"
                                    class="mt-1 h-11 w-full rounded-xl border border-border px-4 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                            <div>
                                <label for="subject" class="block text-sm font-medium text-zinc-700">Subject</label>
                                <select id="subject" name="subject"
                                    class="mt-1 h-11 w-full rounded-xl border border-border px-4 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    <option value="order">Order Inquiry</option>
                                    <option value="product">Product Question</option>
                                    <option value="delivery">Delivery</option>
                                    <option value="return">Return/Refund</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-zinc-700">Message <span class="text-red-500">*</span></label>
                            <textarea id="message" name="message" rows="5" required
                                class="mt-1 w-full resize-none rounded-xl border border-border px-4 py-3 text-sm text-zinc-900 outline-none transition focus:border-primary focus:ring-2 focus:ring-primary/20">{{ old('message') }}</textarea>
                        </div>
                        <button type="submit" class="btn-primary w-full text-center font-semibold">Send Message</button>
                    </form>
                </div>

                {{-- Contact Info --}}
                <div class="space-y-6">
                    {{-- WhatsApp CTA --}}
                    @php $wn = preg_replace('/\D+/', '', \App\Models\Setting::get('whatsapp_number','923001234567')); @endphp
                    <a href="https://wa.me/{{ $wn }}" target="_blank" rel="noopener noreferrer"
                        class="flex w-full items-center justify-center gap-3 rounded-2xl bg-emerald-600 px-6 py-5 text-lg font-semibold text-white shadow-lg transition hover:bg-emerald-700">
                        <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Chat on WhatsApp
                    </a>

                    <div class="rounded-2xl border border-zinc-200 bg-white p-7 shadow-sm">
                        <h3 class="font-heading text-2xl text-zinc-900">Contact Information</h3>
                        <ul class="mt-6 space-y-5">
                            <li class="flex items-start gap-4">
                                <span class="mt-0.5 rounded-xl bg-primary/10 p-2.5 text-primary">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 6.75z"/></svg>
                                </span>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-400">Phone / WhatsApp</p>
                                    <a href="tel:{{ \App\Models\Setting::get('contact_phone', '+923001234567') }}" class="mt-1 block text-sm font-medium text-zinc-800 hover:text-primary">
                                        {{ \App\Models\Setting::get('contact_phone', '+92 300 1234567') }}
                                    </a>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <span class="mt-0.5 rounded-xl bg-primary/10 p-2.5 text-primary">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                </span>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-400">Email</p>
                                    <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'info@cosmexpvtltd.com') }}" class="mt-1 block text-sm font-medium text-zinc-800 hover:text-primary">
                                        {{ \App\Models\Setting::get('contact_email', 'info@cosmexpvtltd.com') }}
                                    </a>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <span class="mt-0.5 rounded-xl bg-primary/10 p-2.5 text-primary">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                </span>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-400">Address</p>
                                    <p class="mt-1 text-sm font-medium text-zinc-800">{{ \App\Models\Setting::get('address', 'Lahore, Pakistan') }}</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <span class="mt-0.5 rounded-xl bg-primary/10 p-2.5 text-primary">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </span>
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-zinc-400">Working Hours</p>
                                    <p class="mt-1 text-sm font-medium text-zinc-800">Mon – Sat: 10am – 8pm</p>
                                    <p class="text-sm text-zinc-500">Sunday: 12pm – 6pm</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    {{-- Google Maps placeholder --}}
                    {{-- <iframe src="YOUR_GOOGLE_MAPS_EMBED_URL" width="100%" height="300" class="mt-6 rounded-2xl border border-zinc-200" allowfullscreen loading="lazy"></iframe> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
