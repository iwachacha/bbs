<x-app-layout>
    <form action="#" method="get">
        <input type="search" name="search" placeholder="講義を検索">
    </form>
    <a href='/lectures/create'>講義を追加する</a>
    <h1>講義一覧</h1>
    <div class='lectures'>
        @foreach ($lectures as $lecture)
            <div class="lecture" style="border-bottom: solid 1px;">
                <h2>{{ $lecture->name }}</h2>
                <div>
                    <table border=1>
                        <tr><th>講義名</th><td>{{ $lecture->name }}</td></tr>
                        <tr><th>担当教員名</th><td>{{ $lecture->professor_last }}{{ $lecture->professor_first }}</td></tr>
                        <tr><th>カテゴリー</th><td>{{ $lecture->lecture_category->name }}</td></tr>
                        <tr><th>評価数</th><td>{{ $lecture->reviews_count }}</td></tr>
                    </table>
                </div>
                <div>
                    <a href='{{ route('lecture.show', ['lecture' => $lecture->id]) }}'>講義情報</a>
                    <a href='{{ route('lecture.edit', ['lecture' => $lecture->id]) }}'>講義情報修正</a>
                    <a href='{{ route('review.index', ['lecture' => $lecture->id]) }}'>評価一覧</a>
                    <a href='{{ route('review.create', ['lecture' => $lecture->id]) }}'>この講義を評価する</a>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
