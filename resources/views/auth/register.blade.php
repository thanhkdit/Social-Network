<x-guest-layout>
    <div class="form-register">
        <div name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" enctype='multipart/form-data'>
            @csrf
            <div class="form-layout">
                <div class="form-col">
                    <!-- Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />

                        <x-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required />
                    </div>
                    
                    <!-- Avatar -->
                    <div class="mt-4 register-avatar">
                        <div class="label">
                            Avatar
                        </div>
                        <div class="inner">
                            <label for="avatar">
                                <img class='preview-avatar w-50' src="{{ URL::to('/') . '/images/default-avatar.png' }}" alt="avatar">
                            </label>
                            <input id="avatar" type="file" name="avatar" hidden accept="image/*" />
                        </div>
                    </div>
                </div>
                <div class="form-col">
                    <!-- Description -->
                    <div>
                        <x-label for="description" :value="__('Description')" />

                        <x-input id="description" class="block mt-1 w-full" type="text" name="description" max="36" :value="old('description')" />
                    </div>

                    <!-- Birthday -->
                    <div class="mt-4">
                        <x-label for="birthday" :value="__('Birthday')" />

                        <x-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" :value="old('birthday')" />
                    </div>

                    <!-- Phone -->
                    <div class="mt-4">
                        <x-label for="phone" :value="__('Phone')" />

                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />
                    </div>

                    <!-- Introduce -->
                    <div class="mt-4">
                        <x-label for="introduce" :value="__('Introduce')" />
                        <textarea id="introduce" class="block mt-1 w-full register-textarea" type="text" name="introduce" :value="old('introduce')"></textarea>
                    </div>
                    
                    <!-- Address -->
                    <div class="mt-4">
                        <x-label for="address" :value="__('Address')" />
                        <textarea id="address" class="block mt-1 w-full register-textarea" type="text" name="address" :value="old('address')"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>
