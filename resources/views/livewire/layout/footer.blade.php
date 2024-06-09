@use(Illuminate\Support\Carbon, 'Carbon')

<div class=" shadow-surface-glass max-laptop:py-4 backdrop-blur will-change-transform [@supports(backdrop-filter:blur(15px))]:bg-secondary-main/[3%] shadow-sm rounded-md bg-white/30 dark:bg-brand-dark/30">
    <div class="w-full draggable">
        <div class="container flex flex-col mx-auto">
            <div class="flex flex-col items-center w-full my-20">
                <span class="mb-8">
                    <a href="{{ route('home') }}">
                        <span class="sr-only">Loqui</span>
                        <img class="h-10 w-10" src={{ URL::asset('images/logo.svg') }} alt="Loqui - Social Media Platform">
                    </a>
                </span>
                <div class="flex flex-col items-center gap-6 mb-8">
                    <div class="flex flex-wrap items-center justify-center gap-5 lg:gap-12 gap-y-3 lg:flex-nowrap text-dark-grey-900">
                        <a href="{{ route('changelog') }}" class="dark:text-white font-semibold">Changelog</a>
                    </div>

                </div>
                <div class="flex items-center">
                    <p class="text-base dark:text-white font-normal leading-7 text-center text-grey-700">
                        {{ Carbon::now()->format("Y-m-d") }} {{ env('APP_NAME') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>