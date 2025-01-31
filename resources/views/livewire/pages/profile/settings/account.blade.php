<form wire:submit="update">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 dark:border-white pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">{{ __('Profile') }}</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-white">
                        {{ __('This information will be displayed publicly so be careful what you share.') }}
                    </p>
                    <div class="mt-10 grid grid-cols-1 gap-y-8">
                        <div class="col-span-full">
                            <label for="photo"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Photo') }}</label>
                            <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                                x-on:livewire-upload-finish="uploading = false; progress = 0;"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                class="mt-2 flex items-center gap-x-3 relative">
                                <div class="h-12 w-12 relative">
                                    @if ($photo)
                                        <img src="{{ $photo->temporaryUrl() }}" alt="{{ $user->name }}"
                                            class="absolute inset-0 rounded-full">
                                    @else
                                        <img src="{{ URL::asset($user->image_url) }}" alt="{{ $user->name }}"
                                            class=" absolute inset-0 rounded-full">
                                    @endif
                                </div>
                                <div class="relative">
                                    <input type="file" wire:model="photo" class="absolute opacity-0 inset-0" />
                                    <button aria-label="Upload Image" type="button"
                                        class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Change</button>
                                </div>
                                <div x-show="uploading" class="w-full">
                                    <div class="w-full h-4 bg-slate-100 rounded-lg shadow-inner mt-3">
                                        <div class="bg-green-500 h-4 rounded-lg" :style="{ width: `${progress}%` }">
                                        </div>
                                    </div>
                                </div>
                                <div class="text-danger">
                                    @error('photo')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full">
                            <label for="username"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Username') }}</label>
                            <div class="mt-2">
                                <div
                                    class="flex rounded-md overflow-hidden shadow-sm border-gray-200 border sm:max-w-md">
                                    <span
                                        class="flex select-none items-center pl-3 text-gray-500 dark:bg-white  sm:text-sm">{{ URL::to('/') }}/@</span>
                                    <input type="text" wire:model="user.username" autocomplete="username"
                                        class="block w-full border-0 py-1.5 text-gray-900 dark:bg-white appearance-none !outline-none dark:text-black shadow-sm   placeholder:text-gray-400 sm:text-sm sm:leading-6"
                                        placeholder="janesmith">
                                </div>
                                <div class="text-danger">
                                    @error('user.username')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-span-full">
                            <label for="bio"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('About') }}</label>
                            <div class="mt-2">
                                <textarea wire:model="user.bio" rows="3"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-500 dark:bg-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                            </div>
                            <p class="mt-3 text-sm leading-6 text-gray-500">
                                {{ __('Write a few sentences about yourself.') }}</p>
                            <div class="text-danger">
                                @error('user.bio')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">
                        {{ __('Personal Information') }}
                    </h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-200">
                        {{ __('Use a permanent address where you can receive mail.') }}
                    </p>
                    <div class="mt-10 grid grid-cols-1 gap-y-8">
                        <div class="col-span-full">
                            <label for="name"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Name') }}</label>
                            <div class="mt-2">
                                <input type="text" wire:model="user.name" autocomplete="given-name"
                                    class="block w-full rounded-md border-gray-200 dark:border-0 py-1.5 appearance-none !ring-none  text-gray-900 dark:bg-white  dark:text-black shadow-sm   placeholder:text-gray-400  sm:text-sm sm:leading-6">
                            </div>
                            <div class="text-danger">
                                @error('user.name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-span-full">
                            <label for="email"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">{{ __('Email address') }}</label>
                            <div class="mt-2">
                                <input id="email" wire:model="user.email" type="email" autocomplete="email"
                                    class="block w-full rounded-md border-gray-200 dark:border-0 py-1.5 appearance-none !ring-none text-gray-900 dark:bg-white  dark:text-black shadow-sm   placeholder:text-gray-400  sm:text-sm sm:leading-6">
                            </div>
                            <div class="text-danger">
                                @error('user.email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button aria-label="Reset values" type="button"
                    class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">{{ __('Cancel') }}</button>
                <button aria-label="Save" type="submit"
                    class="rounded-md bg-brand-dark px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-dark">{{ __('Save') }}</button>
            </div>
        </form>
