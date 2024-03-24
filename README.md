# museumAvontuur

Plugin: museum avontuur plugin
Datum: 24-03-2024

In het kort:
Een wordpress plugin waar mee ik mij museum bezoeken kan bewaren en tonen op felis.nl

Uitleg:
In maart 24 ben ik me een aantal anderen begonnen 4 a 5 musea op een zaterdag te bezoeken. Ik wilde dit niet voorbij laten gaan en besloot dit te fotograferen. In ieder museum maak ik een aantal fotos (met mijn panasonic camera, beter van kwaliteit dan mijn telefoon). Ik neem ook een poppetje mee die op een aantal fotos terug komt. Een soort rode draad. De eigenlijke ontwikkeling is gedaan door Chat- gtp
Het is een wordpress login, bestaat uit 2 files.
- museum.php
- museum.js
Museum.php maakt een extra entry museumbezoeken in het wp dashboard. Een museumbezoek in een eigen post type. Chat heeft dit uitgewerkt. 


Invoer beschikbaar:
Bericht titel: Naam van het museum, wordt bij de weergave gebruikt
Tekst vak (de content): wordt getoont. Hou dit kort en grappig. Verschijnt in de uiteindelijke post
Datum bezoek: bezoek datum
Museum Website: invoerveld waar link naar de site van het museum kan worden geplaats


Gebruik in WP:
Upload de php en js file in een plugin dir:
- museum
  - museum.php
  - museum.js

activeer de plugin en gebruik de invoer

Weergave van de postst
maak een nieuwe pagina in oxygen. Maak minimaal een section en zet daar een easypost in.
maak de volgende aanpassingen in de easypost:

Maak een customquery
- posttype: museum_reviews (als de plugin goed geinstalleerd is dan maakt oxygen een dropdownlist waar deze te kiezen is)
- filtering: het idee is een pagina per datum. Kies hier dan de datum om op te filteren

vul Template.php met de inhoud van template.txt
vul template.css met de inhoud van css.txt
