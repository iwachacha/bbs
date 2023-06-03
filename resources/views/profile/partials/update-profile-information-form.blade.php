<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            ユーザー情報を変更できます
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        
        <div class="mt-4">
            <x-input-label for="faculty" :value="__('Faculty')" />
            <x-text-select id="faculty" class="block mt-1 w-full" name="faculty_id">
                <option value="">登録しない</option>
                @foreach($faculties as $faculty)
                    @if($faculty->id === $user->faculty_id)
                        <option value="{{ $faculty->id }}" selected>{{ $faculty->name }}</option>
                    @else
                        <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                    @endif
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('faculty')" class="mt-2" />
        </div>
        
        <div class="mt-4">
            <x-input-label for="department" :value="__('Department')" />
            <x-text-select id="department" class="block mt-1 w-full" name="department_id">
                <option value="">登録しない</option>
                @foreach($departments as $department)
                    @if($department->id === $user->department_id)
                        <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                    @else
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endif
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>
        
        <div class="mt-4">
            <x-input-label for="course" :value="__('Course')" />
            <x-text-select id="course" class="block mt-1 w-full" name="course_id">
                <option value="">登録しない</option>
                @foreach($courses as $course)
                    @if($course->id === $user->course_id)
                        <option value="{{ $course->id }}" selected>{{ $course->name }}</option>
                    @else
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endif
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('course')" class="mt-2" />
        </div>
        
        <div class="mt-4">
            <x-input-label for="grade" :value="__('Grade')" />
            <x-text-select id="grade" class="block mt-1 w-full" name="grade">
                <option value="">登録しない</option>
                @for($i = 1; $i <= 4; $i++)
                    @if($i === $user->grade)
                        <option selected>{{ $i }}</option>
                    @else
                        <option>{{ $i }}</option>
                    @endif
                @endfor
            </x-text-select>
            <x-input-error :messages="$errors->get('grade')" class="mt-2" />
        </div>
        
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
