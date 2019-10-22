We may not have answered all of your questions in the previous sections. The FAQ contains some questions that have not been answered elsewhere.

## What is /i at the end of the application URL?

Of course, ```/i``` has a purpose! We used it for performance and usability:

* It allows for serving icons, images, styles and scripts without cookies. Without that trick, those files would be downloaded more often, especially when form authentication is used. Also, HTTP requests would be heavier.
* ```./p/``` public root can be served without any HTTP access restrictions. Whereas it could be implemented in ```./p/i/```.
* It avoids problems while serving public resources like ```favicon.ico```, ```robots.txt```, etc.
* It allows the logo to be displayed instead of a white page while hitting a restriction or a delay during the loading process.

## Why robots.txt is located in a sub-folder?

To increase security, FreshRSS is hosted in two sections. The first section is public (```./p``` folder) and the second section is private (everything else). Therefore the ```robots.txt``` file is located in ```./p``` sub-folder.

As explained in the [administration section](../admins/03_Installation.md), it is highly recommended to make only the public section available at the domain level. With that configuration, ```./p``` is the root folder for http://demo.freshrss.org/, thus making ```robots.txt``` available at the root of the application.

The same rule applies for ```favicon.ico``` and ```.htaccess```.

## Why do I have errors while registering a feed?

There can be different origins for that problem.
The feed syntax can be invalid, it can be unrecognized by the SimplePie library. the hosting server can be the root of the problem, FreshRSS can be buggy.
The first step is to identify what causes the problem.
Here are the steps to follow:

1. __Verify if the feed syntax is valid__ with the [W3C on-line tool](http://validator.w3.org/feed/ "RSS and Atom feed validator"). If it is not valid, there is nothing we can do.
1. __Verify SimplePie validation__ with the [SimplePie on-line tool](http://simplepie.org/demo/ "SimplePie official demo"). If it is not recognized, there is nothing we can do.
1. __Verify FreshRSS integration__ with the [demo](http://demo.freshrss.org "FreshRSS official demo"). If it is not working, you need to [create an issue on Github](https://github.com/FreshRSS/FreshRSS/issues/new "Create an issue for FreshRSS") so we can have a look at it. If it is working, there is probably something fishy with the hosting server.

Here is a list of feeds which don't work:

* http://foulab.org/fr/rss/Foulab_News: is not a W3C valid feed (November 2014)
* http://eu.battle.net/hearthstone/fr/feed/news: is not a W3C valid feed (Novembre 2014)
* http://webseriesmag.blogs.liberation.fr/we/atom.xml: is not working for the user but succeed on all the described validations (November 2014)

## How to change a forgotten password?

Since [1.10.0](https://github.com/FreshRSS/FreshRSS/releases/tag/1.10.0) release, admins are able to change user passwords directly from the interface. This interface is available under  ```Administration → Manage users```.
Select a user, enter a password, and validate.

Since [1.8.0](https://github.com/FreshRSS/FreshRSS/releases/tag/1.8.0) release, admins are able to change user passwords using a terminal. It worth mentioning that it must have access to PHP CLI. Open a terminal, and type the following command:
```sh
./cli/update_user.php --user <username> --password <password>
```
For more information on that matter, there is a [dedicated documentation](../../cli/README.md).

## Permissions under SELinux

Some Linux distribution like Fedora or RedHat Enterprise Linux have SELinux system enabled. This acts like a firewall application, so all applications cannot write/modify files under certain conditions. While installing FreshRSS, step 2 can fail if the httpd process cannot write to some data sub-directories, the following command should be executed as root :
```sh
semanage fcontext -a -t httpd_sys_rw_content_t '/usr/share/FreshRSS/data(/.*)?'
restorecon -Rv /usr/share/FreshRSS/data
```
