<div>
    <form wire:submit.prevent="update">
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">
                {{ __('Notifications') }}
            </h2>
            <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-200">
                {{ __("We'll always let you know about important changes, but you pick what else you want to hear about.") }}
            </p>
            <div class="mt-10 space-y-10">
                <fieldset>
                    <legend class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                        {{ __('By Email') }}
                    </legend>
                    <div class="mt-6 space-y-6">
                        <div class="relative flex gap-x-3">
                            <div class="flex h-6 items-center">
                                <input id="replay" wire:model="mail.replay" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                            </div>
                            <div class="text-sm leading-6">
                                <label for="replay"
                                    class="font-medium text-gray-900 dark:text-white">{{ __('Replays') }}</label>
                                <p class="text-gray-500">
                                    {{ __('Get notified when someones replay on a message that you sent.') }}
                                </p>
                            </div>
                        </div>
                        <div class="relative flex gap-x-3">
                            <div class="flex h-6 items-center">
                                <input id="message" wire:model="mail.message" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                            </div>
                            <div class="text-sm leading-6">
                                <label for="message"
                                    class="font-medium text-gray-900 dark:text-white">{{ __('Messages') }}</label>
                                <p class="text-gray-500">
                                    {{ __('Get notified when a user send a message to you.') }}
                                </p>
                            </div>
                        </div>
                        <div class="relative flex gap-x-3">
                            <div class="flex h-6 items-center">
                                <input id="likes" wire:model="mail.likes" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                            </div>
                            <div class="text-sm leading-6">
                                <label for="likes"
                                    class="font-medium text-gray-900 dark:text-white">{{ __('Likes') }}</label>
                                <p class="text-gray-500">
                                    {{ __('Get notified when a user add like to your replay.') }}
                                </p>
                            </div>
                        </div>
                        <div class="relative flex gap-x-3">
                            <div class="flex h-6 items-center">
                                <input id="follow" wire:model="mail.follow" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                            </div>
                            <div class="text-sm leading-6">
                                <label for="follow"
                                    class="font-medium text-gray-900 dark:text-white">{{ __('Follows') }}</label>
                                <p class="text-gray-500">{{ __('Get notified when a user follows you.') }}</p>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend class="text-sm font-semibold leading-6 text-gray-900 dark:text-white">
                        {{ __('By Browser Notification') }}
                    </legend>
                    <div class="mt-6 space-y-6">
                        <div class="relative flex gap-x-3">
                            <div class="flex h-6 items-center">
                                <input id="replay" wire:model="browser.replay" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                            </div>
                            <div class="text-sm leading-6">
                                <label for="replay"
                                    class="font-medium text-gray-900 dark:text-white">{{ __('Replays') }}</label>
                                <p class="text-gray-500">
                                    {{ __('Get notified when someones replay on a message that you sent.') }}
                                </p>
                            </div>
                        </div>
                        <div class="relative flex gap-x-3">
                            <div class="flex h-6 items-center">
                                <input id="message" wire:model="browser.message" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                            </div>
                            <div class="text-sm leading-6">
                                <label for="message"
                                    class="font-medium text-gray-900 dark:text-white">{{ __('Messages') }}</label>
                                <p class="text-gray-500">
                                    {{ __('Get notified when a user send a message to you.') }}
                                </p>
                            </div>
                        </div>
                        <div class="relative flex gap-x-3">
                            <div class="flex h-6 items-center">
                                <input id="likes" wire:model="browser.likes" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                            </div>
                            <div class="text-sm leading-6">
                                <label for="likes"
                                    class="font-medium text-gray-900 dark:text-white">{{ __('Likes') }}</label>
                                <p class="text-gray-500">
                                    {{ __('Get notified when a user add like to your replay.') }}
                                </p>
                            </div>
                        </div>
                        <div class="relative flex gap-x-3">
                            <div class="flex h-6 items-center">
                                <input id="follow" wire:model="browser.follow" type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-brand-dark focus:ring-brand-dark">
                            </div>
                            <div class="text-sm leading-6">
                                <label for="follow"
                                    class="font-medium text-gray-900 dark:text-white">{{ __('Follows') }}</label>
                                <p class="text-gray-500">{{ __('Get notified when a user follows you.') }}</p>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="mt-8 flex justify-end">
            <button type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-brand-dark hover:bg-brand-light focus:outline-none focus:border-brand-dark focus:shadow-outline-brand active:bg-brand-dark transition ease-in-out duration-150">
                {{ __('Save') }}
            </button>
    </form>
</div>
