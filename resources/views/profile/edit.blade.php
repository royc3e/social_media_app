<x-app-layout class="bg-gray-900">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12" style="background: linear-gradient(120deg, #0f0c29, #302b63, #24243e);">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Update Profile Information -->
            <div class="p-6 sm:p-8 bg-gray-800/50 text-white shadow sm:rounded-lg border border-gray-700" style="background-color: rgba(255, 255, 255, 0.1);">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Profile Picture -->
            <div class="p-6 sm:p-8 bg-gray-800/50 text-white shadow sm:rounded-lg border border-gray-700" style="background-color: rgba(255, 255, 255, 0.1);">
                <div class="max-w-xl">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Profile Picture') }}</h3>

                    <!-- Display current profile picture -->
                    <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('default-profile.png') }}" alt="Profile Picture" class="rounded-full w-32 h-32 mb-4 border-4 border-gray-600 shadow-lg">
                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="mb-4 text-red-500">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Profile Picture Update Form -->
                    <form method="POST" action="{{ route('profile.picture.update') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-4">
                            <input type="file" name="profile_picture" accept="image/*" class="border rounded p-2 bg-transparent text-white border-gray-700 hover:bg-gray-600 focus:border-indigo-500" required>
                        </div>

                        <div class="flex items-center gap-4 mt-4">
                            <x-primary-button class="bg-[rgba(255,255,255,0.1)] text-white hover:bg-opacity-80 focus:bg-opacity-80">{{ __('Update Profile Picture') }}</x-primary-button>

                            @if (session('status') === 'profile-picture-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-400">
                                    {{ __('Profile picture updated.') }}
                                </p>
                            @endif
                        </div>
                    </form>

                </div>
            </div>

            <!-- Update Password -->
            <div class="p-6 sm:p-8 bg-gray-800/50 text-white shadow sm:rounded-lg border border-gray-700" style="background-color: rgba(255, 255, 255, 0.1);">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete User -->
            <div class="p-6 sm:p-8 bg-gray-800/50 text-white shadow sm:rounded-lg border border-gray-700" style="background-color: rgba(255, 255, 255, 0.1);">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
