<x-layout nav-main="/">
    <div class="mx-auto max-w-3xl sm:mt-2 flex flex-col justify-between text-white text-center font-black text-2xl leading-none">
        @if($start_days_left > 1)
        <h2 class="bg-mango-600 px-1 py-3 mx-6 mt-3">
            Bannerlauf startet in
            {{ $start_days_left }} Tagen, am {{ $banner_start->format('d.m.') }}
        </h2>
        @elseif(0 > $start_days_left)
        <h2 class="bg-mango-600 px-1 py-3 mx-6 mt-3">
            Die Banner laufen noch {{ $end_days_left }} Tage, bis zum {{ $banner_end->format('d.m.') }}
        </h2>
        @else
        <h2 class="bg-mango-600 px-1 py-3 mx-6 mt-3">
            Bannerlauf startet {{$start_days_left == 1?'morgen':'heute'}}, um 18 Uhr
            <a href="https://youtu.be/ajqxr-0PEr8" target="_blank" rel="noopener noreferrer" class="bg-white text-mango-600 py-2 px-6 mt-3 inline-block font-bold">
                Zum Gottesdienst-Livestream →
            </a>
        </h2>
        @endif
        <video autoplay loop muted playsinline poster="/img/trotzdem_banner.jpg" width="768" heigh="432" tabindex="-1" aria-label="Wehendes DPSG Banner">
            <source src="/img/trotzdem_banner.webm" type="video/webm" />
            <source src="/img/trotzdem_banner.mp4" type="video/mp4" />
            <img src="/img/trotzdem_banner.jpg" alt="Wehendes DPSG Banner">
        </video>

        <div class="bg-mango-600 px-1 py-3 text-2xl mx-6 mb-3">
            {{ $team_count }} Gruppen &middot;
            <span class="inline-block">{{ $challenge_count }} Projekte zur Auswahl</span>
        </div>
    </div>
    <div class="prose lg:prose-xl mx-auto px-2 sm:px-0 py-8 text-center">
        <p>
            Nachdem unser Diözesanlager “Pack Ma’s 13” mit weit über 2000 Teilnehmer:innen aufgrund der Aktuellen
            Situation
            abgesagt werden musste, wollen wir <strong>TROTZDEM</strong> zeigen, dass es möglich ist, auch in diesen
            komplizierten Zeiten die Vielfalt unserer grandiosen Diözese erlebbar zu machen.
        </p>
        <p>
            Daher haben wir uns die Aktion „Trotzdem ’13“ überlegt, mit der wir gemeinsam ganz hygienekonform den Sommer
            mit
            so viel Pfadfinder-Spirit wie möglich füllen wollen.
        </p>
        <h3>
            Aber wie soll das funktionieren?
        </h3>
        <p>
            Natürlich können wir in diesem Jahr kein Großlager abhalten. Trotzdem ’13 ist daher als Bannerlauf angelegt,
            den
            wir über die gesamte Diözese München und Freising verteilt mit so vielen Gruppen wie möglich
            stattfinden
            lassen wollen. Der Bannerlauf wird dabei von individuellen Herausforderungen begleitet, die jede Gruppe
            durchführen und dokumentieren sollen. Das Ziel der Aktion ist, gemeinsam neue Dinge auszuprobieren, neue
            Pfadfinder:innen kennen zu lernen und insgesamt die Welt ein bisschen besser zu machen.

        </p>
        @if ($showLoginLink)
        <h4>
            Lasst euch den Spaß nicht entgehen, und <a href="{{route('app.team.index')}}">
                meldet euch gleich an
            </a>.
        </h4>
        @else
        <h4>
            Hier geht’s <a href="/ablauf">zum Ablauf</a>
        </h4>
        @endif
    </div>
</x-layout>
