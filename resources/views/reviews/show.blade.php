<x-app-layout>
    <h1>評価情報</h1>
    <div>
        <h2>{{ $lecture->name }}</h2>
        <table border=1>
            <tr><th>投稿者</th><td>{{ $review->user->name }}</td></tr>
            <tr><th>一言評価</th><td>{{ $review->title }}</td></tr>
            <tr><th>講義内容</th><td>{{ $review->lecture_content }}</td></tr>
            <tr><th>受講年度</th><td>{{ $review->year }}</td></tr>
            <tr><th>授業方式</th><td>{{ $review->class_method }}</td></tr>
            <tr><th>出席確認</th><td>{{ $review->attedance }}</td></tr>
            <tr><th>評価方法</th><td>{{ $review->evaluation_method }}</td></tr>
            <tr><th>評価レベル</th><td>{{ $review->evaluation_level }}</td></tr>
            <tr><th>講義レベル</th><td>{{ $review->lecture_level }}</td></tr>
            <tr><th>シラバスとの比較</th><td>{{ $review->comp_syllabus }}</td></tr>
            <tr><th>楽単度</th><td>☆{{ $review->rate_credit}}</td></tr>
            <tr><th>充実度</th><td>☆{{ $review->rate_adequacy}}</td></tr>
            <tr><th>総合満足度</th><td>☆{{ $review->rate_satisfaction}}</td></tr>
            <tr><th>評価詳細</th><td>{{ @$review->body }}</td></tr>
        </table>
    </div>
    <div>
        <a href='{{ route('review.index', ['lecture' => $lecture->id, 'review' => $review->id]) }}'>評価一覧</a>
        @if($review->user_id === Auth::user()->id)
            <a href='{{ route('review.edit', ['lecture' => $lecture->id, 'review' => $review->id]) }}'>評価を修正する</a>
        @endif
    </div>
</x-app-layout>
