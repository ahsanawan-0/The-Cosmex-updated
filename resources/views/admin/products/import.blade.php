@extends('layouts.admin')

@section('title', 'Import Products')
@section('page_title', 'Import CSV')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[minmax(0,1.4fr)_minmax(320px,0.9fr)]">
        <div class="rounded-3xl border border-zinc-200 bg-white p-8 shadow-sm">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.24em] text-primary">Bulk Upload</p>
                    <h2 class="mt-2 text-3xl font-semibold text-zinc-900">Import products from CSV</h2>
                    <p class="mt-2 text-sm text-zinc-500">Use the official template so every column maps correctly.</p>
                </div>

                <a href="{{ route('admin.products.import.template') }}" class="inline-flex items-center rounded-2xl bg-primary px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-dark">
                    Download CSV Template
                </a>
            </div>

            <form method="POST" action="{{ route('admin.products.import.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <label for="csv_file" class="flex min-h-64 cursor-pointer flex-col items-center justify-center rounded-3xl border border-dashed border-zinc-300 bg-zinc-50 px-6 py-10 text-center">
                    <input id="csv_file" name="csv_file" type="file" accept=".csv,.txt" required class="hidden">
                    <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-[#D4AF37]/10 text-[#8f6b08]">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 16.5V6.75m0 0-3.75 3.75M12 6.75l3.75 3.75M3.75 15v2.25A2.25 2.25 0 0 0 6 19.5h12a2.25 2.25 0 0 0 2.25-2.25V15" /></svg>
                    </div>
                    <p class="mt-5 text-base font-semibold text-zinc-900">Drop your CSV here or click to upload</p>
                    <p class="mt-2 text-sm text-zinc-500">Accepted file types: `.csv`, `.txt` &middot; Max size 10MB</p>
                </label>

                <button type="submit" class="inline-flex items-center rounded-2xl bg-primary px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-primary-dark">
                    Import Products
                </button>
            </form>
        </div>

        <div class="space-y-6">
            <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-zinc-900">Required Columns</h3>
                <ul class="mt-4 space-y-2 text-sm text-zinc-600">
                    <li><span class="font-semibold text-zinc-900">name</span> — product title</li>
                    <li><span class="font-semibold text-zinc-900">category_name</span> — must match an existing category</li>
                    <li><span class="font-semibold text-zinc-900">price</span> — base selling price</li>
                </ul>
            </div>

            <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
                <h3 class="text-lg font-semibold text-zinc-900">Optional Columns</h3>
                <p class="mt-3 text-sm text-zinc-600">`sale_price`, `stock`, `short_description`, `description`, `status`, `seo_title`, `seo_description`</p>
                <p class="mt-4 rounded-2xl bg-zinc-50 px-4 py-3 text-sm text-zinc-500">
                    Images must be uploaded manually after import from the product edit page.
                </p>
            </div>

            @if (session('import_summary'))
                <div class="rounded-3xl border border-[#D4AF37]/25 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-zinc-900">Last Import Results</h3>
                    <p class="mt-3 text-sm text-zinc-600">
                        {{ session('import_summary.imported') }} imported &middot; {{ session('import_summary.skipped') }} skipped
                    </p>

                    @if (! empty(session('import_summary.errors')))
                        <ul class="mt-4 list-disc space-y-1 pl-5 text-sm text-zinc-500">
                            @foreach (array_slice(session('import_summary.errors'), 0, 5) as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection
