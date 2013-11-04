# FreshRSS
FreshRSS est un agrégateur de flux RSS à auto-héberger à l'image de [Selfoss](http://selfoss.aditu.de/), [TinyTinyRSS](http://tt-rss.org/redmine/projects/tt-rss/wiki), [Leed](http://projet.idleman.fr/leed/) ou encore [Kriss Feed](http://tontof.net/kriss/feed/). Il se veut léger et facile à prendre en main tout en étant un outil puissant et paramétrable.

* Site officiel : http://marienfressinaud.github.io/FreshRSS/
* Démo : http://marienfressinaud.fr/projets/freshrss/
* Développeur : Marien Fressinaud <dev@marienfressinaud.fr>
* Version actuelle : 0.5.1
* Date de publication 2013-10-15
* License AGPL3

![Logo de FreshRSS](http://marienfressinaud.fr/data/images/freshrss/freshrss_title.png)

# Disclaimer
Cette application a été développée pour s'adapter à mes besoins personnels.
Je ne garantis en aucun cas la sécurité de celle-ci, ni son bon fonctionnement
sur un autre serveur que le mien. Je m'engage néanmoins à répondre dans la
mesure du possible aux demandes d'évolution si celles-ci me semblent justifiées.
Privilégiez pour cela des demandes sur GitHub
(https://github.com/marienfressinaud/FreshRSS/issues) ou par mail (dev@marienfressinaud.fr)

# Pré-requis
* Serveur Apache ou Nginx (non testé sur les autres)
* PHP 5.3 (il me faudrait des retours sur d'autres versions antérieures)
 * libxml pour PHP
 * cURL
 * PDO et MySQL
* MySQL (SQLite à venir)
* Un navigateur Web récent tel Firefox, Chrome, Opera, Safari, Internet Explorer 9+
 * Fonctionne aussi sur mobile

![Capture d'écran de FreshRSS](http://marienfressinaud.fr/data/images/freshrss/freshrss_default-design.png)

# Installation
1. Récupérez l'application FreshRSS via la commande git ou [en téléchargeant l'archive](https://github.com/marienfressinaud/FreshRSS/archive/master.zip)
2. Déplacez l'application où vous voulez sur votre serveur (attention, la partie accessible se trouve dans le répertoire `./public`)
3. Accédez à FreshRSS à travers votre navigateur web et suivez les instructions d'installation
4. Tout devrait fonctionner :) En cas de problème, n'hésitez pas à me contacter.

# Sécurité et conseils
1. Pour une meilleure sécurité, faites en sorte que seul le répertoire `./public` soit accessible par le navigateur. Faites pointer un sous-domaine sur le répertoire `./public` par exemple
2. Dans tous les cas, assurez-vous que `./app/configuration/application.ini` ne puisse pas être téléchargé !
3. Le fichier de log peut être utile à lire si vous avez des soucis
4. Le fichier `./public/index.php` défini les chemins d'accès aux répertoires clés de l'application. Si vous les bougez, tout se passe ici.
5. Vous pouvez ajouter une tâche CRON sur le script d'actualisation des flux. Il s'agit d'un script PHP à exécuter avec la commande `php`. Par exemple, pour exécuter le script toutes les heures :
```
7 * * * * php /chemin/vers/freshrss/actualize_script.php >/dev/null 2>&1
```
