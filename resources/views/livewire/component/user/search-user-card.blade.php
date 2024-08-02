<div class="flex justify-between max-laptop:flex-col max-laptop:justify-start max-laptop:items-start gap-4 hover:[@supports(backdrop-filter:blur(15px))]:bg-brand-dark/50 transition-all duration-300  items-center shadow-surface-glass backdrop-blur will-change-transform [@supports(backdrop-filter:blur(15px))]:bg-brand-dark/30 w-full rounded-lg border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-brand-dark placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6 px-4">
    <div class="flex items-center gap-x-6">
        <img src="{{ $user->image_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full">
        <a wire:navigate href="{{ route('profile.user', ['user' => $user->username]) }}">
            <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900 dark:text-white">
                {{ $user->name }}
            </h3>
            <p class="text-sm font-semibold leading-6 text-brand-dark dark:text-gray-400">{{ '@' . $user->username }}</p>
        </a>
    </div>
    <div>
        <button aria-label="Follow" wire:click="follow({{ $user->id }})" class="{{ $isFollowing ? 'bg-brand-dark text-brand-100 border-brand-dark' : 'text-brand-dark border-brand-dark hover:bg-brand-dark hover:text-brand-light hover:border-brand-dark dark:border-brand-main dark:hover:bg-brand-main dark:hover:text-brand-dark' }} border-2  transition-all duration-300 rounded-md px-6 py-2 dark:text-brand-main font-semibold font-rubik">
            {{ $isFollowing ? __('Following') : __('Follow') }}
        </button>
    </div>
</div>