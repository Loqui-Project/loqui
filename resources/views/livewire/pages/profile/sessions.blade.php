<div class="container">
    <div class="max-w-lg mx-auto py-4">
        <div class="mb-10 flex flex-row justify-between items-center">
            <h1 class="text-2xl font-bold text-white">
                {{__("Sessions")}}
            </h1>
            <button wire:click="endAllSessions"
                class="border-2 text-brand-light border-brand-main hover:bg-brand-main hover:text-brand-dark transition-all duration-300 rounded-md px-6 py-2  font-semibold font-rubik">
                {{__("End All Sessions")}}
            </button>
        </div>
        <div class="flex flex-col gap-4">
            @foreach ($sessions as $session)
                <div class="relative">
                    <div
                        class="w-full  z-[1] p-10 shadow-surface-glass max-laptop:py-4   [@supports(backdrop-filter:blur(15px))]:bg-secondary-main/[3%] shadow-sm rounded-md bg-white/30 dark:bg-brand-dark/30">
                        <div class="flex flex-col justify-start items-start gap-6">
                            <div class="flex flex-row items-center gap-4 w-full">
                                @if ($session['device'] == 'desktop')
                                    <div>
                                        <svg width="24" height="24" class="fill-white w-8 h-8"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.95352 17H2.75C1.7835 17 1 16.2165 1 15.25V3.75C1 2.7835 1.7835 2 2.75 2H21.25C22.2165 2 23 2.7835 23 3.75V15.25C23 16.2165 22.2165 17 21.25 17H15.0463C15.217 18.3751 15.8509 19.6522 16.815 20.7568C17.0083 20.9784 17.0544 21.2926 16.9327 21.5604C16.811 21.8281 16.544 22 16.2499 22H7.74989C7.45578 22 7.18882 21.8281 7.06711 21.5604C6.94541 21.2926 6.99144 20.9784 7.18482 20.7568C8.14891 19.6522 8.78282 18.3751 8.95352 17ZM21.5 3.75V15.25C21.5 15.3881 21.3881 15.5 21.25 15.5H2.75C2.61193 15.5 2.5 15.3881 2.5 15.25V3.75C2.5 3.61193 2.61193 3.5 2.75 3.5H21.25C21.3881 3.5 21.5 3.61193 21.5 3.75ZM13.5369 17C13.6624 18.2662 14.1009 19.445 14.7601 20.5H9.23971C9.89885 19.445 10.3373 18.2662 10.4629 17H13.5369Z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="flex items-center justify-between w-full">
                                    <div>
                                        <h2 class="text-white text-lg font-bold">{{ $session['ip_address'] }}</h2>
                                        @if ($session['current'])
                                            <p class="text-white text-opacity-50">{{__("Current Session")}}</p>
                                        @else
                                            <p class="text-white text-opacity-50">{{__("Last Active:")}}
                                                {{ $session['last_activity'] }}</p>
                                        @endif
                                    </div>
                                    <div>
                                        <button aria-label="Close Session"
                                            wire:click="closeSession('{{ $session['id'] }}')"
                                            class="border-2 text-brand-light border-brand-main hover:bg-brand-main hover:text-brand-dark transition-all duration-300 rounded-md px-6 py-2  font-semibold font-rubik">
                                            {{__("Close Session")}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-white mt-2">
                            {{__("Seen in")}} {{ $session['country'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
