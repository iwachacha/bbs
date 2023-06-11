<x-app-layout>
    <div class="search"> <!--検索機能-->
        <form action="{{ route('lecture.index') }}" method="GET">
            <div>
                <label for="lecture_name">講義名</label>
                <input type="search" name="search_lecture_name" placeholder="講義名を入力してください" id="lecture_name">
            </div>
            <div>
                <label for="professor_name">担当教員名</label>
                <input type="search" name="search_professor_name" placeholder="担当教員名を入力してください" id="professor_name">
            </div>
            <div>
                <label for="category">講義カテゴリー</label>
                <select name="search_category" id="category">
                    <option value="" selected>選択してください</option>
                    @foreach($lecture_categories as $lecture_category)　
                        <option value="{{ $lecture_category->id }}">{{ $lecture_category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="faculty">開講学部</label>
                <select name="search_faculty" id="faculty">
                    <option value="" selected>選択してください</option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="department">開講学科・課程</label>
                <select name="search_department" id="department">
                    <option value="" selected>選択してください</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="course">開講コース・専修</label>
                <select name="search_course" id="course">
                    <option value="" selected>選択してください</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <input type="submit" value="検索">
        </form>
    </div>

    <a href='/lectures/create'>講義を追加する</a>
    <p>{{ $result_count }}件取得しました<p>
    <h1>講義一覧</h1>
    <x-content-card-container>
        @foreach ($lectures as $lecture)
            <x-content-card>
                <x-slot name="name">{{ $lecture->lecture_name }}/{{ $lecture->professor_name }}</x-slot>
                <x-slot name="rate">☆5</x-slot>
                <x-slot name="route">{{ route('review.index', ['lecture' => $lecture->id]) }}</x-slot>
                <x-slot name="route_name">評価一覧</x-slot>
                <x-slot name="heart_icon"><span class="material-symbols-outlined">favorite</span></x-slot>
                <x-slot name="review_icon"><span class="material-symbols-outlined">comment</span></x-slot>
                <x-slot name="reviews_count">{{ $lecture->reviews_count }}</x-slot>
            </x-content-card>
        @endforeach
    </x-content-card-container>
    
    <div class="mt-12">{{ $lectures->appends(request()->query())->links() }}
    
    </div>
    <div class="mt-4 mb-8 text-right">
        @if (count($lectures) >0)
            <p>全{{ $lectures->total() }}件中 
               {{  ($lectures->currentPage() -1) * $lectures->perPage() + 1}} - 
               {{ (($lectures->currentPage() -1) * $lectures->perPage() + 1) + (count($lectures) -1)  }}件表示中</p>
        @else
            <p>データがありません</p>
        @endif
    </div>
</x-app-layout>
