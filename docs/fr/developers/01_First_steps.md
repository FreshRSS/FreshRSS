# Configurer son environnement

**TODO**

## Docker

Le développement et le deploiement de FreshRSS peuvent se faire [via Docker](https://github.com/FreshRSS/FreshRSS/tree/dev/Docker).

# Architecture du projet

**TODO**

# Style de codage

Si vous désirez contribuer au code, il est important de respecter le style de codage suivant. Le code actuel ne le respecte pas entièrement mais il est de notre devoir à tous de le changer dès que l'occasion se présente.

Aucune nouvelle contribution ne respectant pas ces règles ne sera acceptée tant que les corrections nécessaires ne sont pas appliquées.

## Espaces, tabulations et autres caractères blancs

### Indentation
L'indentation du code doit être faite impérativement avec des tabulations.

### Alignement

Une fois l'indentation faite, il peut être nécessaire de faire un alignement pour simplifier la lecture. Dans ce cas, il faut utiliser les espaces.

```php
$resultat = une_fonction_avec_un_nom_long($param1, $param2,
                                          $param3, $param4);
```

### Fin de ligne

Le caractère de fin de ligne doit être un saut de ligne (LF) qui est le caractère de fin de ligne des systèmes *NIX. Ce caractère ne doit pas être précédé par des caractères blanc.

Il est possible de vérifier la présence de caractères blancs en fin de ligne grâce à Git avec la commande suivante :

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

Il n'y a pas d'espaces entre des parenthèses. Il n'y a pas d'espaces avant une parenthèse ouvrante sauf si elle est précédée d'un mot-clé. Il n'y a pas d'espaces après une parenthèse fermante sauf si elle est suivie d'une accolade ouvrante.

```php
if ($a == 10) {
    // faire quelque chose
}

if ((int)$a == 10) {
    // faire quelque chose
}
```

### Le cas des fonctions chainées

Ce cas se présente le plus souvent en Javascript. Quand on a des fonctions chainées, des fonctions anonymes ainsi que des fonctions de rappels, il est très facile de se perdre. Dans ce cas là, on ajoute une indentation supplémentaire pour toute l'instruction et on revient au même niveau pour une instruction de même niveau.

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

Les lignes ne doivent pas dépasser 80 caractères. Il est cependant autorisé exceptionnellement de dépasser cette limite s'il n'est pas possible de la respecter mais en aucun cas, les lignes ne doivent dépasser les 100 caractères.

Dans le cas des fonctions, les paramètres peuvent être déclarés sur plusieurs lignes.

```php
function ma_fonction($param_1, $param_2,
                     $param_3, $param_4) {
    // faire quelque chose
}
```

## Nommage

L'ensemble des éléments du code (fonctions, classes, méthodes et variables) doivent être nommés de manière à décrire leur usage de façon concise.

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

## Compatibilité avec PHP 5.3

Il ne faut pas demander l'indice d'un tableau qui est retourné par une fonction ou une méthode. Il faut passer par une variable intermédiaire.

```php
// code compatible avec PHP 5.3
$ma_variable = fonction_qui_retourne_un_tableau();
echo $ma_variable[0];
// code incompatible avec PHP 5.3
echo fonction_qui_retourne_un_tableau()[0];
```

Il ne faut pas utiliser la déclaration raccourcie des tableaux.

```php
// code compatible avec PHP 5.3
$variable = array();
// code incompatible avec PHP 5.3
$variable = [];
```

## Divers

### Opérateurs
Les opérateurs doivent être en fin de ligne dans le cas de conditions sur plusieurs lignes.

```php
if ($a == 10 ||
    $a == 20) {
    // faire quelque chose
}
```

### Fin des fichiers

Si le fichier ne contient que du PHP, il ne doit pas comporter de balise fermante

### Tableaux

Lors de l'écriture de tableaux sur plusieurs lignes, tous les éléments doivent être suivis d'une virgule (même le dernier).

```php
$variable = array(
    "valeur 1",
    "valeur 2",
    "valeur 3",
);
```
