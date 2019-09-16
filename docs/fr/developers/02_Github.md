# Remonter un problème ou une suggestion

Malgré le soin apporté à FreshRSS, il se peut que des bugs apparaissent encore. Le projet est jeune et le développement dynamique, aussi celui-ci pourra être corrigé rapidement. Il se peut aussi que vous ayez en tête une fonctionnalité qui n'existe pas encore. Que celle-ci vous paraisse idiote, farfelue, inutile ou trop spécifique, il ne faut surtout pas hésiter à nous la proposer ! Très souvent des "idées en l'air" ont trouvé une oreille attentive. Ce sont les regards externes qui font le plus évoluer le projet.

Si vous êtes convaincus qu'il faut vous faire entendre, voici la marche à suivre.

## Sur GitHub

GitHub est la plate-forme à privilégier pour vos demandes. En effet, cela nous permet de pouvoir discuter à plusieurs sur un problème ou une suggestion et de faire émerger, souvent, des idées nouvelles. Ne négligeons pas cet aspect "social" !

 1. [Rendez-vous sur le gestionnaire de tickets de bugs](https://github.com/FreshRSS/FreshRSS/issues)
 2. Commencez par rechercher si une demande similaire n'a pas déjà été faite. Si oui, n'hésitez pas à ajouter votre voix à la demande.
 3. Si votre demande est nouvelle, [ouvrez un nouveau ticket de bug](https://github.com/FreshRSS/FreshRSS/issues/new)
 4. Rédigez enfin votre demande. Si vous maitrisez l'anglais, c'est la langue à privilégier car cela permet d'ouvrir la discussion à un plus grand nombre de personnes. Sinon, ce n'est pas grave, continuez en français :)
 5. Merci de bien vouloir suivre les quelques conseils donnés plus bas pour faciliter la prise en compte de votre ticket.

## De façon informelle

Tout le monde n'aime pas ou n'utilise pas GitHub pour des raisons aussi diverses que légitimes. C'est pourquoi vous pouvez aussi nous contacter de façon plus informelle.

* Sur [les listes de diffusion](https://freshrss.org/announce-of-the-mailing-lists.html)
* À des évènements / rencontres autour du Logiciel Libre
* Autour d'une bière dans un bar
* Etc.

## Conseils

Voici quelques conseils pour bien présenter votre remontée de bug ou votre suggestion :


* **Faites attention à l'orthographe.** même si ce n'est pas toujours facile, faites votre maximum ;)
* **Donnez un titre explicite à votre demande**, quitte à ce qu'il soit un peu long. Cela nous aide non seulement à comprendre votre demande, mais aussi à retrouver votre ticket plus tard.
* **Une demande = un ticket.** Vous pouvez avoir des tas d'idées mais vous avez peur de spammer le gestionnaire de bugs : ça ne fait rien. Il vaut mieux avoir un peu trop de tickets que trop de demandes dans un seul. On s'occupera de fermer et regrouper les demandes qui le peuvent.
* Si vous remontez un bug, pensez à nous **fournir les logs de FreshRSS** (accessibles dans les dossier ''data/log/'' de FreshRSS) **et PHP** (l'emplacement peut varier selon les distributions, mais pensez à chercher dans ''/var/log/httpd'' ou ''/var/log/apache'').
* Si vous ne trouvez pas les fichiers de logs, précisez-le dans votre ticket afin que nous sachions que vous avez déjà cherché.
* Tous les bugs ne nécessitent pas les logs, mais si vous doutez, mieux vaut nous les fournir. Les logs sont importants et très utiles pour débugguer !
* Il se peut que les logs puissent révéler des informations plus ou moins confidentielles, **faites attention à ne rien divulguer de sensible.**

De plus, face à un bug, je ne peux que vous encourager à suivre le format de message suivant (tiré du [site de Max & Sam](http://sametmax.com/template-de-demande-daide-en-informatique/)) :

----

**Quel est mon objectif ?**

Donnez le contexte général de ce que vous essayiez de faire.

**Qu’est-ce que j’ai essayé de faire ?**

Expliquez pas à pas ce que vous avez fait afin que nous puissions reproduire le bug.

**Quels résultats ai-je obtenus ?**

Le bug : ce que vous voyez qui n'aurez pas dû se passer. Ici vous pouvez fournir les logs.

**Quel était le résultat attendu ?**

Afin que nous comprenions bien où est le problème... au moins selon vous :p

**Quelle est ma situation ?**

Pensez à donner les informations suivantes si vous les connaissez :

 1. Quel navigateur ? Quelle version ?
 2. Quel serveur : Apache, Nginx ? Quelle version ?
 3. Quelle version de PHP ?
 4. Quelle base de données : SQLite, MySQL, MariaDB, PostgreSQL ? Quelle version ?
 5. Quelle distribution sur le serveur ? Et… quelle version ?

----

# Système de branches

**TODO**

# Proposer un patch

**TODO**