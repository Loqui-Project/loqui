<div class="relative flex">
    <a href={{ $url }} class="flex items-start flex-row gap-2">
        <div class="w-10 h-10 flex justify-center items-center ">
            <img src="{{ $userImage }}" alt="default-avatar" class="w-8 h-8  rounded-full">
        </div>
        <div class="flex flex-col  w-full">
            <p>
                @if ($senderUsername == null)
                    <span class="text-sm text-black dark:text-white">{!! $senderName !!}</span>
                @else
                    <a class="text-sm text-black dark:text-white" href="{{ route('profile.user', ['username' => $senderUsername]) }}">
                        {!! $senderName !!}
                    </a>
                @endif
            </p>

            <time class="text-sm text-black dark:text-white" datetime="{{ $notification->created_at }}">{{ $created_at }}</time>
        </div>
    </a>
    @if ($notification->read_at == null)
        <button wire:click="markAsRead" class="absolute top-[10px] right-0 w-2 h-2 bg-brand-dark rounded-full"></button>
    @endif
</div>
