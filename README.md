# FreshRSS
FreshRSS est un agrégateur de flux RSS à auto-héberger à l'image de [RSSLounge](http://rsslounge.aditu.de/), [TinyTinyRSS](http://tt-rss.org/redmine/projects/tt-rss/wiki) ou [Leed](http://projet.idleman.fr/leed/). Il se veut léger et facile à prendre en main tout en étant un outil puissant et paramétrable. L'objectif étant d'offrir une alternative sérieuse à Google Reader.

* Site officiel : http://marienfressinaud.github.io/FreshRSS/
* Démo : http://marienfressinaud.fr/projets/freshrss/
* Développeur : Marien Fressinaud <dev@marienfressinaud.fr>
* Version actuelle : 0.4.0
* Date de publication 2013-07-02
* License AGPL3

![Capture d'écran de FreshRSS](http://marienfressinaud.fr/data/files/wiki_freshrss/freshrss_normal_view.png)

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
0 * * * * php /chemin/vers/freshrss/actualize_script.php >/dev/null 2>&1
```
