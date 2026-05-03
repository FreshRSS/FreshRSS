---
nav_order: 50
redirect_from:
  - /en/users/07_Frequently_Asked_Questions.html
---

# Frequently asked questions

Il est possible que nous n’ayons pas répondu à toutes vos questions dans les
parties précédentes. La FAQ regroupe certaines interrogations qui n’ont pas
trouvé leur réponse ailleurs.

## C’est quoi ce `/i` à la fin de l’URL ?

Bien entendu, le ```/i``` n’est pas là pour faire joli ! Il s’agit d’une
question de performances et de praticité :

* Cela permet de servir les icônes, images, styles, scripts sans
  cookie. Sans cela, ces fichiers seraient souvent re-téléchargés, en
  particulier lorsque le formulaire de connexion est utilisé. De plus, les
  requêtes vers ces ressources seraient plus lourdes.
* La racine publique ```./p/``` peut être servie sans restriction d’accès
  HTTP (qui peut avantageusement être mise en place dans ```./p/i/```).
* Cela permet d’éviter des problèmes pour des fichiers qui doivent être
  publics pour bien fonctionner, comme ```favicon.ico```, ```robots.txt```,
  etc.
* Cela permet aussi d’avoir un logo FreshRSS plutôt qu’une page blanche pour
  accueillir l’utilisateur par exemple dans le cas de la restriction d’accès
  HTTP ou lors de l’attente du chargement plus lourd du reste de
  l’interface.

## Pourquoi le ```robots.txt``` se trouve dans un sous-répertoire ?

Afin d’améliorer la sécurité, FreshRSS est découpé en deux parties : une
partie publique (le répertoire ```./p```) et une partie privée (tout le
reste !). Le ```robots.txt``` se trouve donc dans le sous-répertoire
```./p```.

As explained in the [security section](../admins/access-control.html), it’s
highly recommended to make only the public section available at the domain
level.  With that configuration, `./p` is the root folder for
<https://demo.freshrss.org/>, thus making `robots.txt` available at the root
of the application.

L’explication est la même pour les fichiers ```favicon.ico``` et
```.htaccess```.

## Pourquoi j’ai des erreurs quand j’essaye d’enregistrer un flux ?

Il peut y avoir différentes origines à ce problème. Le flux peut avoir une
syntaxe invalide, il peut ne pas être reconnu par la bibliothèque SimplePie,
l’hébergement peut avoir des problèmes, FreshRSS peut être boggué. Il faut
dans un premier temps déterminer la cause du problème.Voici la liste des
étapes à suivre pour la déterminer :

