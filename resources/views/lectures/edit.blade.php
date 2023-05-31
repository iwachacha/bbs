<x-app-layout>
    <h1>講義情報編集</h1>
    <form action="{{ route('lecture.show', ['lecture' => $lecture->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="lecture_name">
            <label for="name">講義名</label>
            <input type="text" name="lecture[name]" id="name" value="{{ $lecture->name }}"/>
        </div>
        <div class="professor_name">
            <label>担当教員名</label>
            <label for="professor_last">姓</label>
            <input type="text" name="lecture[professor_last]" id="professor_last" value="{{ $lecture->professor_last }}"/>
            <label for="professor_first">名</label>
            <input type="text" name="lecture[professor_first]" id="professor_first" value="{{ $lecture->professor_first }}"/>
        </div>
        <div class="category">
            <label for="lecture_category_id">講義カテゴリー</label>
            <select name="lecture[lecture_category_id]" id="lecture_category_id">
                @foreach($lecture_categories as $lecture_category)　
                    @if($lecture_category->id === $lecture->lecture_category_id)　<!--初期値を元の入力値に設定する　以下同様-->
                        <option value="{{ $lecture->lecture_category_id }}" selected>{{ $lecture->lecture_category->name }}</option>
                    @else
                        <option value="{{ $lecture_category->id }}">{{ $lecture_category->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="faculty">
            <label for="faculty_id">開講学部</label>
            <select name="lecture[faculty_id]" id="faculty_id">
                @foreach($faculties as $faculty)
                    @if(isset($lecture->faculty_id)) <!--nullありのため　以下同様-->
                        @if($faculty->id === $lecture->faculty_id)
                            <option value="{{ $lecture->faculty_id }}" selected>{{ $lecture->faculty->name }}</option>
                        @else
                            <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                        @endif
                    @else
                        <option value="" selected>なし（共通教養・外国語・体育科目の場合）</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="department">
            <label for="department_id">開講学科・課程</label>
            <select name="lecture[department_id]" id="department_id">
                @foreach($departments as $department)
                    @if(isset($lecture->department_id)) 
                        @if($department->id === $lecture->department_id)
                            <option value="{{ $lecture->department_id }}" selected>{{ $lecture->department->name }}</option>
                        @else
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endif
                    @else
                        <option value="" selected>なし（共通教養・外国語・体育・学部科目の場合）</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="course">
            <label for="course_id">開講コース・専修</label>
            <select name="lecture[course_id]" id="course_id">
                @foreach($courses as $course)
                    @if(isset($lecture->course_id)) 
                        @if($course->id === $lecture->course_id)
                            <option value="{{ $lecture->course_id }}" selected>{{ $lecture->course->name }}</option>
                        @else
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endif
                    @else
                        <option value="" selected>なし（専修・コース等の科目ではない場合）</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="season">
            <label>開講時期</label>
            @if($lecture->season === "前期")
                <input type="radio" name="lecture[season]" value="前期" id="pre" checked><label for="pre">前期</label>
                <input type="radio" name="lecture[season]" value="後期" id="post"><label for="post">後期</label> 
            @else
                <input type="radio" name="lecture[season]" value="前期" id="pre"><label for="pre">前期</label>
                <input type="radio" name="lecture[season]" value="後期" id="post" checked><label for="post">後期</label> 
            @endif
        </div>
        <div class="grade">
            <label>開講学年</label>
            @for($i=1; $i<=4; $i++) <!--1~4年の選択肢　初期値を元の入力値に設定-->
                @if($i === $lecture->grade)
                    <input type="radio" name="lecture[grade]" value="{{ $i }}" id="grade{{ $i }}" checked><label for="grade{{ $i }}">{{ $i }}年次</label>
                @else
                    <input type="radio" name="lecture[grade]" value="{{ $i }}" id="grade{{ $i }}"><label for="grade{{ $i }}">{{ $i }}年次</label>
                @endif
            @endfor
        </div>
        <input type="submit" value="保存する"/>
    </form>
</x-app-layout>