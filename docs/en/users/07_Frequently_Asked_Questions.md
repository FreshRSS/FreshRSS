We may not have answered all of your questions in the previous sections. The FAQ contains some questions that have not been answered elsewhere.

## What is `/i` at the end of the application URL?

Of course, ```/i``` has a purpose! It's used for performance and usability:

* It allows for serving icons, images, styles and scripts without cookies. Without that trick, those files would be downloaded more often, especially when form authentication is used. Also, HTTP requests would be heavier.
* The ```./p/``` public root can be served without any HTTP access restrictions. Whereas it could be implemented in ```./p/i/```.
* It avoids problems while serving public resources like ```favicon.ico```, ```robots.txt```, etc.
* It allows the logo to be displayed instead of a white page while hitting a restriction or a delay during the loading process.

## Why is `robots.txt` located in a sub-folder?

To increase security, FreshRSS is hosted in two sections. The first section is public (the `./p` folder) and the second section is private (everything else). Therefore the `robots.txt` file is located in the `./p` sub-folder.

As explained in the [security section](/en/User_documentation/Installation/Security), it's highly recommended to make only the public section available at the domain level. With that configuration, `./p` is the root folder for http://demo.freshrss.org/, thus making `robots.txt` available at the root of the application.

The same principle applies to `favicon.ico` and `.htaccess`.

## Why do I have errors while registering a feed?

There can be different origins for that problem.
The feed syntax can be invalid, it can be unrecognized by the SimplePie library, the hosting server can be the root of the problem, or FreshRSS can be buggy.
The first step is to identify what causes the problem.
Here are the steps to follow:

1. __Verify if the feed syntax is valid__ with the [W3C on-line tool](http://validator.w3.org/feed/ "RSS and Atom feed validator"). If it's not valid, there's nothing we can do.
1. __Verify SimplePie validation__ with the [SimplePie on-line tool](http://simplepie.org/demo/ "SimplePie official demo"). If it's not recognized, there's nothing we can do.
1. __Verify FreshRSS integration__ with the [demo](http://demo.freshrss.org "FreshRSS official demo"). If it's not working, you need to [create an issue on Github](https://github.com/FreshRSS/FreshRSS/issues/new "Create an issue for FreshRSS") so we can have a look at it. If it's working, there's probably something fishy with the hosting server.

Here's a list of feeds which don't work:

* http://foulab.org/fr/rss/Foulab_News: is not a W3C valid feed (November 2014)
* http://eu.battle.net/hearthstone/fr/feed/news: is not a W3C valid feed (November 2014)
* http://webseriesmag.blogs.liberation.fr/we/atom.xml: is not working for the user but passes validation (November 2014)

## How can you change a forgotten password?

Since the [1.10.0](https://github.com/FreshRSS/FreshRSS/releases/tag/1.10.0) release, admins can change user passwords directly from the interface. This interface is available under  ```Administration → Manage users```.
Select a user, enter a password, and validate.

Since the [1.8.0](https://github.com/FreshRSS/FreshRSS/releases/tag/1.8.0) release, admins can change user passwords using a terminal. It worth mentioning that you must have access to PHP CLI. Open a terminal, and type the following command:
```sh
./cli/update_user.php --user <username> --password <password>
```
For more information on that matter, please refer to the [dedicated documentation](../../cli/README.md).

## Permissions under SELinux

Some Linux distribution, like Fedora or RedHat Enterprise Linux, have SELinux enabled. This acts similar to a firewall application, so that applications can't write or modify files under certain conditions. While installing FreshRSS, step 2 can fail if the httpd process can't write to some data sub-directories. The following command should be executed as root to fix this problem:
```sh
semanage fcontext -a -t httpd_sys_rw_content_t '/usr/share/FreshRSS/data(/.*)?'
restorecon -Rv /usr/share/FreshRSS/data
```

## Why do I have a blank page while trying to configure the sharing options?

The `sharing` word in the URL is a trigger word for some an-blocker rules. Starting at version 1.16, `sharing` has been replaced by `integration` in the faulty URL while keeping the exact same wording through out the application.

If you are using a version prior to 1.16, you can disable your ad-blocker for FreshRSS or you can add a rule to allow the `sharing` page to be accessed.

Examples with _uBlock_:

- Whitelist your FreshRSS instance by adding it in _uBlock > Open the dashboard > Whitelist_.
- Authorize your FreshRSS instance to call `sharing` configuration page by adding the rule `*sharing,domain=~yourdomain.com` in _uBlock > Open the dashboard > My filters_
