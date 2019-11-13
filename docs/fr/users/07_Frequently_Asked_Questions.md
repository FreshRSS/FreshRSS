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

<<<<<<< HEAD
As explained in the [security section](/en/User_documentation/Installation/Security), it's highly recommended to make only the public section available at the domain level. With that configuration, `./p` is the root folder for http://demo.freshrss.org/, thus making `robots.txt` available at the root of the application.
=======
As explained in the [security section](/en/User_documentation/Installation/Security), it is highly recommended to make only the public section available at the domain level. With that configuration, ```./p``` is the root folder for https://demo.freshrss.org/, thus making ```robots.txt``` available at the root of the application.
>>>>>>> 8bdf7b09f208346481cba5e08edc55dfab8c8d63

L'explication est la même pour les fichiers ```favicon.ico``` et
```.htaccess```.

## Pourquoi j'ai des erreurs quand j'essaye d'enregistrer un flux ?

Il peut y avoir différentes origines à ce problème. Le flux peut avoir une
syntaxe invalide, il peut ne pas être reconnu par la bibliothèque SimplePie,
l'hébergement peut avoir des problèmes, FreshRSS peut être boggué. Il faut
dans un premier temps déterminer la cause du problème.Voici la liste des
étapes à suivre pour la déterminer :

1. __Verify if the feed syntax is valid__ with the [W3C on-line
   tool](https://validator.w3.org/feed/ "RSS and Atom feed validator"). If
   it's not valid, there's nothing we can do.
1. __Verify SimplePie validation__ with the [SimplePie on-line
   tool](https://simplepie.org/demo/ "SimplePie official demo"). If it's not
   recognized, there's nothing we can do.
1. __Verify FreshRSS integration__ with the [demo](https://demo.freshrss.org
   "FreshRSS official demo"). If it's not working, you need to [create an
   issue on Github](https://github.com/FreshRSS/FreshRSS/issues/new "Create
   an issue for FreshRSS") so we can have a look at it. If it's working,
   there's probably something fishy with the hosting server.

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

## Pourquoi y a-t-il une page blanche lorsque je configure les options de partage ?

Le mot `sharing` dans l'URL est un mot déclencheur pour certaines règles des
bloqueurs de publicités. À partir de la version 1.16, `sharing` a été
remplacé par `integration` dans l'URL posant problème tout en conservant
exactement la même dénomination à travers l'application.

Si vous utilisez une version antérieure à 1.16, vous pouvez désactiver votre
bloqueur de publicité pour FreshRSS ou vous pouvez ajouter une règle pour
permettre la consultation de la page de configuration « partage ».

Exemples avec _uBlock_ :

- Ajoutez votre instance FreshRSS à la liste blanche de en l'ajoutant dans
  _uBlock > Ouvrir le tableau de bord > Liste blanche_.
- Autorisez votre instance FreshRSS à appeler la page de configuration
  `sharing` en ajoutant la règle `*sharing,domain=~votredomaine.com` dans
  _uBlock > Ouvrir le fichier tableau de bord > Mes filtres_
