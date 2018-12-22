# Personnaliser la vue

##Langue
À l'heure actuelle, FreshRSS est disponible en 13 langues. Après validation de ce choix, l'interface sera affichée dans la langue choisie, même si certaines parties de l'interface peuvent ne pas encore avoir été traduites. Si vous voulez aider à la traduction, regardez comment vous pouvez [contribuer au projet](../contributing.md#contribute-to-internationalization-i18n).

Il y a des parties de FreshRSS qui ne sont pas traduites et qui n'ont pas vocation à l'être. Pour le moment, les logs visibles dans l'application ainsi que celle générées par le script de mise à jour automatique en font partie.

Les langues disponibles sont : cz, de, en, es, fr, he, it, kr, nl, oc, pt-br, ru, tr, zh-cn.

##Thème
Les goûts et les couleurs, ça ne se discute pas. C'est pourquoi FreshRSS propose huit thèmes officiels :

 * *Blue Lagoon* par **Mister aiR**
 * *Dark* par **AD**
 * *Flat design* par **Marien Fressinaud**
 * *Origine* par **Marien Fressinaud**
 * *Origine-compact* par **Kevin Papst**
 * *Pafat* par **Plopoyop**
 * *Screwdriver* par **Mister aiR**
 * *Swage* par **Patrick Crandol**

Si aucun de ceux proposés ne convient, il est toujours possible de [créer son propre thème](../developers/04_Frontend/02_Design.md).

Pour sélectionner un thème, il suffit de faire défiler les thèmes jusqu'à l'apparition du thème choisi. Après validation, le thème sera appliqué à l'interface.

##Largeur du contenu
Il y en a qui préfère des lignes de texte courtes, d'autres qui préfèrent maximiser l'espace disponible sur l'écran. Pour satisfaire le maximum de personne, il est possible de choisir la largeur du contenu affiché. Il y a quatre réglages disponibles :

 * **Fine** qui affiche le contenu jusqu'à 550 pixels
 * **Moyenne** qui affiche le contenu jusqu'à 800 pixels
 * **Large** qui affiche le contenu jusqu'à 1000 pixels
 * **Pas de limite** qui affiche le contenu sur 100% de la place disponible

##Icônes d'article

**TODO**

##Temps d'affichage de la notification HTML5
Après la mise à jour automatique des flux, FreshRSS utilise l'API de notification de HTML5 pour avertir de l'arrivée de nouveaux articles.

Il est possible de régler la durée d'affichage de cette notification. Par défaut, la valeur est 0.

# Options de lecture

**TODO**

# Archivage

**TODO**

# Partage

**TODO**

# Raccourcis

**TODO**

# Filtres

**TODO**

# Utilisateurs

**TODO**

## Méthodes d'authentification

**Brouillon**

### Authentification HTTP

 1.  Ne laisse rien de visible
 2.  Pour Apache, basé sur un fichier .htaccess
    - Exemple de .htaccess pour un utilisateur "marie" à placer dans le répertoire de FreshRSS ou dans un répertoire parent :

```
AuthUserFile /home/marie/repertoire/.htpasswd
AuthGroupFile /dev/null
AuthName "Chez Marie"
AuthType Basic
Require user marie
```

Plus d'informations dans [la documentation d'Apache.](http://httpd.apache.org/docs/trunk/howto/auth.html#gettingitworking)


# Gestion des flux

## Informations

**TODO**

## Archivage

**TODO**

## Identification

**TODO**

## Avancé

### Récupérer un flux tronqué à partir de FreshRSS

La question revient régulièrement, je vais essayer de clarifier ici comment on peut récupérer un flux RSS tronqué avec FreshRSS. Sachez avant tout que la manière de s'y prendre n'est absolument pas "user friendly", mais elle fonctionne :)

Sachez aussi que par cette manière vous générez beaucoup plus de trafic vers les sites d'origines et qu'ils peuvent vous bloquer par conséquent. Les performances de FreshRSS sont aussi moins bonnes car vous devez alors aller chercher le contenu des articles un par un. C'est donc une fonctionnalité à utiliser avec parcimonie !

Ce que j'entends par "Chemin CSS des articles sur le site d’origine" correspond en fait au "chemin" constitué par les IDs et les classes (en html, correspond aux attributs id et class) pour récupérer uniquement la partie intéressante qui correspond à l'article. L'idéal est que ce chemin commence par un id (qui est unique pour la page)

#### Exemple 1 : Rue89

Pour trouver ce chemin, il faut se rendre à l'adresse d'un des articles tronqués (par exemple http://www.rue89.com/2013/10/15/prof-maths-jai-atteint-lextase-dihn-pedagogie-inversee-246635). Il faut alors chercher le "bloc" HTML correspondant au contenu de l'article (dans le code source !)

On trouve ici que le bloc qui englobe uniquement le contenu de l'article est ```<div class="content clearfix">```. On ne va garder que la classe .content ici. Néanmoins, comme je le disais plus haut, il est préférable de commencer le chemin avec un id. Si on remonte au bloc parent, il s'agit du bloc ```<div id="article">``` et c'est parfait ! Le chemin sera donc ```#article .content```

#### Liste de correspondances site -> chemin css

*  Rue89 : ```#article .content```
*  PCINpact : ```#actu_content```
*  Lesnumériques : ```article#body div.text.clearfix```
*  Phoronix : ```#main .content```

### Récupérer un flux tronqué à l'aide d'outils externes

Des outils complémentaires peuvent être utilisés pour récupérer le contenu complet d'un article, comme :

* [RSS-Bridge](https://github.com/RSS-Bridge/rss-bridge)
* [Full-Text RSS](https://bitbucket.org/fivefilters/full-text-rss)
