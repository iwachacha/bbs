<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        
        <!-- Faculty -->
        <div class="mt-4">
            <x-input-label for="faculty" :value="__('Faculty')" />
            <x-text-select id="faculty" class="block mt-1 w-full" name="faculty_id" :value="old('faculty')" required autofocus autocomplete="faculty">
                <option value="" selected disabled>選択してください</option>
                <option value="">登録しない</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('faculty')" class="mt-2" />
        </div>
        
        <!-- Department -->
        <div class="mt-4">
            <x-input-label for="department" :value="__('Department')" />
            <x-text-select id="department" class="block mt-1 w-full" name="department_id" :value="old('department')" required autofocus autocomplete="department">
                <option value="" selected disabled>選択してください</option>
                <option value="">登録しない</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>
        
        <!-- Course -->
        <div class="mt-4">
            <x-input-label for="course" :value="__('Course')" />
            <x-text-select id="course" class="block mt-1 w-full" name="course_id" :value="old('course')" required autofocus autocomplete="course">
                <option value="" selected disabled>選択してください</option>
                <option value="">登録しない</option>
                <option value="">コース・専修がない</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('course')" class="mt-2" />
        </div>
        
        <!-- Grade -->
        <div class="mt-4">
            <x-input-label for="grade" :value="__('Grade')" />
            <x-text-select id="grade" class="block mt-1 w-full" name="grade" :value="old('grade')" required autofocus autocomplete="grade">
                <option value="" selected disabled>選択してください</option>
                <option value="">登録しない</option>
                @for($i = 0; $i <= 4; $i++)
                    <option>{{ $i }}</option>
                @endfor
            </x-text-select>
            <x-input-error :messages="$errors->get('grade')" class="mt-2" />
        </div>
        
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

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
