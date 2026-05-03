---
nav_order: 10
redirect_from:
  - /en/developers/02_First_steps.html
---

# First steps

FreshRSS est construit en PHP et utilise le framework Minz. Les
dépendancessont directement incluses dans le code source, donc vous n’avez
pas besoin d’utiliser Composer.

Il existe plusieurs façons de configurer votre environnement
dedéveloppement. La méthode la plus simple et la plus supportée est basée
surDocker. C’est la solution qui est documentée ci-dessous. Si vous avez
déjà unenvironnement PHP fonctionnel, vous n’en avez probablement pas
besoin.

Nous supposons ici que vous utilisez une distribution GNU/Linux, capable
d’exécuter Docker. Sinon, vous devrez adapter les commandes en conséquence.

Les commandes qui suivent doivent être exécutées dans une console. Ils
commencent par `$` quand les commandes doivent être exécutées en tant
qu’utilisateur normal, et par `#` quand elles doivent être exécutées en tant
qu’utilisateur root. Vous n’avez pas besoin de taper ces caractères. Un
chemin d’accès peut être indiqué devant ces caractères pour vous aider à
identifier où ils doivent être exécutés. Par exemple, `app$ echo 'Hello
World'` indique que vous devez exécuter la commande `echo` dans le
répertoire `app/`.

Tout d’abord, vous devez installer
[Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/).

Une fois que c’est fait, clonez le dépôt de code de la manière suivante :

```sh
git clone https://github.com/FreshRSS/FreshRSS.git
cd FreshRSS
```

Notez que, pour contribuer, vous devrez d’abord « forker » ce dépôt de code
(ou dépôt de code référent) et cloner votre « fork » à la place de ce
dépôt. Adaptez les commandes en conséquence.

Ensuite, la seule commande que vous devez connaître est la suivante :

```sh
make start
```

Cela peut prendre un certain temps pour que Docker télécharge l’image
utilisée. Dans le cas où la commande échoue pour un problème de droit, il
faudra soit ajouter votre utilisateur au groupe `docker`, soit relancer la
commande en la préfixant par `sudo`.

