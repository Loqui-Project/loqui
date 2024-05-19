<div class="relative">
    <div class="sticky top-[90px] w-full z-[2] p-10 shadow-surface-glass max-laptop:py-4 backdrop-blur will-change-transform [@supports(backdrop-filter:blur(15px))]:bg-secondary-main/[3%] shadow-sm rounded-md bg-white/30 dark:bg-brand-dark/30">
        <div class="flex flex-col justify-start items-start gap-6">
            <div class="flex flex-row items-center gap-4">
                <div>
                    <img src="{{ URL::asset($user->mediaObject->media_path) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full">
                </div>
                <div>
                    <div>
                        <h2 class="text-brand-dark font-rubik text-base font-bold dark:text-white">{{ $user->name }}
                        </h2>
                    </div>
                    <div>
                        <span class="text-[#6A6A6A] text-sm font-normal  dark:text-gray-100">{{ '@' . $user->username
                            }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-row items-center justify-between gap-4 w-full" >
                <div class="flex flex-col gap-2 items-center justify-center">
                    <span class="font-bold text-xl dark:text-white">{{ $messagesCount }}</span>
                    <span class="dark:text-white">{{ __('Message') }}</span>
                </div>
                <button class="flex flex-col gap-2 items-center justify-center" wire:click="$dispatch('showUsers', { type: 'following' })">
                    <span class="font-bold text-xl dark:text-white">{{ $followingCount }}</span>
                    <span class="dark:text-white">{{ __('Following') }}</span>
                </button>
                <button class="flex flex-col gap-2 items-center justify-center"  wire:click="$dispatch('showUsers', { type: 'followers' })">
                    <span class="font-bold text-xl dark:text-white">{{ $followersCount }}</span>
                    <span class="dark:text-white">{{ __('Followers') }}</span>
                </button>
            </div>
            <div class="w-full">
                <hr class="w-full h-[1px] bg-gray-200" />

                @if (Auth::user()->id == $user->id)
                <div class="flex flex-row items-center justify-between gap-4 w-full mt-4" >
                    <a href="{{ route('profile.account') }}" class="flex flex-row items-center justify-center  w-full text-base py-2 px-2 text-white bg-brand-dark rounded-md">
                        {{ __('Edit Profile') }}
                    </a>
                    <button  x-bind="shareButton('{{ $share_data['title'] }}', '{{ $share_data['url'] }}')" class="flex flex-row items-center justify-center w-full text-base py-2 px-2 text-white bg-brand-dark rounded-md">
                        {{ __('Share Profile') }}
                    </button>
                </div>
                @else
                <div class="flex flex-row items-center justify-center gap-2 w-full py-2 px-4 mt-4 text-white bg-brand-dark rounded-md">
                    <span>{{ __('Follow') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
   
    @script
    <script>
        $wire.on('showUsers', (type) => {
            Alpine.store('showSidebar').toggle()
        });
    </script>
    @endscript
</div>