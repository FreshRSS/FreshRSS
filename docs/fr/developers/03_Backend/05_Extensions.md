# Fiche technique 0001 — Écriture d'extensions pour FreshRSS

## Présentation de FreshRSS

FreshRSS est un agrégateur de flux RSS / Atom écrit en PHP depuis octobre 2012. Le site officiel est situé à l'adresse [freshrss.org](https://freshrss.org) et son dépot Git est hébergé par Github : [github.com/FreshRSS/FreshRSS](https://github.com/FreshRSS/FreshRSS).

## Problème à résoudre

FreshRSS est limité dans ses possibilités techniques par différents facteurs :

- La disponibilité des développeurs principaux ;
- La volonté d'intégrer certains changements ;
- Le niveau de « hack » nécessaire pour intégrer des fonctionnalités à la marge.

Si la première limitation peut, en théorie, être levée par la participation de nouveaux contributeurs au projet, elle est en réalité conditionnée par la volonté des contributeurs à s'intéresser au code source du projet en entier. Afin de lever les deux autres limitations quant à elles, il faudra la plupart du temps passer par un « à-coté » souvent synonyme de « fork ».

Une autre solution consiste à passer par un système d'extensions. En permettant à des utilisateurs d'écrire leur propre extension sans avoir à s'intéresser au cœur même du logiciel de base, on permet :

1. De réduire la quantité de code source à assimiler pour un nouveau contributeur ;
2. De permettre d'intégrer des nouveautés de façon non-officielles ;
3. De se passer des développeurs principaux pour d'éventuelles améliorations sans passer par la case « fork ».

Note : il est tout à fait imaginable que les fonctionnalités d'une extension puissent par la suite être intégrées dans le code initial de FreshRSS de façon officielle. Cela permet de proposer un « proof of concept » assez facilement.


## Comprendre les mécaniques de base (Minz et MVC)

**TODO** : bouger dans 02_Minz.md

Cette fiche technique devrait renvoyer vers la documentation officielle de FreshRSS et de Minz (le framework PHP sur lequel repose FreshRSS). Malheureusement cette documentation n'existe pas encore. Voici donc en quelques mots les principaux éléments à connaître. Il n'est pas nécessaire de lire l'ensemble des chapitres de cette section si vous n'avez pas à utiliser une fonctionnalité dans votre extension (si vous n'avez pas besoin de traduire votre extension, pas besoin d'en savoir plus sur le module `Minz_Translate` par exemple).

### Architecture MVC

Minz repose et impose une architecture MVC pour les projets l'utilisant. On distingue dans cette architecture trois composants principaux :

- Le Modèle : c'est l'objet de base que l'on va manipuler. Dans FreshRSS, les catégories, les flux et les articles sont des modèles. La partie du code qui permet de les manipuler en base de données fait aussi partie du modèle mais est séparée du modèle de base : on parle de DAO (pour « Data Access Object »). Les modèles sont stockés dans un répertoire `Models`.
- La Vue : c'est ce qui représente ce que verra l'utilisateur. La vue est donc simplement du code HTML que l'on mixe avec du PHP pour afficher les informations dynamiques. Les vues sont stockées dans un répertoire `views`.
- Le Contrôleur : c'est ce qui permet de lier modèles et vues entre eux. Typiquement, un contrôleur va charger des modèles à partir de la base de données (une liste d'articles par exemple) pour les « passer » à une vue afin qu'elle les affiche. Les contrôleurs sont stockés dans un répertoire `Controllers`.

### Le routage

Afin de lier une URL à un contrôleur, on doit passer par une phase dite de « routage ». Dans FreshRSS, cela est particulièrement simple car il suffit d'indiquer le nom du contrôleur à charger dans l'URL à l'aide d'un paramètre `c`. Par exemple, l'adresse http://exemple.com?c=hello va exécuter le code contenu dans le contrôleur `hello`.

