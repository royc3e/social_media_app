<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile sa Gwapo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
            <h3 class="text-lg font-semibold mb-4">{{ __('Profile Picture') }}</h3>
        
            <!-- Display current profile picture -->
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('default-profile.png') }}" alt="Profile Picture" class="rounded-full w-32 h-32 mb-4">

            <!-- Profile Picture Update Form -->
            <form method="POST" action="{{ route('profile.picture.update') }}" enctype="multipart/form-data">
                @csrf
                    <div class="mt-4">
                    <input type="file" name="profile_picture" accept="image/*" class="border rounded p-2" required>
                        </div>
                        <div class="flex items-center gap-4 mt-4">
                        <x-primary-button>{{ __('Update Profile Picture') }}</x-primary-button>

                @if (session('status') === 'profile-picture-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600"
                    >{{ __('Profile picture updated.') }}</p>
                @endif
            </div>
        </form>
    </div>
</div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
