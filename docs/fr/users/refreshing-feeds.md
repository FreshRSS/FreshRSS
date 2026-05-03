---
nav_order: 70
redirect_from:
  - /en/users/09_refreshing_feeds.html
---

# Rafraîchir les flux

To take full advantage of FreshRSS, it needs to retrieve new items from the
feeds you have subscribed to. There are several ways to do this:

- [Manual update](#manual-update)
    - [Complete update](#complete-update)
    - [Partial update](#partial-update)
- [Automatic update with cron](#automatic-update-with-cron)
- [Online cron](#online-cron)
    - [For Form Authentication (Web
      form)](#for-form-authentication-web-form)
    - [For HTTP authentication](#for-http-authentication)
    - [For No authentication (None)](#for-no-authentication-none)
- [Feed configuration of “Do not automatically refresh more often
  than”](#feed-configuration-of-do-not-automatically-refresh-more-often-than)
    - [Background](#background)
    - [Default value](#default-value)
    - [Individual feed configuration](#individual-feed-configuration)

## Mise à jour manuelle

Si vous ne pouvez pas ou ne voulez pas utiliser la méthode automatique, vous
pouvez le faire de façon manuelle. Il existe deux méthodes qui permettent de
mettre à jour tout ou partie des flux.

### Mise à jour complète

Cette mise à jour se fait pour l’ensemble des flux de l’instance. Pour
initier cette mise à jour, il suffit de cliquer sur le lien de mise à jour
disponible dans le menu de navigation.

![Menu de navigation](../img/users/refresh.1.png)

Lorsque la mise à jour démarre, une barre de progression apparait et
s’actualise au fur et à mesure de la récupération des articles.

![Barre de progression](../img/users/refresh.5.png)

### Mise à jour partielle

Cette mise à jour se fait pour le flux sélectionné uniquement. Pour initier
cette mise à jour, il suffit de cliquer sur le lien de mise à jour
disponible dans le menu du flux.

![Menu du flux](../img/users/refresh.2.png)

## Automatic update with cron

This is the recommended method.

Cette méthode n’est possible que si vous avez accès aux tâches planifiées de
la machine sur laquelle est installée votre instance de FreshRSS.

Le script qui permet de mettre à jour les articles s’appelle
*actualize_script.php* et se trouve dans le répertoire *app* de votre
instance de FreshRSS. La syntaxe des tâches planifiées ne sera pas expliqué
ici, cependant voici [une introduction rapide à
crontab](http://www.adminschoice.com/crontab-quick-reference/) qui peut vous
aider.

Ci-dessous vous trouverez un exemple permettant la mise à jour des articles
toutes les heures.

```cron
0 * * * * php /chemin/vers/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

## Online cron

If you do not have access to the installation server scheduled task, you can
still automate the update process.

To do so, you need to create a scheduled task, which need to call a specific
URL: <https://freshrss.example.net/i/?c=feed&a=actualize> (it could be
different depending on your installation). Depending on your application
authentication method, you need to adapt the scheduled task.

« Paramètres de configuration du script; Ils sont utilisables simultanément
: »

- Parameter `ajax`
  <https://freshrss.example.net/i/?c=feed&a=actualize&ajax=1> Only a status
  site is returned and not a complete website. Example: "OK"

- Parameter `maxFeeds`
  <https://freshrss.example.net/i/?c=feed&a=actualize&maxFeeds=30> If
  *maxFeeds* is set the configured amount of feeds is refreshed at once. The
  default setting is `10`.

- Parameters `user` and `token`
  <https://freshrss.example.net/i/?c=feed&a=actualize&user=alice&token=token123>
  Security parameters that allow a user to refresh their feed when *Web
  form* authentication is set. For detailed Documentation see “Form
  authentication” below.

### For Form Authentication (Web form)

If your FreshRSS instance is using Form Authentication, you can configure a
*Master authentication token* in a user profile to grant access to the
online cron.

![Token configuration](../img/users/token.png)

After setting the authentication token, use the `user` and `token`
parameters to call the online cron script. For the above example, the syntax
for the scheduled task will look as follows:

<https://freshrss.example.net/i/?c=feed&a=actualize&maxFeeds=10&ajax=1&user=alice&token=token123>

Alternatively, but not recommended, you can also allow anonymous users to
update feeds (*Allow anonymous refresh of the articles*), and that does not
require a token.

![Configuration de l’accès anonymes](../img/users/anonymous_access.1.png)

This allows anyone to update the feeds of the default user’s subscriptions.

### For HTTP authentication

If your FreshRSS instance is using HTTP authentication, you’ll need to
provide your credentials to the scheduled task.

**Note:** This method is discouraged as your credentials are stored in plain text.

```cron
0 * * * * curl -u alice:password123 'https://freshrss.example.net/i/?c=feed&a=actualize&maxFeeds=10&ajax=1&user=alice'
```

On some systems, that syntax might also work:

<https://alice:password123@freshrss.example.net/i/?c=feed&a=actualize&maxFeeds=10&ajax=1&user=alice>

### For No authentication (None)

If your FreshRSS instance uses no authentication (public instance, default
user):

<https://freshrss.example.net/i/?c=feed&a=actualize&maxFeeds=10&ajax=1>

## Feed configuration of “Do not automatically refresh more often than”

### Background

FreshRSS does not, by design, supports pull refreshes at frequencies higher
than once every 15 minutes. But FreshRSS supports [instant push
(WebSub)](websub.md).

FreshRSS is part of an RSS ecosystem. A typical reaction that we have seen
from several servers is to simply ban by, IP, user-agent, or to remove their
RSS feed altogether. Bad user behaviours affect the larger community.

### Default value

The default value of “Do not automatically refresh more often than” is set in Configuration -> Archiving.

The lowest global/default purposely cannot be set faster than every 20
minutes, to avoid wasting resources and make sure the RSS ecosystem remains
sane.

### Individual feed configuration

Under the settings for individual feeds, you can go down to 15min.

---
Read more: - [Normal, Global and Reader view](./views.md)  - [Filter the
feeds and search](./filtering-articles.md)
