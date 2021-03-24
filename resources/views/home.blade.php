<x-layout nav-main="/">
    <div class="mx-auto max-w-3xl sm:mt-2 flex flex-col justify-between text-white text-center font-black text-2xl leading-none">
        <div class="bg-mango-600 px-1 py-3 mx-6 mt-3">Bannerlauf startet in
            {{ $days_left }} Tagen
        </div>
        <video autoplay loop muted playsinline poster="/img/trotzdem_banner.jpg" width="768" heigh="432">
            <source src="/img/trotzdem_banner.webm" type="video/webm" />
            <source src="/img/trotzdem_banner.mp4" type="video/mp4" />
            <img src="/img/trotzdem_banner.jpg" title="Your browser does not support the <video> tag">
        </video>

        <div class="bg-mango-600 px-1 py-3 text-2xl mx-6 mb-3">
            am {{ $banner_start->format('d.m.Y') }}
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
