# Configurer son environnement (Docker)

FreshRSS est construit en PHP et utilise le framework Minz. Les dépendances
sont directement inclus dans le code source, donc vous n'avez pas besoin de
Composer.

Il existe plusieurs façons de configurer votre environnement de
développement. La méthode la plus simple et la plus supportée est basée sur
Docker, lequel est la solution documentée ci-dessous. Si vous avez déjà un
environnement PHP fonctionnel, vous n'en avez probablement pas besoin.

Nous supposons ici que vous utilisez une distribution GNU/Linux, capable
d'exécuter Docker. Sinon, vous devrez adapter les commandes en conséquence.

The commands that follow have to be executed in a console. They start by `$`
when commands need to be executed as normal user, and by `#` when they need
to be executed as root user. You don't have to type these characters. A path
may be indicated before these characters to help you identify where they
need to be executed. For instance, `app$ echo 'Hello World'` indicates that
you have to execute `echo` command in the `app/` directory.

First, you need to install
[Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/).

Once you're done, clone the repository with:

```console
$ git clone https://github.com/FreshRSS/FreshRSS.git
$ cd FreshRSS
```

Note that, if you want to contribute, you have to fork the repository first
and clone your fork instead of the "root" one. Adapt the commands in
consequence.

Then, the only command you need to know is the following:

```console
$ make start
```

This might take some time while Docker downloads the image. If your user
isn't in the `docker` group, you'll need to prepend the command with `sudo`.

**You can now access FreshRSS at [http://localhost:8080](http://localhost:8080).** Just follow the install process and select the SQLite database.

You can stop the containers by typing <kbd>Control</kbd> + <kbd>c</kbd> or with the following command, in another terminal:

```console
$ make stop
```

If you're interested in the configuration, the `make` commands are defined
in the [`Makefile`](/Makefile).

If you need to use a different tag image (default is `dev-alpine`), you can
set the `TAG` environment variable:

```console
$ TAG=dev-arm make start
```

You can find the full list of available tags [on the Docker
hub](https://hub.docker.com/r/freshrss/freshrss/tags).

You might want to rebuild the Docker image locally. You can do it with:

```console
$ make build
$ # or
$ TAG=dev-arm make build
```

The `TAG` variable can be anything (e.g. `dev-local`). You can target a
specific architecture by adding `-alpine` or `-arm` at the end of the tag
(e.g. `dev-local-arm`).

# Architecture du projet

**TODO**

# Extensions

If you want to create your own FreshRSS extension, take a look at the
[extension documentation](03_Backend/05_Extensions.md).

# Style de codage

If you want to contribute to the source code, it is important to follow the
project coding style. The actual code does not follow it throughout the
project, but every time we have an opportunity, we should fix it.

Contributions which do not follow the coding style will be rejected as long
as the coding style is not fixed.

## Spaces, tabs and white spaces

### Indentation
L'indentation du code doit être faite impérativement avec des tabulations.

### Alignement

Une fois l'indentation faite, il peut être nécessaire de faire un alignement
pour simplifier la lecture. Dans ce cas, il faut utiliser les espaces.

```php
$resultat = une_fonction_avec_un_nom_long($param1, $param2,
                                          $param3, $param4);
```

### Fin de ligne

Le caractère de fin de ligne doit être un saut de ligne (LF) qui est le
caractère de fin de ligne des systèmes *NIX. Ce caractère ne doit pas être
précédé par des caractères blanc.

Il est possible de vérifier la présence de caractères blancs en fin de ligne
grâce à Git avec la commande suivante :

```bash
# commande à lancer avant l'ajout des fichiers dans l'index
git diff --check
# commande à lancer après l'ajout des fichiers dans l'index mais avant le commit
git diff --check --cached
```

### Fin de fichier

Chaque fichier doit se terminer par une ligne vide.

### Le cas de la virgule, du point et du point-virgule

Il n'y a pas d'espace avant ces caractères, il y en a un après.

### Le cas des opérateurs

Chaque opérateur est entouré d'espaces.

```php
if ($a == 10) {
	// faire quelque chose
}

echo $a ? 1 : 0;
```

### Le cas des parenthèses

Il n'y a pas d'espaces entre des parenthèses. Il n'y a pas d'espaces avant
une parenthèse ouvrante sauf si elle est précédée d'un mot-clé. Il n'y a pas
d'espaces après une parenthèse fermante sauf si elle est suivie d'une
accolade ouvrante.

```php
if ($a == 10) {
	// faire quelque chose
}

if ((int)$a == 10) {
	// faire quelque chose
}
```

### Le cas des fonctions chainées

Ce cas se présente le plus souvent en Javascript. Quand on a des fonctions
chainées, des fonctions anonymes ainsi que des fonctions de rappels, il est
très facile de se perdre. Dans ce cas là, on ajoute une indentation
supplémentaire pour toute l'instruction et on revient au même niveau pour
une instruction de même niveau.

```javascript
// Première instruction
shortcut.add(shortcuts.mark_read, function () {
		//...
	}, {
		'disable_in_input': true
	});
// Deuxième instruction
shortcut.add("shift+" + shortcuts.mark_read, function () {
		//...
	}, {
		'disable_in_input': true
	});
```

## Longueur des lignes

Les lignes ne doivent pas dépasser 80 caractères. Il est cependant autorisé
exceptionnellement de dépasser cette limite s'il n'est pas possible de la
respecter mais en aucun cas, les lignes ne doivent dépasser les 100
caractères.

Dans le cas des fonctions, les paramètres peuvent être déclarés sur
plusieurs lignes.

```php
function ma_fonction($param_1, $param_2,
                     $param_3, $param_4) {
	// faire quelque chose
}
```

## Nommage

L'ensemble des éléments du code (fonctions, classes, méthodes et variables)
doivent être nommés de manière à décrire leur usage de façon concise.

### Fonctions et variables

Les fonctions et les variables doivent suivre la convention "snake case".

```php
// une fontion
function nom_de_la_fontion() {
	// faire quelque chose
}
// une variable
$nom_de_la_variable;
```

### Méthodes

Les méthodes doivent suivre la convention "lower camel case".

```php
private function nomDeLaMethode() {
	// faire quelque chose
}
```

### Classes

Les classes doivent suivre la convention "upper camel case".

```php
abstract class NomDeLaClasse {}
```

## Encodage

Les fichiers doivent être encodés en UTF-8.

## Compatibilité PHP

Assurez-vous que votre code fonctionne avec une version de PHP aussi
ancienne que celle que FreshRSS supporte officiellement.

## Divers

### Le cas des opérateurs
Les opérateurs doivent être en fin de ligne dans le cas de conditions sur
plusieurs lignes.

```php
if ($a == 10 ||
    $a == 20) {
	// faire quelque chose
}
```

### Fin de fichier

Si le fichier ne contient que du PHP, il ne doit pas comporter de balise
fermante.

### Tableaux

Lors de l'écriture de tableaux sur plusieurs lignes, tous les éléments
doivent être suivis d'une virgule (même le dernier).

```php
$variable = [
	"value 1",
	"value 2",
	"value 3",
];
```
