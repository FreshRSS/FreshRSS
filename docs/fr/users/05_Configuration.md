
# Personnaliser la vue

## Langue

À l'heure actuelle, FreshRSS est disponible en 13 langues. Après validation
de ce choix, l'interface sera affichée dans la langue choisie, même si
certaines parties de l'interface peuvent ne pas encore avoir été
traduites. Si vous voulez aider à la traduction, regardez comment vous
pouvez [contribuer au
projet](../contributing.md#contribute-to-internationalization-i18n).

Il y a des parties de FreshRSS qui ne sont pas traduites et qui n'ont pas
vocation à l'être. Pour le moment, les logs visibles dans l'application
ainsi que celle générées par le script de mise à jour automatique en font
partie.

Les langues disponibles sont : cz, de, en, es, fr, he, it, kr, nl, oc,
pt-br, ru, tr, zh-cn.

## Thème

Les goûts et les couleurs, ça ne se discute pas. C'est pourquoi FreshRSS
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

Pour sélectionner un thème, il suffit de faire défiler les thèmes jusqu'à
l'apparition du thème choisi. Après validation, le thème sera appliqué à
l'interface.

## Largeur du contenu

Il y en a qui préfère des lignes de texte courtes, d'autres qui préfèrent
maximiser l'espace disponible sur l'écran. Pour satisfaire le maximum de
personne, il est possible de choisir la largeur du contenu affiché. Il y a
quatre réglages disponibles :

 * **Fine** qui affiche le contenu jusqu'à 550 pixels
 * **Moyenne** qui affiche le contenu jusqu'à 800 pixels
 * **Large** qui affiche le contenu jusqu'à 1000 pixels
 * **Pas de limite** qui affiche le contenu sur 100% de la place disponible

## Icônes d'article

Veuillez noter que cette section n'affecte que la vue normale.

![Configuration des icônes
d'article](../img/users/configuration.article.icons.png)

Chaque article est rendu avec un en-tête (ligne supérieure) et un pied de
page (ligne inférieure). Dans cette section, vous pouvez choisir ce qui sera
affiché dans ceux-ci.

Si vous désactivez tous les éléments de la ligne supérieure, vous pourrez
toujours les voir, puisqu'il contient le nom du flux et le titre de
l'article. Mais si vous faites le même chose pour la ligne inférieure, elle
sera vide.

## HTML5 notification timout

After the automatic updates of the feeds, FreshRSS uses the HTML5
notification API to notify of the arrival of new articles.

The duration of this notification can be set. By default, the value is 0.

## Show the navigation button

By default, FreshRSS displays buttons to ease the article navigation when
browsing on mobile. The drawback is that they eat up some precious space.

![navigation button
configuration](../img/users/configuration.navigation.button.png)

If you don't use those buttons because you never browse on mobile or because
you browse with gestures, you can disable them from the interface.

# Reading

**TODO**

# Archiving

**TODO**

# Sharing

To make your life easier, you can share directly an article within FreshRSS.

At the moment, FreshRSS supports 15 sharing methods ranging from self-hosted
services (Shaarli, etc.) to proprietary services (Facebook, etc.).

By default, the sharing list is empty.  ![Sharing
configuration](../img/users/configuration.sharing.png)

To add a new item in the list, follow those simple steps:

 1. Select the share method in the drop-down.
 1. Press the ```✚``` sign to add it to the list.
 1. Configure the method in the list. All method names can be modified in
    the display. Some methods need the sharing URL to be able to work
    properly (ex: Shaarli).
 1. Submit your changes.

To remove an item from the list, follow those simple steps:

 1. Press the ```❌``` sign next to the share method you want to remove.
 1. Submit your changes.

# Shortcuts

To ease the use of the application, FreshRSS comes with a lot of predefined
keyboard shortcuts.  They allow actions to improve the user experience with
a keyboard.

Of course, if you're not satisfied with the key mapping, you can change you
configuration to fit your needs.

There are 4 types of shortcuts:

 1. Views: they allow switching views with ease.
 1. Navigation: they allow navigation through articles, feeds, and
    categories.
 1. Article actions: they allow interactions with an article, like sharing
    or opening it on the original web-site.
 1. Other actions: they allow other interactions with the application, like
    opening the user queries menu or accessing the documentation.

It's worth noting that the share article action has two levels. Once you
press the shortcut, a menu containing all the share options opens.  To
choose one share option, you need to select it by its number. When there is
only one option, it's selected automatically though.

The same process applies to the user queries.

Be aware that there is no validation on the selected shortcuts.  This means
that if you assign a shortcut to more than one action, you'll end up with
some unexpected behavior.

# User queries

You can configure your [user queries](./03_Main_view.md) in that
section. There is not much to say here as it is pretty straightforward.  You
can only change user query titles or drop them.

At the moment, there is no helper to build a user query from here.

# Users

**TODO**

## Authentication methods

### HTTP Authentication (Apache)

 1. User control is based on the `.htaccess` file.
 2. It is best practice to place the `.htaccess` file in the `./i/`
    subdirectory so the API and other third party services can work.
 3. If you want to limit all access to registered users only, place the file
    in the FreshRSS directory itself or in a parent directory. Note that
    WebSub and API will not work!
 4. Example `.htaccess` file for a user "marie":

```
AuthUserFile /home/marie/repertoire/.htpasswd

AuthGroupFile /dev/null

AuthName "Chez Marie"

AuthType Basic

Require user marie

```


More information can be found in the [Apache
documentation](http://httpd.apache.org/docs/trunk/howto/auth.html#gettingitworking).

# Subscription management

## Information

**TODO**

## Archivage

**TODO**

## Login

**TODO**

## Advanced

### Retrieve a truncated stream from within FreshRSS

The question comes up regularly, so we will try to clarify here how one can
retrieve a truncated RSS feed with FreshRSS. Please note that the process is
absolutely not "user friendly", but it works :)

Also know that this way you are generating much more traffic to the
originating sites and that they might block you accordingly. The performance
of FreshRSS is also negatively affected because you have to fetch the full
article content one by one. So it's a feature to use sparingly!

What is meant by "CSS path of articles on the original site" actually
corresponds to the "path" consisting of IDs and classes (which in html,
matches the id and class attributes) to retrieve only the interesting part
that corresponds to the article. Ideally, this path starts with an id (which
is unique to the page).

#### Example: Rue89

To find this path, you must go to the address of one of the truncated
articles (for example
http://www.rue89.com/2013/10/15/prof-maths-jai-atteint-lextase-dihn-pedagogie-inversee-246635).
You must then look for the "block" of HTML corresponding to the content of
the article (in the source code!).

We find here that the block that encompasses only the content of the article is ```<div class="content clearfix">```. We will only use the ".content" class here. Nevertheless, as said above, it is best to start the path with an id. If we go back to the parent block, this is the block ```<div id="article">``` and that's perfect! The path will be ```#article .content```.

#### Add the corresponding classes to the articles CSS path on the feed configuration page. Examples:

*  Rue89: ```#article .content```
*  PCINpact: ```#actu_content```
*  Lesnumériques: ```article#body div.text.clearfix```
*  Phoronix : ```#main .content```

### Retrieve a truncated stream with external tools

Complimentary tools can be used to retrieve full article content, such as:

* [RSS-Bridge](https://github.com/RSS-Bridge/rss-bridge)
* [Full-Text RSS](https://bitbucket.org/fivefilters/full-text-rss)
