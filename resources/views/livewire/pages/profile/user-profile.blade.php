<div class="container" >
    <div class="max-w-screen-laptop mx-auto mt-10">
        <div class="flex justify-between hover:[@supports(backdrop-filter:blur(15px))]:bg-brand-dark/50 transition-all duration-300  items-center shadow-surface-glass   [@supports(backdrop-filter:blur(15px))]:bg-brand-dark/30 w-full rounded-lg border-0 py-4 text-gray-900 shadow-sm ring-1 ring-inset ring-brand-dark placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-brand-dark sm:text-sm sm:leading-6 px-4">
            <div class="flex items-center gap-x-6">
                <img src="{{ $user->image_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full">
                <div>
                    <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900 dark:text-white">
                        {{ $user->name }}
                    </h3>
                    <p class="text-sm font-semibold leading-6 text-brand-dark dark:text-gray-400">
                        {{ '@' . $user->username }}
                    </p>
                </div>
            </div>
            {{-- <livewire:user::follow-button :user="$user" /> --}}
        </div>
        <div>
            <form class="w-full" wire:submit="sendMessage">
                <div class="border-t border-t-brand-main mt-4 pt-2">
                    <div class="mt-2 w-full">
                        <div class="mb-4">
                            <div class="mt-2">
                                <textarea wire:model="content" rows="3" placeholder="{{__("Send a message")}}" class="block w-full text-white rounded-md border-0 py-1.5 shadow-surface-glass   [@supports(backdrop-filter:blur(15px))]:bg-brand-dark/30 dark:placeholder:text-white"></textarea>
                            </div>
                            <div class="text-danger">
                                @error('content')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <button aria-label="Send message" type="submit" class="flex transition-all duration-300 px-8 py-2 justify-center rounded-md bg-brand-dark text-sm font-semibold leading-6 text-white shadow-sm hover:bg-brand-main focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-dark">{{__("Send")}}</button>
                    <div class="items center mt-3 flex">
                        <input type="checkbox" wire:model="anonymously" id="anonymously" class="mt-1 rounded border-brand-dark bg-transparent text-brand-dark focus:ring-brand-dark" @disabled(Auth::check()==false)>
                        <label for="anonymously" class="ml-2 text-brand-dark dark:text-brand-light">{{__("Anonymously")}}</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="my-10">
            <div class="grid grid-cols-2 laptop:gap-x-10 max-laptop:grid-cols-1 max-laptop:gap-y-10">
                @foreach ($userMessages as $message)
                @livewire('component.message-with-replay', ['message' => $message, 'user' => $user], key($message->id))
                @endforeach
            </div>
        </div>
    </div>

</div>
{{-- @script
<script>
    $wire.on('not-auth-for-follow', () => {
        window.Swal.fire({
            title: 'Error!',
            text: 'You need to be logged in to follow users.',
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: "Sign in ?",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                window.location.href = "{{ route('auth.sign-in') }}?redirect={{ url()->current() }}";
            }
        })
    });
</script>
@endscript --}}
