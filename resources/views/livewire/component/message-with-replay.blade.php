<div class="col-span-1 max-laptop:col-span-12">
    <div class="flex flex-col justify-between gap-10 items-start h-full hover:[@supports(backdrop-filter:blur(15px))]:bg-brand-dark/50 transition-all duration-300  shadow-surface-glass backdrop-blur will-change-transform [@supports(backdrop-filter:blur(15px))]:bg-brand-dark/30 w-full rounded-lg border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-brand-dark placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6 px-4">
        <div class="flex flex-col items-start justify-start w-full gap-4">
            <div>
                <p class="font-bold text-md font-rubik text-white">{{ $message->message }}</p>
            </div>
            <div class="flex items-center gap-4 flex-row w-full  border-b pb-4">
                <div class="w-12 h-12 flex justify-center items-center">
                    @if ($message->sender == null || !!$message->is_anon == true)
                    <img src="{{ URL::asset('images/default-avatar.png') }}" alt="default-avatar" class="w-10 h-10 rounded-full">
                    @else
                    <img src="{{ URL::asset($message->sender->image_url) }}" alt="{{ $message->sender->name }}" class="w-10 h-10 rounded-full">
                    @endif
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex justify-between w-full">
                        <span class="font-bold text-white ">
                            {{ $message->sender == null || !!$message->is_anon == true ? __('Anonymous') : optional($message->sender)->name }}
                        </span>
                        <span class="text-white text-sm">
                            {{ $message->created_at->diffForHumans() }}
                        </span>
                    </div>
                    @if ($message->sender !== null && !!$message->is_anon == false)
                    <div>
                        <a wire:navigate href="{{ route('profile.user', ['user' => $message->sender]) }}" class="text-white text-sm italic">{{ '@' . $message->sender->username }}</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="bg-brand-main/30 backdrop-blur-md w-full p-4 rounded-md">
                <div class="flex items-center gap-4 flex-row w-full pb-4">
                    <div class="w-12 h-12 flex justify-center items-center">
                        <img src="{{ URL::asset($message->user->image_url) }}" alt="{{ $message->user->name }}" class="w-10 h-10 rounded-full">
                    </div>
                    <a class="flex flex-col w-full" href="{{ route('profile.user', ['user' => $message->user]) }}">
                        <div class="flex justify-between w-full">
                            <span class="font-bold text-white">
                                {{ $message->user->name }}
                            </span>
                        </div>
                        <div>
                            <span class="text-white italic text-sm">{{ '@' . $message->user->username }}</span>
                        </div>
                    </a>
                </div>
                <div>
                    <p class="text-white">
                        {{ optional($message->replay->first())->text }}
                    </p>
                </div>
            </div>
        </div>
        @if (Auth::check())
        <div class="flex flex-row items-center justify-between gap-4 relative w-full">
            <div class="flex gap-4">
                <button wire:click="addLike" class="flex items-center gap-2  group/button relative" aria-label="Add like">
                    <div class="inline-flex items-center justify-center">
                        <div class="absolute z-0 -left-[4px] w-8 h-8 rounded-full -top-[5px] bottom-0 group-hover/button:bg-brand-light/30 transition-all"></div>
                        <div class="relative z-10">
                            @if ($liked)
                            <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-brand-light">
                                <path d="M13.9996 20.4077C13.5078 20.7157 13.0971 20.9544 12.8078 21.1169C12.6545 21.203 12.5001 21.2867 12.3447 21.3688L12.3438 21.3693L12.3426 21.3699C12.1276 21.4803 11.8725 21.4803 11.6574 21.3699C11.5008 21.2884 11.3461 21.2033 11.1922 21.1169C10.9029 20.9544 10.4922 20.7157 10.0004 20.4077C9.01844 19.7929 7.70549 18.8973 6.38882 17.7763C3.80141 15.5735 1 12.3318 1 8.51351C1 5.052 3.82903 2.5 6.73649 2.5C9.02981 2.5 10.8808 3.72621 12 5.60482C13.1192 3.72621 14.9702 2.5 17.2635 2.5C20.171 2.5 23 5.052 23 8.51351C23 12.3318 20.1986 15.5735 17.6112 17.7763C16.2945 18.8973 14.9816 19.7929 13.9996 20.4077Z" />
                            </svg>
                            @else
                            <svg width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6 fill-brand-light" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.73649 2.5C3.82903 2.5 1 5.052 1 8.51351C1 12.3318 3.80141 15.5735 6.38882 17.7763C7.70549 18.8973 9.01844 19.7929 10.0004 20.4077C10.4922 20.7157 10.9029 20.9544 11.1922 21.1169C11.4093 21.2388 11.5582 21.318 11.6223 21.3516C11.7407 21.4132 11.8652 21.4527 12 21.4527C12.1193 21.4527 12.2378 21.4238 12.3438 21.3693C12.5003 21.2886 12.6543 21.2031 12.8078 21.1169C13.0971 20.9544 13.5078 20.7157 13.9996 20.4077C14.9816 19.7929 16.2945 18.8973 17.6112 17.7763C20.1986 15.5735 23 12.3318 23 8.51351C23 5.052 20.171 2.5 17.2635 2.5C14.9702 2.5 13.1192 3.72621 12 5.60482C10.8808 3.72621 9.02981 2.5 6.73649 2.5ZM6.73649 4C4.65746 4 2.5 5.88043 2.5 8.51351C2.5 11.6209 4.8236 14.4738 7.36118 16.6342C8.60701 17.6948 9.85656 18.5479 10.7965 19.1364C11.2656 19.4301 11.6557 19.6567 11.9269 19.8091L12 19.85L12.0731 19.8091C12.3443 19.6567 12.7344 19.4301 13.2035 19.1364C14.1434 18.5479 15.393 17.6948 16.6388 16.6342C19.1764 14.4738 21.5 11.6209 21.5 8.51351C21.5 5.88043 19.3425 4 17.2635 4C15.1581 4 13.4627 5.38899 12.7115 7.64258C12.6094 7.94883 12.3228 8.15541 12 8.15541C11.6772 8.15541 11.3906 7.94883 11.2885 7.64258C10.5373 5.38899 8.84185 4 6.73649 4Z" />
                            </svg>
                            @endif
                        </div>
                    </div>
                    </span>
                    <span class="text-brand-light">
                        {{ $likes_count }} <span>{{ __('like') }}</span>
                    </span>
                </button>
                <button wire:click="addFavorite" class="flex items-center gap-2 group/button relative" aria-label="Add to favorite">
                    <div class="inline-flex items-center justify-center">
                        <div class="absolute z-0 -left-[4px] w-8 h-8 rounded-full -top-[5px] bottom-0 group-hover/button:bg-brand-light/30 transition-all"></div>
                        <div class="relative z-10">
                            @if ($favorited)
                            <svg width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6 fill-brand-light" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.74998 2C5.78163 2 4.99752 2.78635 5.00001 3.75447L5.00001 3.75591L5.00001 21.25C5.00001 21.5383 5.16527 21.8011 5.42512 21.926C5.68497 22.0509 5.99341 22.0158 6.21853 21.8357L12 17.2105L17.7815 21.8357C18.0066 22.0158 18.3151 22.0509 18.5749 21.926C18.8348 21.8011 19 21.5383 19 21.25V3.75C19 2.7835 18.2165 2 17.25 2H6.74998Z" />
                            </svg>
                            @else
                            <svg width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6 fill-brand-light" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5 3.75C5 2.7835 5.7835 2 6.75 2H17.25C18.2165 2 19 2.7835 19 3.75V21.25C19 21.5383 18.8347 21.8011 18.5749 21.926C18.315 22.0509 18.0066 22.0158 17.7815 21.8357L12 17.2105L6.21852 21.8357C5.99339 22.0158 5.68496 22.0509 5.42511 21.926C5.16526 21.8011 5 21.5383 5 21.25V3.75ZM6.75 3.5C6.61193 3.5 6.5 3.61193 6.5 3.75V19.6895L11.5315 15.6643C11.8054 15.4452 12.1946 15.4452 12.4685 15.6643L17.5 19.6895V3.75C17.5 3.61193 17.3881 3.5 17.25 3.5H6.75Z" />
                            </svg>
                            @endif
                        </div>
                    </div>
                    <span class="text-brand-light">
                        {{ $favorites_count }} <span>{{ __('Favorites') }}</span>
                    </span>
                </button>
            </div>
            <button aria-label="Share The Message" x-bind="shareButton('{{ $message_details['title'] }}', '{{ $message_details['url'] }}')" class="inline-flex items-center justify-center">
                <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-brand-light">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.53 1.22C12.3894 1.07955 12.1988 1.00066 12 1.00066C11.8012 1.00066 11.6106 1.07955 11.47 1.22L8.22 4.47C8.08752 4.61217 8.0154 4.80022 8.01882 4.99452C8.02225 5.18882 8.10097 5.37421 8.23838 5.51162C8.37579 5.64903 8.56118 5.72774 8.75548 5.73117C8.94978 5.7346 9.13783 5.66248 9.28 5.53L11.25 3.56V14.25C11.25 14.4489 11.329 14.6397 11.4697 14.7803C11.6103 14.921 11.8011 15 12 15C12.1989 15 12.3897 14.921 12.5303 14.7803C12.671 14.6397 12.75 14.4489 12.75 14.25V3.56L14.72 5.53C14.7887 5.60368 14.8715 5.66279 14.9635 5.70378C15.0555 5.74477 15.1548 5.76681 15.2555 5.76859C15.3562 5.77036 15.4562 5.75184 15.5496 5.71412C15.643 5.6764 15.7278 5.62025 15.799 5.54903C15.8703 5.47782 15.9264 5.39298 15.9641 5.29959C16.0018 5.20621 16.0204 5.10618 16.0186 5.00547C16.0168 4.90477 15.9948 4.80546 15.9538 4.71346C15.9128 4.62146 15.8537 4.53866 15.78 4.47L12.53 1.22ZM5.5 9.75C5.5 9.68369 5.52634 9.6201 5.57322 9.57322C5.62011 9.52633 5.6837 9.5 5.75 9.5H8.25C8.44891 9.5 8.63968 9.42098 8.78033 9.28033C8.92098 9.13967 9 8.94891 9 8.75C9 8.55108 8.92098 8.36032 8.78033 8.21967C8.63968 8.07901 8.44891 8 8.25 8H5.75C5.28587 8 4.84075 8.18437 4.51256 8.51256C4.18437 8.84075 4 9.28587 4 9.75V20.25C4 21.216 4.784 22 5.75 22H18.25C18.7141 22 19.1592 21.8156 19.4874 21.4874C19.8156 21.1592 20 20.7141 20 20.25V9.75C20 9.28587 19.8156 8.84075 19.4874 8.51256C19.1592 8.18437 18.7141 8 18.25 8H15.75C15.5511 8 15.3603 8.07901 15.2197 8.21967C15.079 8.36032 15 8.55108 15 8.75C15 8.94891 15.079 9.13967 15.2197 9.28033C15.3603 9.42098 15.5511 9.5 15.75 9.5H18.25C18.3163 9.5 18.3799 9.52633 18.4268 9.57322C18.4737 9.6201 18.5 9.68369 18.5 9.75V20.25C18.5 20.3163 18.4737 20.3799 18.4268 20.4268C18.3799 20.4737 18.3163 20.5 18.25 20.5H5.75C5.6837 20.5 5.62011 20.4737 5.57322 20.4268C5.52634 20.3799 5.5 20.3163 5.5 20.25V9.75Z" />
                </svg>
            </button>
        </div>
        @endif
    </div>
</div>
@script
<script>
    $wire.on('not-auth-for-action', (message) => {
        window.Swal.fire({
            title: 'Not Authenticated',
            text: message,
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: "Sign in ?",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = "{{ route('auth.sign-in') }}?redirect={{ url()->current() }}";
            }
        })
    });
</script>
@endscript