Une notion qui n'a pas encore été évoquée est le système d'« actions ». Une action est exécutée *sur* un contrôleur. Concrètement, un contrôleur va être représenté par une classe et ses actions par des méthodes. Pour exécuter une action, il est nécessaire d'indiquer un paramètre `a` dans l'URL.

Exemple de code :

```php
<?php

class FreshRSS_hello_Controller extends Minz_ActionController {
	public function indexAction() {
		$this->view->a_variable = 'FooBar';
	}

	public function worldAction() {
		$this->view->a_variable = 'Hello World!';
	}
}

?>
```

Si l'on charge l'adresse http://exemple.com?c=hello&a=world, l'action `world` va donc être exécutée sur le contrôleur `hello`.

Note : si `c` ou `a` n'est pas précisée, la valeur par défaut de chacune de ces variables est `index`. Ainsi l'adresse http://exemple.com?c=hello va exécuter l'action `index` du contrôleur `hello`.

Plus loin, sera utilisée la convention `hello/world` pour évoquer un couple contrôleur/action.

### Gestion des vues

Chaque vue est associée à un contrôleur et à une action. La vue associée à `hello/world` va être stockée dans un fichier bien spécifique : `views/hello/world.phtml`. Cette convention est imposée par Minz.

Comme expliqué plus haut, les vues sont du code HTML mixé à du PHP. Exemple de code :

```html
<p>
	Phrase passée en paramètre : <?= $this->a_variable ?>
</p>
```

La variable `$this->a_variable` a été passée précédemment par le contrôleur (voir exemple précédent). La différence est que dans le contrôleur il est nécessaire de passer par `$this->view` et que dans la vue `$this` suffit.

### Accéder aux paramètres GET / POST

Il est souvent nécessaire de profiter des paramètres passés par GET ou par POST. Dans Minz, ces paramètres sont accessibles de façon indistincts à l'aide de la classe `Minz_Request`. Exemple de code :

```php
<?php

$default_value = 'foo';
$param = Minz_Request::param('bar', $default_value);

// Affichera la valeur du paramètre `bar` (passé via GET ou POST)
// ou "foo" si le paramètre n'existe pas.
echo $param;

// Force la valeur du paramètre `bar`
Minz_Request::_param('bar', 'baz');

// Affichera forcément "baz" puisque nous venons de forcer sa valeur.
// Notez que le second paramètre (valeur par défaut) est facultatif.
echo Minz_Request::param('bar');

?>
```

La méthode `Minz_Request::isPost()` peut être utile pour n'exécuter un morceau de code que s'il s'agit d'une requête POST.

Note : il est préférable de n'utiliser `Minz_Request` que dans les contrôleurs. Il est probable que vous rencontriez cette méthode dans les vues de FreshRSS, voire dans les modèles, mais sachez qu'il ne s'agit **pas** d'une bonne pratique.

### Accéder aux paramètres de session

L'accès aux paramètres de session est étrangement similaire aux paramètres GET / POST mais passe par la classe `Minz_Session` cette fois-ci ! Il n'y a pas d'exemple ici car vous pouvez reprendre le précédent en changeant tous les `Minz_Request` par des `Minz_Session`.

### Gestion des URL

Pour profiter pleinement du système de routage de Minz, il est fortement déconseillé d'écrire les URL en dur dans votre code. Par exemple, la vue suivante doit être évitée :

```html
<p>
	Accéder à la page <a href="http://exemple.com?c=hello&amp;a=world">Hello world</a>!
</p>
```

Si un jour il est décidé d'utiliser un système d'« url rewriting » pour avoir des adresses au format http://exemple.com/controller/action, toutes les adresses précédentes deviendraient ineffectives !

Préférez donc l'utilisation de la classe `Minz_Url` et de sa méthode `display()`. `Minz_Url::display()` prend en paramètre un tableau de la forme suivante :

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

Comme cela peut devenir un peu pénible à utiliser à la longue, surtout dans les vues, il est préférable d'utiliser le raccourci `_url()` :

