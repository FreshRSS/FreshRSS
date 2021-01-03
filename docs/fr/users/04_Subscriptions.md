# Ajouter un flux

 1. Pour ajouter un flux, copiez le lien vers le fichier RSS ou Atom qui vous intéresse (par exemple, le lien RSS du Framablog est `https://framablog.org/feed/`).
 2. Sur l’interface de FreshRSS, cliquez sur « Gestion des abonnements ».
 3. Collez l’URL du flux dans le champ « Ajouter un flux RSS » juste en dessous du titre.
 4. (facultatif) : Vous pouvez descendre jusqu’à « Catégorie » et sélectionner la catégorie dans laquelle vous souhaitez enregistrer votre flux. Par défaut, le nouveau flux sera dans « Sans catégorie ».

# Import et export
Voir [export/import SQLite]( https://github.com/FreshRSS/FreshRSS/tree/master/cli) pour une alternative.
## Exportation

 1. Pour exporter votre liste d’abonnements, allez dans « Gestion des abonnements ».
 2. Cliquez ensuite sur « Importer / exporter » dans le menu de gauche.
 3. Vous pouvez mettre dans votre export :
    1. la liste des flux
    2. les articles que vous avez étiquetés
    3. les articles que vous avez mis en favoris
    4. et enfin, vous pouvez sélectionner les flux que vous voulez exporter (par défaut tous les flux sont sélectionnés)
 4. Cliquez sur « Exporter ».

 ## Importation
 
  1. Pour importer un fichier d’abonnement vers votre compte FreshRSS, allez dans l’espace « Importer / exporter » comme ci-dessus
  2. Cliquez sur « Parcourir » et sélectionnez votre fichier sur votre ordinateur.
  3. Validez en cliquant sur « Importer ».

> **Important**: vous ne pouvez pas importer directement depuis un fichier texte.
> Vous devez le convertir au format _OPML_ au préalable.
> Voici une liste d’outils que vous pouvez utiliser :
> - [Pandoc](https://pandoc.org/) disponible sur la plus part des systèmes,
> - [OPML generator](https://opml-gen.ovh/) disponible en ligne,
> - [txt2opml](https://alterfiles.com/convert/txt/opml) disponible en ligne.

# Utiliser le « bookmarklet »

Les « bookmarklets » sont de petits scripts que vous pouvez exécuter pour effectuer des tâches diverses et variées. FreshRSS offre un signet « bookmark » pour s’abonner aux fils de nouvelles.

 1. Ouvrez « Gestion des abonnements ».
 2. Cliquez sur « Outils d’abonnement ».
 3. Glissez le bouton « S’abonner » dans la barre d’outils des signets ou
    cliquez droit et choisissez l’action « Lien vers les signets » de votre navigateur.

# Organisation des flux

Vous pouvez trier vos flux dans différentes catégories. Un flux ne peut être que dans une seule catégorie.

 1. Ouvrez « Gestion des abonnements ».
 2. Vous pouvez ajouter une catégorie d’abonnements de cette manière :
    1. Tapez le nom de votre catégorie dans le champ « Nouvelle catégorie »
    2. Cliquez ensuite sur le bouton « Valider »
 3. Ensuite, vous pouvez glisser vos abonnements de catégorie en catégorie
 4. (facultatif) : Pour qu’un flux s’affiche dans la catégorie, et non pas dans l’onglet principal, dans son paramètre « Visibilité », choisissez « Afficher dans sa catégorie ».
