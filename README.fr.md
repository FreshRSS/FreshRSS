* [English version](README.md)

# FreshRSS
FreshRSS est un agrégateur de flux RSS à auto-héberger à l’image de [Leed](http://projet.idleman.fr/leed/) ou de [Kriss Feed](http://tontof.net/kriss/feed/).

Il se veut léger et facile à prendre en main tout en étant un outil puissant et paramétrable.

Il permet de gérer plusieurs utilisateurs, et dispose d’un mode de lecture anonyme.

* Site officiel : http://freshrss.org
* Démo : http://demo.freshrss.org/
* Développeur : Marien Fressinaud <dev@marienfressinaud.fr>
* Version actuelle : 0.8.1
* Date de publication : 2014-10-09
* License [GNU AGPL 3](http://www.gnu.org/licenses/agpl-3.0.html)

![Logo de FreshRSS](http://marienfressinaud.fr/data/images/freshrss/freshrss_title.png)

# Note sur les branches
**Ce logiciel est encore en développement !** Veuillez vous assurer d'utiliser la branche qui vous correspond :

* Utilisez [la branche master](https://github.com/marienfressinaud/FreshRSS/tree/master/) si vous visez la stabilité.
* [La branche beta](https://github.com/marienfressinaud/FreshRSS/tree/beta) est celle par défaut : les nouveautés y sont ajoutées environ tous les mois.
* Pour les développeurs et ceux qui savent ce qu'ils font, [la branche dev](https://github.com/marienfressinaud/FreshRSS/tree/dev) vous ouvre les bras !

# Disclaimer
Cette application a été développée pour s’adapter à des besoins personnels et non professionnels.
Je ne garantis en aucun cas la sécurité de celle-ci, ni son bon fonctionnement.
Je m’engage néanmoins à répondre dans la mesure du possible aux demandes d’évolution si celles-ci me semblent justifiées.
Privilégiez pour cela des demandes sur GitHub
(https://github.com/marienfressinaud/FreshRSS/issues) ou par mail (dev@marienfressinaud.fr)

# Pré-requis
* Serveur modeste, par exemple sous Linux ou Windows
	* Fonctionne même sur un Raspberry Pi avec des temps de réponse < 1s (testé sur 150 flux, 22k articles, soit 32Mo de données partiellement compressées)
* Serveur Web Apache2 (recommandé), ou nginx, lighttpd (non testé sur les autres)
* PHP 5.2.1+ (PHP 5.3.7+ recommandé)
	* Requis : [PDO_MySQL](http://php.net/pdo-mysql) ou [PDO_SQLite](http://php.net/pdo-sqlite), [cURL](http://php.net/curl), [GMP](http://php.net/gmp) (seulement pour accès API sur platformes < 64 bits)
	* Recommandés : [JSON](http://php.net/json), [mbstring](http://php.net/mbstring), [zlib](http://php.net/zlib), [Zip](http://php.net/zip)
* MySQL 5.0.3+ (recommandé) ou SQLite 3.7.4+
* Un navigateur Web récent tel Firefox 4+, Chrome, Opera, Safari, Internet Explorer 9+
	* Fonctionne aussi sur mobile

![Capture d’écran de FreshRSS](http://marienfressinaud.fr/data/images/freshrss/freshrss_default-design.png)

# Installation
1. Récupérez l’application FreshRSS via la commande git ou [en téléchargeant l’archive](https://github.com/marienfressinaud/FreshRSS/archive/master.zip)
2. Placez l’application sur votre serveur (la partie à exposer au Web est le répertoire `./p/`)
3. Le serveur Web doit avoir les droits d’écriture dans le répertoire `./data/`
4. Accédez à FreshRSS à travers votre navigateur Web et suivez les instructions d’installation
5. Tout devrait fonctionner :) En cas de problème, n’hésitez pas à me contacter.

# Contrôle d’accès
Il est requis pour le mode multi-utilisateur, et recommandé dans tous les cas, de limiter l’accès à votre FreshRSS. Au choix :
* En utilisant l’identification par formulaire (requiert JavaScript, et PHP 5.3.7+ recommandé – fonctionne avec certaines versions de PHP 5.3.3+)
* En utilisant l’identification par [Mozilla Persona](https://login.persona.org/about) incluse dans FreshRSS
* En utilisant un contrôle d’accès HTTP défini par votre serveur Web
	* Voir par exemple la [documentation d’Apache sur l’authentification](http://httpd.apache.org/docs/trunk/howto/auth.html)
		* Créer dans ce cas un fichier `./p/i/.htaccess` avec un fichier `.htpasswd` correspondant.

# Rafraîchissement automatique des flux
* Vous pouvez ajouter une tâche Cron lançant régulièrement le script d’actualisation automatique des flux.
Consultez la documentation de Cron de votre système d’exploitation ([Debian/Ubuntu](http://doc.ubuntu-fr.org/cron), [Red Hat/Fedora](http://doc.fedora-fr.org/wiki/CRON_:_Configuration_de_t%C3%A2ches_automatis%C3%A9es), [Slackware](http://docs.slackware.com/fr:slackbook:process_control?#cron), [Gentoo](http://wiki.gentoo.org/wiki/Cron/fr), [Arch Linux](http://wiki.archlinux.fr/Cron)…).
C’est une bonne idée d’utiliser le même utilisateur que votre serveur Web (souvent “www-data”).
Par exemple, pour exécuter le script toutes les heures :

```
7 * * * * php /chemin/vers/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

# Conseils
* Pour une meilleure sécurité, faites en sorte que seul le répertoire `./p/` soit accessible depuis le Web, par exemple en faisant pointer un sous-domaine sur le répertoire `./p/`.
	* En particulier, les données personnelles se trouvent dans le répertoire `./data/`.
* Le fichier `./constants.php` définit les chemins d’accès aux répertoires clés de l’application. Si vous les bougez, tout se passe ici.
* En cas de problème, les logs peuvent être utile à lire, soit depuis l’interface de FreshRSS, soit manuellement depuis `./data/log/*.log`.

# Sauvegarde
* Il faut conserver vos fichiers `./data/config.php` ainsi que `./data/*_user.php` et éventuellement `./data/persona/`
* Vous pouvez exporter votre liste de flux depuis FreshRSS au format OPML
* Pour sauvegarder les articles eux-même, vous pouvez utiliser [phpMyAdmin](http://www.phpmyadmin.net) ou les outils de MySQL :

```bash
mysqldump -u utilisateur -p --databases freshrss > freshrss.sql
```


# Bibliothèques incluses
* [SimplePie](http://simplepie.org/)
* [MINZ](https://github.com/marienfressinaud/MINZ)
* [php-http-304](http://alexandre.alapetite.fr/doc-alex/php-http-304/)
* [jQuery](http://jquery.com/)
* [keyboard_shortcuts](http://www.openjs.com/scripts/events/keyboard_shortcuts/)
* [flotr2](http://www.humblesoftware.com/flotr2)

## Uniquement pour certaines options
* [bcrypt.js](https://github.com/dcodeIO/bcrypt.js)
* [phpQuery](http://code.google.com/p/phpquery/)

## Si les fonctions natives ne sont pas disponibles
* [Services_JSON](http://pear.php.net/pepr/pepr-proposal-show.php?id=198)
* [password_compat](https://github.com/ircmaxell/password_compat)
