<div class="container">
    <div id="messages" class="grid grid-cols-2 laptop:gap-x-10 max-laptop:grid-cols-1 max-laptop:gap-y-10 my-10">
        @forelse ($favorites as $favorite)
        @livewire('component.message-with-replay', ['message' => $favorite, 'user' => $user], key($favorite->id))
        @empty
        <div class="col-span-2 hover:[@supports(backdrop-filter:blur(15px))]:bg-brand-dark/50 transition-all duration-300  shadow-surface-glass   [@supports(backdrop-filter:blur(15px))]:bg-brand-dark/30 w-full rounded-lg border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-brand-dark placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6 px-4">
            <div>
                <p class="font-bold text-md font-rubik text-white">{{__("No messages found")}}</p>
            </div>
        </div>
        @endforelse
    </div>
</div>