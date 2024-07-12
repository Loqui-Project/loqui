@section('title', 'Home')
<div class="bg-white dark:bg-black">
    <div class="relative isolate px-6 pt-14 laptop:px-8">
        <div class="absolute inset-x-0 bg-white dark:bg-black -z-10 transform-gpu overflow-hidden blur-3xl" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>
        <div class="container">
            <div class="grid grid-cols-12 justify-between laptop:gap-x-4 mb-10 max-laptop:gap-y-4">
                <div class="col-start-1 col-end-4 max-desktop:col-span-12">
                    <livewire:user::home-card :user="$user" :userData="$user_data">
                </div>
                <div class="col-start-5 col-span-12 max-desktop:col-span-12">
                    <div id="messages" class="grid grid-cols-2 laptop:gap-x-10 laptop:gap-y-10 max-laptop:grid-cols-1 max-laptop:gap-y-10">
                        @forelse ($messages as $userMessage)
                        @livewire('component.message-with-replay', ['message' => $userMessage, 'user' => $user], key($userMessage->id))
                        @empty
                        <div class="col-span-2 hover:[@supports(backdrop-filter:blur(15px))]:bg-brand-dark/50 transition-all duration-300  shadow-surface-glass backdrop-blur will-change-transform [@supports(backdrop-filter:blur(15px))]:bg-brand-dark/30 w-full rounded-lg border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-brand-dark placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6 px-4">
                            <div>
                                <p class="font-bold text-md font-rubik text-white">No messages found</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                    @if ($messages->hasMorePages())
                    <div class="mt-10 w-full flex justify-center items-center">
                        <button aria-label="Load more" wire:click="loadMore" class="inline-flex min-w-[200px] transition-all duration-300 justify-center rounded-md bg-brand-dark px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-brand-main focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-dark">
                            Load more
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-brand-main to-brand-dark opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

    </div>
</div>