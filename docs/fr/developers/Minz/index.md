# Minz

Cette fiche technique devrait renvoyer vers la documentation officielle de
FreshRSS et de Minz (le framework PHP sur lequel repose
FreshRSS). Malheureusement cette documentation n’existe pas encore. Voici
donc en quelques mots les principaux éléments à connaître. Il n’est pas
nécessaire de lire l’ensemble des chapitres de cette section si vous n’avez
pas à utiliser une fonctionnalité dans votre extension (si vous n’avez pas
besoin de traduire votre extension, pas besoin d’en savoir plus sur le
module `Minz_Translate` par exemple).

## Architecture MVC

Minz repose et impose une architecture MVC pour les projets l’utilisant. On
distingue dans cette architecture trois composants principaux :

* Le Modèle : c’est l’objet de base que l’on va manipuler. Dans FreshRSS,
	les catégories, les flux et les articles sont des modèles. La partie du
	code qui permet de les manipuler en base de données fait aussi partie du
	modèle mais est séparée du modèle de base : on parle de DAO (pour « Data
	Access Object »). Les modèles sont stockés dans un répertoire `Models`.
* La Vue : c’est ce qui représente ce que verra l’utilisateur. La vue est
	donc simplement du code HTML que l’on mixe avec du PHP pour afficher les
	informations dynamiques. Les vues sont stockées dans un répertoire
	`views`.
* Le Contrôleur : c’est ce qui permet de lier modèles et vues entre
	eux. Typiquement, un contrôleur va charger des modèles à partir de la base
	de données (une liste d’articles par exemple) pour les « passer » à une
	vue afin qu’elle les affiche. Les contrôleurs sont stockés dans un
	répertoire `Controllers`.

## Routage

Afin de lier une URL à un contrôleur, on doit passer par une phase dite de «
routage ». Dans FreshRSS, cela est particulièrement simple car il suffit
d’indiquer le nom du contrôleur à charger dans l’URL à l’aide d’un paramètre `c`.
Par exemple, l’adresse <http://exemple.com?c=hello> va exécuter le code
contenu dans le contrôleur `hello`.

Une notion qui n’a pas encore été évoquée est le système d'« actions ». Une
action est exécutée *sur* un contrôleur. Concrètement, un contrôleur va être
représenté par une classe et ses actions par des méthodes. Pour exécuter une
action, il est nécessaire d’indiquer un paramètre `a` dans l’URL.

Exemple de code :

```php
<?php

class FreshRSS_hello_Controller extends FreshRSS_ActionController {
	public function indexAction() {
		$this->view->a_variable = 'FooBar';
	}

	public function worldAction() {
		$this->view->a_variable = 'Hello World!';
	}
}

?>
```

Si l’on charge l’adresse <http://exemple.com?c=hello&a=world>, l’action
`world` va donc être exécutée sur le contrôleur `hello`.

Note : si `c` ou `a` n’est pas précisée, la valeur par défaut de chacune de
ces variables est `index`. Ainsi l’adresse <http://exemple.com?c=hello> va
exécuter l’action `index` du contrôleur `hello`.

Plus loin, sera utilisée la convention `hello/world` pour évoquer un couple
contrôleur/action.

## Vues

Chaque vue est associée à un contrôleur et à une action. La vue associée à
`hello/world` va être stockée dans un fichier bien spécifique :
`views/hello/world.phtml`. Cette convention est imposée par Minz.

Comme expliqué plus haut, les vues sont du code HTML mixé à du PHP. Exemple
de code :

```html
<p>
	Phrase passée en paramètre : <?= $this->a_variable ?>
</p>
```

La variable `$this->a_variable` a été passée précédemment par le contrôleur (voir exemple précédent). La différence est que dans le contrôleur il est nécessaire de passer par `$this->view` et que dans la vue `$this` suffit.

## Accéder aux paramètres GET / POST

Il est souvent nécessaire de profiter des paramètres passés par GET ou par
POST. Dans Minz, ces paramètres sont accessibles de façon indistincts à
l’aide de la classe `Minz_Request`. Exemple de code :

```php
<?php

$default_value = 'foo';
$param = Minz_Request::paramString('bar') ?: $default_value;

// Affichera la valeur du paramètre `bar` (passé via GET ou POST)
// ou "foo" si le paramètre n’existe pas.
echo $param;

// Force la valeur du paramètre `bar`
Minz_Request::_param('bar', 'baz');

// Affichera forcément "baz" puisque nous venons de forcer sa valeur.
// Notez que le second paramètre (valeur par défaut) est facultatif.
echo Minz_Request::paramString('bar');

?>
```

