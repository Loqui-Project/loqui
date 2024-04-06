<div
    class="col-span-1  flex flex-col items-start justify-start w-full gap-4 bg-white/60 dark:bg-white/100 p-6 shadow-lg rounded-lg">
    <div>
        <p class="font-bold text-md font-rubik">{{ $message->message }}</p>
    </div>
    <div class="flex items-center gap-4 flex-row w-full  border-b pb-4">
        <div class="w-12 h-12 flex justify-center items-center">
            @if ($message->sender == null || !!$message->is_anon == true)
                <img src="{{ URL::asset('images/default-avatar.png') }}" alt="default-avatar"
                    class="w-10 h-10 rounded-full">
            @else
                <img src="{{ URL::asset($message->sender->mediaObject->media_path) }}" alt="{{ $message->sender->name }}"
                    class="w-10 h-10 rounded-full">
            @endif
        </div>
        <div class="flex flex-col w-full">
            <div class="flex justify-between w-full">
                <span class="font-bold">
                    {{ $message->sender == null || !!$message->is_anon == true ? 'Anonymous ' : optional($message->sender)->name }}
                </span>
                <span class="text-gray-400">
                    {{ $message->created_at->diffForHumans() }}
                </span>
            </div>
            @if ($message->sender !== null && !!$message->is_anon == false)
                <div>
                    <a href={{ route('profile.user', ['username' => $message->sender->username]) }}
                        class="text-gray-400">{{ '@' . $message->sender->username }}</a>
                </div>
            @endif
        </div>
    </div>
    <div class="w-full">
        <form class="w-full" wire:submit="addReplay">
            <div>
                <div class="mt-2 w-full">
                    <div class="mb-4">
                        <label for="replay" class="block text-sm font-medium leading-6 text-gray-900">Replay</label>
                        <div class="mt-2">
                            <textarea wire:model="replay" rows="3"
                                class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6"></textarea>
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
                <button type="submit"
                    class="flex w-full transition-all duration-300 justify-center rounded-md bg-brand-dark px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-brand-main focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-dark">Add
                    replay</button>
            </div>
        </form>
    </div>
</div>
