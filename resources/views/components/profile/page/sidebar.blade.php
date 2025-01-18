<div class="mb-10 z-[2] top-20 sticky rounded-lg w-1/4 border-r">
    <!-- Nothing worth having comes easy. - Theodore Roosevelt -->
    <ul class="flex flex-col w-full p-0 m-0 n">
        @foreach($menuLinks as $menuLink)
            <li class="w-full block">
                <a class="{{ $menuLink['active'] ? "border-r-4 border-brand-dark text-brand-dark bg-brand-dark/10" : "text-brand-dark"  }} font-medium block transition-all duration-300 w-full py-4 px-2 pl-4" wire:navigate  href="{{ $menuLink['url'] }}">{{$menuLink["name"]}}</a>
            </li>
        @endforeach
    </ul>
</div>
