<div x-data="{ open: false }" class="relative">
    <button @click="open = ! open" class="text-sm font-semibold leading-6 flex flex-row gap-4 items-center text-gray-900 dark:text-white" aria-label="Open Notification DropDown">
        <span>
            <svg width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6 fill-black dark:fill-white" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C8.31847 1 5 3.56545 5 7V11.5389C5 12.1805 4.81008 12.8078 4.45416 13.3417L2.25488 16.6406C2.08869 16.8899 2 17.1828 2 17.4824C2 18.3206 2.67945 19 3.51759 19H8.5C8.5 20.933 10.067 22.5 12 22.5C13.933 22.5 15.5 20.933 15.5 19H20.4824C21.3206 19 22 18.3206 22 17.4824C22 17.1828 21.9113 16.8899 21.7451 16.6406L19.5458 13.3417C19.1899 12.8078 19 12.1805 19 11.5389V7C19 3.56545 15.6815 1 12 1ZM6.5 7C6.5 4.63556 8.88254 2.5 12 2.5C15.1175 2.5 17.5 4.63556 17.5 7V11.5389C17.5 12.4767 17.7776 13.3935 18.2978 14.1737L20.497 17.4726C20.499 17.4755 20.5 17.4789 20.5 17.4824C20.5 17.4862 20.4989 17.489 20.4989 17.489C20.4989 17.489 20.497 17.4927 20.4948 17.4948C20.4927 17.497 20.489 17.4989 20.489 17.4989C20.489 17.4989 20.4862 17.5 20.4824 17.5H3.51759C3.51378 17.5 3.51097 17.4989 3.51097 17.4989C3.51097 17.4989 3.50729 17.497 3.50515 17.4948C3.50302 17.4927 3.50107 17.489 3.50107 17.489C3.50107 17.489 3.5 17.4862 3.5 17.4824C3.5 17.4789 3.50103 17.4755 3.50295 17.4726L5.70224 14.1737C6.22242 13.3935 6.5 12.4767 6.5 11.5389V7ZM14 19H10C10 20.1046 10.8954 21 12 21C13.1046 21 14 20.1046 14 19Z" />
            </svg>
        </span>
        <span>
            Notification <span class="text-xs font-normal text-gray-400 dark:text-gray-500">({{ $count }})</span>
        </span>
    </button>
    <div x-show="open" @click.outside="open = false" x-transition class="absolute top-10 w-full min-w-80 bg-white dark:bg-black rounded-md shadow-lg  p-4">
        <nav class="border-b border-b-black  dark:border-b-white">
            <ul class="pb-4 flex flex-col justify-start space-y-4">
                @foreach ($notifications as $notification)
                @livewire('component.notification.card', ['notification' => $notification], key($notification->id))
                @endforeach
            </ul>
        </nav>
        <div class="flex flex-row items-center justify-center pt-4 gap-2">
            <a href="{{ route("notifications") }}" class="text-md font-medium leading-none text-brand-dark dark:text-white">View all notifications</a>
        </div>
    </div>
</div>