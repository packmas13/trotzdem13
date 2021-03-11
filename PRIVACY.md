**Infrastruktur**
- Webhost: Hetzner (Cloud Server CX11 in Nürnberg)
- CMS: Kein (selbstgemachte Homepage mit PHP+Laravel)
- Protokoll: HTTPS

**Logs**
- Server logs (nginx) für 14 Tage (IP + User-Agent)


**Cookies (alle nur mit https)**
- `trotzdem13_session`: technische "Session" (max 2 Stunden)
- `*****` (zufällige Ziffern): technische "Session" (max 2 Stunden)
- `XSRF-TOKEN`: Sicherheit gegen Cross-Site-Request-Forgery (max 2 Stunde)
- `remember_web_*` Nur für eingeloggten Nutzer, zur automatischen Erkennung (5 Jahre) - gelöscht beim Abmelden

**Eingegebene Nutzerdaten**
- Vor- und Nachname
- E-Mail
- Passwort (wird verschlüsselt gespeichert)

**Gruppe**
- GPS-Koordinaten für die Teilnahme
- Kontaktdaten für Banner-Weitergabe

**Externe Dienstleister**
- Besucher-Statistik ohne Cookie mit Plausible.io (https://plausible.io/data-policy)
- Custom fonts mit Google Fonts (https://fonts.google.com/about)
- Geographische Karte mit Mapbox (https://www.mapbox.com/legal/privacy)
