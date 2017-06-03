# Qu'est-ce que PubSubHubbub ?

Derrière ce nom barbare se cache un protocole qui vient compléter Atom et RSS. En effet, le fonctionnement de base de ces deux derniers implique de vérifier à intervalles réguliers s'il existe de nouveaux articles sur les sites suivis. Cela même si le site concerné n'a rien publié depuis la dernière synchronisation. Le protocole PubSubHubbub permet d'éviter des synchronisations inutiles en notifiant en temps réel l'agrégateur de la présence de nouveaux articles.

# Fonctionnement de PubSubHubbub

On va retrouver trois notions dans PubSubHubbub : les éditeurs (les sites qui publient du contenu), les abonnés (les agrégateurs de flux RSS) et les hubs.

Lorsqu'un agrégateur s'abonne à un site et récupère son flux RSS, il peut y trouver l'adresse d'un hub. Si c'est le cas — car un site peut ne pas en préciser —, l'agrégateur va s'abonner au hub et non pas à l'éditeur directement. Ainsi, lorsqu'un éditeur va publier du contenu, il va notifier le hub qui va lui-même notifier et envoyer le contenu à tous ses abonnés.

Pour pouvoir être notifié, les abonnés doivent fournir une adresse accessible publiquement sur Internet.

# PubSubHubbub et FreshRSS

Depuis la version 1.1.2-beta, FreshRSS supporte officiellement PubSubHubbub. Vous pouvez donc recevoir en temps réel les articles des sites qui affichent dans leur flux RSS un « hub ».
