# Qu’est-ce que WebSub ?

Derrière le nom de [WebSub](https://www.w3.org/TR/websub/) (anciennement [PubSubHubbub](https://github.com/pubsubhubbub/PubSubHubbub)) se cache un protocole qui vient compléter Atom et RSS.
En effet, le fonctionnement de base de ces deux derniers implique de vérifier à intervalles réguliers s’il existe de nouveaux articles sur les sites suivis.
Cela même si le site concerné n’a rien publié depuis la dernière synchronisation.
Le [protocole WebSub](https://www.w3.org/TR/websub/) permet d’éviter des synchronisations inutiles en notifiant en temps réel l’agrégateur de la présence de nouveaux articles.

## Fonctionnement de WebSub

On va retrouver trois notions dans WebSub : **les éditeurs** (les sites qui publient du contenu comme des flux ATOM / RSS), **les abonnés** (les agrégateurs de flux RSS comme FreshRSS), et **les hubs**.

Lorsqu’un agrégateur s’abonne à un site et récupère son flux RSS, il peut y trouver l’adresse d’un hub.
Si c’est le cas — car un site peut ne pas en préciser —, l’agrégateur va s’abonner au hub et non pas à l’éditeur directement.
Ainsi, lorsqu’un éditeur va publier du contenu, il va notifier le hub qui va lui-même notifier et envoyer le contenu à tous ses abonnés.

Pour pouvoir être notifié, les abonnés doivent fournir une adresse accessible publiquement sur Internet.

## Activer WebSub dans FreshRSS

FreshRSS supporte nativement WebSub, mais requiert une addresse publique (lu depuis la configuration `base_url`),
et requiert aussi aussi que le répertoire `./FreshRSS/p/api/` soit accessible publiquement (comme pour les autres APIs de FreshRSS).

Durant l’installation Web initiale, le support de WebSub est activé si le serveur semble avoir une adresse publique.
Dans tous les cas, vérifiez votre `./data/config.php` pour :

```php
'base_url' => 'https://freshrss.example.net/',
'pubsubhubbub_enabled' => true,
```

Des logs supplémentaires relatifs à WebSub sont consultables dans `./FreshRSS/data/users/_/log_pshb.txt`

## Tester la compatibilité WebSub de votre instance FreshRSS

Vous pouvez tester que le support WebSub de votre instance FreshRSS est correct avec un service comme :

* <http://push-tester.cweiske.de>

Quand vous y créez un nouvel article, celui-ci devrait être immédiatement disponible dans votre FreshRSS.

## Tester la compatibilité WebSub d’un flux RSS / ATOM

* <https://test.livewire.io> (pour n’importe quel flux)
* <https://websub.rocks/publisher> (pour les flux que vous contrôlez)

## Exemples de flux utilisant WebSub

Vous pouvez recevoir en temps réel les articles des sites qui affichent dans leur flux RSS un « hub »,
tels [Friendica](https://friendi.ca), WordPress (WordPress.com ou avec [une extension](https://wordpress.org/plugins/pubsubhubbub/)), Blogger, Medium, etc.

## Ajouter WebSub à votre flux RSS / ATOM

Votre CMS (par exemple WordPress) supporte peut-être déjà WebSub en option, comme :

* <https://wordpress.org/plugins/pushpress/>

Sinon, vous pouvez faire une solution qui notifie un hub, comme :

* <https://websubhub.com>
* <https://pubsubhubbub.appspot.com>

Ou encore déployer votre propre hub, comme :

* <https://github.com/flusio/Webubbub>

## Tester la compatibilité WebSub d’un hub

* <https://websub.rocks/hub/100>