La méthode `Minz_Request::isPost()` peut être utile pour n’exécuter un
morceau de code que s’il s’agit d’une requête POST.

Note : il est préférable de n’utiliser `Minz_Request` que dans les
contrôleurs. Il est probable que vous rencontriez cette méthode dans les
vues de FreshRSS, voire dans les modèles, mais sachez qu’il ne s’agit
**pas** d’une bonne pratique.

## Accéder aux paramètres de session

L’accès aux paramètres de session est étrangement similaire aux paramètres
GET / POST mais passe par la classe `Minz_Session` cette fois-ci ! Il n’y a
pas d’exemple ici car vous pouvez reprendre le précédent en changeant tous
les `Minz_Request` par des `Minz_Session`.

## Gestion des URL

Pour profiter pleinement du système de routage de Minz, il est fortement
déconseillé d’écrire les URL en dur dans votre code. Par exemple, la vue
suivante doit être évitée :

```html
<p>
	Accéder à la page <a href="http://exemple.com?c=hello&amp;a=world">Hello world</a>!
</p>
```

Si un jour il est décidé d’utiliser un système d'« url rewriting » pour
avoir des adresses au format <http://exemple.com/controller/action>, toutes
les adresses précédentes deviendraient ineffectives !

Préférez donc l’utilisation de la classe `Minz_Url` et de sa méthode
`display()`. `Minz_Url::display()` prend en paramètre un tableau de la forme
suivante :

```php
<?php

$url_array = [
	'c' => 'hello',
	'a' => 'world',
	'params' => [
		'foo' => 'bar',
	],
];

// Affichera quelque chose comme .?c=hello&amp;a=world&amp;foo=bar
echo Minz_Url::display($url_array);

?>
```

Comme cela peut devenir un peu pénible à utiliser à la longue, surtout dans
les vues, il est préférable d’utiliser le raccourci `_url()` :

```php
<?php

// Affichera la même chose que précédemment
echo _url('hello', 'world', 'foo', 'bar');

?>
```

Note : en règle générale, la forme raccourcie (`_url()`) doit être utilisée
dans les vues tandis que la forme longue (`Minz_Url::display()`) doit être
utilisée dans les contrôleurs.

## Redirections

Il est souvent nécessaire de rediriger un utilisateur vers une autre
page. Pour cela, la classe `Minz_Request` dispose d’une autre méthode utile
: `forward()`. Cette méthode prend en argument le même format d’URL que
celui vu juste avant.

Exemple de code :

```php
<?php

$url_array = [
	'c' => 'hello',
	'a' => 'world',
];

// Indique à Minz de rediriger l’utilisateur vers la page hello/world.
// Notez qu’il s’agit d’une redirection au sens Minz du terme, pas d’une redirection que le navigateur va avoir à gérer (code HTTP 301 ou 302)
// Le code qui suit forward() va ainsi être exécuté !
Minz_Request::forward($url_array);

// Pour effectuer une redirection type 302, ajoutez "true".
// Le code qui suivra ne sera alors jamais exécuté.
Minz_Request::forward($url_array, true);

?>
```

Il est très fréquent de vouloir effectuer une redirection tout en affichant
un message à l’utilisateur pour lui indiquer comment s’est déroulée l’action
effectuée juste avant (validation d’un formulaire par exemple). Un tel
message est passé par une variable de session `notification` (note : nous
parlerons plutôt de « feedback » désormais pour éviter la confusion avec une
notification qui peut survenir à tout moment). Pour faciliter ce genre
d’action très fréquente, il existe deux raccourcis qui effectuent tout deux
une redirection type 302 en affectant un message de feedback :

```php
<?php

$url_array = [
	'c' => 'hello',
	'a' => 'world',
];
$feedback_good = 'Tout s’est bien passé !';
$feedback_bad = 'Oups, quelque chose n’a pas marché.';

Minz_Request::good($feedback_good, $url_array);

// ou

Minz_Request::bad($feedback_bad, $url_array);

?>
```

## Gestion de la traduction

Cette partie est [expliquée dans la page dédiée](/docs/fr/internationalization.md).

## Migration

Existing documentation includes:

* [How to manage migrations](migrations.md)
