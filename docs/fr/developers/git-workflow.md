---
nav_order: 20
redirect_from:
  - /en/developers/02_GitHub.html
---

# Git workflow

## Élémentaire

Si vous êtes novice dans Git, voici quelques ressources qui pourraient vous
être utiles :

* [GitHub’s blog
  post](https://github.blog/news-insights/the-library/new-to-git/)
* <https://docs.github.com/en/github/getting-started-with-github/set-up-git>
* <http://sixrevisions.com/resources/git-tutorials-beginners/>
* <http://rogerdudler.github.io/git-guide/>

## Obtenir le dernier code du répertoire FreshRSS

Vous devez avant tout ajouter le repo officiel à votre liste de repo remote
:

```sh
git remote add upstream git@github.com:FreshRSS/FreshRSS.git
```

Vous pouvez vérifier que le repo remote a été ajouté avec succès en
utilisant :

```sh
git remote -v show
```

Vous pouvez maintenant pull le dernier code de développement :

```sh
git checkout edge
git pull upstream edge
```

## Lancer une nouvelle branche de développement

```sh
git checkout -b mon-branch-developpement
```

## Proposer un patch

```sh
# Ajoutez le fichier modifié, ici actualize_script.php
git add app/actualize_script.php
# Commitez le changement et écrivez un message de commit approprié.
git commit
# Vérifiez deux fois que tout a l’air d’aller bien
git show
# Poussez les changements sur ton fork
git push
```

Vous pouvez maintenant créer une PR en fonction de votre branche.

## Comment écrire un message de commit

A commit message should succinctly describe the changes on the first
line. For example:

> Fixe une icône cassée

Si nécessaire, une ligne blanche et une explication plus longue peuvent le
suivre.

For further tips, see [here
(chris.beams.io)](https://chris.beams.io/posts/git-commit/).
