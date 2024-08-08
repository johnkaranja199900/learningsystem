<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/css.css">
</head>
<body>
    <div class="login-wrap">
        <div class="login-html">
            <form method="POST" action="{{ route('register') }}">
                    @csrf
                <div class="sign-up-htm">
                    <div class="group">
                        <label for="user" class="label">first Name</label>
                        <input id="user" name="fname"type="text" class="input" required>
                        <x-input-error :messages="$errors->get('fname')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="user" class="label">Second Name</label>
                        <input id="user" name="sname"type="text" class="input" required>
                        <x-input-error :messages="$errors->get('sname')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="user" class="label">Last Name</label>
                        <input id="user" name="lname"type="text" class="input" required>
                        <x-input-error :messages="$errors->get('lname')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="user" class="label">Gender</label>
                        <select id="gender" name="gender" class="input" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="user" class="label">Phone Number</label>
                        <input id="user" name="Phone"type="number" max="10" min="10" class="input" required>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div class="group">
                        <label for="pass" class="label">Email Address</label>
                        <input id="pass" name="email"type="text" class="input" required>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="user" class="label">Course</label>
                        <select id="gender" name="unit" class="input" required>
                            <option value="male">Computer Packages</option>
                            <option value="female">Graphic Design</option>
                            <option value="female">Web Development</option>
                            <option value="female">C programming</option>
                            <option value="female">Python Programming</option>
                            <option value="female">PhP programming</option>
                        </select>
                        <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                    </div>

                    <div class="group">
                        <label for="pass" class="label">Password</label>
                        <input id="pass" name="password" type="password" class="input" data-type="password" required>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="group">
                        <label for="pass" class="label">Confirm Password</label>
                        <input id="pass"name="password_confirmation" type="password" class="input" data-type="password" required>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    
                    <div class="group">
                        <input type="submit" class="button" value="Sign Up">
               
                    </div>
                </div>
                </form>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="{{URL('sign')}}">
                        <label for="tab-1">Already Student?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
{{--
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

--}}



