<div
    class="col-span-1 flex flex-col h-full items-start justify-between w-full gap-4 bg-white/60 dark:bg-white/100 p-6 shadow-lg rounded-lg">
    <div class="flex flex-col items-start justify-start w-full gap-4">
        <div>
            <p class="font-bold text-md font-rubik">{{ $message->message }}</p>
        </div>
        <div class="flex items-center gap-4 flex-row w-full  border-b pb-4">
            <div class="w-12 h-12 flex justify-center items-center">
                @if ($message->sender == null || !!$message->is_anon == true)
                    <img src="{{ URL::asset('images/default-avatar.png') }}" alt="default-avatar"
                        class="w-10 h-10 rounded-full">
                @else
                    <img src="{{ URL::asset($message->sender->mediaObject->media_path) }}"
                        alt="{{ $message->sender->name }}" class="w-10 h-10 rounded-full">
                @endif
            </div>
            <div class="flex flex-col w-full">
                <div class="flex justify-between w-full">
                    <span class="font-bold">
                        {{ $message->sender == null || !!$message->is_anon == true ? 'Anonymous ' : optional($message->sender)->name }}
                    </span>
                    <span class="text-gray-400">
                        {{ $message->created_at->diffForHumans() }}
                    </span>
                </div>
                @if ($message->sender !== null && !!$message->is_anon == false)
                    <div>
                        <a href="{{ route('profile.user', ['username' => $message->sender->username]) }}"
                            class="text-gray-400">{{ '@' . $message->sender->username }}</a>
                    </div>
                @endif

            </div>
        </div>
        <div class="bg-brand-main/50 backdrop-blur-md w-full p-4 rounded-md">
            <div class="flex items-center gap-4 flex-row w-full pb-4">
                <div class="w-12 h-12 flex justify-center items-center">
                    <img src="{{ URL::asset($message->user->mediaObject->media_path) }}"
                        alt="{{ $message->user->name }}" class="w-10 h-10 rounded-full">
                </div>
                <a class="flex flex-col w-full" href="{{ route('profile.user', ['username' => $message->user->username]) }}">
                    <div class="flex justify-between w-full">
                        <span class="font-bold">
                            {{ $message->user->name }}
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-600">{{ '@' . $message->user->username }}</span>
                    </div>
                </a>
            </div>
            <div>
                <p>
                    {{ optional($message->replay->first())->text }}
                </p>
            </div>
        </div>
    </div>
    @if (Auth::check())

        <div class="flex gap-4">
            <button wire:click="addLike" class="flex items-center gap-2">
                <span>
                    @if ($liked)
                        <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6 fill-brand-dark">
                            <path
                                d="M13.9996 20.4077C13.5078 20.7157 13.0971 20.9544 12.8078 21.1169C12.6545 21.203 12.5001 21.2867 12.3447 21.3688L12.3438 21.3693L12.3426 21.3699C12.1276 21.4803 11.8725 21.4803 11.6574 21.3699C11.5008 21.2884 11.3461 21.2033 11.1922 21.1169C10.9029 20.9544 10.4922 20.7157 10.0004 20.4077C9.01844 19.7929 7.70549 18.8973 6.38882 17.7763C3.80141 15.5735 1 12.3318 1 8.51351C1 5.052 3.82903 2.5 6.73649 2.5C9.02981 2.5 10.8808 3.72621 12 5.60482C13.1192 3.72621 14.9702 2.5 17.2635 2.5C20.171 2.5 23 5.052 23 8.51351C23 12.3318 20.1986 15.5735 17.6112 17.7763C16.2945 18.8973 14.9816 19.7929 13.9996 20.4077Z" />
                        </svg>
                    @else
                        <svg width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6 fill-brand-dark"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.73649 2.5C3.82903 2.5 1 5.052 1 8.51351C1 12.3318 3.80141 15.5735 6.38882 17.7763C7.70549 18.8973 9.01844 19.7929 10.0004 20.4077C10.4922 20.7157 10.9029 20.9544 11.1922 21.1169C11.4093 21.2388 11.5582 21.318 11.6223 21.3516C11.7407 21.4132 11.8652 21.4527 12 21.4527C12.1193 21.4527 12.2378 21.4238 12.3438 21.3693C12.5003 21.2886 12.6543 21.2031 12.8078 21.1169C13.0971 20.9544 13.5078 20.7157 13.9996 20.4077C14.9816 19.7929 16.2945 18.8973 17.6112 17.7763C20.1986 15.5735 23 12.3318 23 8.51351C23 5.052 20.171 2.5 17.2635 2.5C14.9702 2.5 13.1192 3.72621 12 5.60482C10.8808 3.72621 9.02981 2.5 6.73649 2.5ZM6.73649 4C4.65746 4 2.5 5.88043 2.5 8.51351C2.5 11.6209 4.8236 14.4738 7.36118 16.6342C8.60701 17.6948 9.85656 18.5479 10.7965 19.1364C11.2656 19.4301 11.6557 19.6567 11.9269 19.8091L12 19.85L12.0731 19.8091C12.3443 19.6567 12.7344 19.4301 13.2035 19.1364C14.1434 18.5479 15.393 17.6948 16.6388 16.6342C19.1764 14.4738 21.5 11.6209 21.5 8.51351C21.5 5.88043 19.3425 4 17.2635 4C15.1581 4 13.4627 5.38899 12.7115 7.64258C12.6094 7.94883 12.3228 8.15541 12 8.15541C11.6772 8.15541 11.3906 7.94883 11.2885 7.64258C10.5373 5.38899 8.84185 4 6.73649 4Z" />
                        </svg>
                    @endif
                </span>
                <span class="text-brand-dark">
                    {{ $likes_count }} <span>like</span>
                </span>
            </button>
            <button wire:click="addFavorite" class="flex items-center gap-2">
                <span>
                    @if ($favorited)
                        <svg width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6 fill-brand-dark"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.74998 2C5.78163 2 4.99752 2.78635 5.00001 3.75447L5.00001 3.75591L5.00001 21.25C5.00001 21.5383 5.16527 21.8011 5.42512 21.926C5.68497 22.0509 5.99341 22.0158 6.21853 21.8357L12 17.2105L17.7815 21.8357C18.0066 22.0158 18.3151 22.0509 18.5749 21.926C18.8348 21.8011 19 21.5383 19 21.25V3.75C19 2.7835 18.2165 2 17.25 2H6.74998Z" />
                        </svg>
                    @else
                        <svg width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6 fill-brand-dark"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5 3.75C5 2.7835 5.7835 2 6.75 2H17.25C18.2165 2 19 2.7835 19 3.75V21.25C19 21.5383 18.8347 21.8011 18.5749 21.926C18.315 22.0509 18.0066 22.0158 17.7815 21.8357L12 17.2105L6.21852 21.8357C5.99339 22.0158 5.68496 22.0509 5.42511 21.926C5.16526 21.8011 5 21.5383 5 21.25V3.75ZM6.75 3.5C6.61193 3.5 6.5 3.61193 6.5 3.75V19.6895L11.5315 15.6643C11.8054 15.4452 12.1946 15.4452 12.4685 15.6643L17.5 19.6895V3.75C17.5 3.61193 17.3881 3.5 17.25 3.5H6.75Z" />
                        </svg>
                    @endif
                </span>
                <span class="text-brand-dark">
                    {{ $favorites_count }} <span>Favorites</span>
                </span>
            </button>
        </div>
    @endif

</div>
