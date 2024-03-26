@section('title', 'Sign up')

<div class="min-h-screen flex justify-center items-center">
    <div class="container">
        <div class="max-w-xl mx-auto max-laptop:max-w-full">
            <div class="flex min-h-full flex-col justify-center px-6 py-8 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="mx-auto h-10 w-auto" src={{ URL::asset('images/logo.svg') }} alt="Your Company">
                    <h2
                        class="mt-4 text-center text-2xl font-bold leading-9 tracking-tight font-cormorant-garamond text-black">
                        Sign in to your
                        account</h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form class="space-y-2" wire:submit="signUp">
                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Full
                                name</label>
                            <div class="mt-2">
                                <input wire:model="name" type="name" autocomplete="name"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6">
                                <div class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div>
                            <label for="username"
                                class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                            <div class="mt-2">
                                <input wire:model="username" type="username" autocomplete="username"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6">
                                <div class="text-danger">
                                    @error('username')
                                        {{ $message }}
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                                address</label>
                            <div class="mt-2">
                                <input wire:model="email" type="email" autocomplete="email"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6">
                                <div class="text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password"
                                    class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                            </div>
                            <div class="mt-2">
                                <input wire:model="password" type="password" autocomplete="current-password"
                                    class="block w-full rounded-md border-0 py-1.5 transition-all duration-300 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6">
                                <div class="text-danger">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium leading-6 text-gray-900">Confirm
                                    password</label>
                            </div>
                            <div class="mt-2">
                                <input wire:model="password_confirmation" type="password"
                                    autocomplete="current-password"
                                    class="block w-full rounded-md border-0 py-1.5 transition-all duration-300 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6">
                                <div class="text-danger">
                                    @error('password_confirmation')
                                        {{ $message }}
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div>
                            <button type="submit"
                                class="flex w-full transition-all duration-300 justify-center rounded-md bg-brand-dark px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-brand-main focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-dark">Sign
                                up</button>
                        </div>
                    </form>

                    <p class="mt-10 text-center text-sm text-gray-500">
                        already a memeber?
                        <a href="/auth/sign-in"
                            class="font-semibold leading-6 transition-all duration-300 text-brand-dark hover:text-brand-main">
                            Sign in
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
