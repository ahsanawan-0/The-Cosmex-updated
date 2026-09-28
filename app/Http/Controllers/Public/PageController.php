<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\ContactReceived;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PageController extends Controller
{
    public function about(): View
    {
        $stats = [
            'products' => Product::active()->count(),
            'categories' => Category::where('status', 'active')->withActiveProducts()->count(),
        ];

        return view('public.pages.about', compact('stats'));
    }

    public function contact(): View
    {
        return view('public.pages.contact');
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $success = 'Thank you! Your message has been received. We will get back to you shortly.';

        // Honeypot: real visitors never see or fill this field.
        if (filled($request->input('website'))) {
            return redirect()->route('contact')->with('success', $success);
        }

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'subject' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]) + ['phone' => null, 'subject' => null];

        // 1. Keep the message even if email delivery fails.
        $record = null;
        try {
            $record = ContactMessage::create($data + ['ip' => $request->ip()]);
        } catch (Throwable $e) {
            report($e);
        }

        // 2. Email it to the team.
        try {
            Mail::to(Setting::get('contact_email', config('site.contact_email')))->send(new ContactReceived($data));
            $record?->update(['emailed_at' => now()]);
        } catch (Throwable $e) {
            report($e);
        }

        // 3. Always leave a trace in the log as a last resort.
        Log::info('Contact form submission', ['id' => $record?->id] + $data);

        return redirect()->route('contact')->with('success', $success);
    }

    public function privacy(): View
    {
        return view('public.pages.privacy');
    }

    public function terms(): View
    {
        return view('public.pages.terms');
    }
}
