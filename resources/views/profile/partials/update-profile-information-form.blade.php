<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
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
            <x-input-label for="name" :value="__('Name')" class="text-white" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-transparent text-white border-2 focus:border-indigo-500 focus:ring-indigo-500" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('name')" />
        </div>

        <!-- Email Field (Locked) -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-white" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full bg-transparent text-white border-2 focus:border-indigo-500 focus:ring-indigo-500" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
                readonly
            />
            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-400">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-indigo-500 hover:text-indigo-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-500">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Birthdate Field -->
        <div>
            <x-input-label for="birthdate" :value="__('Birthdate')" class="text-white" />
            <x-text-input id="birthdate" name="birthdate" type="date" class="mt-1 block w-full bg-transparent text-white border-2 focus:border-indigo-500 focus:ring-indigo-500" :value="old('birthdate', $user->birthdate)" required />
            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('birthdate')" />
        </div>

        <!-- Age Calculation -->
        <div>
            <x-input-label for="age" :value="__('Age')" class="text-white" />
            <x-text-input id="age" name="age" type="text" class="mt-1 block w-full bg-transparent text-white border-2 focus:border-indigo-500 focus:ring-indigo-500" :value="old('age', $user->age)" readonly />
        </div>

        <!-- Phone Number Field -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" class="text-white" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full bg-transparent text-white border-2 focus:border-indigo-500 focus:ring-indigo-500" :value="old('phone', $user->phone)" required />
            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('phone')" />
        </div>

        <!-- Gender Field -->
        <div>
            <x-input-label for="gender" :value="__('Gender')" class="text-white" />
            <select id="gender" name="gender" class="mt-1 block w-full bg-gray-800 text-white border-2 border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="male" {{ old('gender', $user->gender) === 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                <option value="female" {{ old('gender', $user->gender) === 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                <option value="other" {{ old('gender', $user->gender) === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
            </select>
            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('gender')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-[rgba(255,255,255,0.1)] text-white hover:bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-500">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>

<script>
    document.getElementById('birthdate').addEventListener('change', function () {
        var birthdate = new Date(this.value);
        var today = new Date();
        var age = today.getFullYear() - birthdate.getFullYear();
        var m = today.getMonth() - birthdate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }
        document.getElementById('age').value = age;
    });
</script>
