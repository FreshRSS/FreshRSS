* [English version](README.md)

# FreshRSS
FreshRSS est un agrégateur de flux RSS à auto-héberger à l’image de [Leed](http://projet.idleman.fr/leed/) ou de [Kriss Feed](http://tontof.net/kriss/feed/).

Il se veut léger et facile à prendre en main tout en étant un outil puissant et paramétrable.

Il permet de gérer plusieurs utilisateurs, et dispose d’un mode de lecture anonyme.
Il supporte [PubSubHubbub](https://code.google.com/p/pubsubhubbub/) pour des notifications instantanées depuis les sites compatibles.

* Site officiel : http://freshrss.org
* Démo : http://demo.freshrss.org/
* Licence : [GNU AGPL 3](http://www.gnu.org/licenses/agpl-3.0.html)

![Logo de FreshRSS](./doc/FreshRSS-logo.png)

# Téléchargement
Voir la [liste des versions](../../releases).

## Note sur les branches
**Ce logiciel est en développement permanent !** Veuillez vous assurer d'utiliser la branche qui vous correspond :

* Utilisez [la branche master](https://github.com/FreshRSS/FreshRSS/tree/master/) si vous visez la stabilité.
* Pour les développeurs et ceux qui veulent aider à tester les toutes dernières fonctionnalités, [la branche dev](https://github.com/FreshRSS/FreshRSS/tree/dev) vous ouvre les bras !

# Avertissements
Cette application a été développée pour s’adapter principalement à des besoins personnels, et aucune garantie n'est fournie.
Les demandes de fonctionnalités, rapports de bugs, et autres contributions sont les bienvenues. Privilégiez pour cela des [demandes sur GitHub](https://github.com/FreshRSS/FreshRSS/issues).
Nous sommes une communauté amicale.

# Prérequis
* Serveur modeste, par exemple sous Linux ou Windows
	* Fonctionne même sur un Raspberry Pi 1 avec des temps de réponse < 1s (testé sur 150 flux, 22k articles)
* Serveur Web Apache2 (recommandé), ou nginx, lighttpd (non testé sur les autres)
* PHP 5.3.3+ (PHP 5.4+ recommandé, et PHP 5.5+ pour les performances, et PHP 7+ pour d’encore meilleures performances)
	* Requis : [DOM](http://php.net/dom), [XML](http://php.net/xml), [PDO_MySQL](http://php.net/pdo-mysql) ou [PDO_SQLite](http://php.net/pdo-sqlite) ou [PDO_PGSQL](http://php.net/pdo-pgsql), [cURL](http://php.net/curl)
	* Recommandés : [JSON](http://php.net/json), [GMP](http://php.net/gmp) (pour accès API sur plateformes < 64 bits), [IDN](http://php.net/intl.idn) (pour les noms de domaines internationalisés), [mbstring](http://php.net/mbstring) et/ou [iconv](http://php.net/iconv) (pour conversion d’encodages), [Zip](http://php.net/zip) (pour import/export), [zlib](http://php.net/zlib) (pour les flux compressés)
* MySQL 5.5.3+ (recommandé), ou SQLite 3.7.4+, ou PostgreSQL (experimental)
* Un navigateur Web récent tel Firefox, Internet Explorer 11 / Edge, Chrome, Opera, Safari.
	* Fonctionne aussi sur mobile

![Capture d’écran de FreshRSS](./doc/FreshRSS-screenshot.png)

# Installation
1. Récupérez l’application FreshRSS via la commande git ou [en téléchargeant l’archive](../releases)
2. Placez l’application sur votre serveur (la partie à exposer au Web est le répertoire `./p/`)
3. Le serveur Web doit avoir les droits d’écriture dans le répertoire `./data/`
4. Accédez à FreshRSS à travers votre navigateur Web et suivez les instructions d’installation
5. Tout devrait fonctionner :) En cas de problème, n’hésitez pas à me contacter.
6. Des paramètres de configuration avancée peuvent être accédés depuis [config.php](./data/config.default.php).

## Installation automatisée
* [![DP deploy](https://raw.githubusercontent.com/DFabric/DPlatform-ShellCore/gh-pages/img/deploy.png)](https://dfabric.github.io/DPlatform-ShellCore)
* [YunoHost](https://github.com/YunoHost-Apps/freshrss_ynh)

## Exemple d’installation complète sur Linux Debian/Ubuntu
```sh
# Si vous utilisez le serveur Web Apache (sinon il faut un autre serveur Web)
sudo apt-get install apache2
sudo a2enmod headers expires rewrite ssl	#Modules Apache

# Pour Ubuntu <= 15.10, Debian <= 8 Jessie
sudo apt-get install php5 php5-curl php5-gmp php5-intl php5-json php5-sqlite
sudo apt-get install libapache2-mod-php5	#Pour Apache
sudo apt-get install mysql-server mysql-client php5-mysql	#Base de données MySQL optionnelle
sudo apt-get install postgresql php5-pgsql	#Base de données PostgreSQL optionnelle

# Pour Ubuntu >= 16.04, Debian >= 9 Stretch
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
# Mettre les droits d’accès pour le serveur Web
cd FreshRSS
sudo chown -R :www-data .
sudo chmod -R g+w ./data/
# Publier FreshRSS dans votre répertoire HTML public
sudo ln -s /usr/share/FreshRSS/p /var/www/html/FreshRSS
# Naviguez vers http://example.net/FreshRSS pour terminer l’installation.
# (Si vous le faite depuis localhost, vous pourrez avoir à ajuster le réglage de votre adresse publique)

# Mettre à jour FreshRSS vers une nouvelle version
cd /usr/share/FreshRSS
sudo git reset --hard
sudo git pull
sudo chown -R :www-data .
sudo chmod -R g+w ./data/
```

## Contrôle d’accès
Il est requis pour le mode multi-utilisateur, et recommandé dans tous les cas, de limiter l’accès à votre FreshRSS. Au choix :
* En utilisant l’identification par formulaire (requiert JavaScript, et PHP 5.3.7+ recommandé – fonctionne avec certaines versions de PHP 5.3.3+)
* En utilisant un contrôle d’accès HTTP défini par votre serveur Web
	* Voir par exemple la [documentation d’Apache sur l’authentification](http://httpd.apache.org/docs/trunk/howto/auth.html)
		* Créer dans ce cas un fichier `./p/i/.htaccess` avec un fichier `.htpasswd` correspondant.

# Rafraîchissement automatique des flux
* Vous pouvez ajouter une tâche Cron lançant régulièrement le script d’actualisation automatique des flux.
Consultez la documentation de Cron de votre système d’exploitation ([Debian/Ubuntu](http://doc.ubuntu-fr.org/cron), [Red Hat/Fedora](http://doc.fedora-fr.org/wiki/CRON_:_Configuration_de_t%C3%A2ches_automatis%C3%A9es), [Slackware](http://docs.slackware.com/fr:slackbook:process_control?#cron), [Gentoo](http://wiki.gentoo.org/wiki/Cron/fr), [Arch Linux](http://wiki.archlinux.fr/Cron)…).
C’est une bonne idée d’utiliser le même utilisateur que votre serveur Web (souvent “www-data”).
Par exemple, pour exécuter le script toutes les heures :

```
8 * * * * php /votre-chemin/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

### Exemple pour Debian / Ubuntu
Créer `/etc/cron.d/FreshRSS` avec :

```
7,37 * * * * www-data php -f /usr/share/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```


# Conseils
* Pour une meilleure sécurité, faites en sorte que seul le répertoire `./p/` soit accessible depuis le Web, par exemple en faisant pointer un sous-domaine sur le répertoire `./p/`.
	* En particulier, les données personnelles se trouvent dans le répertoire `./data/`.
* Le fichier `./constants.php` définit les chemins d’accès aux répertoires clés de l’application. Si vous les bougez, tout se passe ici.
* En cas de problème, les logs peuvent être utile à lire, soit depuis l’interface de FreshRSS, soit manuellement depuis `./data/log/*.log`.


# Sauvegarde
* Il faut conserver vos fichiers `./data/config.php` ainsi que `./data/*_user.php`
* Vous pouvez exporter votre liste de flux depuis FreshRSS au format OPML
* Pour sauvegarder les articles eux-mêmes, vous pouvez utiliser [phpMyAdmin](http://www.phpmyadmin.net) ou les outils de MySQL :

```bash
mysqldump -u utilisateur -p --databases freshrss > freshrss.sql
```


# Bibliothèques incluses
* [SimplePie](http://simplepie.org/)
* [MINZ](https://github.com/marienfressinaud/MINZ)
* [php-http-304](http://alexandre.alapetite.fr/doc-alex/php-http-304/)
* [jQuery](http://jquery.com/)
* [ArthurHoaro/favicon](https://github.com/ArthurHoaro/favicon)
* [lib_opml](https://github.com/marienfressinaud/lib_opml)
* [jQuery Plugin Sticky-Kit](http://leafo.net/sticky-kit/)
* [keyboard_shortcuts](http://www.openjs.com/scripts/events/keyboard_shortcuts/)
* [flotr2](http://www.humblesoftware.com/flotr2)

## Uniquement pour certaines options
* [bcrypt.js](https://github.com/dcodeIO/bcrypt.js)
* [phpQuery](http://code.google.com/p/phpquery/)

## Si les fonctions natives ne sont pas disponibles
* [Services_JSON](http://pear.php.net/pepr/pepr-proposal-show.php?id=198)
* [password_compat](https://github.com/ircmaxell/password_compat)


# Clients compatibles
Tout client supportant une API de type Google Reader. Sélection :

* Android
	* [News+](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus) avec [News+ Google Reader extension](https://play.google.com/store/apps/details?id=com.noinnion.android.newsplus.extension.google_reader) (Propriétaire)
	* [EasyRSS](https://github.com/Alkarex/EasyRSS) (Libre, F-Droid)
* Linux
	* [FeedReader 2.0+](https://jangernert.github.io/FeedReader/) (Libre)
