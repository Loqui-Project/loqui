<div x-data="{ open: false }" class="relative z-20">
    <button @click="open = ! open" class="flex flex-row justify-start items-center gap-4 cursor-pointer rounded-mdk p-4" aria-label="Open User Menu">
        <div>
            <img src="{{ URL::asset($user->image_url) }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-full">
        </div>
        <div class="flex flex-col items-start justify-start">
            <span class="text-md capitalize text-left font-semibold text-gray-900  dark:text-white">{{ $user->name }}</span>
            <span class="text-sm text-gray-400 italic dark:text-white">{{ '@' . $user->username }}</span>
        </div>
    </button>
    <div x-show="open" @click.outside="open = false" x-transition class="absolute top-[76px] w-full bg-white dark:bg-black rounded-md shadow-lg  p-4">
        <nav class="border-b border-b-black  dark:border-b-white">
            <ul class="pb-4 flex flex-col justify-start space-y-4">
                <li>
                    <a wire:navigate href="{{ route('profile.settings.account') }}" class="flex items-center flex-row gap-2">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" class="[&>path]:fill-brand-dark w-6 h-6" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.5C8.96251 2.5 6.50012 4.96245 6.50012 8C6.50012 9.88946 7.45289 11.5564 8.90419 12.5466C5.53963 13.7791 3.11605 16.9629 3.004 20.7277C2.99168 21.1417 3.31733 21.4873 3.73136 21.4997C4.14539 21.512 4.49101 21.1863 4.50334 20.7723C4.62347 16.7357 7.93397 13.5 12 13.5C16.0659 13.5 19.3764 16.7357 19.4966 20.7723C19.5089 21.1863 19.8545 21.512 20.2685 21.4997C20.6826 21.4873 21.0082 21.1417 20.9959 20.7277C20.8839 16.963 18.4603 13.7791 15.0958 12.5466C16.5472 11.5564 17.5 9.88949 17.5 8C17.5 4.96245 15.0376 2.5 12 2.5ZM8.00012 8C8.00012 5.79085 9.79096 4 12 4C14.2091 4 16 5.79085 16 8C16 10.2092 14.2091 12 12 12C9.79096 12 8.00012 10.2092 8.00012 8Z" fill="#1F2328" />
                            </svg>
                        </span>
                        <span class="dark:text-white">
                            {{ __('Account') }}
                        </span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('profile.favorites') }}" class="flex items-center flex-row gap-2">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" class="[&>path]:fill-brand-dark w-6 h-6" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5 3.75C5 2.7835 5.7835 2 6.75 2H17.25C18.2165 2 19 2.7835 19 3.75V21.25C19 21.5383 18.8347 21.8011 18.5749 21.926C18.315 22.0509 18.0066 22.0158 17.7815 21.8357L12 17.2105L6.21852 21.8357C5.99339 22.0158 5.68496 22.0509 5.42511 21.926C5.16526 21.8011 5 21.5383 5 21.25V3.75ZM6.75 3.5C6.61193 3.5 6.5 3.61193 6.5 3.75V19.6895L11.5315 15.6643C11.8054 15.4452 12.1946 15.4452 12.4685 15.6643L17.5 19.6895V3.75C17.5 3.61193 17.3881 3.5 17.25 3.5H6.75Z" />
                            </svg>
                        </span>
                        <span class="dark:text-white">
                            {{ __('Favorites') }}
                        </span>
                    </a>
                </li>
                <li>
                    <div class="flex items-center flex-row gap-2">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" class="[&>path]:fill-brand-dark w-6 h-6" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.9708 8.26466C10.751 8.41117 10.5951 8.61188 10.4834 8.83541C10.2981 9.20589 9.84762 9.35606 9.47713 9.17082C9.10665 8.98558 8.95648 8.53507 9.14172 8.16459C9.34246 7.76312 9.65534 7.33883 10.1387 7.01659C10.6268 6.69121 11.2438 6.5 12 6.5C12.6578 6.5 13.369 6.69469 13.9344 7.11875C14.5199 7.55783 14.9375 8.2399 14.9375 9.125C14.9375 10.1584 14.4248 10.8447 13.9108 11.3404C13.7216 11.5229 13.5124 11.6976 13.332 11.8483C13.2804 11.8914 13.2309 11.9328 13.1852 11.9715C13.0026 12.1263 12.86 12.256 12.75 12.38V13.75C12.75 14.1642 12.4143 14.5 12 14.5C11.5858 14.5 11.25 14.1642 11.25 13.75V12.2765C11.25 12.0403 11.3169 11.7726 11.4973 11.5413C11.7162 11.2607 11.9827 11.0245 12.2152 10.8274C12.2788 10.7734 12.3395 10.7227 12.398 10.6738L12.399 10.673C12.5706 10.5295 12.7225 10.4025 12.8695 10.2608C13.2369 9.90641 13.4375 9.58472 13.4375 9.125C13.4375 8.76009 13.2823 8.50467 13.0344 8.31875C12.7665 8.11781 12.384 8 12 8C11.5063 8 11.1858 8.12129 10.9708 8.26466Z" fill="#1F2328" />
                                <path d="M13 17C13 17.5523 12.5523 18 12 18C11.4477 18 11 17.5523 11 17C11 16.4477 11.4477 16 12 16C12.5523 16 13 16.4477 13 17Z" fill="#1F2328" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1ZM2.5 12C2.5 6.75329 6.75329 2.5 12 2.5C17.2467 2.5 21.5 6.75329 21.5 12C21.5 17.2467 17.2467 21.5 12 21.5C6.75329 21.5 2.5 17.2467 2.5 12Z" fill="#1F2328" />
                            </svg>
                        </span>
                        <span class="dark:text-white">
                            {{ __('Help') }}
                        </span>
                    </div>
                </li>
            </ul>
        </nav>
        <div class="flex flex-row items-center pt-4 gap-2">
            <div>
                <svg width="24" height="24" viewBox="0 0 24 24" class="fill-danger" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 3.25C3 2.2835 3.7835 1.5 4.75 1.5H10.25C10.6642 1.5 11 1.83579 11 2.25C11 2.66421 10.6642 3 10.25 3H4.75C4.61193 3 4.5 3.11193 4.5 3.25V20.75C4.5 20.8881 4.61193 21 4.75 21H10.25C10.6642 21 11 21.3358 11 21.75C11 22.1642 10.6642 22.5 10.25 22.5H4.75C3.7835 22.5 3 21.7165 3 20.75V3.25Z" />
                    <path d="M19.0064 12.75L15.7055 16.2342C15.4207 16.5349 15.4335 17.0096 15.7342 17.2945C16.0349 17.5793 16.5096 17.5665 16.7945 17.2658L21.2945 12.5158C21.5685 12.2265 21.5685 11.7735 21.2945 11.4842L16.7945 6.73419C16.5096 6.43349 16.0349 6.42066 15.7342 6.70554C15.4335 6.99041 15.4207 7.46511 15.7055 7.76581L19.0063 11.25H10.75C10.3358 11.25 10 11.5858 10 12C10 12.4142 10.3358 12.75 10.75 12.75H19.0064Z" />
                </svg>

            </div>
            <div>
                <a wire:navigate href="/auth/sign-out" class="text-md font-bold leading-none text-danger">{{ __('Sign out') }}</a>
            </div>
        </div>
    </div>
</div>
