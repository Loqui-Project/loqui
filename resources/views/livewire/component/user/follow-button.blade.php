<div x-data="{ 'isModalOpen': $wire.entangle('isModalOpen').live }" x-on:keydown.escape="isModalOpen = false">
    @if (Auth::check() && optional(Auth::user())->id !== $user->id)
        @if($isFollowing)
            <div>
                <button wire:click="openFollowingSettings" aria-label="Following" class="bg-brand-dark text-brand-100 border-brand-dark border-2  transition-all duration-300 rounded-md px-6 py-2 dark:text-brand-main font-semibold font-rubik">
                    {{__('Following') }}
                </button>
                
    <div class="w-full h-full fixed opacity-75 z-10 left-0 top-0 bg-black/80" x-show="isModalOpen" x-cloak></div>
    <div
      role="dialog"
      tabindex="-1"
      x-show="isModalOpen"      
      x-on:click.away="isModalOpen = false"
      x-cloak
      x-transition
      class="fixed inset-0 flex items-center justify-center z-50"
    >
    <div class="bg-brand-dark rounded-lg pt-6 w-96 max-w-full shadow-lg transform transition-all duration-300" x-show.transition.opacity="isModalOpen">
                <div class="flex items-center flex-col gap-y-2 mb-10 text-center">
                    <img src="{{ URL::asset($user->image_url) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full">
                    <h3 class="text-sm font-semibold leading-6 text-brand-dark dark:text-white">
                        {{ $user->name }}
                    </h3>
                    <span class="italic text-white">{{"@".$user->username}}</span>
                </div>
                <div class="mt-6">
                <ul class="flex flex-col items-start w-full p-0">
                    <li class="px-6 py-6 hover:bg-brand-main/40 group/item cursor-pointer w-full transition-all duration-300">
                        <button class="text-start text-white w-full transition-all duration-300">
                            {{__("Add to close friends list")}}
                        </button>
                    </li>
                    <li class="px-6 py-6 hover:bg-brand-main/40 group/item cursor-pointer w-full transition-all duration-300">
                    <button class="text-start text-white w-full transition-all duration-300">
                    {{__("Add to favorites")}}
                        </button>
                    </li>
                    <li class="px-6 py-6 hover:bg-brand-main/40 group/item cursor-pointer w-full transition-all duration-300">
                    <button wire:click="unfollow" class="text-start text-danger w-full transition-all duration-300">
                    {{__("Unfollow")}}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
            </div>
        @else
            <div>
                <button wire:click="follow" aria-label="Follow" class="text-brand-dark border-brand-dark hover:bg-brand-dark hover:text-brand-light hover:border-brand-dark dark:border-brand-main dark:hover:bg-brand-main dark:hover:text-brand-dark border-2 transition-all duration-300 rounded-md px-6 py-2 dark:text-brand-main font-semibold font-rubik">
                    {{  __('Follow') }}
                </button>
            </div>
        @endif
    @endif

    
</div>
