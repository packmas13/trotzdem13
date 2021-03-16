<x-layout nav-main="/challenges">
    <div class="text-center">
        <h2 class="title my-4 min-w-1/2">
            die Challenges
        </h2>

        <ul>
            @empty($challenges)
                <li>
                    <h2>bisher keine Challenges verfügbar</h2>
                </li>
            @endempty
            @foreach ($challenges as $challenge)
                <li>
                    <h2>{{$challenge->title}}</h2>
                    <span>{{$challenge->description}}</span>
                </li>
            @endforeach
        </ul>
    </div>
</x-layout>
