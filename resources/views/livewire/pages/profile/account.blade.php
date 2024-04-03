@section('title', 'Account')

<div class="container ">
    <div class="max-w-lg mx-auto py-4">
        <form wire:submit="updateProfile">
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 dark:border-white pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Profile</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-white">This information will be displayed
                        publicly so be careful
                        what you share.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="col-span-full">
                            <label for="photo"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Photo</label>
                            <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                                x-on:livewire-upload-finish="uploading = false; progress = 0;"
                                x-on:livewire-upload-progress="progress = $event.detail.progress"
                                class="mt-2 flex items-center gap-x-3 relative">
                                @if ($photo)
                                    <img src="{{ $photo->temporaryUrl() }}" alt="{{ $user->name }}"
                                        class="h-12 w-12 rounded-full">
                                @else
                                    <img src="{{ URL::asset($user->mediaObject->media_path) }}"
                                        alt="{{ $user->name }}" class="h-12 w-12 rounded-full">
                                @endif

                                <div class="relative">

                                    <input type="file" wire:model="photo" class="absolute opacity-0 inset-0" />
                                    <button type="button"
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
                        <div class="sm:col-span-4">
                            <label for="username"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Username</label>
                            <div class="mt-2">
                                <div
                                    class="flex rounded-md overflow-hidden shadow-sm border-gray-200 border sm:max-w-md">
                                    <span
                                        class="flex select-none items-center pl-3 text-gray-500 dark:bg-white  sm:text-sm">{{ URL::to('/') }}/@</span>
                                    <input type="text" wire:model="username" autocomplete="username"
                                        class="block w-full border-0 py-1.5 text-gray-900 dark:bg-white appearance-none !outline-none dark:text-black shadow-sm   placeholder:text-gray-400 sm:text-sm sm:leading-6"
                                        placeholder="janesmith">
                                </div>
                                <div class="text-danger">
                                    @error('username')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Personal Information
                    </h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-200">Use a permanent address where you
                        can receive mail.
                    </p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="name"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Name</label>
                            <div class="mt-2">
                                <input type="text" wire:model="name" autocomplete="given-name"
                                    class="block w-full rounded-md border-gray-200 dark:border-0 py-1.5 appearance-none !ring-none  text-gray-900 dark:bg-white  dark:text-black shadow-sm   placeholder:text-gray-400  sm:text-sm sm:leading-6">
                            </div>
                            <div class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </div>

                        </div>


                        <div class="sm:col-span-4">
                            <label for="email"
                                class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Email
                                address</label>
                            <div class="mt-2">
                                <input id="email" wire:model="email" type="email" autocomplete="email"
                                    class="block w-full rounded-md border-gray-200 dark:border-0 py-1.5 appearance-none !ring-none text-gray-900 dark:bg-white  dark:text-black shadow-sm   placeholder:text-gray-400  sm:text-sm sm:leading-6">
                            </div>
                            <div class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>


                    </div>
                </div>

                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Notifications <span
                            class="text-gray-500">(Comming soon)</span></h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-200">We'll always let you know about
                        important changes,
                        but
                        you pick what else you want to hear about.</p>

                    <div class="mt-10 space-y-10">
                        <fieldset>
                            <legend class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">By Email
                            </legend>
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="replay" name="replay" type="checkbox" disabled
                                            class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="replay"
                                            class="font-medium text-gray-900 dark:text-white">Replays</label>
                                        <p class="text-gray-500">Get notified when someones replay on a
                                            message that you sent.
                                        </p>
                                    </div>
                                </div>
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="candidates" name="candidates" type="checkbox" disabled
                                            class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="candidates"
                                            class="font-medium text-gray-900 dark:text-white">Message</label>
                                        <p class="text-gray-500">Get notified when a user send a message to you.</p>
                                    </div>
                                </div>
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="offers" name="offers" type="checkbox" disabled
                                            class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="offers"
                                            class="font-medium text-gray-900 dark:text-white">Likes</label>
                                        <p class="text-gray-500">Get notified when a user add like to your replay.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">By Browser
                                Notification
                            </legend>
                            <div class="mt-6 space-y-6">
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="replay" name="replay" type="checkbox" disabled
                                            class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="replay"
                                            class="font-medium text-gray-900 dark:text-white">Replays</label>
                                        <p class="text-gray-500">Get notified when someones replay on a
                                            message that you sent.
                                        </p>
                                    </div>
                                </div>
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="candidates" name="candidates" type="checkbox" disabled
                                            class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="candidates"
                                            class="font-medium text-gray-900 dark:text-white">Message</label>
                                        <p class="text-gray-500">Get notified when a user send a message to you.</p>
                                    </div>
                                </div>
                                <div class="relative flex gap-x-3">
                                    <div class="flex h-6 items-center">
                                        <input id="offers" name="offers" type="checkbox" disabled
                                            class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                                    </div>
                                    <div class="text-sm leading-6">
                                        <label for="offers"
                                            class="font-medium text-gray-900 dark:text-white">Likes</label>
                                        <p class="text-gray-500">Get notified when a user add like to your replay.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="button"
                    class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">Cancel</button>
                <button type="submit"
                    class="rounded-md bg-brand-dark px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-dark">Save</button>
            </div>
        </form>
    </div>
</div>
