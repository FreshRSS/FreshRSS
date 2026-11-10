# Préparer la sortie

Afin d’avoir le plus de retour possible avant une sortie, il est préférable
de l’annoncer sur GitHub en créant un ticket dédié ([voir les
exemples](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS%20Call%20for%20testing&type=Issues)).
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

## Annoncer publiquement la sortie

Créer [une nouvelle release GitHub](https://github.com/FreshRSS/FreshRSS/releases/new)
en utilisant le numéro de version comme étiquette (tag) (par ex. `1.2.3`).

Depuis FreshRSS 1.22.0, notre système de mise à jour automatique par ZIP
utilise uniquement les informations de GitHub : la création d’une release
GitHub rend la nouvelle version immédiatement disponible pour toutes les
instances non Git, sans aucune modification manuelle d’un serveur de mise à
jour. Le ZIP est automatiquement téléchargé depuis le tag (par ex.
`https://github.com/FreshRSS/FreshRSS/archive/refs/tags/1.2.3.zip`) à partir
du champ `tag_name` retourné par
[l’API GitHub des releases](https://docs.github.com/en/rest/releases/releases#get-the-latest-release).

Puis annoncer la sortie :
* sur <https://framapiaf.org/@freshrss> ;

## Lancer la prochaine version

```console
$ git checkout edge
$ vim constants.php
# Mettre à jour le numéro de version de FRESHRSS_VERSION
$ vim CHANGELOG.md
# Préparer la section pour la prochaine version
$ git add CHANGELOG.md && git commit && git push
```