1. __Vérifier la validité du flux__ grâce à l’[outil en ligne du
   W3C](https://validator.w3.org/feed/ "Validateur en ligne de flux RSS et
   Atom"). Si ça ne fonctionne pas, nous ne pouvons rien faire.
1. __Vérifier la reconnaissance par SimplePie__ grâce à l’[outil en ligne de
   SimplePie](https://simplepie.org/demo/ "Démo officielle de
   SimplePie"). Si ça ne fonctionne pas, nous ne pouvons rien faire.
1. __Vérifier l’intégration dans FreshRSS__ grâce à la
   [démo](https://demo.freshrss.org "Démo officielle de FreshRSS"). Si ça ne
   fonctionne pas, il faut [créer un ticket sur
   GitHub](https://github.com/FreshRSS/FreshRSS/issues/new "Créer un ticket
   pour FreshRSS") pour que l’on puisse regarder ce qui se passe. Si ça
   fonctionne, il y a probablement un problème avec l’hébergement.

## Comment changer un mot de passe oublié ?

Depuis la version
[1.10.0](https://github.com/FreshRSS/FreshRSS/releases/tag/1.10.0),
l’administrateur peut modifier le mot de passe d’un utilisateur depuis
l’interface. Cette interface est disponible dans le menu ```Administration →
Gestion des utilisateurs```. Il suffit de sélectionner l’utilisateur, de
saisir un mot de passe et de valider.

Depuis la version
[1.8.0](https://github.com/FreshRSS/FreshRSS/releases/tag/1.8.0),
l’administrateur peut modifier le mot de passe d’un utilisateur depuis un
terminal. Il est bon de noter que celui-ci doit avoir un accès à PHP en
ligne de commande. Pour cela, il suffit d’ouvrir son terminal et de saisir
la commande suivante :

```sh
./cli/update_user.php --user <username> --password <password>

```

For more information on that matter, please refer to the [dedicated
documentation](https://github.com/FreshRSS/FreshRSS/blob/edge/cli/README.md).

## Gérer les permissions sous SELinux

Some Linux distribution, like Fedora or RedHat Enterprise Linux, have
SELinux enabled. This acts similar to a firewall application, so that
applications can’t write or modify files under certain conditions. While
installing FreshRSS, step 2 can fail if the httpd process can’t write to
some data sub-directories. The following command should be executed as root
to fix this problem:

```sh
semanage fcontext -a -t httpd_sys_rw_content_t '/usr/share/FreshRSS/data(/.*)?'
restorecon -Rv /usr/share/FreshRSS/data
```

## Pourquoi y a-t-il une page blanche lorsque je configure les options de partage ?

Le mot `sharing` dans l’URL est un mot déclencheur pour certaines règles des
bloqueurs de publicités. À partir de la version 1.16, `sharing` a été
remplacé par `integration` dans l’URL posant problème tout en conservant
exactement la même dénomination à travers l’application.

Si vous utilisez une version antérieure à 1.16, vous pouvez désactiver votre
bloqueur de publicité pour FreshRSS ou vous pouvez ajouter une règle pour
permettre la consultation de la page de configuration « partage ».

Exemples avec _uBlock_ :

* Ajoutez votre instance FreshRSS à la liste blanche de en l’ajoutant dans
  _uBlock > Ouvrir le tableau de bord > Liste blanche_.
* Autorisez votre instance FreshRSS à appeler la page de configuration
  `sharing` en ajoutant la règle `*sharing,domain=~votredomaine.com` dans
  _uBlock > Ouvrir le fichier tableau de bord > Mes filtres_

## Problems with firewalls

If you have the error "Blast! This feed has encountered a problem. Please
verify that it is always reachable then update it.", it might be because of
a firewall misconfiguration.

To identify the problem, here are the steps to follow:

* step 1: Try to reach the feed locally to discard a problem with the feed
  itself. You can use your browser to this purpose.
* step 2: Try to reach the feed from the host in which FreshRSS is
  installed. Something like `time curl -v
  'https://github.com/FreshRSS/FreshRSS/commits/edge.atom'` should make the
  deal. If you are running FreshRSS within a Docker container, then you can
  check connectivity from within the container itself with something similar
  to `sudo docker exec freshrss php -r
  "readfile('https://github.com/FreshRSS/FreshRSS/commits/edge.atom');"`. If
  none of this works, then it might be a problem with your firewall.

Then to fix it, you need to do check your firewall configuration and ensure
that you are not blocking connections to IPs and/or ports in which your
feeds are located. If using iptables and you are blocking inbound
connections to ports 80/443, check that the rules are properly configured
and you are not also blocking outbound connections to the very same ports.

For example, when using the firewall provided by Synology, you can block
traffic for certain applications (i.e., ports). One could think that these
rules would be applied only to incoming connections but specifying * for the
originating host of the requests will also include your local networks. To
deal with this issue, you will have to add exceptions for your local
networks to be able to access those ports with a higher priority than the
one blocking incoming connections. This could be similar for other frontends
to iptables. Please check the following discussion about a [similar
issue](https://www.reddit.com/r/synology/comments/8fo2sj/ds918_firewall_blocking_outgoing_traffic_from/).
