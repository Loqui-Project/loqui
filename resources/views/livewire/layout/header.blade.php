<header x-data="{ openMenu: false }"
    class="sticky z-[2] inset-x-0 top-2 m-6 shadow-surface-glass max-laptop:py-4 backdrop-blur will-change-transform [@supports(backdrop-filter:blur(15px))]:bg-secondary-main/[3%] shadow-sm rounded-md bg-white/30 dark:bg-brand-dark/30">
    <div class="container">
        <nav class="flex items-center justify-between laptop:px-8 flex-wrap" aria-label="Main navbar">
            <div class="flex laptop:flex-1">
                <a href="{{ route('home') }}">
                    <span class="sr-only">Loqui</span>
                    <img class="h-10 w-auto" src={{ URL::asset('images/logo.svg') }} alt="Loqui">
                </a>
            </div>
            @if (Auth::check())
                <div class="hidden laptop:flex laptop:gap-x-12">
                    <a href={{ route('home') }}
                        class="text-sm font-semibold leading-6 flex gap-4 items-center text-gray-900 dark:text-white">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6 dark:fill-white"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.0295 2.58983C11.5893 2.11485 12.4107 2.11485 12.9705 2.58983L20.4705 8.95347C20.8064 9.23847 21 9.65672 21 10.0972V19.5C21 20.3284 20.3284 21 19.5 21H13.75C13.3358 21 13 20.6642 13 20.25V14H11V20.25C11 20.6642 10.6642 21 10.25 21H4.5C3.67157 21 3 20.3284 3 19.5V10.0972C3 9.65672 3.19364 9.23847 3.52953 8.95347L11.0295 2.58983ZM12 3.7336L4.5 10.0972L4.5 19.5H9.5V13.25C9.5 12.8358 9.83579 12.5 10.25 12.5H13.75C14.1642 12.5 14.5 12.8358 14.5 13.25V19.5H19.5V10.0972L12 3.7336Z" />
                            </svg>
                        </span>
                        <span>
                            {{ __("Home") }}
                        </span>
                    </a>
                    <a href={{ route('search') }}
                        class="text-sm font-semibold leading-6 flex gap-4 items-center text-gray-900 dark:text-white">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24"
                                class="w-6 h-6 fill-black dark:fill-white" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.25 2C5.69365 2 2 5.69365 2 10.25C2 14.8063 5.69365 18.5 10.25 18.5C12.2581 18.5 14.0987 17.7825 15.5293 16.59L21.2197 22.2803C21.5126 22.5732 21.9874 22.5732 22.2803 22.2803C22.5732 21.9874 22.5732 21.5126 22.2803 21.2197L16.59 15.5293C17.7825 14.0987 18.5 12.2581 18.5 10.25C18.5 5.69365 14.8063 2 10.25 2ZM3.5 10.25C3.5 6.52208 6.52208 3.5 10.25 3.5C13.9779 3.5 17 6.52208 17 10.25C17 13.9779 13.9779 17 10.25 17C6.52208 17 3.5 13.9779 3.5 10.25Z" />
                            </svg>

                        </span>
                        <span>
                            {{ __("Search") }}
                        </span>
                    </a>
                    <a href={{ route('inbox') }}
                        class="text-sm font-semibold leading-6 flex gap-4 items-center text-gray-900 dark:text-white">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24"
                                class="w-6 h-6 fill-black dark:fill-white" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.80111 3.5709C5.07434 2.92198 5.70987 2.5 6.41397 2.5H17.5877C18.2903 2.5 18.9248 2.9202 19.199 3.56709L22.9405 12.3948C22.9798 12.4874 23 12.5869 23 12.6875V20.25C23 21.2165 22.2165 22 21.25 22H2.75C1.7835 22 1 21.2165 1 20.25V12.75C1 12.65 1.01998 12.5511 1.05877 12.459L4.80111 3.5709ZM6.41397 4C6.31339 4 6.2226 4.06028 6.18357 4.15299L2.87956 12H8C8.26675 12 8.51343 12.1417 8.64783 12.3721L10.1808 15H13.8192L15.3522 12.3721C15.4852 12.144 15.7284 12.0027 15.9925 12L21.1223 11.9487L17.8179 4.15244C17.7787 4.06003 17.6881 4 17.5877 4H6.41397ZM21.5 13.445L16.4333 13.4957L14.8978 16.1279C14.7634 16.3583 14.5168 16.5 14.25 16.5H9.75C9.48325 16.5 9.23657 16.3583 9.10217 16.1279L7.56922 13.5H2.5V20.25C2.5 20.3881 2.61193 20.5 2.75 20.5H21.25C21.3881 20.5 21.5 20.3881 21.5 20.25V13.445Z" />
                            </svg>
                        </span>
                        <span>
                            {{ __("Inbox") }}
                        </span>
                    </a>
                </div>
                <div class="flex laptop:flex-1 laptop:justify-end">
                    <div class="max-laptop:flex hidden">
                        <button type="button" @click="openMenu = !openMenu"
                            class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                            <span class="sr-only">Open main menu</span>
                            <svg x-show="openMenu" class="h-6 w-6 dark:[&>path]:stroke-white" viewBox="0 0 24 24"
                                stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <svg x-show="openMenu == false" class="h-6 w-6 dark:[&>path]:stroke-white" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                    <x-user-header-card />
                </div>
            @else
                <div class="hidden laptop:flex laptop:gap-x-6 p-4">
                    <a href={{ route('auth.sign-in') }}
                        class="text-sm font-semibold leading-6 flex gap-4 items-center text-gray-900 dark:text-white">
                        <span>
                            {{ __("Sign in") }}
                        </span>
                    </a>
                    <a href={{ route('auth.sign-out') }}
                        class="text-sm bg-brand-dark text-white px-8 py-2 rounded-md hover:bg-brand-dark/90 transition-all duration-300 font-semibold leading-6 flex gap-4 items-center  ">
                        <span>
                            {{ __("Sign up") }}
                        </span>
                    </a>

                </div>
            @endif

        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div class="laptop:hidden" role="dialog" aria-modal="true">
            <div class="mt-6 flow-root" x-show="openMenu" @click.outside="openMenu = false" x-transition>
                <div class="flex flex-col gap-4">
                    <a href={{ route('home') }}
                        class="text-sm font-semibold transition-all duration-300 hover:pb-2  hover:border-b hover:border-white  leading-6 flex gap-4 items-center text-gray-900 dark:text-white">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24" class="w-6 h-6 dark:fill-white"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.0295 2.58983C11.5893 2.11485 12.4107 2.11485 12.9705 2.58983L20.4705 8.95347C20.8064 9.23847 21 9.65672 21 10.0972V19.5C21 20.3284 20.3284 21 19.5 21H13.75C13.3358 21 13 20.6642 13 20.25V14H11V20.25C11 20.6642 10.6642 21 10.25 21H4.5C3.67157 21 3 20.3284 3 19.5V10.0972C3 9.65672 3.19364 9.23847 3.52953 8.95347L11.0295 2.58983ZM12 3.7336L4.5 10.0972L4.5 19.5H9.5V13.25C9.5 12.8358 9.83579 12.5 10.25 12.5H13.75C14.1642 12.5 14.5 12.8358 14.5 13.25V19.5H19.5V10.0972L12 3.7336Z" />
                            </svg>
                        </span>
                        <span>
                            {{ __("Home") }}
                        </span>
                    </a>
                    <a href={{ route('search') }}
                        class="text-sm font-semibold leading-6 transition-all duration-300 hover:pb-2  hover:border-b hover:border-white flex gap-4 items-center text-gray-900 dark:text-white">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24"
                                class="w-6 h-6 fill-black dark:fill-white" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.25 2C5.69365 2 2 5.69365 2 10.25C2 14.8063 5.69365 18.5 10.25 18.5C12.2581 18.5 14.0987 17.7825 15.5293 16.59L21.2197 22.2803C21.5126 22.5732 21.9874 22.5732 22.2803 22.2803C22.5732 21.9874 22.5732 21.5126 22.2803 21.2197L16.59 15.5293C17.7825 14.0987 18.5 12.2581 18.5 10.25C18.5 5.69365 14.8063 2 10.25 2ZM3.5 10.25C3.5 6.52208 6.52208 3.5 10.25 3.5C13.9779 3.5 17 6.52208 17 10.25C17 13.9779 13.9779 17 10.25 17C6.52208 17 3.5 13.9779 3.5 10.25Z" />
                            </svg>

                        </span>
                        <span>
                            {{ __("Search") }}
                        </span>
                    </a>
                    <a href={{ route('inbox') }}
                        class="text-sm font-semibold leading-6 transition-all duration-300 hover:pb-2  hover:border-b hover:border-white flex gap-4 items-center text-gray-900 dark:text-white">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24"
                                class="w-6 h-6 fill-black dark:fill-white" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M4.80111 3.5709C5.07434 2.92198 5.70987 2.5 6.41397 2.5H17.5877C18.2903 2.5 18.9248 2.9202 19.199 3.56709L22.9405 12.3948C22.9798 12.4874 23 12.5869 23 12.6875V20.25C23 21.2165 22.2165 22 21.25 22H2.75C1.7835 22 1 21.2165 1 20.25V12.75C1 12.65 1.01998 12.5511 1.05877 12.459L4.80111 3.5709ZM6.41397 4C6.31339 4 6.2226 4.06028 6.18357 4.15299L2.87956 12H8C8.26675 12 8.51343 12.1417 8.64783 12.3721L10.1808 15H13.8192L15.3522 12.3721C15.4852 12.144 15.7284 12.0027 15.9925 12L21.1223 11.9487L17.8179 4.15244C17.7787 4.06003 17.6881 4 17.5877 4H6.41397ZM21.5 13.445L16.4333 13.4957L14.8978 16.1279C14.7634 16.3583 14.5168 16.5 14.25 16.5H9.75C9.48325 16.5 9.23657 16.3583 9.10217 16.1279L7.56922 13.5H2.5V20.25C2.5 20.3881 2.61193 20.5 2.75 20.5H21.25C21.3881 20.5 21.5 20.3881 21.5 20.25V13.445Z" />
                            </svg>
                        </span>
                        <span>
                            {{ __("Inbox") }}
                        </span>
                    </a>
                    <a href="{{ route("notifications") }}"
                        class="text-sm font-semibold leading-6 transition-all duration-300 hover:pb-2  hover:border-b hover:border-white flex gap-4 items-center text-gray-900 dark:text-white">
                        <span>
                            <svg width="24" height="24" viewBox="0 0 24 24"
                                class="w-6 h-6 fill-black dark:fill-white" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M12 1C8.31847 1 5 3.56545 5 7V11.5389C5 12.1805 4.81008 12.8078 4.45416 13.3417L2.25488 16.6406C2.08869 16.8899 2 17.1828 2 17.4824C2 18.3206 2.67945 19 3.51759 19H8.5C8.5 20.933 10.067 22.5 12 22.5C13.933 22.5 15.5 20.933 15.5 19H20.4824C21.3206 19 22 18.3206 22 17.4824C22 17.1828 21.9113 16.8899 21.7451 16.6406L19.5458 13.3417C19.1899 12.8078 19 12.1805 19 11.5389V7C19 3.56545 15.6815 1 12 1ZM6.5 7C6.5 4.63556 8.88254 2.5 12 2.5C15.1175 2.5 17.5 4.63556 17.5 7V11.5389C17.5 12.4767 17.7776 13.3935 18.2978 14.1737L20.497 17.4726C20.499 17.4755 20.5 17.4789 20.5 17.4824C20.5 17.4862 20.4989 17.489 20.4989 17.489C20.4989 17.489 20.497 17.4927 20.4948 17.4948C20.4927 17.497 20.489 17.4989 20.489 17.4989C20.489 17.4989 20.4862 17.5 20.4824 17.5H3.51759C3.51378 17.5 3.51097 17.4989 3.51097 17.4989C3.51097 17.4989 3.50729 17.497 3.50515 17.4948C3.50302 17.4927 3.50107 17.489 3.50107 17.489C3.50107 17.489 3.5 17.4862 3.5 17.4824C3.5 17.4789 3.50103 17.4755 3.50295 17.4726L5.70224 14.1737C6.22242 13.3935 6.5 12.4767 6.5 11.5389V7ZM14 19H10C10 20.1046 10.8954 21 12 21C13.1046 21 14 20.1046 14 19Z" />
                            </svg>
                        </span>
                        <span>
                            {{ __("Notification") }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
