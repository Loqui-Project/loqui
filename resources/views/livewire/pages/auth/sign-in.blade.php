<div class="min-h-screen flex justify-center items-center ">
        <div class="max-w-xl max-laptop:max-w-full mx-auto hover:[@supports(backdrop-filter:blur(15px))]:bg-brand-dark/50 transition-all duration-300  shadow-surface-glass   [@supports(backdrop-filter:blur(15px))]:bg-brand-dark/30 w-full rounded-lg border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-brand-dark placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark px-4">
            <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <img class="mx-auto h-14 w-14" src={{ URL::asset('images/logo.svg') }} alt="Loqui - Social Media Platform">
                    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight font-cormorant-garamond text-white">
                        {{__("Sign in to your account")}}
                    </h2>
                </div>
                @if ($show == true)
                <div class="mt-4">
                    @if ($status == true)
                    <div class="flex bg-green-100 rounded-lg p-4 mb-4 text-sm text-green-700" role="alert">
                        <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                    @else
                    <div class="flex bg-red-100 rounded-lg p-4 mb-4 text-sm text-red-700" role="alert">
                        <svg class="w-5 h-5 inline mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            {{ $message }}
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                <div class="mt-4 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form class="space-y-6" wire:submit="signIn">
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-white">{{__("Email address")}}</label>
                            <div class="mt-2">
                                <input wire:model="email" type="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6">
                                <div class="text-danger">
                                    @error('email')
                                    {{ $message }}
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium leading-6 text-white">{{__("Password")}}</label>
                                <div class="text-sm">
                                    <a wire:navigate href="{{ route('password.forget') }}" class="font-semibold transition-all duration-300 text-brand-light hover:text-brand-main">{{__("Forgot password?")}}</a>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input wire:model="password" type="password" autocomplete="current-password" class="block w-full rounded-md border-0 py-1.5 transition-all duration-300 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6">
                                <div class="text-danger">
                                    @error('email')
                                    {{ $message }}
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div>
                            <button aria-label="Sign in" type="submit" class="flex w-full transition-all duration-300 justify-center rounded-md bg-brand-dark px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-brand-main focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-dark">{{__("Sign in")}}</button>
                        </div>
                    </form>

                </div>
                <span class="w-full h-[2px] bg-gray-200 mt-4"></span>
                <p class="mt-10 text-center text-sm text-white">
                    {{__("Not a member?")}}
                    <a wire:navigate href="/auth/sign-up" class="font-semibold leading-6 transition-all duration-300 text-brand-light hover:text-brand-main">
                        {{__("Sign up now")}}
                    </a>
                </p>
            </div>
        </div>
</div>