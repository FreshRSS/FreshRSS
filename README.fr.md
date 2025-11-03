[![Dons Liberapay](https://img.shields.io/liberapay/receives/FreshRSS.svg?logo=liberapay)](https://liberapay.com/FreshRSS/donate)

* Lire ce document sur [github.com/FreshRSS/FreshRSS/](https://github.com/FreshRSS/FreshRSS/blob/edge/README.md) pour avoir les images et liens corrects.
* [English version](README.md)

# FreshRSS

FreshRSS est un agrégateur de flux RSS à auto-héberger.

Il se veut léger et facile à prendre en main tout en étant un outil puissant et paramétrable, et [traduit](#internationalisation--20-langues-statut-des-traductions) en nombreuses langues.

Il permet de gérer plusieurs utilisateurs, dispose d’un mode de lecture anonyme, et supporte les étiquettes personnalisées.
Il y a une API pour les clients (mobiles), ainsi qu’une [interface en ligne de commande](cli/README.md).

Grâce au standard [WebSub](https://freshrss.github.io/FreshRSS/fr/users/08_PubSubHubbub.html),
FreshRSS est capable de recevoir des notifications push instantanées depuis les sources compatibles, [Friendica](https://friendi.ca), [WordPress](https://wordpress.org/plugins/pubsubhubbub/), Blogger, Medium, etc.

FreshRSS supporte nativement le [moissonnage du Web (Web Scraping)](https://freshrss.github.io/FreshRSS/en/users/11_website_scraping.html) basique,
basé sur [XPath](https://www.w3.org/TR/xpath-10/), pour les sites Web sans flux RSS / Atom.
Supporte aussi les documents JSON.

FreshRSS permet de [repartager des sélections d’articles par HTML, RSS, et OPML](https://freshrss.github.io/FreshRSS/en/users/user_queries.html).

Plusieurs [méthodes de connexion](https://freshrss.github.io/FreshRSS/en/admins/09_AccessControl.html) sont supportées : formulaire Web (avec un mode anonyme), Authentification HTTP (compatible avec proxy), OpenID Connect.

Enfin, FreshRSS permet l’ajout d’[extensions](#extensions) pour encore plus de personnalisation.

* Site officiel : <https://freshrss.org>
* Démo : <https://demo.freshrss.org>
* Licence : [GNU AGPL 3](https://www.gnu.org/licenses/agpl-3.0.fr.html)

![Logo de FreshRSS](docs/img/FreshRSS-logo.png)

## Contributions

Les demandes de fonctionnalités, rapports de bugs, et autres contributions sont les bienvenues. Privilégiez pour cela des [demandes sur GitHub](https://github.com/FreshRSS/FreshRSS/issues).
Nous sommes une communauté amicale.

Pour faciliter les contributions, [l’option suivante](.devcontainer/README.md) est disponible :

[![Ouvrir dans GitHub Codespaces](https://github.com/codespaces/badge.svg)](https://github.com/codespaces/new?hide_repo_select=true&ref=edge&repo=6322699)

## Capture d’écran

![Capture d’écran de FreshRSS](docs/img/FreshRSS-screenshot.png)

## Avertissements

FreshRSS n’est fourni avec aucune garantie.

# [Documentation](https://freshrss.github.io/FreshRSS/fr/)

* La [documentation utilisateurs](https://freshrss.github.io/FreshRSS/fr/users/02_First_steps.html) pour découvrir les fonctionnalités de FreshRSS.
* La [documentation administrateurs](https://freshrss.github.io/FreshRSS/fr/users/01_Installation.html) pour l’installation et la maintenance de FreshRSS.
* La [documentation développeurs](https://freshrss.github.io/FreshRSS/fr/developers/01_First_steps.html) pour savoir comment contribuer et mieux comprendre le code source de FreshRSS.
* Le [guide de contribution](https://freshrss.github.io/FreshRSS/fr/contributing.html) pour nous aider à développer FreshRSS.

## Prérequis

* Un navigateur Web récent tel que Firefox / IceCat, Edge, Chromium / Chrome, Opera, Safari.
	* Fonctionne aussi sur mobile (sauf certaines fonctionnalités)
* Serveur modeste, par exemple sous Linux ou Windows
	* Fonctionne même sur un Raspberry Pi 1 avec des temps de réponse < 1s (testé sur 150 flux, 22k articles)
* Serveur Web Apache2.4+ (recommandé), ou nginx, lighttpd (non testé sur les autres)
* PHP 8.1+
	* Extensions requises : [cURL](https://www.php.net/curl), [DOM](https://www.php.net/dom), [JSON](https://www.php.net/json), [XML](https://www.php.net/xml), [session](https://www.php.net/session), [ctype](https://www.php.net/ctype)
	* Extensions recommandées : [PDO_SQLite](https://www.php.net/pdo-sqlite) (pour l’export/import), [GMP](https://www.php.net/gmp) (pour accès API sur plateformes < 64 bits), [IDN](https://www.php.net/intl.idn) (pour les noms de domaines internationalisés), [mbstring](https://www.php.net/mbstring) (pour le texte Unicode), [iconv](https://www.php.net/iconv) (pour conversion d’encodages), [ZIP](https://www.php.net/zip) (pour import/export), [zlib](https://www.php.net/zlib) (pour les flux compressés)
	* Extension pour base de données : [PDO_PGSQL](https://www.php.net/pdo-pgsql) ou [PDO_SQLite](https://www.php.net/pdo-sqlite) ou [PDO_MySQL](https://www.php.net/pdo-mysql)
* PostgreSQL 10+ ou SQLite ou MariaDB 10.0.5+ ou MySQL 8.0+

# [Installation](https://freshrss.github.io/FreshRSS/fr/users/01_Installation.html)

Si vous préférez que votre FreshRSS soit stable, vous devriez télécharger la dernière version. De nouvelles versions sont publiées tous les 2 ou 3 mois. Voir la [liste des versions](https://github.com/FreshRSS/FreshRSS/releases).

Si vous voulez une publication continue (rolling release) avec les dernières nouveautés, ou bien aider à tester ou développer la future version stable, vous pouvez utiliser [la branche edge](https://github.com/FreshRSS/FreshRSS/tree/edge/).

## Installation automatisée

| | | |
|-|-|-|
| [<img src="https://www.docker.com/wp-content/uploads/2022/03/horizontal-logo-monochromatic-white.png" width="160" alt="Docker" />](./Docker/) | [<img src="https://install-app.yunohost.org/install-with-yunohost.png" width="160" alt="YunoHost" />](https://install-app.yunohost.org/?app=freshrss) | [<img src="https://elest.io/images/logos/deploy-to-elestio-btn.png" width="160" alt="Elestio" />](https://elest.io/open-source/freshrss) |
| [<img src="https://cloudron.io/img/button.svg" width="160" alt="Cloudron" />](https://cloudron.io/button.html?app=org.freshrss.cloudronapp) | [<img src="https://www.pikapods.com/static/run-button-34.svg" width="160" alt="PikaPods" />](https://www.pikapods.com/pods?run=freshrss) | [<img src="https://zeabur.com/button.svg" width="160" alt="Zeabur" />](https://zeabur.com/templates/MD4TRW) |
| [<img src="https://raw.githubusercontent.com/ClawCloud/Run-Template/refs/heads/main/Run-on-ClawCloud.svg" width="160" alt="ClawCloud" />](https://template.run.claw.cloud/?openapp=system-fastdeploy%3FtemplateName%3Dfreshrss) | [<img src="https://assets.hostinger.com/vps/deploy.svg" width="160" alt="Hostinger" />](https://www.hostinger.com/vps/docker-hosting?compose_url=https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/freshrss/docker-compose.yml) | |


## Installation manuelle

1. Récupérez l’application FreshRSS via la commande git ou [en téléchargeant l’archive](../releases)
2. Placez l’application sur votre serveur (la partie à exposer au Web est le répertoire `./p/`)
3. Le serveur Web doit avoir les droits d’écriture dans le répertoire `./data/`
4. Accédez à FreshRSS à travers votre navigateur Web et suivez les instructions d’installation
	* ou utilisez [l’interface en ligne de commande](cli/README.md)
5. Tout devrait fonctionner :) En cas de problème, n’hésitez pas à [nous contacter](https://github.com/FreshRSS/FreshRSS/issues).
6. Des paramètres de configuration avancés peuvent être vus dans [config.default.php](config.default.php) et modifiés dans `data/config.php`.
7. Avec Apache, activer [`AllowEncodedSlashes`](https://httpd.apache.org/docs/trunk/mod/core.html#allowencodedslashes) pour une meilleure compatibilité avec les clients mobiles.

Plus d’informations sur l’installation et la configuration serveur peuvent être trouvées dans [notre documentation](https://freshrss.github.io/FreshRSS/fr/users/01_Installation.html).

## Exemple d’installation complète sur Linux Debian/Ubuntu

```sh
# Si vous utilisez le serveur Web Apache (sinon il faut un autre serveur Web)
sudo apt-get install apache2
sudo a2enmod headers expires rewrite ssl	#Modules Apache

# Exemple pour Ubuntu >= 16.04, Debian >= 9 Stretch
sudo apt install php php-curl php-gmp php-intl php-mbstring php-sqlite3 php-xml php-zip
sudo apt install libapache2-mod-php	#Pour Apache
sudo apt install mysql-server mysql-client php-mysql	#Base de données MySQL optionnelle
sudo apt install postgresql php-pgsql	#Base de données PostgreSQL optionnelle

## Redémarrage du serveur Web
sudo service apache2 restart

# Pour FreshRSS lui-même (git est optionnel si vous déployez manuellement les fichiers d’installation)
cd /usr/share/
sudo apt-get install git
sudo git clone https://github.com/FreshRSS/FreshRSS.git
cd FreshRSS

# La branche par défault “edge” est la celle de la publication continue,
# mais vous pouvez changer de branche pour “latest” si vous préférez les versions stables de FreshRSS
sudo git checkout latest

# Mettre les droits d’accès pour le serveur Web
sudo cli/access-permissions.sh
# Si vous souhaitez permettre les mises à jour par l’interface Web (un peu moins sûr)
sudo chown www-data:www-data -R .

# Publier FreshRSS dans votre répertoire HTML public
[ ! -e "/var/www/html/FreshRSS" ] && sudo ln -s /usr/share/FreshRSS/p /var/www/html/FreshRSS || echo "/var/www/html/FreshRSS existe déjà"
# Naviguez vers http://example.net/FreshRSS pour terminer l’installation
# (Si vous le faite depuis localhost, vous pourrez avoir à ajuster le réglage de votre adresse publique)
# ou utilisez l’interface en ligne de commande

# Mettre à jour FreshRSS vers une nouvelle version par git
cd /usr/share/FreshRSS
sudo git pull
sudo cli/access-permissions.sh
```

Voir la [documentation de la ligne de commande](cli/README.md) pour plus de détails.

## Contrôle d’accès

Il est requis pour le mode multi-utilisateur, et recommandé dans tous les cas, de limiter l’accès à votre FreshRSS. Au choix :

* En utilisant l’identification par formulaire (requiert JavaScript)
* En utilisant un contrôle d’accès HTTP défini par votre serveur Web
	* Voir par exemple la [documentation d’Apache sur l’authentification](https://httpd.apache.org/docs/trunk/howto/auth.html)
		* Créer dans ce cas un fichier `./p/i/.htaccess` avec un fichier `.htpasswd` correspondant.

# Rafraîchissement automatique des flux

* Vous pouvez ajouter une tâche Cron lançant régulièrement le script d’actualisation automatique des flux.
Consultez la documentation de Cron de votre système d’exploitation ([Debian/Ubuntu](https://doc.ubuntu-fr.org/cron), [Red Hat/Fedora](https://doc.fedora-fr.org/wiki/CRON_:_Configuration_de_t%C3%A2ches_automatis%C3%A9es), [Slackware](https://docs.slackware.com/fr:slackbook:process_control?#cron), [Gentoo](https://wiki.gentoo.org/wiki/Cron/fr), [Arch Linux](https://wiki.archlinux.fr/Cron)…).
C’est une bonne idée d’utiliser le même utilisateur que votre serveur Web (souvent “www-data”).
Par exemple, pour exécuter le script toutes les heures :

```text
8 * * * * php /usr/share/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

## Exemple pour Debian / Ubuntu

Créer `/etc/cron.d/FreshRSS` avec :

```text
7,37 * * * * www-data php -f /usr/share/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

# Conseils

* Pour une meilleure sécurité, faites en sorte que seul le répertoire `./p/` soit accessible depuis le Web, par exemple en faisant pointer un sous-domaine sur le répertoire `./p/`.
	* En particulier, les données personnelles se trouvent dans le répertoire `./data/`.
* Le fichier `./constants.php` définit les chemins d’accès aux répertoires clés de l’application. Si vous les bougez, tout se passe ici.
* En cas de problème, les logs peuvent être utile à lire, soit depuis l’interface de FreshRSS, soit manuellement depuis `./data/users/*/log*.txt`.
	* Le répertoire spécial `./data/users/_/` contient la partie des logs partagés par tous les utilisateurs.


# FAQ

* La date et l’heure dans la colonne de droite sont celles déclarées par le flux, pas l’heure à laquelle les articles ont été reçus par FreshRSS, et cette colonne n’est pas utilisée pour le tri.
	* En particulier, lors de l’import d’un nouveau flux, ses articles sont importés en tête de liste.


# Sauvegarde

* Il faut conserver vos fichiers `./data/config.php` ainsi que `./data/users/*/config.php`
* Vous pouvez exporter votre liste de flux au format OPML soit depuis l’interface Web, soit [en ligne de commande](cli/README.md)

Pour sauvegarder les articles eux-mêmes, vous pouvez utiliser la [ligne de commande](cli/README.md) pour exporter votre base de données vers une base de données au format SQLite :

```sh
./cli/export-sqlite-for-user.php --user <username> --filename </path/to/db.sqlite>
```

> Il est impératif que le nom du fichier contenant la base de données ait une extension `sqlite`.
Si ce n’est pas le cas, la commande ne fonctionnera pas correctement.

Vous pouvez encore utiliser la [ligne de commande](cli/README.md) pour importer la base de données au format SQLite dans votre base de données:

```sh
./cli/import-sqlite-for-user.php --user <username> --filename </path/to/db.sqlite>
```

> Encore une fois, il est impératif que le nom du fichier contenant la base de données ait une extension `sqlite`. Si ce n’est pas le cas, la commande ne fonctionnera pas correctement.

Le processus d’import/export à l’aide d’une base de données SQLite est utile quand vous devez :

* exporter complètement les données d’un utilisateur,
* sauvegarder votre service,
* migrer votre service sur un autre serveur,
* changer de type de base de données,
* corriger des erreurs de base de données.

# Extensions

FreshRSS permet l’ajout d’extensions en plus des fonctionnalités natives.
Voir le [dépôt dédié à ces extensions](https://github.com/FreshRSS/Extensions).

# Internationalisation : 20+ langues. Statut des traductions

<translations>
<!-- This section is automatically generated by `./cli/check.translation.php -g` -->

| Langage | Progression | |
| - | - | - |
| Čeština (cs) | ￭￭￭￭￭￭￭￭･･ 85% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fcs+%2F%28TODO%7CDIRTY%29%24%2F) |
| Deutsch (de) | ￭￭￭￭￭￭￭￭￭･ 96% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fde+%2F%28TODO%7CDIRTY%29%24%2F) |
| Ελληνικά (el) | ￭￭￭￭･･････ 40% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fel+%2F%28TODO%7CDIRTY%29%24%2F) |
| English (en) | ￭￭￭￭￭￭￭￭￭￭ 100% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fen+%2F%28TODO%7CDIRTY%29%24%2F) |
| English (United States) (en-US) | ￭￭￭￭￭￭￭￭￭￭ 100% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fen-US+%2F%28TODO%7CDIRTY%29%24%2F) |
| Español (es) | ￭￭￭￭￭￭￭￭･･ 88% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fes+%2F%28TODO%7CDIRTY%29%24%2F) |
| فارسی (fa) | ￭￭￭￭￭￭￭￭￭･ 94% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Ffa+%2F%28TODO%7CDIRTY%29%24%2F) |
| Suomi (fi) | ￭￭￭￭￭￭￭￭￭･ 96% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Ffi+%2F%28TODO%7CDIRTY%29%24%2F) |
| Français (fr) | ￭￭￭￭￭￭￭￭￭￭ 100% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Ffr+%2F%28TODO%7CDIRTY%29%24%2F) |
| עברית (he) | ￭￭￭￭･･････ 44% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fhe+%2F%28TODO%7CDIRTY%29%24%2F) |
| Magyar (hu) | ￭￭￭￭￭￭￭￭￭･ 96% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fhu+%2F%28TODO%7CDIRTY%29%24%2F) |
| Bahasa Indonesia (id) | ￭￭￭￭￭￭￭￭￭･ 93% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fid+%2F%28TODO%7CDIRTY%29%24%2F) |
| Italiano (it) | ￭￭￭￭￭￭￭￭￭･ 97% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fit+%2F%28TODO%7CDIRTY%29%24%2F) |
| 日本語 (ja) | ￭￭￭￭￭￭￭￭￭･ 92% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fja+%2F%28TODO%7CDIRTY%29%24%2F) |
| 한국어 (ko) | ￭￭￭￭￭￭￭￭･･ 85% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fko+%2F%28TODO%7CDIRTY%29%24%2F) |
| Latviešu (lv) | ￭￭￭￭￭￭￭･･･ 79% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Flv+%2F%28TODO%7CDIRTY%29%24%2F) |
| Nederlands (nl) | ￭￭￭￭￭￭￭￭￭･ 96% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fnl+%2F%28TODO%7CDIRTY%29%24%2F) |
| Occitan (oc) | ￭￭￭￭￭￭￭･･･ 78% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Foc+%2F%28TODO%7CDIRTY%29%24%2F) |
| Polski (pl) | ￭￭￭￭￭￭￭￭￭･ 99% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fpl+%2F%28TODO%7CDIRTY%29%24%2F) |
| Português (Brasil) (pt-BR) | ￭￭￭￭￭￭￭￭･･ 85% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fpt-BR+%2F%28TODO%7CDIRTY%29%24%2F) |
| Português (Portugal) (pt-PT) | ￭￭￭￭￭￭￭￭･･ 85% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fpt-PT+%2F%28TODO%7CDIRTY%29%24%2F) |
| Русский (ru) | ￭￭￭￭￭￭￭￭￭￭ 100% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fru+%2F%28TODO%7CDIRTY%29%24%2F) |
| Slovenčina (sk) | ￭￭￭￭￭￭￭￭･･ 85% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fsk+%2F%28TODO%7CDIRTY%29%24%2F) |
| Türkçe (tr) | ￭￭￭￭￭￭￭￭￭･ 93% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Ftr+%2F%28TODO%7CDIRTY%29%24%2F) |
| Українська (uk) | ￭￭￭￭￭￭￭￭￭･ 96% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fuk+%2F%28TODO%7CDIRTY%29%24%2F) |
| 简体中文 (zh-CN) | ￭￭￭￭￭￭￭￭･･ 87% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fzh-CN+%2F%28TODO%7CDIRTY%29%24%2F) |
| 正體中文 (zh-TW) | ￭￭￭￭￭￭￭￭･･ 85% | [contribuer](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS+path%3Aapp%2Fi18n%2Fzh-TW+%2F%28TODO%7CDIRTY%29%24%2F) |

</translations>

# APIs et applications natives

FreshRSS supporte l’accès depuis des applications natives pour Linux, Android, iOS, Windows et macOS, grâce à deux APIs distinctes :
[l’API compatible Google Reader](https://freshrss.github.io/FreshRSS/fr/users/06_Mobile_access.html) (la meilleure),
et [l’API Fever](https://freshrss.github.io/FreshRSS/fr/users/06_Fever_API.html) (moindres fonctionnalités, moins efficace, moins sûre).

| App                                                                                   | Plateforme  | Logiciel libre                                                | Maintenu & Dévelopé    | API              | Mode hors-ligne | Sync rapide | Récupère plus d’articles dans les vues individuelles | Récupère les articles lus | Favoris  | Étiquettes | Podcasts | Gestion des flux |
|:--------------------------------------------------------------------------------------|:-----------:|:-------------------------------------------------------------:|:----------------------:|:----------------:|:-------------:|:---------:|:------------------------------:|:-------------------:|:----------:|:------:|:--------:|:------------:|
| [Readrops](https://github.com/readrops/Readrops)                                      | Android     | [✔️](https://github.com/readrops/Readrops)                    | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐    | ➖                             | ✔️                  | ✔️         | [➖](https://github.com/readrops/Readrops/issues/54) | ➖       | ✔️           |
| [Capy Reader](https://github.com/jocmp/capyreader)                                    | Android     | [✔️](https://github.com/jocmp/capyreader)                     | ✔️✔️                   | GReader          | ✔️            | ⭐⭐      | ✔️							 | ✔️                  | ✔️         | ✔️	| ➖       | ✔️           |
| [FeedMe](https://play.google.com/store/apps/details?id=com.seazon.feedme)             | Android     | [➖](https://github.com/seazon/FeedMe)                        | ✔️✔️                   | GReader          | ✔️            | ⭐⭐      | ➖                             | ➖                  | ✔️         | [✓](https://github.com/seazon/FeedMe/issues/348) | ✔️       | ✔️           |
| [FocusReader](https://play.google.com/store/apps/details?id=allen.town.focus.reader)  | Android     | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐      | ➖                             | ➖                  | ✔️         | ✓     | ✓      | ✔️           |
| [Your News](https://yournews.app/)                                                    | Android, iOS| ➖                                                            | ✔️✔️                   | GReader          | ➖️            | ⭐       | ✔️                             | ✔️                  | ✔️        | ➖     | ➖      | ➖        |
| [Fluent Reader Lite](https://hyliu.me/fluent-reader-lite/)                            | Android, iOS| [✔️](https://github.com/yang991178/fluent-reader-lite)        | ✔️                     | GReader          | ✔️            | ⭐⭐      | ➖                             | ➖                  | ✓         | ➖     | ➖       | ➖           |
| [Read You](https://github.com/Ashinch/ReadYou/)                                       | Android     | [✔️](https://github.com/Ashinch/ReadYou/)                     | [En développement](https://github.com/Ashinch/ReadYou/discussions/542) | GReader | ➖ | [⭐](https://github.com/Ashinch/ReadYou/issues/666) | ➖ | ✔️ | ✔️ | ➖     | ➖       | ✔️           |

| App                                                                                   | Plateforme  | Logiciel libre                                                | Maintenu & Dévelopé    | API              | Mode hors-ligne | Sync rapide | Récupère plus d’articles dans les vues individuelles | Récupère les articles lus | Favoris  | Étiquettes | Podcasts | Gestion des flux |
|:--------------------------------------------------------------------------------------|:-----------:|:-------------------------------------------------------------:|:----------------------:|:----------------:|:-------------:|:---------:|:------------------------------:|:-------------------:|:----------:|:------:|:--------:|:------------:|
| [Fluent Reader](https://hyliu.me/fluent-reader/)                             | Windows, Linux, macOS| [✔️](https://github.com/yang991178/fluent-reader)             | ✔️✔️                   | Fever            | ✔️            | ⭐         | ➖                             | ✔️                  | ✓         | ➖     | ➖       | ➖           |
| [RSS Guard](https://github.com/martinrotter/rssguard)             | Windows, GNU/Linux, macOS, OS/2 | [✔️](https://github.com/martinrotter/rssguard)                | ✔️✔️                   | GReader          | ✔️            | ⭐⭐ | ➖ | ✔️ | ✔️ | ✔️ | ✔️ | ✔️ |
| [NewsFlash](https://gitlab.com/news-flash/news_flash_gtk)                             | GNU/Linux   | [✔️](https://gitlab.com/news-flash/news_flash_gtk)            | ✔️✔️                   | GReader          | ➖            | ⭐⭐        | ➖                           | ✔️                | ✔️       | ✔️    | ➖      | ➖          |
| [Newsboat](https://newsboat.org/)                                       | GNU/Linux, macOS, FreeBSD | [✔️](https://github.com/newsboat/newsboat/)                   | ✔️✔️                   | GReader          | ➖            | ⭐        | ➖                             | ✔️                  | ✔️         | ➖     | ✔️       | ➖           |

| App                                                                                   | Plateforme  | Logiciel libre                                                | Maintenu & Dévelopé    | API              | Mode hors-ligne | Sync rapide | Récupère plus d’articles dans les vues individuelles | Récupère les articles lus | Favoris  | Étiquettes | Podcasts | Gestion des flux |
|:--------------------------------------------------------------------------------------|:-----------:|:-------------------------------------------------------------:|:----------------------:|:----------------:|:-------------:|:---------:|:------------------------------:|:-------------------:|:----------:|:------:|:--------:|:------------:|
| [Vienna RSS](http://www.vienna-rss.com/)                                              | macOS       | [✔️](https://github.com/ViennaRSS/vienna-rss)                 | ✔️✔️                   | GReader          | ❔            | ❔        | ❔                             | ❔                  | ❔         | ❔     | ❔       | ❔           |
| [Readkit](https://apps.apple.com/app/readkit-read-later-rss/id1615798039)             | iOS, macOS  | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐    | ➖                             | ✔️                  | ✔️         | ➖     | ✓       | 💲           |
| [Reeder Classic](https://www.reederapp.com/classic/)                                  | iOS, macOS  | ➖                                                            | ✔️✔️                   | GReader          | ✔️            | ⭐⭐⭐       | ➖                             | ✔️                  | ✔️         | ➖     | ➖       | ✔️           |
| [lire](https://lireapp.com/)                                                          | iOS, macOS  | ➖                                                            | ✔️✔️                   | GReader          | ❔            | ❔        | ❔                             | ❔                  | ❔         | ❔     | ❔       | ❔           |
| [Unread](https://apps.apple.com/app/unread-2/id1363637349)                            | iOS         | ➖                                                            | ✔️✔️                   | Fever            | ✔️            | ❔        | ❔                             | ❔                  | ✔️         | ➖     | ➖       | ➖           |
| [Fiery Feeds](https://apps.apple.com/app/fiery-feeds-rss-reader/id1158763303)         | iOS         | ➖                                                            | ✔️✔️                   | Fever            | ❔            | ❔        | ❔                             | ❔                  | ❔         | ➖     | ➖       | ➖           |
| [Netnewswire](https://ranchero.com/netnewswire/)                                      | iOS, macOS  | [✔️](https://github.com/Ranchero-Software/NetNewsWire)        | En développement        | GReader          | ✔️            | ❔        | ❔                             | ❔                  | ✔️         | ➖     | ❔       | ✔️           |

# Bibliothèques incluses

* [SimplePie](https://simplepie.org/)
* [php-http-304](https://alexandre.alapetite.fr/doc-alex/php-http-304/)
* [lib_opml](https://framagit.org/marienfressinaud/lib_opml)
* [bcrypt.js](https://github.com/dcodeIO/bcrypt.js)
* [PhpGt/CssXPath](https://github.com/PhpGt/CssXPath)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
* [Chart.js](https://www.chartjs.org)

# Crédits additionels

* Basé sur une version modifiée du [framework MINZ](https://framagit.org/marienfressinaud/MINZ)
* Certaines [icônes](https://gitlab.gnome.org/Archive/gnome-icon-theme-symbolic) sont issues du [projet GNOME](https://www.gnome.org/)
* Polices : [*Open Sans*](https://fonts.google.com/specimen/Open+Sans), [*Lato*](https://www.latofonts.com/lato-free-fonts/), [*Spectral*](https://github.com/productiontype/spectral)

# Alternatives

Si FreshRSS ne vous convient pas pour une raison ou pour une autre, voici d’autres solutions à considérer :

* [Kriss Feed](https://tontof.net/kriss/feed/)
* [Leed](https://github.com/LeedRSS/Leed)
* [Et plus…](https://framalibre.org/tags/lecteur-de-flux-rss)
* [Et encore plus…](https://alternativeto.net/software/freshrss/) (mais si vous appréciez FreshRSS, mettez un “j’aime” !)