```php
<?php

// Affichera la même chose que précédemment
echo _url('hello', 'world', 'foo', 'bar');

?>
```

Note : en règle générale, la forme raccourcie (`_url()`) doit être utilisée dans les vues tandis que la forme longue (`Minz_Url::display()`) doit être utilisée dans les contrôleurs.

### Redirections

Il est souvent nécessaire de rediriger un utilisateur vers une autre page. Pour cela, la classe `Minz_Request` dispose d'une autre méthode utile : `forward()`. Cette méthode prend en argument le même format d'URL que celui vu juste avant.

Exemple de code :

```php
<?php

$url_array = [
	'c' => 'hello',
	'a' => 'world',
];

// Indique à Minz de rediriger l'utilisateur vers la page hello/world.
// Notez qu'il s'agit d'une redirection au sens Minz du terme, pas d'une redirection que le navigateur va avoir à gérer (code HTTP 301 ou 302)
// Le code qui suit forward() va ainsi être exécuté !
Minz_Request::forward($url_array);

// Pour effectuer une redirection type 302, ajoutez "true".
// Le code qui suivra ne sera alors jamais exécuté.
Minz_Request::forward($url_array, true);

?>
```

Il est très fréquent de vouloir effectuer une redirection tout en affichant un message à l'utilisateur pour lui indiquer comment s'est déroulée l'action effectuée juste avant (validation d'un formulaire par exemple). Un tel message est passé par une variable de session `notification` (note : nous parlerons plutôt de « feedback » désormais pour éviter la confusion avec une notification qui peut survenir à tout moment). Pour faciliter ce genre d'action très fréquente, il existe deux raccourcis qui effectuent tout deux une redirection type 302 en affectant un message de feedback :

```php
<?php

$url_array = [
	'c' => 'hello',
	'a' => 'world',
];
$feedback_good = 'Tout s\'est bien passé !';
$feedback_bad = 'Oups, quelque chose n\'a pas marché.';

Minz_Request::good($feedback_good, $url_array);

// ou

Minz_Request::bad($feedback_bad, $url_array);

?>
```

### Gestion de la traduction