**Vous pouvez maintenant accéder à FreshRSS à [http://localhost:8080](http://localhost:8080).** Suivez simplement le processus d’installation et sélectionnez la base de données SQLite.

Vous pouvez arrêter les conteneurs en tapant <kbd>Control</kbd> + <kbd>c</kbd> ou avec la commande suivante, dans un autre terminal:

```sh
make stop
```

If you’re interested in the configuration, the `make` commands are defined
in the
[`Makefile`](https://github.com/FreshRSS/FreshRSS/blob/edge/Makefile).

Si vous avez besoin d’utiliser une image Docker identifiée par un tag
différent (par défaut `alpine`), vous pouvez surcharger de la manière
suivante la variable d’environnement `TAG` au moment de l’exécution de la
commande :

```sh
TAG=alpine make start
```

Vous pouvez trouver la liste complète des tags disponibles [sur le hub
Docker](https://hub.docker.com/r/freshrss/freshrss/tags).

Si vous voulez construire l’image Docker, vous pouvez lancer la commande
suivante :

```sh
make build
```

The `TAG` variable can be anything (e.g. `local`). You can target a specific
architecture by adding `-alpine` at the end of the tag
(e.g. `local-alpine`).

## Architecture du projet

- the PHP framework: [Minz](minz.md)

## Extensions

If you want to create your own FreshRSS extension, take a look at the
[extension documentation](writing-extensions.md).

## Style de codage

Si vous désirez contribuer au code, il est important de respecter le style
de codage suivant. Le code actuel ne le respecte pas entièrement mais il est
de notre devoir à tous de le changer dès que l’occasion se présente.

Aucune nouvelle contribution ne respectant pas ces règles ne sera acceptée
tant que les corrections nécessaires ne sont pas appliquées.

## GitHub Actions

The code will be checked for every pull request commit on GitHub via [GitHub
Actions](https://github.com/FreshRSS/FreshRSS/actions).  See the
configuration file
[`tests.yml`](https://github.com/FreshRSS/FreshRSS/blob/edge/.github/workflows/tests.yml).

## Running fixes & tests

Tests can be run locally, e.g. by running `make test-all`, and several
problems can be automatically fixed by running `make fix-all`.

```sh
make fix-all
make test-all
```

This requires `make` and `npm` in addition to the FreshRSS requirements. See
below for the precise requirements for a few platforms.

### Debian / Ubuntu

> ℹ️ Also applies to [Microsoft Windows](https://docs.microsoft.com/windows/wsl/install-win10) thanks to [WSL](https://ubuntu.com/wsl).

Here are the dependencies that need to be manually installed prior to
running the fixes & tests.

```sh
sudo apt update && sudo apt install --no-install-recommends -y make npm php-cli php-curl php-mbstring php-xml unzip wget
```

### Fedora / Red Hat

```sh
yum install -y git make npm php-cli php-curl php-mbstring php-xml php-pdo unzip wget
```

### Alpine Linux

```sh
apk add git make npm php-cli php-curl php-ctype php-dom php-mbstring php-openssl php-phar php-simplexml php-xml php-pdo php-tokenizer php-xmlreader php-xmlwriter unzip wget
```

### Partial fixes & tests

- composer-based: `npm run fix && npm test` or see the [`scripts` section of
  `composer.json`](https://github.com/FreshRSS/FreshRSS/blob/edge/composer.json)
  for individual tests or fixes such as `composer phpstan`
- npm-based: `npm run fix && npm test` or see the [`scripts` section of
  `package.json`](https://github.com/FreshRSS/FreshRSS/blob/edge/package.json)
  for individual tests or fixes such as `npm run rtlcss`

### Tests summary

> ℹ Check [`AGENTS.md`](https://github.com/FreshRSS/FreshRSS/blob/edge/AGENTS.md) for detailed coding conventions (both for humans and AI agents).

A short (not complete) summary:

#### PHP

> ℹ Check [`php.instructions.md`](https://github.com/FreshRSS/FreshRSS/blob/edge/.github/instructions/php.instructions.md) for detailed coding conventions (both for humans and AI agents).

- Syntax of `php` and `phtml` files is checked.
- translation files (`i18n`) are checked ([more information about i18n
  files](../internationalization.html)).
- unit test (`tests`) are run by [PHPunit](https://phpunit.de/).
- Linter:
  - [PHP_Codesniffer (phpcs)](https://github.com/squizlabs/PHP_CodeSniffer)
  - [PHPstan](https://github.com/phpstan/phpstan)

### CSS

> ℹ Check [`css.instructions.md`](https://github.com/FreshRSS/FreshRSS/blob/edge/.github/instructions/css.instructions.md) for detailed coding conventions (both for humans and AI agents).

- Linter:
  - [PHP_Codesniffer (phpcs)](https://github.com/squizlabs/PHP_CodeSniffer)
  - via npm `.styleintrc.json`
  - check that RTL (right-to-left) CSS files match to standard CSS files

### JavaScript

> ℹ Check [`javascript.instructions.md`](https://github.com/FreshRSS/FreshRSS/blob/edge/.github/instructions/javascript.instructions.md) for detailed coding conventions (both for humans and AI agents).

- Linter:
  - via npm `.styleintrc.json` ([ECMAScript
    2017](https://en.wikipedia.org/wiki/ECMAScript#8th_Edition_%E2%80%93_ECMAScript_2017))

### Markdown

> ℹ Check [`markdown.instructions.md`](https://github.com/FreshRSS/FreshRSS/blob/edge/.github/instructions/markdown.instructions.md) for detailed coding conventions (both for humans and AI agents).

- Linter:
  - via npm `.markdownlint.json`

## Espaces, tabulations et autres caractères blancs

> ℹ Check [`_general.instructions.md`](https://github.com/FreshRSS/FreshRSS/blob/edge/.github/instructions/_general.instructions.md) for detailed coding conventions (both for humans and AI agents).

### Indentation

L’indentation du code doit être faite impérativement avec des tabulations.

### Alignement

Une fois l’indentation faite, il peut être nécessaire de faire un alignement
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

```sh
# commande à lancer avant l’ajout des fichiers dans l’index
git diff --check
# commande à lancer après l’ajout des fichiers dans l’index mais avant le commit
git diff --check --cached
```

### Fin de fichier

Chaque fichier doit se terminer par une ligne vide.

### Le cas de la virgule, du point et du point-virgule

Il n’y a pas d’espace avant ces caractères, il y en a un après.

### Le cas des opérateurs

Chaque opérateur est entouré d’espaces.

```php
if ($a == 10) {
	// faire quelque chose
}

echo $a ? 1 : 0;
```

### Le cas des parenthèses

Il n’y a pas d’espaces entre des parenthèses. Il n’y a pas d’espaces avant
une parenthèse ouvrante sauf si elle est précédée d’un mot-clé. Il n’y a pas
d’espaces après une parenthèse fermante sauf si elle est suivie d’une
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

It happens most of the time in JavaScript files. When there are chained
functions with closures and call-back functions, it’s hard to understand the
code if not properly formatted. In those cases, we add a new indent level
for the complete instruction and reset the indent for a new instruction on
the same level.

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
exceptionnellement de dépasser cette limite s’il n’est pas possible de la
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

L’ensemble des éléments du code (fonctions, classes, méthodes et variables)
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

### Operators on multiple lines

Les opérateurs doivent être en fin de ligne dans le cas de conditions sur
plusieurs lignes.

```php
if ($a == 10 ||
    $a == 20) {
	// faire quelque chose
}
```

### End of PHP file

Si le fichier ne contient que du PHP, il ne doit pas comporter de balise
fermante.

### Tableaux

Lors de l’écriture de tableaux sur plusieurs lignes, tous les éléments
doivent être suivis d’une virgule (même le dernier).

```php
$variable = [
	"valeur 1",
	"valeur 2",
	"valeur 3",
];
```
