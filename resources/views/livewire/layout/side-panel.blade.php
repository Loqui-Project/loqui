<div class="relative z-50" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-show="$store.showSidebar.show"
        x-transition:enter="transition ease-in-out duration-500" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in-out duration-500"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <div class="fixed inset-0 overflow-hidden" :class="!$store.showSidebar.show ? '-z-10 invisible' : 'z-10 visible'">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto relative w-screen max-w-md" x-show="$store.showSidebar.show"
                    x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                    <div class="absolute left-0 top-0 -ml-8 flex pr-2 pt-4 sm:-ml-10 sm:pr-4"
                        x-show="$store.showSidebar.show" x-transition:enter="ease-in-out duration-500"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in-out duration-500" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <button aria-label="Close Panel" type="button" @click="$store.showSidebar.toggle()"
                            class="relative rounded-md text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                            <span class="absolute -inset-2.5"></span>
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div
                        class="flex h-full flex-col overflow-y-auto  p-10 shadow-surface-glass max-laptop:py-4 backdrop-blur will-change-transform [@supports(backdrop-filter:blur(15px))]:bg-secondary-main/[3%] rounded-md bg-white/30 dark:bg-brand-dark/30 py-6 shadow-xl">
                        <div class="border-b border-b-white py-4 mb-4">
                            <h2 class="text-lg capitalize font-semibold leading-6 text-white" id="slide-over-title">
                                {{ $type }}
                            </h2>
                        </div>
                        <div class="relative mt-6 flex-1 px-4 sm:px-6">
                            @if ($users != null)
                                <div class="flex flex-col gap-4">
                                    @forelse($users as $user)
                                        @livewire('component.user.sidebar-card', ['user' => $user, 'type' => $type, 'authUser' => $authUser], key($user->id))
                                    @empty
                                        <p>No users</p>
                                    @endforelse
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
