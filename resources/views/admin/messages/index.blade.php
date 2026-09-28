@extends('layouts.admin')

@section('title', 'Messages')
@section('page_title', 'Messages')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-zinc-500">Contact form</p>
            <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Website messages</h2>
            <p class="mt-2 text-sm text-zinc-500">Every contact-form submission is saved here, including any that could not be emailed.</p>
        </div>

        <div class="overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-100">
                    <thead class="bg-zinc-50">
                        <tr class="text-left text-[10px] font-bold uppercase tracking-widest text-zinc-500">
                            <th class="px-6 py-4">Received</th>
                            <th class="px-6 py-4">From</th>
                            <th class="px-6 py-4">Subject</th>
                            <th class="px-6 py-4">Message</th>
                            <th class="px-6 py-4">Emailed</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 text-sm text-zinc-700">
                        @forelse ($messages as $message)
                            <tr class="align-top">
                                <td class="px-6 py-4 whitespace-nowrap text-zinc-500">{{ $message->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-zinc-900">{{ $message->name }}</p>
                                    <a href="mailto:{{ $message->email }}" class="text-primary hover:underline">{{ $message->email }}</a>
                                    @if ($message->phone)
                                        <p class="text-zinc-500">{{ $message->phone }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $message->subject ?: '—' }}</td>
                                <td class="px-6 py-4 min-w-[320px] whitespace-pre-line">{{ $message->message }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($message->emailed_at)
                                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Yes</span>
                                    @else
                                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">Not sent</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-zinc-500">No messages yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $messages->links() }}
    </div>
@endsection
