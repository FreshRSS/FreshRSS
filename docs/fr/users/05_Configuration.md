
# Personnaliser la vue

## Langue

À l’heure actuelle, FreshRSS est disponible en 13 langues. Après validation
de ce choix, l’interface sera affichée dans la langue choisie, même si
certaines parties de l’interface peuvent ne pas encore avoir été
traduites. Si vous voulez aider à la traduction, regardez comment vous
pouvez [contribuer au
projet](../contributing.md#contribute-to-internationalization-i18n).

Il y a des parties de FreshRSS qui ne sont pas traduites et qui n’ont pas
vocation à l’être. Pour le moment, les logs visibles dans l’application
ainsi que celle générées par le script de mise à jour automatique en font
partie.

Les langues disponibles sont : cz, de, en, es, fr, he, it, ko, nl, oc,
pt-br, ru, tr, zh-cn.

## Thème

Les goûts et les couleurs, ça ne se discute pas. c’est pourquoi FreshRSS
propose huit thèmes officiels :

* *Blue Lagoon* par **Mister aiR**
* *Dark* par **AD**
* *Flat design* par **Marien Fressinaud**
* *Origine* par **Marien Fressinaud**
* *Origine-compact* par **Kevin Papst**
* *Pafat* par **Plopoyop**
* *Screwdriver* par **Mister aiR**
* *Swage* par **Patrick Crandol**

Si aucun de ceux proposés ne convient, il est toujours possible de [créer
son propre thème](../developers/04_Frontend/02_Design.md).

Pour sélectionner un thème, il suffit de faire défiler les thèmes jusqu’à
l’apparition du thème choisi. Après validation, le thème sera appliqué à
l’interface.

## Largeur du contenu

Il y en a qui préfère des lignes de texte courtes, d’autres qui préfèrent
maximiser l’espace disponible sur l’écran. Pour satisfaire le maximum de
personne, il est possible de choisir la largeur du contenu affiché. Il y a
quatre réglages disponibles :

* **Fine** qui affiche le contenu jusqu’à 550 pixels
* **Moyenne** qui affiche le contenu jusqu’à 800 pixels
* **Large** qui affiche le contenu jusqu’à 1000 pixels
* **Pas de limite** qui affiche le contenu sur 100% de la place disponible

## Icônes d’article

Veuillez noter que cette section n’affecte que la vue normale.

![Configuration des icônes
d’article](../img/users/configuration.article.icons.png)

Chaque article est rendu avec un en-tête (ligne supérieure) et un pied de
page (ligne inférieure). Dans cette section, vous pouvez choisir ce qui sera
affiché dans ceux-ci.

Si vous désactivez tous les éléments de la ligne supérieure, vous pourrez
toujours les voir, puisqu’il contient le nom du flux et le titre de
l’article. Mais si vous faites le même chose pour la ligne inférieure, elle
sera vide.

## Temps d’affichage de la notification HTML5

Après la mise à jour automatique des flux, FreshRSS utilise l’API de
notification de HTML5 pour avertir de l’arrivée de nouveaux articles.

Il est possible de régler la durée d’affichage de cette notification. Par
défaut, la valeur est 0.

## Show the navigation button

By default, FreshRSS displays buttons to ease the article navigation when
browsing on mobile. The drawback is that they eat up some precious space.

![navigation button
configuration](../img/users/configuration.navigation.button.png)

If you do not use those buttons because you never browse on mobile or because
you browse with gestures, you can disable them from the interface.

# Reading

> **À FAIRE**

# Archivage

> **À FAIRE**

# Partage

Pour vous faciliter la vie, vous pouvez partager des articles directement
via FreshRSS.

At the moment, FreshRSS supports 18 sharing methods, ranging from
self-hosted services (Shaarli, etc.) to proprietary services (Facebook,
etc.).

By default, the sharing list is empty.  ![Sharing
configuration](../img/users/configuration.sharing.png)

Pour ajouter un nouvel élément à la liste, veuillez suivre les étapes
simples ci-dessous :

1. Select the desired sharing method in the drop-down list.
1. Press the ```✚``` button to add it to the list.
1. Configure the method in the list. All names can be modified in the
	display. Some methods need the sharing URL to be able to work properly
	(ex: Shaarli).
1. Submit your changes.

To remove an item from the list, follow those simple steps:

1. Press the ```❌``` button next to the share method you want to remove.
1. Submit your changes.

# Raccourcis

To ease the use of the application, FreshRSS comes with a lot of predefined
keyboard shortcuts.  They allow actions to improve the user experience with
a keyboard.

Of course, if you’re not satisfied with the key mapping, you can change you
configuration to fit your needs.

There are 4 types of shortcuts:

1. Views: they allow switching views with ease.
1. Navigation: they allow navigation through articles, feeds, and
	categories.
1. Article actions: they allow interactions with an article, like sharing
	or opening it on the original web-site.
1. Other actions: they allow other interactions with the application, like
	opening the user queries menu or accessing the documentation.

It’s worth noting that the share article action has two levels. Once you
press the shortcut, a menu containing all the share options opens.  To
choose one share option, you need to select it by its number. When there is
only one option, it’s selected automatically though.

The same process applies to the user queries.

Be aware that there is no validation on the selected shortcuts.  This means
that if you assign a shortcut to more than one action, you will end up with
some unexpected behavior.

# User queries

You can configure your [user queries](./03_Main_view.md) in that
section. There is not much to say here as it is pretty straightforward.  You
can only change user query titles or drop them.

At the moment, there is no helper to build a user query from here.

# Users

> **À FAIRE**

## Authentication methods

### HTTP Authentication (Apache)

1. User control is based on the `.htaccess` file.
2. It is best practice to place the `.htaccess` file in the `./i/`
	subdirectory so the API and other third party services can work.
3. If you want to limit all access to registered users only, place the file
	in the FreshRSS directory itself or in a parent directory. Note that
	WebSub and API will not work!
4. Example `.htaccess` file for a user "marie":

```apache
AuthUserFile /home/marie/repertoire/.htpasswd
AuthGroupFile /dev/null
AuthName "Chez Marie"
AuthType Basic
Require user marie
```

Plus d’informations dans [la documentation
d’Apache.](http://httpd.apache.org/docs/trunk/howto/auth.html#gettingitworking)

# Gestion des flux

## Informations

> **À FAIRE**

## Archivage des flux

> **À FAIRE**

## Identification

> **À FAIRE**

## Avancé

### Récupérer un flux tronqué à partir de FreshRSS

La question revient régulièrement, je vais essayer de clarifier ici comment
on peut récupérer un flux RSS tronqué avec FreshRSS. Sachez avant tout que
la manière de s’y prendre n’est absolument pas "user friendly", mais elle
fonctionne. :)

Sachez aussi que par cette manière vous générez beaucoup plus de trafic vers
les sites d’origines et qu’ils peuvent vous bloquer par conséquent. Les
performances de FreshRSS sont aussi moins bonnes car vous devez alors aller
chercher le contenu des articles un par un. c’est donc une fonctionnalité à
utiliser avec parcimonie !

Ce que j’entends par "Chemin CSS des articles sur le site d’origine"
correspond en fait au "chemin" constitué par les IDs et les classes (en
html, correspond aux attributs id et class) pour récupérer uniquement la
partie intéressante qui correspond à l’article. L’idéal est que ce chemin
commence par un id (qui est unique pour la page).

#### Exemple : Rue89

Pour trouver ce chemin, il faut se rendre à l’adresse d’un des articles tronqués.
Il faut alors chercher le "bloc" HTML correspondant au contenu de l’article
(dans le code source !)

On trouve ici que le bloc qui englobe uniquement le contenu de l’article est ```<div class="content clearfix">```. On ne va garder que la classe `.content` ici. Néanmoins, comme je le disais plus haut, il est préférable de commencer le chemin avec un id. Si on remonte au bloc parent, il s’agit du bloc ```<div id="article">``` et c’est parfait ! Le chemin sera donc ```#article .content```.

#### Liste de correspondances site → chemin css

* Rue89 : ```#article .content```
* PCINpact : ```#actu_content```
* Lesnumériques : ```article#body div.text.clearfix```
* Phoronix : ```#main .content```

### Récupérer un flux tronqué à l’aide d’outils externes

Des outils complémentaires peuvent être utilisés pour récupérer le contenu
complet d’un article, comme :

* [RSS-Bridge](https://github.com/RSS-Bridge/rss-bridge)
* [Full-Text RSS](https://bitbucket.org/fivefilters/full-text-rss)
