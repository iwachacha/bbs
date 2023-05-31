<x-app-layout>
    <h1>講義評価修正</h1>
    <form action="{{ route('review.show', ['lecture' => $lecture->id, 'review' => $review->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="title">
            <label for="title">一言評価</label>
            <input type="text" name="review[title]" value="{{ $review->title }}" id="title"/>
        </div>
        <div class="year">
            <label for="year">受講年度</label>
            <select name="review[year]" id="year">
                @for($i = $year - 5 ; $i <= $year; $i++)    <!-- 現役学生対象のサービスのため現在までの年を表示（留年考慮） -->
                    @if($i === $review->year)   <!--初期値を元の入力値に設定　以下同様-->
                        <option selected>{{ $i }}</option>
                    @else
                        <option>{{ $i }}</option>
                    @endif
                @endfor
            </select>
        </div>
        <div class="class_method">
            <label for="class_method">授業方式</label>
            <select name="review[class_method]" id="class_method">
                @foreach($class_methods as $class_method)
                    @if($review->class_method === $class_method)
                        <option selected>{{ $class_method }}</option>
                    @else
                        <option>{{ $class_method }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="attedance">
            <label for="attedance">出席確認</label>
            <select name="review[attedance]" id="attedance">
                @foreach($attedances as $attedance)
                    @if($review->attedance === $attedance)
                        <option selected>{{ $attedance }}</option>
                    @else
                        <option>{{ $attedance }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="evaluation_method">
            <label for="evaluation_method">評価方法</label>
            <select name="review[evaluation_method]" id="evaluation_method">
                @foreach($evaluation_methods as $evaluation_method)
                    @if($review->evaluation_method === $evaluation_method)
                        <option selected>{{ $evaluation_method }}</option>
                    @else
                        <option>{{ $evaluation_method }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="evaluation_level">
            <label for="evaluation_level">評価レベル</label>
            <select name="review[evaluation_level]" id="evaluation_level">
                @foreach($levels as $level)
                    @if($review->evaluation_level === $level)
                        <option selected>{{ $level }}</option>
                    @else
                        <option>{{ $level }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="lecture_level">
            <label for="lecture_level">講義レベル</label>
            <select name="review[lecture_level]" id="lecture_level">
                @foreach($levels as $level)
                    @if($review->evaluation_level === $level)
                        <option selected>{{ $level }}</option>
                    @else
                        <option>{{ $level }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="comp_syllabus">
            <label for="comp_syllabus">シラバスとの比較</label>
            <select name="review[comp_syllabus]" id="comp_syllabus">
                @foreach($syllabi as $syllabus)
                    @if($review->comp_syllabus === $syllabus)
                        <option selected>{{ $syllabus }}</option>
                    @else
                        <option>{{ $syllabus }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="lecture_content">
            <label for="lecture_content">講義内容</label>
            <textarea name="review[lecture_content]" cols="50" rows="2" maxlength="100" id="lecture_content">{{ $review->lecture_content }}</textarea>
        </div>
        <div class="body">
            <label for="body">評価詳細</label>
            <textarea name="review[body]" cols="50" rows="2" maxlength="100" id="body">{{ $review->body }}</textarea>
        </div>
        <div class="rate_credit">
            <label>楽単度</label>
            @for($i=1; $i<=5; $i++)
                @if($review->rate_credit === $i)
                    <label for="rate_credit{{ $i }}">☆{{ $i }}</label>
                    <input type="radio" name="review[rate_credit]" id="rate_credit{{ $i }}" value={{ $i }} checked>
                @else
                    <label for="rate_credit{{ $i }}">☆{{ $i }}</label>
                    <input type="radio" name="review[rate_credit]" id="rate_credit{{ $i }}" value={{ $i }}>
                @endif
            @endfor
        </div>
        <div class="rate_adequacy">
            <label>充実度</label>
            @for($i=1; $i<=5; $i++)
                @if($review->rate_adequacy === $i)
                    <label for="rate_adequacy{{ $i }}">☆{{ $i }}</label>
                    <input type="radio" name="review[rate_adequacy]" id="rate_adequacy{{ $i }}" value={{ $i }} checked>
                @else
                    <label for="rate_adequacy{{ $i }}">☆{{ $i }}</label>
                    <input type="radio" name="review[rate_adequacy]" id="rate_adequacy{{ $i }}" value={{ $i }}>
                @endif
            @endfor
        </div>
        <div class="rate_satisfaction">
            <label>満足度</label>
            @for($i=1; $i<=5; $i++)
                @if($review->rate_satisfaction === $i)
                    <label for="rate_satisfaction{{ $i }}">☆{{ $i }}</label>
                    <input type="radio" name="review[rate_satisfaction]" id="rate_satisfaction{{ $i }}" value={{ $i }} checked>
                @else
                    <label for="rate_adequacy{{ $i }}">☆{{ $i }}</label>
                    <input type="radio" name="review[rate_satisfaction]" id="rate_satisfaction{{ $i }}" value={{ $i }}>
                @endif
            @endfor
        </div>
        <input type="submit" value="保存する"/>
    </form>
</x-app-layout>
