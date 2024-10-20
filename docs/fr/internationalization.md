# Gestion de la traduction

Grâce à nos contributeurs, FreshRSS est traduit dans [plus de 20 langues](./users/05_Configuration.md#language).
Cette section expliquera les bases de l’internationalisation dans FreshRSS, de la traduction de l’application dans votre propre langue à la réalisation d’un changement spécifique.

## Aperçu

Il est fréquent (et c’est un euphémisme) de vouloir afficher des phrases à
l’utilisateur. Dans l’exemple précédent par exemple, nous affichions un
feedback à l’utilisateur en fonction du résultat d’une validation de
formulaire. Le problème est que FreshRSS possède des utilisateurs de
différentes nationalités. Il est donc nécessaire de pouvoir gérer
différentes langues pour ne pas rester cantonné à l’Anglais ou au Français.

La solution consiste à utiliser la classe `Minz_Translate` qui permet de
traduire dynamiquement FreshRSS (ou toute application basée sur Minz). Avant
d’utiliser ce module, il est nécessaire de savoir où trouver les chaînes de
caractères à traduire. Chaque langue possède son propre sous-répertoire dans
un répertoire parent nommé `i18n`. Par exemple, les fichiers de langue en
Français sont situés dans `i18n/fr/`. Il existe sept fichiers différents :

* `admin.php` pour tout ce qui est relatif à l’administration de FreshRSS ;
* `conf.php` pour l’aspect configuration ;
* `feedback.php` contient les traductions des messages de feedback ;
* `gen.php` stocke ce qui est global à FreshRSS (gen pour « general ») ;
* `index.php` pour la page principale qui liste les flux et la page « À propos » ;
* `install.php` contient les phrases relatives à l’installation de FreshRSS ;
* `sub.php` pour l’aspect gestion des abonnements (sub pour « subscription »).

Cette organisation permet de ne pas avoir un unique énorme fichier de
traduction.

Les fichiers de traduction sont assez simples : il s’agit seulement de
retourner un tableau PHP contenant les traductions. Extrait du fichier
`app/i18n/fr/gen.php` :

```php
<?php
return array(
	'action' => array(
		'actualize' => 'Actualiser',
		'back_to_rss_feeds' => '← Retour à vos flux RSS',
		'cancel' => 'Annuler',
		'create' => 'Créer',
		'disable' => 'Désactiver',
	),
	'freshrss' => array(
		'_' => 'FreshRSS',
		'about' => 'À propos de FreshRSS',
	),
);
```

Pour accéder à ces traductions, `Minz_Translate` va nous aider à l’aide de
sa méthode `Minz_Translate::t()`. Comme cela peut être un peu long à taper,
il a été introduit un raccourci qui **doit** être utilisé en toutes
circonstances : `_t()`. Exemple de code :

```html
<p>
	<a href="<?= _url('index', 'index') ?>">
		<?= _t('gen.action.back_to_rss_feeds') ?>
	</a>
</p>
```

La chaîne à passer à la fonction `_t()` consiste en une série d’identifiants
séparés par des points. Le premier identifiant indique de quel fichier on
veut extraire la traduction (dans notre cas présent, de `gen.php`), tandis
que les suivantes indiquent des entrées de tableaux. Ainsi `action` est une
entrée du tableau principal et `back_to_rss_feeds` est une entrée du tableau
`action`. Cela permet d’organiser encore un peu plus nos fichiers de
traduction.

Il existe un petit cas particulier qui permet parfois de se simplifier la
vie : le cas de l’identifiant `_`. Celui-ci doit nécessairement être présent
en bout de chaîne et permet de donner une valeur à l’identifiant de niveau
supérieur. C’est assez dur à expliquer mais très simple à comprendre. Dans
l’exemple donné plus haut, un `_` est associé à la valeur `FreshRSS` : cela
signifie qu’il n’y a pas besoin d’écrire `_t('gen.freshrss._')` mais
`_t('gen.freshrss')` suffit.