Il est fréquent (et c'est un euphémisme) de vouloir afficher des phrases à l'utilisateur. Dans l'exemple précédent par exemple, nous affichions un feedback à l'utilisateur en fonction du résultat d'une validation de formulaire. Le problème est que FreshRSS possède des utilisateurs de différentes nationalités. Il est donc nécessaire de pouvoir gérer différentes langues pour ne pas rester cantonné à l'Anglais ou au Français.

La solution consiste à utiliser la classe `Minz_Translate` qui permet de traduire dynamiquement FreshRSS (ou toute application basée sur Minz). Avant d'utiliser ce module, il est nécessaire de savoir où trouver les chaînes de caractères à traduire. Chaque langue possède son propre sous-répertoire dans un répertoire parent nommé `i18n`. Par exemple, les fichiers de langue en Français sont situés dans `i18n/fr/`. Il existe sept fichiers différents :

- `admin.php` pour tout ce qui est relatif à l'administration de FreshRSS ;
- `conf.php` pour l'aspect configuration ;
- `feedback.php` contient les traductions des messages de feedback ;
- `gen.php` stocke ce qui est global à FreshRSS (gen pour « general ») ;
- `index.php` pour la page principale qui liste les flux et la page « À propos » ;
- `install.php` contient les phrases relatives à l'installation de FreshRSS ;
- `sub.php` pour l'aspect gestion des abonnements (sub pour « subscription »).

Cette organisation permet de ne pas avoir un unique énorme fichier de traduction.

Les fichiers de traduction sont assez simples : il s'agit seulement de retourner un tableau PHP contenant les traductions. Extrait du fichier `app/i18n/fr/gen.php` :

```php
<?php

return [
	'action' => [
		'actualize' => 'Actualiser',
		'back_to_rss_feeds' => '← Retour à vos flux RSS',
		'cancel' => 'Annuler',
		'create' => 'Créer',
		'disable' => 'Désactiver',
	],
	'freshrss' => [
		'_' => 'FreshRSS',
		'about' => 'À propos de FreshRSS',
	],
];

?>
```

Pour accéder à ces traductions, `Minz_Translate` va nous aider à l'aide de sa méthode `Minz_Translate::t()`. Comme cela peut être un peu long à taper, il a été introduit un raccourci qui **doit** être utilisé en toutes circonstances : `_t()`. Exemple de code :

```html
<p>
	<a href="<?= _url('index', 'index') ?>">
		<?= _t('gen.action.back_to_rss_feeds') ?>
	</a>
</p>
```

La chaîne à passer à la fonction `_t()` consiste en une série d'identifiants séparés par des points. Le premier identifiant indique de quel fichier on veut extraire la traduction (dans notre cas présent, de `gen.php`), tandis que les suivantes indiquent des entrées de tableaux. Ainsi `action` est une entrée du tableau principal et `back_to_rss_feeds` est une entrée du tableau `action`. Cela permet d'organiser encore un peu plus nos fichiers de traduction.

Il existe un petit cas particulier qui permet parfois de se simplifier la vie : le cas de l'identifiant `_`. Celui-ci doit nécessairement être présent en bout de chaîne et permet de donner une valeur à l'identifiant de niveau supérieur. C'est assez dur à expliquer mais très simple à comprendre. Dans l'exemple donné plus haut, un `_` est associé à la valeur `FreshRSS` : cela signifie qu'il n'y a pas besoin d'écrire `_t('gen.freshrss._')` mais `_t('gen.freshrss')` suffit.

### Gestion de la configuration

## Écrire une extension pour FreshRSS

Nous y voilà ! Nous avons abordé les fonctionnalités les plus utiles de Minz et qui permettent de faire tourner FreshRSS correctement et il est plus que temps d'aborder les extensions en elles-même.

Une extension permet donc d'ajouter des fonctionnalités facilement à FreshRSS sans avoir à toucher au cœur du projet directement.

### Les fichiers et répertoires de base

La première chose à noter est que **toutes** les extensions **doivent** se situer dans le répertoire `extensions`, à la base de l'arborescence de FreshRSS. Une extension est un répertoire contenant un ensemble de fichiers et sous-répertoires obligatoires ou facultatifs. La convention veut que l'on précède le nom du répertoire principal par un « x » pour indiquer qu'il ne s'agit pas d'une extension incluse par défaut dans FreshRSS.

Le répertoire principal d'une extension doit comporter au moins deux fichiers **obligatoire** :

- Un fichier `metadata.json` qui contient une description de l'extension. Ce fichier est écrit en JSON ;
- Un fichier `extension.php` contenant le point d'entrée de l'extension.

Il est possible aussi que vous ayez besoin de fichiers ou sous-répertoires additionnels selon vos besoins :

- `configure.phtml` est le fichier contenant le formulaire permettant de paramétrer votre extension ;
- Un répertoire `static/` contenant fichiers CSS et JavaScript dont vous aurez besoin pour votre extension. Notez que si vous devez écrire beaucoup de CSS il est peut-être plus intéressant d'écrire un thème complet (mais ce n'est pas le sujet de cette fiche technique) ;
- Un répertoire `Controllers` contenant des contrôleurs additionnels ;
- Un répertoire `i18n` contenant des traductions supplémentaires ;
- Des répertoires `layout` et `views` permettant de définir de nouvelles vues ou d'écraser les vues actuelles.

De plus, il est de bon ton d'avoir un fichier `LICENSE` indiquant la licence sous laquelle est distribuée votre extension et un fichier `README` donnant une description détaillée de celle-ci.

### Écrire le fichier metadata.json

Le fichier `metadata.json` définit votre extension à travers un certain nombre d'éléments importants. Il doit contenir un tableau JSON valide contenant les entrées suivantes :

