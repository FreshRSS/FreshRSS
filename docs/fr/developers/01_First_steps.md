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

# Project architecture

**TODO**

# Extensions

If you want to create your own FreshRSS extension, take a look at the
[extension documentation](03_Backend/05_Extensions.md).

# Coding style

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

There is no space before those characters but there is one after.

### Operators

There should be a space before and after every operator.

```php
if ($a == 10) {
	// faire quelque chose
}

echo $a ? 1 : 0;

```


### Parentheses

Il n'y a pas d'espaces entre des parenthèses. Il n'y a pas d'espaces avant
une parenthèse ouvrante sauf si elle est précédée d'un mot-clé. Il n'y a pas
d'espaces après une parenthèse fermante sauf si elle est suivie d'une
accolade ouvrante.

```php
if ($a == 10) {

	// do something

}



if ((int)$a == 10) {

	// do something

}

```


### With chained functions

Ce cas se présente le plus souvent en Javascript. Quand on a des fonctions
chainées, des fonctions anonymes ainsi que des fonctions de rappels, il est
très facile de se perdre. Dans ce cas là, on ajoute une indentation
supplémentaire pour toute l'instruction et on revient au même niveau pour
une instruction de même niveau.

```javascript
// First instruction

shortcut.add(shortcuts.mark_read, function () {

		//...

	}, {

		'disable_in_input': true

	});

// Second instruction

shortcut.add("shift+" + shortcuts.mark_read, function () {

		//...

	}, {

		'disable_in_input': true

	});

```


## Line length

Lines should be shorter than 80 characters. However, in some case, it is
possible to extend that limit to 100 characters.

With functions, parameters can be declared on different lines.

```php
function my_function($param_1, $param_2,

                     $param_3, $param_4) {

	// do something

}

```


## Naming

All the code elements (functions, classes, methods and variables) must
describe their usage in concise way.

### Functions and variables

They must follow the "snake case" convention.

```php
// a function

function function_name() {

	// do something

}

// a variable

$variable_name;

```


### Methods

They must follow the "lower camel case" convention.

```php
private function methodName() {

	// do something

}

```


### Classes

They must follow the "upper camel case" convention.

```php
abstract class ClassName {}

```


## Encoding

Files must be encoded with UTF-8 character set.

## PHP compatibility

Ensure that your code is working with a PHP version as old as what FreshRSS
officially supports.

## Miscellaneous

### Operators
They must be at the end of the line if a condition runs on more than one
line.

```php
if ($a == 10 ||

    $a == 20) {

	// do something

}

```


### Fin de fichier

If the file contains only PHP code, the PHP closing tag must be omitted.

### Arrays

If an array declaration runs on more than one line, each element must be
followed by a comma even the last one.

```php
$variable = [

	"value 1",

	"value 2",

	"value 3",

];

```

