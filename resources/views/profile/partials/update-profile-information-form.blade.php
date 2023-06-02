<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
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
            <x-text-select id="faculty" class="block mt-1 w-full" name="faculty" :value="old('faculty', $user->faculty)" required autofocus autocomplete="faculty">
                <option value="">登録しない</option>
                @foreach($faculties as $faculty)
                    <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('faculty')" class="mt-2" />
        </div>
        
        <div class="mt-4">
            <x-input-label for="department" :value="__('Department')" />
            <x-text-select id="department" class="block mt-1 w-full" name="department" :value="old('department', $user->faculty)" required autofocus autocomplete="department">
                <option value="">登録しない</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('department')" class="mt-2" />
        </div>
        
        <div class="mt-4">
            <x-input-label for="course" :value="__('Course')" />
            <x-text-select id="course" class="block mt-1 w-full" name="course" required autofocus autocomplete="course">
                <option value="">登録しない</option>
                @foreach($courses as $course)
                    @if(isset($user->course_id))
                        @if($user->course_id === $course->course_id)
                            <option value="{{ $user->course_id }}" selected>{{ $user->course->name }}</option>
                        @else
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endif
                    @else
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endif
                @endforeach
            </x-text-select>
            <x-input-error :messages="$errors->get('course')" class="mt-2" />
        </div>
        
        <!-- Grade -->
        <div class="mt-4">
            <x-input-label for="grade" :value="__('Grade')" />
            <x-text-select id="grade" class="block mt-1 w-full" name="grade" :value="old('grade', $user->course)" required autofocus autocomplete="grade">
                <option value="">登録しない</option>
                @for($i = 1; $i <= 4; $i++)
                    <option>{{ $i }}</option>
                @endfor
            </x-text-select>
            <x-input-error :messages="$errors->get('grade')" class="mt-2" />
        </div>
        
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
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
