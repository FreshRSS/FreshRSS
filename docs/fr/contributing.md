## Rejoignez-nous sur les listes de mailing

S'il vous manque des informations, n'hésitez pas à fouiller un peu la
documentation ou venir nous poser directement vos questions sur [la mailing
list des développeurs](https://freshrss.org/mailman/listinfo/dev).

* Le premier mailing est destiné à l'information générique, il doit être
  adapté aux utilisateurs. [Rejoignez
  mailing@freshrss.org](https://freshrss.org/mailman/listinfo/mailing).
* Le deuxième mailing s'adresse principalement aux développeurs. [Rejoignez
  dev@freshrss.org](https://freshrss.org/mailman/listinfo/dev)

## Signaler un bug

Avez-vous trouvé un bogue ? Ne paniquez pas, voici quelques étapes pour le
signaler facilement :

1. Cherche sur [le bug tracker](https://github.com/FreshRSS/FreshRSS/issues)
   (n'oubliez pas d'utiliser la barre de recherche).
2. Si vous constatez un bogue similaire, n'hésitez pas à poster un
   commentaire pour ajouter de l'importance au ticket correspondant.
3. Si vous ne l'avez pas trouvé, [ouvrez un nouveau
   ticket](https://github.com/FreshRSS/FreshRSS/issues/new).

Si vous devez créer un nouveau ticket, essayez de garder les conseils
suivants :

* Donnez un titre explicite au ticket pour le retrouver plus facilement plus
  tard.
* Soyez aussi exhaustif que possible dans la description : qu'avez-vous fait
  ? Quel est le bogue ? Quelles sont les étapes pour reproduire le bogue ?

Nous avons aussi besoin de quelques informations :

* Votre version de FreshRSS (sur la page A propos) ou le fichier
  `constants.php`)
* Votre configuration de serveur : type d'hébergement, version PHP
* Quelle base de données : SQLite, MySQL, MariaDB, PostgreSQL ? Quelle
  version ?
* Si possible, les logs associés (logs PHP et logs FreshRSS sous
  `data/users/your_user/log.txt`)

## Corriger un bogue

Voulez-vous corriger un bogue ? Pour maintenir une grande coordination entre
les collaborateurs, vous devrez suivre ces indications :

1. Assurez-vous que le bogue est associé à un ticket et indiquez que vous
   allez travailler sur le bogue.
2. [Fork du répertoire de
   projet](https://help.github.com/articles/fork-a-repo/).
3. [Créez une nouvelle
   branche](https://help.github.com/articles/creating-and-deleting-branches-within-your-repository/).
   Le nom de la branche doit être clair, et idéalement préfixé par
   l'identifiant du ticket correspondant. Par exemple,
   `783-contributing-file` pour réparer [ticket
   #783](https://github.com/FreshRSS/FreshRSS/issues/783).
4. Apportez vos modifications à votre fork et [envoyez une demande de
   pull](https://help.github.com/articles/using-pull-requests/) sur la
   branche **dev**.

Si vous devez écrire du code, veuillez suivre [nos recommandations de style
de codage](developers/01_First_steps.md).

**Conseil : **si vous cherchez des bugs faciles à corriger, jetez un coup d'oeil à la vignette "[good first issue](https://github.com/FreshRSS/FreshRSS/issues?q=is%3Aopen+is%3Aissue+label%3A%22good+first+issue%22)".

## Soumettre une idée

Vous avez de bonnes idées, oui ! Ne soyez pas timide et ouvrez [un nouveau
ticket](https://github.com/FreshRSS/FreshRSS/issues/new) sur notre tracker
bogue pour nous demander si nous pouvons le mettre en œuvre. Les plus
grandes idées viennent souvent des suggestions les plus timides !

Si votre idée est bonne, nous y jetterons un coup d'oeil.

## Contribuer à l'internationalisation (i18n)

Si vous voulez améliorer l'internationalisation, ouvrez d'abord un nouveau
ticket et suivez les conseils de la section *Fixer un bogue*.

Les traductions sont disponibles dans les sous-répertoires de `./app/i18n/`.

Nous travaillons sur une meilleure façon de gérer l'internationalisation
mais n'hésitez pas à nous suggérer des idées !

## Contribuer à la documentation

Il ne vous aura pas échappé que la documentation est encore un peu vide… il
y a énormément de choses à faire ! Si vous souhaitez aider à écrire quelques
pages, rendez-vous dans les principaux dépôts[fichier
docs](https://github.com/FreshRSS/FreshRSS/tree/master/docs) !
