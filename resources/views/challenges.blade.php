<x-layout nav-main="/projekte">
    <div class="text-center">
        <h2 class="title my-4 min-w-1/2">
            Projekte
        </h2>
    </div>
    <div class="mx-auto max-w-3xl px-2 pb-8">
        <p class="mb-4 text-gray-700 italic text-center"> Als Gruppe führt ihr innerhalb des Aktionszeitraums 23.04.2021 bis 18.09.2021<br> ein Projekt aus der Liste durch. </p>
        <div id="list">
            <div class="text-center">
                <small class="inline-block">Nur Projekte anzeigen für</small>
                @foreach($banners as $banner)
                @if(empty($current_banner) || $current_banner == $banner->id)
                <a class="px-2 py-1 rounded-full inline-block bg-{{$banner->color}}-light text-{{$banner->color}}-dark mb-1 border border-{{$banner->color}}-dark" href="/projekte?banner_id={{$banner->id}}#list">
                    {{$banner->stufe}}
                </a>
                @else
                <a class="px-2 py-1 rounded-full inline-block bg-{{$banner->color}}-light text-{{$banner->color}}-dark mb-1 border" href="/projekte?banner_id={{$banner->id}}#list">
                    {{$banner->stufe}}
                </a>
                @endif
                @endforeach
                @if(!empty($current_banner))<br>
                <a class="px-2 py-1 rounded-full inline-block bg-gray-200 text-gray-800 mb-1 border-gray-800" href="/projekte#list">
                    Alle Projekte anzeigen
                </a>
                @endif
            </div>
            <ul>
                @forelse ($challenges as $challenge)
                <li class="py-4 flex even:bg-white -mx-2">
                    <div class="sm:mr-4 mr-2 w-24 text-center flex-shrink-0 text-sm">
                        <img src="{{$challenge->category->icon_path}}" class="h-20 w-20 inline" alt="{{$challenge->category->title}}" title="{{$challenge->category->title}}" />
                        <small class="text-gray-600 block">
                            {{$challenge->category->title}}
                        </small>
                    </div>
                    <div class="flex-auto overflow-y-hidden pr-2">
                        <h2 class="text-2xl sm:text-3xl text-teal-600 break-words">
                            {{ $challenge->title }}
                        </h2>
                        <ul class="flex" title="Geeignet für: {{$challenge->banners->map->stufe->join(', ')}}">
                            @foreach($challenge->banners as $banner)
                            <li class="bg-{{$banner->color}}-light h-4 w-4 rounded-full border border-{{$banner->color}}-dark text-{{$banner->color}}-dark text-xs text-center leading-none -mr-1">
                                <small>{{$banner->stufe[0]}}</small>
                            </li>
                            @endforeach
                        </ul>
                        <p class="whitespace-pre-line text-sm sm:text-base">{{ $challenge->description }}</p>
                    </div>
                </li>
                @empty
                <li class="text-center py-4">
                    <em>Noch kein Projekt verfügbar.</em>
                </li>
                @endforelse
            </ul>
        </div>
        <p class="mt-4 text-gray-700 italic text-center">Wenn ihr noch Ideen für weitere Projekte habt, schreibt uns unter
            <x-mailto-orga subject="Projektidee für Trotzdem13" />
        </p>
    </div>
</x-layout>