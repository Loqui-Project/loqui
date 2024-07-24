<div class="col-span-1  ">
    <div class=" flex flex-col justify-between gap-10 h-full items-start hover:[@supports(backdrop-filter:blur(15px))]:bg-brand-dark/50 transition-all duration-300  shadow-surface-glass backdrop-blur will-change-transform [@supports(backdrop-filter:blur(15px))]:bg-brand-dark/30 w-full rounded-lg border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-brand-dark placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6 px-4">
        <div class="flex flex-col gap-2 w-full">
            <div>
                <p class="font-bold text-md font-rubik text-white">{{ $message->message }}</p>
            </div>
            <div class="flex items-center gap-4 flex-row w-full  border-b pb-4">
                <div class="w-12 h-12 flex justify-center items-center">
                    @if ($message->sender == null || !!$message->is_anon == true)
                    <img src="{{ URL::asset('images/default-avatar.png') }}" alt="default-avatar" class="w-10 h-10 rounded-full">
                    @else
                    <img src="{{ URL::asset($message->sender->image_url) }}" alt="{{ $message->sender->name }}" class="w-10 h-10 rounded-full">
                    @endif
                </div>
                <div class="flex flex-col w-full">
                    <div class="flex justify-between w-full">
                        <span class="font-bold text-white">
                            {{ $message->sender == null || !!$message->is_anon == true ? 'Anonymous ' : optional($message->sender)->name }}
                        </span>
                        <span class="text-white text-sm">
                            {{ $message->created_at->diffForHumans() }}
                        </span>
                    </div>
                    @if ($message->sender !== null && !!$message->is_anon == false)
                    <div>
                        <a wire:navigate href="{{ route('profile.user', ['user' => $message->sender->username]) }}" class="text-white text-sm italic">{{ '@' . $message->sender->username }}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="w-full">
            <form class="w-full" wire:submit="addReplay">
                <div>
                    <div class="mt-2 w-full">
                        <div class="mb-4">
                            <label for="replay" class="block text-sm font-medium leading-6 text-white">Replay</label>
                            <div class="mt-2">
                                <textarea wire:model="replay" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6 "></textarea>
                            </div>
                            <div class="text-danger">
                                @error('replay')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <button aria-label="Add replay" type="submit" class="flex w-full transition-all duration-300 justify-center rounded-md bg-brand-dark px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-brand-main focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-dark">{{ __("Add
                                                                                                                                                                                                                                                replay") }}</button>
                </div>
            </form>
        </div>
    </div>

</div>