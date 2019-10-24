Il est possible que nous n'ayons pas répondu à toutes vos questions dans les
parties précédentes. La FAQ regroupe certaines interrogations qui n'ont pas
trouvé leur réponse ailleurs.

## C'est quoi ce `/i` à la fin de l'URL ?

Bien entendu, le ```/i``` n'est pas là pour faire joli ! Il s'agit d'une
question de performances et de praticité :

* Cela permet de servir les icônes, images, styles, scripts sans
  cookie. Sans cela, ces fichiers seraient souvent re-téléchargés, en
  particulier lorsque le formulaire de connexion est utilisé. De plus, les
  requêtes vers ces ressources seraient plus lourdes.
* La racine publique ```./p/``` peut être servie sans restriction d'accès
  HTTP (qui peut avantageusement être mise en place dans ```./p/i/```).
* Cela permet d'éviter des problèmes pour des fichiers qui doivent être
  publics pour bien fonctionner, comme ```favicon.ico```, ```robots.txt```,
  etc.
* Cela permet aussi d'avoir un logo FreshRSS plutôt qu'une page blanche pour
  accueillir l'utilisateur par exemple dans le cas de la restriction d'accès
  HTTP ou lors de l'attente du chargement plus lourd du reste de
  l'interface.

## Pourquoi le ```robots.txt``` se trouve dans un sous-répertoire ?

Afin d'améliorer la sécurité, FreshRSS est découpé en deux parties : une
partie publique (le répertoire ```./p```) et une partie privée (tout le
reste !). Le ```robots.txt``` se trouve donc dans le sous-répertoire
```./p```.

Comme expliqué dans les [conseils de
sécurité](01_Installation.md#conseils-de-securite), il est recommandé de
faire pointer un nom de domaine vers ce sous-répertoire afin que seule la
partie publique ne soit accessible par un navigateur web. De cette manière
http://demo.freshrss.org/ pointe vers le répertoire ```./p``` et le
```robots.txt``` se trouve bien à la racine du site :
http://demo.freshrss.org/robots.txt.

L'explication est la même pour les fichiers ```favicon.ico``` et
```.htaccess```.

## Pourquoi j'ai des erreurs quand j'essaye d'enregistrer un flux ?

Il peut y avoir différentes origines à ce problème. Le flux peut avoir une
syntaxe invalide, il peut ne pas être reconnu par la bibliothèque SimplePie,
l'hébergement peut avoir des problèmes, FreshRSS peut être boggué. Il faut
dans un premier temps déterminer la cause du problème.Voici la liste des
étapes à suivre pour la déterminer :

1. __Vérifier la validité du flux__ grâce à l'[outil en ligne du
   W3C](http://validator.w3.org/feed/ "Validateur en ligne de flux RSS et
   Atom"). Si ça ne fonctionne pas, nous ne pouvons rien faire.
1. __Vérifier la reconnaissance par SimplePie__ grâce à l'[outil en ligne de
   SimplePie](http://simplepie.org/demo/ "Démo officielle de SimplePie"). Si
   ça ne fonctionne pas, nous ne pouvons rien faire.
1. __Vérifier l'intégration dans FreshRSS__ grâce à la
   [démo](http://demo.freshrss.org "Démo officielle de FreshRSS"). Si ça ne
   fonctionne pas, il faut [créer un ticket sur
   Github](https://github.com/FreshRSS/FreshRSS/issues/new "Créer un ticket
   pour FreshRSS") pour que l'on puisse regarder ce qui se passe. Si ça
   fonctionne, il y a probablement un problème avec l'hébergement.

Voici une liste des flux qui ne fonctionnent pas :

* http://foulab.org/fr/rss/Foulab_News : ne passe pas la validation W3C
  (novembre 2014)
* http://eu.battle.net/hearthstone/fr/feed/news : ne passe pas la validation
  W3C (novembre 2014)
* http://webseriesmag.blogs.liberation.fr/we/atom.xml : ne fonctionne pas
  chez l'utilisateur mais passe l'ensemble des validations ci-dessus
  (novembre 2014)

## Comment changer un mot de passe oublié ?

Depuis la version
[1.10.0](https://github.com/FreshRSS/FreshRSS/releases/tag/1.10.0),
l'administrateur peut modifier le mot de passe d'un utilisateur depuis
l'interface. Cette interface est disponible dans le menu ```Administration →
Gestion des utilisateurs```. Il suffit de sélectionner l'utilisateur, de
saisir un mot de passe et de valider.

Depuis la version
[1.8.0](https://github.com/FreshRSS/FreshRSS/releases/tag/1.8.0),
l'administrateur peut modifier le mot de passe d'un utilisateur depuis un
terminal. Il est bon de noter que celui-ci doit avoir un accès à PHP en
ligne de commande. Pour cela, il suffit d'ouvrir son terminal et de saisir
la commande suivante :
```sh
./cli/update_user.php --user <username> --password <password>

```
Pour plus d'information à ce sujet, il existe la [documentation
dédiée](../../cli/README.md).

## Gérer les permissions sous SELinux

Certaines distributions Linux comme Fedora ou RedHat Enterprise Linux (RHEL)
activent par défaut le système SELinux. Celui-ci permet de gérer des
permissions au niveau des processus. Lors de l'installation de FreshRSS,
l'étape 2 procède à la vérification des droits sur certains répertoires, il
faut donc exécuter la commande suivante en tant que root:
```sh
semanage fcontext -a -t httpd_sys_rw_content_t '/usr/share/FreshRSS/data(/.*)?'
restorecon -Rv /usr/share/FreshRSS/data
```
