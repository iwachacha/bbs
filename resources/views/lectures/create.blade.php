<x-app-layout>
    <h1>講義作成</h1>
    <form action="{{ route('lecture.index') }}" method="POST">
        @csrf
        <div>
            <label for="lecture_name">講義名</label>
            <input type="text" name="lecture[lecture_name]" id="lecture_name" placeholder="講義名を入力してください"/>
        </div>
        <div>
            <label for="professor_name">担当教員名</label>
            <input type="text" name="lecture[professor_name]" id="professor_name" placeholder="教員名を入力してください"/>
        </div>
        <div>
            <label for="lecture_category_id">講義カテゴリー</label>
            <select name="lecture[lecture_category_id]" id="lecture_category_id">
                <option value="" selected disabled>選択してください</option>
                @foreach($lecture_categories as $lecture_category)　
                    <option value="{{ $lecture_category->id }}">{{ $lecture_category->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="faculty_id">開講学部</label>
            <select name="lecture[faculty_id]" id="faculty_id">
                <option value="" selected disabled>選択してください</option>
                <option value="">なし（共通教養・外国語・体育科目の場合）</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="department_id">開講学科・課程</label>
            <select name="lecture[department_id]" id="department_id">
                <option value="" selected disabled>選択してください</option>
                <option value="">なし（共通教養・外国語・体育・学部科目の場合）</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="course_id">開講コース・専修</label>
            <select name="lecture[course_id]" id="course_id">
                <option value="" selected disabled>選択してください</option>
                <option value="">なし（専修・コース等の科目ではない場合）</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>開講時期</label>
            <input type="radio" name="lecture[season]" value="前期" id="pre"><label for="pre">前期</label>
            <input type="radio" name="lecture[season]" value="後期" id="post"><label for="post">後期</label>    
        </div>
        <div>
            <label>開講学年</label>
            @for($i=1; $i<=4; $i++)
                <input type="radio" name="lecture[grade]" value="{{ $i }}" id="grade{{ $i }}"><label for="grade{{ $i }}">{{ $i }}年次</label>
            @endfor
        </div>
        <input type="submit" value="作成する"/>
    </form>
</x-app-layout>