- `name` : le nom de votre extension ;
- `author` : votre nom, éventuellement votre adresse mail mais il n'y a pas de format spécifique à adopter ;
- `description` : une description de votre extension ;
- `version` : le numéro de version actuel de l'extension ;
- `entrypoint` : indique le point d'entrée de votre extension. Il doit correspondre au nom de la classe contenue dans le fichier `extension.php` sans le suffixe `Extension` (donc si le point d'entrée est `HelloWorld`, votre classe s'appellera `HelloWorldExtension`) ;
- `type` : définit le type de votre extension. Il existe deux types : `system` et `user`. Nous étudierons cette différence juste après.

Seuls les champs `name` et `entrypoint` sont requis.

### Choisir entre extension « system » ou « user »

### Écrire le fichier extension.php

Ce fichier est le point d'entrée de votre extension. Il doit contenir une classe bien spécifique pour fonctionner. Comme évoqué plus haut, le nom de la classe doit être votre `entrypoint` suffixé par `Extension` (`HelloWorldExtension` par exemple). De plus, cette classe doit héritée de la classe `Minz_Extension` pour bénéficier des méthodes propres aux extensions.

Votre classe va bénéficier de quatre méthodes à redéfinir :

- `install()` est appelée lorsqu'un utilisateur va cliquer sur le bouton pour activer votre extension. Elle permet par exemple de mettre à jour la base de données d'un utilisateur afin de la rendre compatible avec l'extension. Elle retourne `true` si tout s'est bien passé ou, dans le cas contraire, une chaîne de caractères expliquant le problème ;
- `uninstall()` est appelée lorsqu'un utilisateur va cliquer sur le bouton pour désactiver votre extension. Ainsi, vous pourrez annuler les changements en base de données que vous avez potentiellement faits dans `install()`. Elle retourne `true` si tout s'est bien passé ou, dans le cas contraire, une chaîne de caractères expliquant le problème ;
- `init()` est appelée à chaque chargement de page *si l'extension est activée*. Elle va donc initialiser le comportement de l'extension. C'est la méthode la plus importante ;
- `handleConfigureAction()` est appelée lorsqu'un utilisateur charge le panneau de gestion de l'extension. Plus précisément, elle est appelée lorsque l'URL `?c=extension&a=configure&e=le-nom-de-votre-extension` est chargée. Vous devriez aussi écrire ici le comportement voulu lors de la validation du formulaire contenu dans votre fichier `configure.phtml`.

De plus, vous disposerez d'un certain nombre de méthodes directement héritées de `Minz_Extension` que vous ne devriez pas redéfinir :

- Les « getters » tout d'abord. La plupart sont suffisamment explicites pour ne pas les détailler : `getName()`, `getEntrypoint()`, `getPath()` (permet de récupérer le chemin vers votre extension), `getAuthor()`, `getDescription()`, `getVersion()`, `getType()` ;
- `getFileUrl($filename, $type)` va vous retourner l'URL vers un fichier du répertoire `static`. Le premier paramètre est le nom du fichier (sans `static/`), le deuxième est le type de fichier à servir (`css` ou `js`) ;
- `registerController($base_name)` va indiquer à Minz de prendre en compte le contrôleur donné dans le système de routage. Le contrôleur doit se situer dans votre répertoire `Controllers`, le nom du fichier doit être `<base_name>Controller.php` et le nom de la classe `FreshExtension_<base_name>_Controller`.

TODO :

- `registerViews()`
- `registerTranslates()`
- `registerHook($hook_name, $hook_function)`

### Système de « hooks »

TODO :

- `entry_before_display` (`function($entry) -> Entry | null`)
- `entry_before_insert` (`function($entry) -> Entry | null`)
- `feed_before_insert` (`function($feed) -> Feed | null`)
- `post_update` (`function(none) -> none`)
- `simplepie_before_init` (`function($simplePie, $feed) -> none`)

### Écrire le fichier configure.phtml

Lorsque vous voulez ajouter de la configuration à votre extension ou afficher ses informations, vous devez créer le fichier `configure.phtml`.
