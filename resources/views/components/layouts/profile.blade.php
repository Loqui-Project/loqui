<x-layout-app>
    <x-slot:title>
        {{$title}}
    </x-slot>
  <div class="container">
      <div class="flex items-start gap-x-10">

          <x-profile::side-bar/>
          <div class="w-3/4">
              {{$slot}}
          </div>
      </div>

  </div>
</x-layout-app>

