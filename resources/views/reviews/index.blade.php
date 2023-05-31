<x-app-layout>
    <a href='/lectures/{{ $lecture->id }}/reviews/create'>この講義を評価する</a>
    <h1>講義評価一覧</h1>
    <div class='reviews'>
        @foreach ($reviews as $review)
            <div class="review" style="border-bottom: solid 1px;">
                <table>
                    <tr><th>投稿者</th><td>{{ $review->user->name }}</td></tr>
                    <tr><th>一言評価</th><td>{{ $review->title }}</td></tr>
                    <tr><th>総合満足度</th><td>☆{{ $review->rate_satisfaction}}</td></tr>
                </table>
                <div>
                    <a href='{{ route('review.show', ['lecture' => $lecture->id, 'review' => $review->id]) }}'>評価詳細</a>
                    @if($review->user_id === Auth::user()->id)
                        <a href='{{ route('review.edit', ['lecture' => $lecture->id, 'review' => $review->id]) }}'>評価を修正する</a>
                    @endif
                </div>
             </div>
        @endforeach
    </div>
        <div>
            <a href='{{ route('lecture.index') }}'>講義一覧</a>
        </div>
</x-app-layout>
