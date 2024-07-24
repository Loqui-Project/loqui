@section('title', 'Search')
<div class="bg-white dark:bg-black">
    <div class="relative isolate px-6 pt-14 laptop:px-8">
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

        <div class="w-full max-w-screen-laptop overflow-hidden rounded-lg mx-auto my-10">
            <div class="mb-4">
                <h1 class="text-2xl font-bold font-rubik dark:text-white">{{__("Explore")}}</h1>
            </div>
            <div>
                <form class="w-full" wire:submit.prevent="search">
                    <div class="flex items center justify-center">
                        <div class="w-full">
                            <div class="mb-4">
                                <div class="mt-2">
                                    <input wire:model.live="search" type="text" placeholder="{{__("Search for users...")}}" class="block text-brand-dark placeholder:text-brand-dark dark:text-white dark:placeholder:text-white shadow-surface-glass backdrop-blur will-change-transform [@supports(backdrop-filter:blur(15px))]:bg-brand-dark/30 w-full rounded-lg border-0 py-4  shadow-sm ring-1 ring-inset ring-brand-dark  focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6">
                                </div>
                                <div class="text-danger">
                                    @error('search')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="grid grid-cols-1 gap-y-6">
                @forelse ($users as $user)
                @livewire('component.user.search-user-card', ['user' => $user], key($user->id))
                @empty
                <div class="flex justify-between max-laptop:flex-col max-laptop:justify-start max-laptop:items-start gap-4 hover:[@supports(backdrop-filter:blur(15px))]:bg-brand-dark/50 transition-all duration-300  items-center shadow-surface-glass backdrop-blur will-change-transform [@supports(backdrop-filter:blur(15px))]:bg-brand-dark/30 w-full rounded-lg border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-brand-dark placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6 px-4">
                    <div class="flex items-center gap-x-6">
                        <div>
                            <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900 dark:text-white">
                                There is no users with {{ $search }}</h3>
                        </div>
                    </div>

                </div>
                @endforelse
                @if ($users->hasMorePages())
                <div class="mt-10 w-full flex justify-center items-center">
                    <button aria-label="Load more" wire:click="loadMore" class="inline-flex min-w-[200px] transition-all duration-300 justify-center rounded-md bg-brand-dark px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-brand-main focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-dark">
                        Load more
                    </button>
                </div>
                @endif
            </div>
        </div>
        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-brand-main to-brand-dark opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>
    </div>
</div>