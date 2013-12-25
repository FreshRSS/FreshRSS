# FreshRSS
FreshRSS est un agrégateur de flux RSS à auto-héberger à l’image de [Leed](http://projet.idleman.fr/leed/) ou de [Kriss Feed](http://tontof.net/kriss/feed/).
Il se veut léger et facile à prendre en main tout en étant un outil puissant et paramétrable.

* Site officiel : http://freshrss.org
* Démo : http://marienfressinaud.fr/projets/freshrss/
* Développeur : Marien Fressinaud <dev@marienfressinaud.fr>
* Version actuelle : 0.7-beta2
* Date de publication 2014-01-xx
* License [GNU AGPL 3](http://www.gnu.org/licenses/agpl-3.0.html)

![Logo de FreshRSS](http://marienfressinaud.fr/data/images/freshrss/freshrss_title.png)

# Disclaimer
Cette application a été développée pour s’adapter à des besoins personnels et non professionnels.
Je ne garantis en aucun cas la sécurité de celle-ci, ni son bon fonctionnement.
Je m’engage néanmoins à répondre dans la mesure du possible aux demandes d’évolution si celles-ci me semblent justifiées.
Privilégiez pour cela des demandes sur GitHub
(https://github.com/marienfressinaud/FreshRSS/issues) ou par mail (dev@marienfressinaud.fr)

# Pré-requis
* Serveur Apache2 ou Nginx (non testé sur les autres)
* PHP 5.2+ (PHP 5.3.3+ recommandé)
 * Requis : [LibXML](http://php.net/xml), [PCRE](http://php.net/pcre), [cURL](http://php.net/curl), [PDO_MySQL](http://php.net/pdo-mysql)
 * Recommandés : [JSON](http://php.net/json), [zlib](http://php.net/zlib), [mbstring](http://php.net/mbstring), [iconv](http://php.net/iconv)
* MySQL 5.0.3+ (ou SQLite 3.7.4+ à venir)
* Un navigateur Web récent tel Firefox, Chrome, Opera, Safari, Internet Explorer 9+
 * Fonctionne aussi sur mobile

![Capture d’écran de FreshRSS](http://marienfressinaud.fr/data/images/freshrss/freshrss_default-design.png)

# Installation
1. Récupérez l’application FreshRSS via la commande git ou [en téléchargeant l’archive](https://github.com/marienfressinaud/FreshRSS/archive/master.zip)
2. Placez l’application sur votre serveur (la partie à exposer au Web est le répertoire `./public/`)
3. Le serveur Web doit avoir les droits d’écriture dans le répertoire `./data/`
4. Accédez à FreshRSS à travers votre navigateur Web et suivez les instructions d’installation
5. Tout devrait fonctionner :) En cas de problème, n’hésitez pas à me contacter.

# Contrôle d’accès
Il est recommandé de limiter l’accès à votre FreshRSS, soit :
* En utilisant l’identification par [Mozilla Persona](https://login.persona.org/about) incluse dans FreshRSS
* En utilisant un contrôle d’accès défini par votre serveur Web
 * Voir par exemple la [documentation d’Apache sur l’authentification](http://httpd.apache.org/docs/trunk/howto/auth.html)

# Rafraîchissement automatique des flux
* Vous pouvez ajouter une tâche CRON sur le script d’actualisation des flux. Par exemple, pour exécuter le script toutes les heures :
```
7 * * * * php /chemin/vers/freshrss/actualize_script.php >/dev/null 2>&1
```

# Conseils
* Pour une meilleure sécurité, faites en sorte que seul le répertoire `./public` soit accessible depuis le Web, par exemple en faisant pointer un sous-domaine sur le répertoire `./public`.
* Les données personnelles se trouvent dans le répertoire `./data/` (déjà protégé par un .htaccess pour Apache - vérifiez que cela fonctionne -, à protéger vous-même dans le cas d’autres serveurs Web).
* Le fichier `./constants.php` définit les chemins d’accès aux répertoires clés de l’application. Si vous les bougez, tout se passe ici.
* En cas de problème, les logs peuvent être utile à lire, soit depuis l’interface de FreshRSS, soit manuellement depuis `./data/log/*.log`.
