<x-layout nav-main="/ablauf">
    <div class="text-center">
        <h2 class="title my-4 min-w-1/2">
            Ablauf
        </h2>
    </div>
    <div class="prose lg:prose-xl mx-auto px-2 pb-8">
        <h3>Wer darf teilnehmen?</h3>
        <ul>
            <li>
                Jeder DPSG Stamm aus der Diözese München und Freising ist eingeladen teilzunehmen. Wie Eure Gruppe
                ausschaut, ist dabei Euch überlassen. Eine Gruppe ist entweder ein Rudel oder Sippe, eine ganze Meute,
                Stufe oder Runde oder gleich euer ganzer Stamm. Auch als Leiterrunde dürft ihr gerne teilnehmen.
            </li>
            <li>
                Aus einem Stamm dürfen auch mehrere Gruppen gleichzeitig teilnehmen.
            </li>
            <li>
                Auch Gruppen aus eingeladenen Verbänden aus der Diözese München und Freising sind herzlich willkommen.
            </li>
            <li>
                Jeder Gruppe werden zwei Partnergruppen zugeteilt. (siehe Bannerlauf).
            </li>
            <li>
                Jede Gruppe wird durch einen Gruppenverantwortlichen angemeldet.
            </li>
        </ul>

        <h3>Projektauswahl und Durchführung</h3>
        <ul>
            <li>
                Als Gruppe führt ihr innerhalb des Aktionszeitraums 23.04.2021 bis 18.09.2021 ein <a
                    href="/projekte">Projekt aus der Liste</a>
                durch.
            </li>
            <li>
                Achtung: Manche Projekte sind terminiert! Und manche Projekte gibt es nur einmal.
            </li>
            <li>
                Ihr dürft als Gruppe auch eigene Ideen als Projekt einreichen und dieses dann durchführen.
                Die Projektleitung sichtet Euer eingereichtes Projekt und gibt Euch dieses zur Durchführung frei.
            </li>
            <li>
                Eignet sich dieses Projekt auch für andere Gruppen, nehmen wir es mit in unserer Liste auf.
            </li>
            <li>
                Wenn ihr ein Projekt abgeschlossen habt, dürft ihr euch im Anschluss auch gerne ein weiteres aus der
                Liste auswählen.
            </li>
        </ul>

        <h3>Bannerlauf</h3>
        <ul>
            <li>
                Jede Gruppe meldet sich für eines der 5 Banner an. Es gibt ein Wölflings-, ein Jungpfadfinder-, ein
                Pfadfinder-, ein Rover- und ein Lilienbanner. Schaut einfach welches am besten zur Altersstruktur eurer
                Gruppe passt.
            </li>
            <li>
                Das Lilienbanner dürft ihr wählen, wenn ihr euch in keinem der anderen Banner wiederfindet. Falls ihr
                eine Gruppe bestehend aus nur Leitern seid, könnte dieses am besten zu Euch passen.
            </li>
            <li>
                Euch erreicht das Banner der ersten Partnergruppe innerhalb eines festen Zeitraums, den euch das
                Trotzdem ’13 Team nach Aktionsbeginn mitteilt. Ihr habt dann ca. 7 bis 14 Tage Zeit das Banner eurer
                zweiten Partnergruppe zu überbringen.
            </li>
            <li>
                Bitte kommuniziert frühzeitig mit euren Partnergruppen wie und wann die Bannerübergaben erfolgen.
            </li>
            <li>
                Die Übergabe und der Transport des Banners soll nachhaltig erfolgen. Seid kreativ!
            </li>
            <li>
                Solange das Banner bei euch ist, dürft ihr euch darauf verewigen. Wie ihr das macht, ist eurer Fantasie
                überlassen. Bedenkt aber, dass Platz für alle Gruppen sein sollte.
            </li>
        </ul>

        <h3>Trotzdem ’13 und Corona</h3>
        <p>
            Leider ist die Entwicklung der Pandemie noch nicht wirklich absehbar und die gesetzlichen Vorgaben ändern
            sich laufend. Welche Regelungen uns als Jugendverband betreffen, findet ihr auf der <a
                href="https://www.bjr.de/service/umgang-mit-corona-virus-sars-cov-2.html">Seite vom BJR</a>.
        </p>
        <p>Wir hoffen, dass ihr möglichst bald viele Aktionen von Angesicht zu Angesicht durchführen könnt.</p>
        <p>Seid kreativ in der Umsetzung, habt Spaß und lasst uns unsere Diözesanaktion trotz(dem13) der Pandemie
            genießen! </p>
        <p>Wir hoffen, dass ihr möglichst bald viele Aktionen von Angesicht zu Angesicht durchführen könnt.</p>
        @if ($showLoginLink)
        <h4>
            Hier geht’s <a href="{{route('app.team.index')}}">zu Dateneingabe</a>
        </h4>
        @endif
    </div>
</x-layout>
