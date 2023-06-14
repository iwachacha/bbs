<x-app-layout>
    <a href='/lectures/{{ $lecture->id }}/reviews/create'>この講義を評価する</a>
    <h1>講義評価一覧</h1>
    
    <x-review-card-container>
        <x-slot name="title">xsxsxsxsxsxxa</x-slot>
        <x-slot name="subtitle">xsxsxsxsxsxsxsxa</x-slot>
        @foreach ($reviews as $review)
            <x-review-card>
                <x-slot name="rate_star">
                    <p class="mb-2">☆aaaaaaa</p>
                    <p class="mb-2">☆aaaaaaa</p>
                    <p>☆aaaaaaa</p>
                </x-slot>
                <x-slot name="user_icon">sxsxxsxsa</x-slot>
                <x-slot name="user_name">asxsxsxsx</x-slot>
                <x-slot name="review_title">xsxsxxsxa</x-slot>
                <x-slot name="good_icon">axsxsxsx</x-slot>
                <x-slot name="good_count">sxsxsxsa</x-slot>
                <x-slot name="good_text">axsxsxsxs</x-slot>
            </x-review-card>
        @endforeach
    </x-review-card-container>
        <div>
            <a href='{{ route('lecture.index') }}'>講義一覧</a>
        </div>
</x-app-layout>
