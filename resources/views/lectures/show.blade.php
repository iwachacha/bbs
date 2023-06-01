<x-app-layout>
    <h1>講義情報</h1>
    <h2>{{ $lecture->lecture_name }}</h2>
        <table border=1>
            <tr><th>講義名</th><td>{{ $lecture->lecture_name }}</td></tr>
            <tr><th>カテゴリー</th><td>{{ $lecture->lecture_category->name }}</td></tr>
            <tr><th>担当教員名</th><td>{{ $lecture->professor_name }}</td></tr>
            <tr><th>学部</th><td>{{ @$lecture->faculty->name }}</td></tr>
            <tr><th>学科・課程</th><td>{{ @$lecture->department->name }}</td></tr>
            <tr><th>コース・専修</th><td>{{ @$lecture->course->name }}</td></tr>
            <tr><th>開講学年</th><td>{{ $lecture->grade }}年</td></tr>
            <tr><th>開講時期</th><td>{{ $lecture->season }}</td></tr>
            <tr><th>投稿者</th><td>{{ $lecture->user->name }}</td></tr>
            <tr><th>投稿日時</th><td>{{ $lecture->created_at->diffForHumans() }}</td></tr>
            <tr><th>修正日時</th><td>{{ $lecture->updated_at->diffForHumans() }}</td></tr>
        </table>
        <a href='{{ route('lecture.index') }}'>講義一覧</a>
</x-app-layout>
