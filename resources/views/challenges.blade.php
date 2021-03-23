<x-layout nav-main="/projekte">
    <div class="text-center">
        <h2 class="title my-4 min-w-1/2">
            Projekte
        </h2>
    </div>
    <div class="mx-auto max-w-3xl px-2 pb-8">
        <p class="mb-4 text-gray-700 italic text-center"> Als Gruppe führt ihr innerhalb des Aktionszeitraums 23.04.2021 bis 18.09.2021<br> ein Projekt aus der Liste durch. </p>
        <p class="mb-4 text-gray-700 italic text-center">Ihr dürft als Gruppe auch eigene Ideen als Projekt einreichen und dieses dann durchführen.
            Die Projektleitung sichtet Euer eingereichtes Projekt und gibt Euch dieses zur Durchführung frei. </p>

        <p class="mb-4 text-gray-700 italic text-center">Wenn ihr noch Ideen für weitere Projekte habt, schreibt uns unter
            <x-mailto-orga subject="Projektidee für Trotzdem13" />
        </p>
        <ul>
            @forelse ($challenges as $challenge)
            <li class="py-4 flex even:bg-white -mx-2">
                <div class="sm:mr-4 mr-2 w-24 text-center flex-shrink-0 text-sm">
                    <img src="{{$challenge->category->icon_path}}" class="h-20 w-20 inline" alt="{{$challenge->category->title}}" title="{{$challenge->category->title}}" />
                    <small class="text-gray-600 block">
                        {{$challenge->category->title}}
                    </small>
                </div>
                <div class="flex-auto">
                    <h2 class="text-3xl text-teal-600">
                        {{ $challenge->title }}
                    </h2>
                    <p class="whitespace-pre-line text-sm sm:text-base">{{ $challenge->description }}</p>
                </div>

                @if(false)
                <div class="flex-0 text-center text-sm">
                    <h4 class="text-xs text-gray-600 pr-2">Geiegnet für</h4>
                    <ul>
                        @foreach($challenge->banners as $banner)
                        <li>
                            <x-banner-pill :banner="$banner" property="stufe" class="mb-1" />
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </li>
            @empty
            <li class="text-center">
                <em>Noch kein Projekt verfügbar.</em>
            </li>
            @endforelse
        </ul>
    </div>
</x-layout>
