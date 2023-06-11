<div class="p-4 lg:w-1/3">
    <div class="h-full bg-gray-100 bg-opacity-75 px-8 pb-24 pt-8 rounded-lg overflow-hidden text-center relative">
        <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">{{ $name }}</h2>
        <p class="title-font sm:text-2xl text-xl font-medium text-gray-900 mb-3">{{ $rate }}</p>
        <p class="leading-relaxed mb-3">Photo booth fam kinfolk cold-pressed sriracha leggings jianbing microdosing tousled waistcoat.</p>
        <a href="{{ $route }}" class="text-blue-500 inline-flex items-center">{{ $route_name }}</a>
        <div class="text-center mt-2 leading-none flex justify-center absolute bottom-0 left-0 w-full py-4">
            <span class="text-gray-400 mr-3 inline-flex items-center leading-none text-sm pr-3 py-1 border-r-2 border-gray-200">
                {{ $heart_icon }}1.2K
            </span>
            <span class="text-gray-400 inline-flex items-center leading-none text-sm">
                {{ $review_icon }}{{ $reviews_count }}
            </span>
        </div>
    </div>
</div>
    