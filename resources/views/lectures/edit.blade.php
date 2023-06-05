<x-app-layout>
    <h1>講義情報編集</h1>
    <form action="{{ route('lecture.show', ['lecture' => $lecture->id]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label for="lecture_name">講義名</label>
            <input type="text" name="lecture[lecture_name]" id="lecture_name" value="{{ $lecture->lecture_name }}"/>
            <x-input-error :messages="$errors->first('lecture.lecture_name')" class="mt-2" />
        </div>
        
        <div>
            <label for="professor_name">担当教員名</label>
            <input type="text" name="lecture[professor_name]" id="professor_name" value="{{ $lecture->professor_name }}"/>
            <x-input-error :messages="$errors->first('lecture.professor_name')" class="mt-2" />
        </div>
        
        <div>
            <label for="lecture_category_id">講義カテゴリー</label>
            <select name="lecture[lecture_category_id]" id="lecture_category_id">
                <option value="" selected disabled>カテゴリーを選択してください</option>
                @foreach($lecture_categories as $lecture_category)　
                    <option value="{{ $lecture_category->id }}" {{ $lecture_category->id == $lecture->lecture_category_id ? 'selected' : '' }}>
                        {{ $lecture_category->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('lecture.lecture_category_id')" class="mt-2" />
        </div>
        
        <div>
            <label for="faculty_id">開講学部</label>
            <select name="lecture[faculty_id]" id="faculty_id">
                <option value="">学部の指定がある場合は選択してください</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}" {{ $faculty->id == $lecture->faculty_id ? 'selected' : '' }}>
                        {{ $faculty->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('lecture.faculty_id')" class="mt-2" />
        </div>
        
        <div>
            <label for="department_id">開講学科・課程</label>
            <select name="lecture[department_id]" id="department_id">
                <option value="">学科・課程の指定がある場合は選択してください</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ $department->id == $lecture->department_id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('lecture.department_id')" class="mt-2" />
        </div>
        
        <div>
            <label for="course_id">開講コース・専修</label>
            <select name="lecture[course_id]" id="course_id">
                <option value="">コース・専修の指定がある場合は選択してください</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $course->id == $lecture->course_id ? 'selected' : '' }}>
                        {{ $course->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('lecture.course_id')" class="mt-2" />
        </div>
        
        <div>
            <label>開講時期</label>
            <input type="radio" name="lecture[season]" value="前期" id="pre" {{ "前期" == $lecture->season ? 'checked' : '' }}>
            <label for="pre">前期</label>
            <input type="radio" name="lecture[season]" value="後期" id="post" {{ "後期" == $lecture->season ? 'checked' : '' }}>
            <label for="post">後期</label>
            <x-input-error :messages="$errors->first('lecture.season')" class="mt-2" />
        </div>
        
        <div>
            <label>開講学年</label>
            @for($i=1; $i<=4; $i++)
                <input type="radio" name="lecture[grade]" value="{{ $i }}" id="grade{{ $i }}" {{ $i == $lecture->grade ? 'checked' : '' }}>
                <label for="grade{{ $i }}">{{ $i }}年次</label>
            @endfor
            <x-input-error :messages="$errors->first('lecture.grade')" class="mt-2" />
        </div>
        
        <input type="submit" value="保存する"/>
    </form>
</x-app-layout>