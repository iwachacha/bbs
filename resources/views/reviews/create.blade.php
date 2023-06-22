<x-app-layout>
    <h1>講義評価作成</h1>
    <form action="{{ route('review.index', ['lecture' => $lecture->id]) }}" method="POST">
        @csrf
        
        <h2>必須入力項目</h2>
        
        <div>
            <label for="title">タイトル</label>
            <input type="text" name="review[title]" placeholder="一言で評価すると？" id="title" value="{{ old('review.title') }}"/>
            <x-input-error :messages="$errors->first('review.title')" class="mt-2" />
        </div>
        
        <div>
            <label for="lecture_content">講義内容</label>
            <textarea name="review[lecture_content]" cols="50" rows="3" maxlength="300" id="lecture_content" placeholder="印象的だった内容は？">{{ old('review.lecture_content') }}</textarea>
            <x-input-error :messages="$errors->first('review.lecture_content')" class="mt-2" />
        </div>
        
        <div>
            <label>楽単度</label>
            @for($i=1; $i<=5; $i++)
                <label for="rate_credit{{ $i }}">☆{{ $i }}</label>
                <input type="radio" name="review[rate_credit]" value="{{ $i }}" id="rate_credit{{ $i }}" {{ $i == old('review.rate_credit') ? 'checked' : '' }}>
            @endfor
            <x-input-error :messages="$errors->first('review.rate_credit')" class="mt-2" />
        </div>
        
        <div>
            <label>充実度</label>
            @for($i=1; $i<=5; $i++)
                <label for="rate_adequacy{{ $i }}">☆{{ $i }}</label>
                <input type="radio" name="review[rate_adequacy]" value="{{ $i }}" id="rate_adequacy{{ $i }}" {{ $i == old('review.rate_adequacy') ? 'checked' : '' }}>
            @endfor
            <x-input-error :messages="$errors->first('review.rate_adequacy')" class="mt-2" />
        </div>
        
        <div>
            <label>面白さ</label>
            @for($i=1; $i<=5; $i++)
                <label for="rate_fun{{ $i }}">☆{{ $i }}</label>
                <input type="radio" name="review[rate_fun]" value="{{ $i }}"  id="rate_satisfaction{{ $i }}" {{ $i == old('review.rate_satisfaction') ? 'checked' : '' }}>
            @endfor
            <x-input-error :messages="$errors->first('review.rate_fun')" class="mt-2" />
        </div>
        
        <h2>任意入力項目</h2>
        
        <div>
            <label for="year">受講年度</label>
            <select name="review[year]" id="year">
                <option selected disabled>選択してください</option>
                @for($i = $now_year - 5 ; $i <= $now_year; $i++)
                    <option {{ $i == old('review.year') ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
            <x-input-error :messages="$errors->first('review.year')" class="mt-2" />
        </div>
        
        <div>
            <label for="class_method">授業方式</label>
            <select name="review[class_method]" id="class_method">
                <option selected disabled>選択してください</option>
                @foreach($class_methods as $class_method)
                    <option {{ $class_method == old('review.class_method') ? 'selected' : '' }}>
                        {{ $class_method }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('review.class_method')" class="mt-2" />
        </div>
        
        <div>
            <label for="attedance">出席確認</label>
            <select name="review[attedance]" id="attedance">
                <option selected disabled>選択してください</option>
                @foreach($attedances as $attedance)
                    <option {{ $attedance == old('review.attedance') ? 'selected' : '' }}>
                        {{ $attedance }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('review.attedance')" class="mt-2" />
        </div>
        
        <div>
            <label for="evaluation_method">評価方法</label>
            <select name="review[evaluation_method]" id="evaluation_method">
                <option selected disabled>選択してください</option>
                @foreach($evaluation_methods as $evaluation_method)
                    <option {{ $evaluation_method == old('review.evaluation_method') ? 'selected' : '' }}>
                        {{ $evaluation_method }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('review.evaluation_method')" class="mt-2" />
        </div>
        
        <div>
            <label for="evaluation_level">評価レベル</label>
            <select name="review[evaluation_level]" id="evaluation_level">
                <option selected disabled>選択してください</option>
                @foreach($levels as $level)
                    <option {{ $level == old('review.evaluation_level') ? 'selected' : '' }}>
                        {{ $level }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('review.evaluation_level')" class="mt-2" />
        </div>
        
        <div>
            <label for="lecture_level">講義レベル</label>
            <select name="review[lecture_level]" id="lecture_level">
                <option selected disabled>選択してください</option>
                @foreach($levels as $level)
                    <option {{ $level == old('review.lecture_level') ? 'selected' : '' }}>
                        {{ $level }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('review.lecture_level')" class="mt-2" />
        </div>
        
        <div>
            <label for="comp_syllabus">シラバスと講義の比較</label>
            <select name="review[comp_syllabus]" id="comp_syllabus">
                <option selected disabled>選択してください</option>
                @foreach($syllabi as $syllabus)
                    <option {{ $syllabus == old('review.comp_syllabus') ? 'selected' : '' }}>
                        {{ $syllabus }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->first('review.comp_syllabus')" class="mt-2" />
        </div>
        
        <div>
            <label for="dtail">詳細</label>
            <textarea name="review[dtail]" cols="50" rows="5" maxlength="500" id="dtail" placeholder="自由記述欄">{{ old('review.dtail') }}</textarea>
            <x-input-error :messages="$errors->first('review.dtail')" class="mt-2" />
        </div>
        
        <input type="submit" value="講義評価を作成する"/>
    </form>
</x-app-layout>
