<x-app-layout>
    <div class="search"> <!--検索機能-->
        <form action="{{ route('lecture.index') }}" method="GET">
            <div>
                <label for="lecture_name">講義名</label>
                <input type="search" name="search_lecture_name" placeholder="講義名を入力してください" id="lecture_name">
            </div>
            <div>
                <label for="professor_name">担当教員名</label>
                <input type="search" name="search_lecture_name" placeholder="担当教員名を入力してください" id="professor_name">
            </div>
            <div>
                <label for="category">講義カテゴリー</label>
                <select name="search_category" id="category">
                    <option value="" selected></option>
                    @foreach($lecture_categories as $lecture_category)　
                        <option value="{{ $lecture_category->id }}">{{ $lecture_category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="faculty">開講学部</label>
                <select name="search_faculty" id="faculty">
                    <option value="" selected></option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="department">開講学科・課程</label>
                <select name="search_department" id="department">
                    <option value="" selected></option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="course">開講コース・専修</label>
                <select name="search_course" id="course">
                    <option value="" selected></option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="submit" value="検索">
        </form>
    <div>
    <div class="content">
        <a href='/lectures/create'>講義を追加する</a>
        <p>{{ $result_count }}件取得しました<p>
        <h1>講義一覧</h1>
        <div class='lectures'>
            @foreach ($lectures as $lecture)
                <div class="lecture" style="border-bottom: solid 1px;">
                    <h2>{{ $lecture->name }}</h2>
                    <div>
                        <table>
                            <tr><th>講義名</th><td>{{ $lecture->lecture_name }}</td></tr>
                            <tr><th>担当教員名</th><td>{{ $lecture->professor_name }}</td></tr>
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
    <div>
</x-app-layout>
