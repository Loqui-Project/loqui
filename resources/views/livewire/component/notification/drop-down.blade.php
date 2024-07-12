<div x-data="{ open: false }" class="relative">
    <button @click="open = ! open" class="text-sm font-semibold leading-6 relative flex flex-row gap-4 items-center text-gray-900 dark:text-white" aria-label="Open Notification DropDown">
        <span class="relative">
            <svg width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6 fill-black dark:fill-white" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C8.31847 1 5 3.56545 5 7V11.5389C5 12.1805 4.81008 12.8078 4.45416 13.3417L2.25488 16.6406C2.08869 16.8899 2 17.1828 2 17.4824C2 18.3206 2.67945 19 3.51759 19H8.5C8.5 20.933 10.067 22.5 12 22.5C13.933 22.5 15.5 20.933 15.5 19H20.4824C21.3206 19 22 18.3206 22 17.4824C22 17.1828 21.9113 16.8899 21.7451 16.6406L19.5458 13.3417C19.1899 12.8078 19 12.1805 19 11.5389V7C19 3.56545 15.6815 1 12 1ZM6.5 7C6.5 4.63556 8.88254 2.5 12 2.5C15.1175 2.5 17.5 4.63556 17.5 7V11.5389C17.5 12.4767 17.7776 13.3935 18.2978 14.1737L20.497 17.4726C20.499 17.4755 20.5 17.4789 20.5 17.4824C20.5 17.4862 20.4989 17.489 20.4989 17.489C20.4989 17.489 20.497 17.4927 20.4948 17.4948C20.4927 17.497 20.489 17.4989 20.489 17.4989C20.489 17.4989 20.4862 17.5 20.4824 17.5H3.51759C3.51378 17.5 3.51097 17.4989 3.51097 17.4989C3.51097 17.4989 3.50729 17.497 3.50515 17.4948C3.50302 17.4927 3.50107 17.489 3.50107 17.489C3.50107 17.489 3.5 17.4862 3.5 17.4824C3.5 17.4789 3.50103 17.4755 3.50295 17.4726L5.70224 14.1737C6.22242 13.3935 6.5 12.4767 6.5 11.5389V7ZM14 19H10C10 20.1046 10.8954 21 12 21C13.1046 21 14 20.1046 14 19Z" />
            </svg>
            <span class="text-[10px] font-normal absolute -top-[11px] -right-[12px] bg-brand-dark rounded-full w-6 h-6 text-center inline-flex items-center justify-center text-white">{{ $count > 99 ? "+99" : $count }}</span>
        </span>
        <span>
            {{__("Notification")}}
        </span>
    </button>
    <div x-show="open" @click.outside="open = false" x-transition class="absolute top-10 w-full min-w-[450px] backdrop:blur-lg  bg-[#2E3357] rounded-md shadow-lg p-4 flex flex-col gap-4">
        <div class="flex justify-between border-b items-center border-b-brand-main pb-4">
            <div>
                <h3 class="text-white text-xl font-bold">{{__("Your notification")}}</h3>
            </div>
            <div>
                <button class="flex items-center" wire:click="makeAllRead">
                    <span>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18.71 7.20998C18.617 7.11625 18.5064 7.04186 18.3845 6.99109C18.2627 6.94032 18.132 6.91418 18 6.91418C17.8679 6.91418 17.7372 6.94032 17.6154 6.99109C17.4935 7.04186 17.3829 7.11625 17.29 7.20998L9.83995 14.67L6.70995 11.53C6.61343 11.4367 6.49949 11.3634 6.37463 11.3142C6.24978 11.265 6.11645 11.2409 5.98227 11.2432C5.84809 11.2455 5.71568 11.2743 5.5926 11.3278C5.46953 11.3813 5.35819 11.4585 5.26495 11.555C5.17171 11.6515 5.0984 11.7654 5.04919 11.8903C4.99999 12.0152 4.97586 12.1485 4.97818 12.2827C4.9805 12.4168 5.00923 12.5493 5.06272 12.6723C5.11622 12.7954 5.19343 12.9067 5.28995 13L9.12995 16.84C9.22291 16.9337 9.33351 17.0081 9.45537 17.0589C9.57723 17.1096 9.70794 17.1358 9.83995 17.1358C9.97196 17.1358 10.1027 17.1096 10.2245 17.0589C10.3464 17.0081 10.457 16.9337 10.55 16.84L18.71 8.67998C18.8115 8.58634 18.8925 8.47269 18.9479 8.34619C19.0033 8.21969 19.0319 8.08309 19.0319 7.94498C19.0319 7.80688 19.0033 7.67028 18.9479 7.54378C18.8925 7.41728 18.8115 7.30363 18.71 7.20998V7.20998Z" fill="#424874" />
                        </svg>
                    </span>
                    <span class="text-white text-sm">
                        {{__("Mark all as read")}}
                    </span>
                </button>
            </div>
        </div>
        <div class="grid grid-cols-5 items-center gap-2 justify-between bg-[#8890CB] p-2 rounded-md">
            <button wire:click="setActiveTab('all')" class="{{$activeTab == "all" ? "bg-[#2E3357] text-[#F8F9FF]" : "text-[#2E3357]"}} col-span-1  py-2 px-2 capitalize font-medium text-sm rounded-md">
                {{__("All")}}
            </button>
            @foreach ($notification_type as $type)
            <button wire:click="setActiveTab('{{ $type["key"] }}')" class="{{$activeTab == $type["key"] ? "bg-[#2E3357] text-[#F8F9FF]" : "text-[#2E3357]"}} col-span-1 text-sm py-2 px-2 capitalize font-medium rounded-md">
                {{__($type["name"])}}
            </button>
            @endforeach
        </div>
        <nav class="border-b border-b-black  dark:border-b-white">
            <ul class="pb-4 flex flex-col justify-start space-y-4">
                @forelse ($notifications as $notification)
                @livewire('component.notification.card', ['notification' => $notification], key($notification->id))
                @empty
                <li class="text-center text-gray-900 dark:text-white">
                    {{ __("No notifications found") }}
                </li>
                @endforelse
            </ul>
        </nav>
        <div class="flex flex-row items-center justify-center pb-2">
            <a wire:navigate href="{{ route('notifications') }}" class="text-md font-medium leading-none text-brand-dark dark:text-white">{{__("View all notifications")}}</a>
        </div>
    </div>
</div>