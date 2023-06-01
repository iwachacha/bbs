<x-app-layout>
    <h1>講義評価作成</h1>
    <form action="{{ route('review.index', ['lecture' => $lecture->id]) }}" method="POST">
        @csrf
        <div>
            <label for="title">一言評価</label>
            <input type="text" name="review[title]" placeholder="タイトルを入力してください" id="title"/>
        </div>
        <div>
            <label for="year">受講年度</label>
            <select name="review[year]" id="year">
                <option selected disabled>選択してください</option>
                @for($i = $year - 5 ; $i <= $year; $i++)
                    <option>{{ $i }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label for="class_method">授業方式</label>
            <select name="review[class_method]" id="class_method">
                <option selected disabled>選択してください</option>
                @foreach($class_methods as $class_method)
                    <option>{{ $class_method }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="attedance">出席確認</label>
            <select name="review[attedance]" id="attedance">
                <option selected disabled>選択してください</option>
                @foreach($attedances as $attedance)
                    <option>{{ $attedance }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="evaluation_method">評価方法</label>
            <select name="review[evaluation_method]" id="evaluation_method">
                <option selected disabled>選択してください</option>
                @foreach($evaluation_methods as $evaluation_method)
                    <option>{{ $evaluation_method }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="evaluation_level">評価レベル</label>
            <select name="review[evaluation_level]" id="evaluation_level">
                <option selected disabled>選択してください</option>
                @foreach($levels as $level)
                    <option>{{ $level }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="lecture_level">講義レベル</label>
            <select name="review[lecture_level]" id="lecture_level">
                <option selected disabled>選択してください</option>
                @foreach($levels as $level)
                    <option>{{ $level }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="comp_syllabus">シラバスとの比較</label>
            <select name="review[comp_syllabus]" id="comp_syllabus">
                <option selected disabled>選択してください</option>
                @foreach($syllabi as $syllabus)
                    <option>{{ $syllabus }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>楽単度</label>
            @for($i=1; $i<=5; $i++)
                <label for="rate_credit{{ $i }}">☆{{ $i }}</label>
                <input type="radio" name="review[rate_credit]" id="rate_credit{{ $i }}" value={{ $i }}>
            @endfor
        </div>
        <div>
            <label>講義充実度</label>
            @for($i=1; $i<=5; $i++)
                <label for="rate_adequacy{{ $i }}">☆{{ $i }}</label>
                <input type="radio" name="review[rate_adequacy]" id="rate_adequacy{{ $i }}" value={{ $i }}>
            @endfor
        </div>
        <div>
            <label>総合満足度</label>
            @for($i=1; $i<=5; $i++)
                <label for="rate_satisfaction{{ $i }}">☆{{ $i }}</label>
                <input type="radio" name="review[rate_satisfaction]" id="rate_satisfaction{{ $i }}" value={{ $i }}>
            @endfor
        </div>
        <div>
            <label for="lecture_content">講義内容</label>
            <textarea name="review[lecture_content]" cols="50" rows="3" maxlength="500" id="lecture_content" placeholder="講義内容を簡潔に記述してください"></textarea>
        </div>
        <div>
            <label for="body">評価詳細</label>
            <textarea name="review[body]" cols="50" rows="5" maxlength="500" id="body" placeholder="自由記述欄"></textarea>
        </div>
        <input type="submit" value="講義評価を作成する"/>
    </form>
</x-app-layout>
