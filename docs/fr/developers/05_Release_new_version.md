# Préparer la sortie

Afin d’avoir le plus de retour possible avant une sortie, il est préférable
de l’annoncer sur GitHub en créant un ticket dédié ([voir les
exemples](https://github.com/FreshRSS/FreshRSS/search?utf8=%E2%9C%93&q=Call+for+testing&type=Issues)).
Ceci est à faire **au moins une semaine à l’avance**.

Il est aussi recommandé de faire l’annonce sur <mailing@freshrss.org>.

## S’assurer de l’état de dev

Avant de sortir une nouvelle version de FreshRSS, il faut vous assurer que
le code est stable et ne présente pas de bugs majeurs. Idéalement, il
faudrait que nos tests soient automatisés et exécutés avant toute
publication.

Il faut aussi **vous assurer que le fichier CHANGELOG est à jour** avec les
mises à jour de la version à sortir.

## Processus Git

```console
$ git checkout edge
$ git pull
$ vim constants.php
# Mettre à jour le numéro de version x.y.z de FRESHRSS_VERSION
$ git commit -a
Version x.y.z
$ git tag -a x.y.z
Version x.y.z
$ git push && git push --tags
```

## Mise à jour de update.freshrss.org

Il est important de mettre à jour update.freshrss.org puisqu’il s’agit du
service par défaut gérant les mises à jour automatiques de FreshRSS.

Le dépot gérant le code se trouve sur GitHub :
[FreshRSS/update.freshrss.org](https://github.com/FreshRSS/update.freshrss.org/).

### Écriture du script de mise à jour

Les scripts se trouvent dans le répertoire `./scripts/` et doivent être de
la forme `update_to_x.y.z.php`. On trouve aussi dans ce répertoire
`update_to_dev.php` destiné aux mises à jour de la branche `edge` (ce
script ne doit pas inclure de code spécifique à une version particulière !)
et `update_util.php` contenant une liste de fonctions utiles à tous les
scripts.

Afin d’écrire un nouveau script, il est préférable de copier / coller celui
de la dernière version ou de partir de `update_to_dev.php`. La première
chose à faire est de définir l’URL à partir de laquelle sera téléchargée le
package FreshRSS (`PACKAGE_URL`). L’URL est de la forme
`https://codeload.github.com/FreshRSS/FreshRSS/zip/x.y.z`.

Il existe ensuite 5 fonctions à remplir :

* `apply_update()` qui se charge de sauvegarder le répertoire contenant les
	données, de vérifier sa structure, de télécharger le package FreshRSS, de
	le déployer et de tout nettoyer. Cette fonction est pré-remplie mais des
	ajustements peuvent être faits si besoin est (ex. réorganisation de la
	structure de `./data`). Elle retourne `true` si aucun problème n’est
	survenu ou une chaîne de caractères indiquant un soucis ;
* `need_info_update()` retourne `true` si l’utilisateur doit intervenir
	durant la mise à jour ou `false` sinon ;
* `ask_info_update()` affiche un formulaire à l’utilisateur si
	`need_info_update()` a retourné `true` ;
* `save_info_update()` est chargée de sauvegarder les informations
	renseignées par l’utilisateur (issues du formulaire de
	`ask_info_update()`) ;
* `do_post_update()` est exécutée à la fin de la mise à jour et prend en
	compte le code de la nouvelle version (ex. si la nouvelle version modifie
	l’objet `Minz_Configuration`, vous bénéficierez de ces améliorations).

## Mise à jour du fichier de versions

Lorsque le script a été écrit et versionné, il est nécessaire de mettre à
jour le fichier `./versions.php` qui contient une table de correspondances
indiquant quelles versions sont mises à jour vers quelles autres versions.

Voici un exemple de fichier `versions.php` :

```php
<?php
return [
	// STABLE
	'0.8.0' => '1.0.0',
	'0.8.1' => '1.0.0',
	'1.0.0' => '1.0.1',  // doesn’t exist (yet)
	// DEV
	'1.1.2-dev' => 'dev',
	'1.1.3-dev' => 'dev',
	'1.1.4-dev' => 'dev',
];
```

Et voici comment fonctionne cette table :

* à gauche se trouve la version N, à droite la version N+1 ;
* les versions `x.y.z-dev` sont **toutes** mises à jour vers `edge` ;
* les versions stables sont mises à jour vers des versions stables ;
* il est possible de sauter plusieurs versions d’un coup à condition que les
	scripts de mise à jour le prennent en charge ;
* il est conseillé d’indiquer la correspondance de la version courante vers
	sa potentielle future version en précisant que cette version n’existe pas
	encore. Tant que le script correspondant n’existera pas, rien ne se
	passera.

Il est **très fortement** indiqué de garder ce fichier rangé selon les
numéros de versions en séparant les versions stables et de dev.

## Déploiement

Avant de mettre à jour update.freshrss.org, il est préférable de tester avec
dev.update.freshrss.org qui correspond à la pré-production. Mettez donc à
jour dev.update.freshrss.org et changez l’URL `FRESHRSS_UPDATE_WEBSITE` de
votre instance FreshRSS. Lancez la mise à jour et vérifiez que celle-ci se
déroule correctement.

Lorsque vous serez satisfait, mettez à jour update.freshrss.org avec le
nouveau script et en testant de nouveau puis passez à la suite.

## Mise à jour des services FreshRSS

Deux services sont à mettre à jour immédiatement après la mise à jour de
update.freshrss.org :

* rss.freshrss.org ;
* demo.freshrss.org (identifiants publics : `demo` / `demodemo`).

## Annoncer publiquement la sortie

Lorsque tout fonctionne, il est temps d’annoncer la sortie au monde entier !

* sur GitHub en créant [une nouvelle
	release](https://github.com/FreshRSS/FreshRSS/releases/new) ;
* sur le blog de freshrss.org au minimum pour les versions stables (écrire
	l’article sur
	[FreshRSS/freshrss.org](https://github.com/FreshRSS/freshrss.org)).
* sur Twitter (compte [@FreshRSS](https://twitter.com/FreshRSS)) ;
* et sur <mailing@freshrss.org> ;

## Lancer la prochaine version de développement

```console
$ git checkout edge
$ vim constants.php
# Mettre à jour le numéro de version de FRESHRSS_VERSION
$ vim CHANGELOG.md
# Préparer la section pour la prochaine version
$ git add CHANGELOG.md && git commit && git push
```

Pensez aussi à mettre à jour update.freshrss.org pour qu’il prenne en compte
la version de développement actuelle.
