<section class="py-12 bg-white">
    <div class="mx-auto max-w-[1280px] px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl lg:text-2xl font-bold tracking-tight text-zinc-900 mb-8 font-heading">Featured Categories</h2>
        
        <div class="flex overflow-x-auto pb-4 gap-4 sm:gap-6 lg:justify-between snap-x snap-mandatory scrollbar-hide">
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}" class="flex shrink-0 flex-col items-center gap-3 snap-start group">
                    <div class="relative h-[104px] w-[104px] overflow-hidden rounded-full bg-zinc-50 border border-transparent group-hover:border-zinc-200 transition-colors">
                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110">
                        
                        {{-- Optional Badges (Simulating the image) --}}
                        @if($loop->index == 0)
                            <span class="absolute left-1/2 top-1 -translate-x-1/2 rounded-full bg-black px-2 py-0.5 text-[8px] font-bold tracking-wider text-white">New</span>
                        @elseif($loop->index == 2)
                            <span class="absolute left-1/2 top-1 -translate-x-1/2 rounded-full bg-red-600 px-2 py-0.5 text-[8px] font-bold tracking-wider text-white">Sale</span>
                        @endif
                    </div>
                    <span class="text-[12px] font-semibold text-zinc-800 text-center leading-tight whitespace-nowrap">{{ $category->name }}</span>
                </a>
            @endforeach
            
            {{-- Shop All Button --}}
            <a href="{{ route('products.index') }}" class="flex shrink-0 flex-col items-center gap-3 snap-start group">
                <div class="flex h-[104px] w-[104px] items-center justify-center rounded-full bg-black text-primary transition-all hover:bg-zinc-900 hover:shadow-lg">
                    <i class="fa-solid fa-arrow-right text-xl"></i>
                </div>
                <span class="text-[12px] font-semibold text-zinc-800 text-center leading-tight whitespace-nowrap">Shop All</span>
            </a>
        </div>
    </div>
</section>

<style>
/* Hide scrollbar for category slider but keep functionality */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}
</style>
