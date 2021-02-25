# SimpleSAMLphp als Service Provider

Referent: Frank Tröger (FAU Erlangen-Nürnberg)

Termin: Donnerstag, 25. Februar, 10:00 - 12:00 Uhr

Vor allem für PHP-Anwendungen könnte [SimpleSAMLphp](https://simplesamlphp.org) eine echte Alternative zum Shibboleth
Service Provider (SP) darstellen. Gemeinsam wird SimpleSAMLphp als SP Schritt für Schritt eingerichtet und soll so den
Teilnehmenden eine erste Entscheidungsgrundlage vermitteln, was für oder gegen den Einsatz
von SimpleSAMLphp spricht.

Die Schulung behandelt u.a. folgende Themen:
* die Installation,
* die Einbindung in eine eigene PHP-Anwendung,
* den automatisierten Bezug von Metadaten aus der DFN-AAI-Föderation,
* die Grundlagen der Authentication Processing Filters und
* die abschließenden Vorbereitungen für den produktiven Betrieb.

Nach den Grundlagen können je nach Interesse und verfügbarer Zeit auch weiterführende
Themen wie
* Key Rollover,
* Ausfallsicherheit und Load-Balancing oder
* Bridging
  behandelt werden.
  
## Allgemeines

Die einzelnen Schritte werden beispielhaft anhand des SPs
https://sso-dev.fau.de/devssp/module.php/saml/sp/metadata.php/default-sp
durchgeführt. Jeder Schritt ist in einem eigenen Verzeichnis abgelegt und kann so
als Grundlage für eigene Versuche herangezogen werden. Für die Integration in die
DFN-AAI-(Test)-Föderation ist ein eigener Account nötig. URLs und Zertifikate sollten
durch eigene ersetzt werden.

Umgebung:
* Linux
* [Docker](https://docs.docker.com/)
* Port 80 und 443 frei

Die in den `docker-compose.yml` verwendeten Docker Volumes sind nur für den
einfachen Zugriff auf das Dateisystem während der Schulung nötig und können bei eigenen
Versuchen entfernt werden.

Ablage Zertifikate / Schlüssel:
```bash
find /opt/simplesamlphp_sp/
/opt/simplesamlphp_sp/
/opt/simplesamlphp_sp/sso-dev.fau.de.crt
/opt/simplesamlphp_sp/sso-dev.fau.de.pem
/opt/simplesamlphp_sp/dfn-aai.pem
```

Das jeweilige `Dockerfile` kann auch als Schritt für Schritt Anleitung für ein Ubuntu 20.04 verwendet werden.

## Schulung

Links:
* [SimpleSAMLphp Dokumentation](https://simplesamlphp.org/docs/stable/)
* [DFN-AAI](https://doku.tid.dfn.de/)
