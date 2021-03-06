# Tabellen

## user
- user_id
- name (Display-Name)
- email (auch als Benutzername verwendet)
- email_verified_at
- password
- profile_photo_path
- role (Vorerst nur "Moderator" fürs Orga-Team)

## team
- team_id
- name
- created_at
- leader_id
- stamm_id
- size
- coordinates (Adresse des Pfadfinderheims für Routen-Berechnung)
- radius (Aktionsradius: nah, mittel, fern)
- logo_path
- code (Für Beitritt von Team-Mitgliedern)

## team_member
- user_id
- team_id

## team_stufe (Verknüpfungstabelle, weil ein Team evtl. aus mehreren Stufen bestehen kann)
- team_id
- stufe

## stamm
- stamm_id (Nami-Nummer)
- name

## challenge
- challenge_id
- title
- description
- image_path
- team_id (für Vorschläge von Teams)
- submitted_at
- published_at
- deleted_at

## banner
- banner_id
- title
- color

## banner_story
- team_id
- banner_id
- start_at
- end_at
- arrived_at (nur ausgefüllt, wenn das Banner angekommen ist)

## post
- post_id
- banner_id
- team_id
- title
- text
- image_path
- coordinates
- submitted_at
- published_at
- deleted_at
