# Idee – objektorientiere Geometrie
## Auftrag
Es sollte ein Projekt erarbeitet werden, welches im Modul objektorientierte Geometrie vorgeführt werden kann.

## Ausgangslage
Jedes Jahr findet im März der Engadin Skimarathon statt. Traditionellerweise bin auch ich immer im Engadin und um den Kollegen einen Tracker zur Verfügung zu stellen, soll eine Website entwickelt werden.

## Ziel
Um genauer zu wissen wo die Teilnehmer gerade sind und wann sie wo ankommen, möchte ich eine Website erstellen. Auf dieser Website soll der Streckenplan des Engadin Skimarathon abgebildet sein und mit Punkten anzeigen, wo sich die Läufer befinden.

## Problem
Die Streckenkarte sieht wie folgt aus. 
![Streckenplan](http://www.engadin-skimarathon.ch/typo3temp/_processed_/csm_Verpflegungsplan_180104_f6a059dd45.jpg)
Norden ist also nicht am oberen Rand der Karte, sondern gedreht. Somit können die GPS Koordinaten nicht einfach als Punkte eingefügt werden.

## Projekt
Mithilfe von Javascript soll die Drehung der Karte herausgefunden werden. Zudem müssen ebenfalls alle empfangenen Koordinaten gedreht und auf der Karte abgebildet werden.
