<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')"></x-input-label>
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        
        <!-- Faculty -->
        <div class="mt-4">
            <x-input-label for="faculty">{{ $labels['faculty'] }}（任意）</x-input-label>
            <x-text-select id="faculty" class="block mt-1 w-full" name="faculty_id">
                <option value="" disabled>選択してください</option>
                <option value="">登録しない</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}" @if($faculty->id == old('faculty_id')) selected @endif>{{ $faculty->name }}</option>
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('faculty')" class="mt-2" />
        </div>
        
        <!-- Department -->
        <div class="mt-4">
            <x-input-label for="department">{{ $labels['department'] }}（任意）</x-input-label>
            <x-text-select id="department" class="block mt-1 w-full" name="department_id">
                <option value="" disabled>選択してください</option>
                <option value="">登録しない</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" @if($department->id == old('department_id')) selected @endif>{{ $department->name }}</option>
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>
        
        <!-- Course -->
        <div class="mt-4">
            <x-input-label for="course">{{ $labels['course'] }}（任意）</x-input-label>
            <x-text-select id="course" class="block mt-1 w-full" name="course_id">
                <option value="" disabled>選択してください</option>
                <option value="">登録しない</option>
                <option value="">コース・専修がない</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" @if($course->id == old('course_id')) selected @endif>{{ $course->name }}</option>
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('course')" class="mt-2" />
        </div>
        
        <!-- Grade -->
        <div class="mt-4">
            <x-input-label for="grade">学年（任意）</x-input-label>
            <x-text-select id="grade" class="block mt-1 w-full" name="grade">
                <option value="" disabled>選択してください</option>
                <option value="">登録しない</option>
                @for($i = 1; $i <= 4; $i++)
                    <option @if($i == old('grade')) selected @endif>{{ $i }}</option>
                @endfor
            </x-text-select>
            <x-input-error :messages="$errors->get('grade')" class="mt-2" />
        </div>
        
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')"></x-input-label>
            <p class="block text-xs text-gray-700">＊大学用メールアドレスをご使用ください</p>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')"></x-input-label>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')"></x-input-label>

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
