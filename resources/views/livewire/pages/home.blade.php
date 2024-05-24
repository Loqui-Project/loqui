@section('title', 'Home')
<div class="bg-white dark:bg-black">
    <div class="relative isolate px-6 pt-14 laptop:px-8">
        <div class="absolute inset-x-0 bg-white dark:bg-black -z-10 transform-gpu overflow-hidden blur-3xl"
            aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>
        <div class="container">
            <div class="grid grid-cols-12 justify-between gap-4 mb-10">
                <div class="col-start-1 col-end-4 max-laptop:col-span-12">
                    <livewire:user::home-card :user="$user">
                </div>
                <div class="col-start-5 col-span-12 max-laptop:col-span-12">
                    <div id="messages" class="grid grid-cols-2 gap-6">
                        @foreach ($messages as $message)
                            @livewire('component.message-with-replay', ['message' => $message], key($message->id))
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
            aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-brand-main to-brand-dark opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

    </div>
</div>