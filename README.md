# museumAvontuur

Plugin: museum avontuur plugin
Datum: 24-03-2024

In het kort:
Een wordpress plugin waar mee ik mij museum bezoeken kan bewaren en tonen op felis.nl

Uitleg:
In maart 24 ben ik me een aantal anderen begonnen 4 a 5 musea op een zaterdag te bezoeken. Ik wilde dit niet voorbij laten gaan en besloot dit te fotograferen. In ieder museum maak ik een aantal fotos (met mijn Panasonic camera, beter van kwaliteit dan mijn telefoon). Ik neem ook een poppetje mee die op een aantal fotos terug komt. Een soort rode draad. 

Het is een wordpress plugin, bestaat uit 2 files.
- museum.php
- museum.js
Museum.php maakt een extra entry museumbezoeken in het wp dashboard. Een museumbezoek in een eigen post type. Chat heeft dit uitgewerkt. De eigenlijke ontwikkeling van de plugin is gedaan met/door Chat- gtp

Het is sorteerbaar op tags. Ik heb dit gebruikt om te sorteren op datum en maak een pagina per datum. Kan ook op iedere andere manier gebruikt worden.


Invoer beschikbaar:
Bericht titel: Naam van het museum, wordt bij de weergave gebruikt
Tekst vak (de content): wordt getoont. Hou dit kort en grappig. Verschijnt in de uiteindelijke post
Datum bezoek: bezoek datum
Museum Website: invoerveld waar link naar de site van het museum kan worden geplaats. Wordt klikable bij tonen
Google maps link: copieer de google map url en plaats die hier. wordt ook klikable
achtergrondkleur (hexcode): geef hier de achtergrond kleur per musuem op, dit is puur optisch voor de weergave

Voeg afbeeldigen toe:
klik en selecteer alle afbeeldingen (in de wordpress mediabox) die je bij het museum wilt hebben. Geen edit mogelijkheid, iets fout gedaan? Gewoon de knop klikken en opnieuw proberen. De fotos worden als tumbnails zichtbaar na klikken update.
Tags: enige nut is sorteren (bijvoorbeeld om per pagina te groeperen). Dit kan in de query van de easypost bij oxigen gefilterd worden.


Gebruik in WP:
Upload de php en js file in een plugin dir:
- museum
  - museum.php
  - museum.js

activeer de plugin en gebruik de invoer

Weergave van de postst
maak een nieuwe pagina in oxygen. Maak minimaal een section en zet daar een easypost in. Enige aanpassing van de query is padding 0. Verder regelt de plugn alles. Ook responsiviteit.

Maak de volgende aanpassingen in de easypost:

Maak een customquery
- posttype: museum_reviews (als de plugin goed geinstalleerd is dan maakt oxygen een dropdownlist waar deze te kiezen is)
- filtering: het idee is een pagina per datum. Kies hier dan de datum om op te filteren

vul Template.php met de inhoud van template.txt
vul template.css met de inhoud van css.txt
