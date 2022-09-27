# Slack downloader

DDD+Hexagonal architektúra példaprojekt

A regisztrált felhasználó egy formon keresztül fel tudja tölteni az egyes slack channel-ökből exportált fájlokat, amelyek Slack Message-eket tartalmaznak.

A ```slackdownloader:image:parse``` command-al ugyan ez érhető el terminálból.

## Bounded Contextek

* **RemoteUser**: A feladata a User tároló menedzselése és authentikálás
* **Audit Log**: Az event bus-ról érkező eseményeket logolja
* **Parser**: Maga a fájl feldolgozó 

## Lokális környezet belövése

### Git clone

Egy tetszőlges mappába klónozzuk ki a projektet:

```asciidoc
git clone git@github.com:ngabesz/slackdownloader.git
```

### Docker build

* **Figyelem!** A docker legújabb verziótját használd! https://docs.docker.com/desktop/install/linux-install/
* Ha lokálisan van apache telepítve, akkor azt állítsd le
* Lépjünk be a /docker mappába
* Terminálban futtassuk: ```bash run.sh```

### .env

* Másold le a ```.env``` fájlt és nevezd át ```.env.local```-ra 
* Vedd ki a következő sorból kommentet ```DATABASE_URL="mysql://slackdownloader:slackdownloader@172.18.0.2/slackdownloader?serverVersion=5.7&charset=utf8mb4"```

### Creating database

* Lépj be a containerbe:
```docker exec -it project_php bash```
* A következő paranccsal hozzuk létre a ```slackdownloader``` adatbázist:
```bin/console doctrine:database:create```
* Hozzuk létre a táblákat: ```bin/console doctrine:update --force```

## Előkészítés
* ```http://localhost:8080``` találod a phpmyadmin
* ```slackdownloader:slackdownloader``` az adatbázis belépési adatai
* A 'user' táblába hozz létre egy user-t
  * A jelszó plaintext!

## Használat
* A ```http://localhost/file/upload``` a főoldal
* Ha nincs belépett felhasználó, akkor a ```http://localhost/login``` felületre ugrunk
* Lépj be a létrehozott user-eddel
* Töltsd fel a ```src/ParserBundle/Tests/Unit/Infrastructure/Shared/Filesystem/fixture/test.json``` file-t
. Ez egy Slack export file minta.
* Ekkor meg kell jellenni egy képnek, ami a fájlban található.

A phpmyadmin-ban, az 'auditlog' táblában fogod látni, milyen események történtek.
A sikeres belépést és a sikeres fájl parszolás van lelogolva.

