<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PageController extends Controller
{
    public function about(): View
    {
        return view('public.pages.about');
    }

    public function contact(): View
    {
        return view('public.pages.contact');
    }

    public function submitContact(Request $request): RedirectResponse
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'subject' => ['nullable', 'string', 'max:100'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Thank you! Your message has been received. We will get back to you shortly.');
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
