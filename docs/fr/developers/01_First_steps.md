# Configurer son environnement (Docker)

FreshRSS est construit en PHP et utilise le framework Minz. Les
dépendancessont directement incluses dans le code source, donc vous n'avez
pas besoin d'utiliser Composer.

Il existe plusieurs façons de configurer votre environnement
dedéveloppement. La méthode la plus simple et la plus supportée est basée
surDocker. C'est la solution qui est documentée ci-dessous. Si vous avez
déjà unenvironnement PHP fonctionnel, vous n'en avez probablement pas
besoin.

Nous supposons ici que vous utilisez une distribution GNU/Linux, capable
d'exécuter Docker. Sinon, vous devrez adapter les commandes en conséquence.

Les commandes qui suivent doivent être exécutées dans une console. Ils
commencent par `$` quand les commandes doivent être exécutées en tant
qu'utilisateur normal, et par `#` quand elles doivent être exécutées en tant
qu'utilisateur root. Vous n'avez pas besoin de taper ces caractères. Un
chemin d'accès peut être indiqué devant ces caractères pour vous aider à
identifier où ils doivent être exécutés. Par exemple, `app$ echo 'Hello
World'` indique que vous devez exécuter la commande `echo` dans le
répertoire `app/`.

Tout d'abord, vous devez installer
[Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/).

Une fois que c'est fait, clonez le dépôt de code de la manière suivante :

```console
$ git clone https://github.com/FreshRSS/FreshRSS.git
$ cd FreshRSS
```

Notez que, pour contribuer, vous devrez d'abord « forker » ce dépôt de code
(ou dépôt de code référent) et cloner votre « fork » à la place de ce
dépôt. Adaptez les commandes en conséquence.

Ensuite, la seule commande que vous devez connaître est la suivante :

```console
$ make start
```

Cela peut prendre un certain temps pour que Docker télécharge l'image
utilisée. Dans le cas où la commande échoue pour un problème de droit, il
faudra soit ajouter votre utilisateur au groupe `docker`, soit relancer la
commande en la préfixant par `sudo`.

**Vous pouvez maintenant accéder à FreshRSS à [http://localhost:8080](http://localhost:8080).** Suivez simplement le processus d'installation et sélectionnez la base de données SQLite.

Vous pouvez arrêter les conteneurs en tapant <kbd>Control</kbd> + <kbd>c</kbd> ou avec la commande suivante, dans un autre terminal:

```console
$ make stop
```

Si la configuration vous intéresse, les commandes `make' sont définies dans
le fichier [`Makefile`](/Makefile).

Si vous avez besoin d'utiliser une image Docker identifiée par un tag
différent (par défaut `alpine`), vous pouvez surcharger de la manière
suivante la variable d'environnement `TAG` au moment de l'exécution de la
commande :

```console
$ TAG=arm make start
```

Vous pouvez trouver la liste complète des tags disponibles [sur le hub
Docker](https://hub.docker.com/r/freshrss/freshrss/tags).

Si vous voulez construire l'image Docker, vous pouvez lancer la commande
suivante :

```console
$ make build
$ # ou
$ TAG=arm make build
```

La valeur de la variable `TAG` peut contenir n'importe quelle valeur (par
exemple `local`). Vous pouvez cibler une architecture spécifique en ajoutant
`-alpine` ou `-arm` à la fin du tag (par exemple `local-arm`).

# Architecture du projet

**À FAIRE**

# Extensions

Si vous souhaitez créer votre propre extension FreshRSS, consultez la
[documentation de l'extension](03_Backend/05_Extensions.md).

# Style de codage

Si vous désirez contribuer au code, il est important de respecter le style
de codage suivant. Le code actuel ne le respecte pas entièrement mais il est
de notre devoir à tous de le changer dès que l'occasion se présente.

Aucune nouvelle contribution ne respectant pas ces règles ne sera acceptée
tant que les corrections nécessaires ne sont pas appliquées.

## Espaces, tabulations et autres caractères blancs

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
	"valeur 1",
	"valeur 2",
	"valeur 3",
];
```
