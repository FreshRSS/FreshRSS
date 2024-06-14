# Refreshing feeds

To take full advantage of FreshRSS, it needs to retrieve new items from the feeds you have subscribed to. There are several ways to do this:

- [Manual update](#manual-update)
    - [Complete update](#complete-update)
    - [Partial update](#partial-update)
- [Automatic update with cron](#automatic-update-with-cron)
- [Online cron](#online-cron)
    - [For Form Authentication](#for-form-authentication)
    - [For HTTP authentication](#for-http-authentication)
    - [For No authentication None](#for-no-authentication-none)
- [Feed configuration of “Do not automatically refresh more often than”](#feed-configuration-of-do-not-automatically-refresh-more-often-than)
    - [Background](#background)
    - [Default value](#default-value)
    - [Individual feed configuration](#individual-feed-configuration)

## Manual update

If you can’t or don’t want to use the automatic method, you can update manually. There are two methods for updating all or some of the feeds.

### Complete update

This update occurs on all feeds. To trigger it, simply click on the update link in the navigation menu.

![Navigation menu](../img/users/refresh.1.png)

When the update starts, a progress bar appears and changes while feeds are processed.

![Progress bar](../img/users/refresh.5.png)

### Partial update

This update occurs on the selected feed only. To trigger it, simply click on the update link in the feed menu.

![Feed menu](../img/users/refresh.2.png)

## Automatic update with cron

This is the recommended method.

This method is only available if you have access to the scheduled tasks of the machine on which your FreshRSS instance is installed.

The script is named *actualize_script.php* and is located in the *app* folder. The scheduled task syntax will not be explained here. However, here is [a quick introduction to crontab](http://www.adminschoice.com/crontab-quick-reference/) that might help you.

Here is an example to trigger article update every hour.

```cron
0 * * * * php /path/to/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

## Online cron

If you do not have access to the installation server scheduled task, you can still automate the update process.

To do so, you need to create a scheduled task, which need to call a specific URL:
<https://freshrss.example.net/i/?c=feed&a=actualize> (it could be different depending on your installation). Depending on your application authentication method, you need to adapt the scheduled task.

Special parameters to configure the script - all parameters can be combined:

- Parameter `ajax`
<https://freshrss.example.net/i/?c=feed&a=actualize&ajax=1>
Only a status site is returned and not a complete website. Example: "OK"

- Parameter `maxFeeds`
<https://freshrss.example.net/i/?c=feed&a=actualize&maxFeeds=30>
If *maxFeeds* is set the configured amount of feeds is refreshed at once. The default setting is `10`.

- Parameter `token`
<https://freshrss.example.net/i/?c=feed&a=actualize&token=542345872345734>
Security parameter to prevent unauthorized refreshes. For detailed Documentation see "Form authentication".

### For Form Authentication

If your FreshRSS instance is using Form Authentication, you can configure an authentication token to grant access to the online cron.

![Token configuration](../img/users/token.1.png)

You can target a specific user by adding their username to the query string, with `&user=insert-username`:

The scheduled task syntax should look as follows:

<https://freshrss.example.net/i/?c=feed&a=actualize&maxFeeds=10&ajax=1&user=someone&token=my-token>

Alternatively, but not recommended, if you configure the application to allow anonymous reading, you can also allow anonymous users to update feeds (“Allow anonymous refresh of the articles”), and that does not require a token.

![Anonymous access configuration](../img/users/anonymous_access.1.png)

### For HTTP authentication

If your FreshRSS instance is using HTTP authentication, you’ll need to provide your credentials to the scheduled task.

**Note:** This method is discouraged as your credentials are stored in plain text.

```cron
0 * * * * curl -u alice:password123 'https://freshrss.example.net/i/?c=feed&a=actualize&maxFeeds=10&ajax=1&user=alice'
```

On some systems, that syntax might also work:

<https://alice:password123@freshrss.example.net/i/?c=feed&a=actualize&maxFeeds=10&ajax=1&user=alice>

### For No authentication (None)

If your FreshRSS instance uses no authentication (public instance, default user):

<https://freshrss.example.net/i/?c=feed&a=actualize&maxFeeds=10&ajax=1>

## Feed configuration of “Do not automatically refresh more often than”

### Background

FreshRSS does not, by design, supports pull refreshes at frequencies higher than once every 15 minutes. But FreshRSS supports [instant push (WebSub)](WebSub.md).

FreshRSS is part of an RSS ecosystem. A typical reaction that we have seen from several servers is to simply ban by, IP, user-agent, or to remove their RSS feed altogether. Bad user behaviours affect the larger community.

### Default value

The default value of “Do not automatically refresh more often than” is set in Configuration -> Archiving.

The lowest global/default purposely cannot be set faster than every 20 minutes, to avoid wasting resources and make sure the RSS ecosystem remains sane.

### Individual feed configuration

Under the settings for individual feeds, you can go down to 15min.

---
Read more:
- [Normal, Global and Reader view](./03_Main_view.md)
- [Filter the feeds and search](./10_filter.md)
