# SimpleSAMLphp als Service Provider

Dieses Repository entstand bei der Durchführung einer Schulung über Service Provider bei der
[DFN-AAI](https://www.aai.dfn.de/) im Februar 2021. Ziel war das Kennenlernen der
Software [SimpleSAMLphp](https://simplesamlphp.org/) als Service Provider in der DFN-AAI-Föderation.

## Aktualisierung auf SimpleSAMLphp 2.3.x
Aktuelle Version: **2.3.5**

## Aktualisierung auf SimpleSAMLphp 2.0.x
Die Original-Schulungsunterlagen beziehen sich auf SimpleSAMLphp 1.19 und sind weiterhin im Branch
[simplesamlphp-1.19](https://github.com/frnktrgr/demo_simplesamlphp_sp/tree/simplesamlphp-1.19) verfügbar.

## Schulung

### Abstract
Referent: Frank Tröger (FAU Erlangen-Nürnberg)

Termin: Donnerstag, 25. Februar, 10:00 - 12:00 Uhr

Vor allem für PHP-Anwendungen könnte SimpleSAMLphp eine echte Alternative zum Shibboleth
Service Provider (SP) darstellen. Gemeinsam wird SimpleSAMLphp als SP Schritt für Schritt eingerichtet und soll so den
Teilnehmenden eine erste Entscheidungsgrundlage vermitteln, was für oder gegen den Einsatz
von SimpleSAMLphp spricht.

Die Schulung behandelt u.a. folgende Themen:
* die Installation,
* die Einbindung in eine eigene PHP-Anwendung,
* den automatisierten Bezug von Metadaten aus der DFN-AAI-Föderation,
* die Grundlagen der Authentication Processing Filters und
* die abschließenden Vorbereitungen für den produktiven Betrieb.

### [01 Voraussetzungen](01_voraussetzungen)
### [02 Installation](02_installation)
### [03 Konfiguration](03_konfiguration)
### [04 Service Provider](04_serviceprovider)
### [05 Einbindung in eine eigene PHP-Anwendung](05_integration)
### [06 Metadaten aus der DFN-AAI-Föderation](06_metarefresh)
### [07 Grundlagen der Authentication Processing Filters](07_authproc)
### [08 Vorbereitungen für den produktiven Betrieb](08_production)
### [09 Extras](09_extras)
  
## Allgemeines

Die einzelnen Schritte werden beispielhaft anhand des SPs
https://sso-dev.fau.de/devssp/module.php/saml/sp/metadata.php/default-sp
durchgeführt. Jeder Schritt ist in einem eigenen Verzeichnis abgelegt und kann so
als Grundlage für eigene Versuche herangezogen werden. Für die Integration in die
DFN-AAI-(Test)-Föderation ist ein eigener Account nötig. URLs und Zertifikate sollten
durch eigene ersetzt werden.

## Testumgebung mit Docker
### Voraussetzungen
* Linux
* [Docker](https://docs.docker.com/)
* Port 80 und 443 frei

Die in den `compose.yaml` verwendeten Docker Volumes sind nur für den
einfachen Zugriff auf das Dateisystem während der Schulung nötig und können bei eigenen
Versuchen entfernt werden.

### Einrichtung der Testumgebung 
Zertifikate und Schlüssel müssen auf dem Hostsystem unter `/opt/simplesamlphp_sp/` abgelegt werden.
```bash
find /opt/simplesamlphp_sp/
/opt/simplesamlphp_sp/
/opt/simplesamlphp_sp/sso-dev.fau.de.crt
/opt/simplesamlphp_sp/sso-dev.fau.de.pem
/opt/simplesamlphp_sp/dfn-aai.pem
```
(`/opt/simplesamlphp_sp/dfn-aai.pem` from https://www.aai.dfn.de/metadata/dfn-aai.pem)

### Testen
Zum Beispiel für [01 Voraussetzungen](01_voraussetzungen):
#### Bauen und Starten
```bash
docker compose -f 01_voraussetzungen/compose.yaml build
docker compose -f 01_voraussetzungen/compose.yaml up -d
```
#### Wechsel in den Container
```bash
docker exec -ti 01_voraussetzungen-sp-1 bash
```
#### Stoppen und Container aufräumen
```bash
docker compose -f 01_voraussetzungen/compose.yaml down
```

## Kein Docker
Das jeweilige `Dockerfile` inklusive der Dateien unter `resources` kann auch als Schritt für Schritt Anleitung für ein Ubuntu 24.04 verwendet werden.

## Links
* [SimpleSAMLphp Dokumentation](https://simplesamlphp.org/docs/stable/)
* [DFN-AAI](https://doku.tid.dfn.de/)
