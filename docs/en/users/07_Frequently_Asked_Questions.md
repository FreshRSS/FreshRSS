We may not have answered all of your questions in the previous sections. The FAQ contains some questions that have not been answered elsewhere.

## What is /i at the end of the application URL?

Of course, ```/i``` has a purpose! We used it for performance and usability:

* it allows to serve icons, images, styles and scripts without cookies. Whitout that trick, those files will be downloaded more often, specially when the form or the Personna authentications are used. Also, HTTP requests will be heavier.
* ```./p/``` public root can be served without any HTTP access restrictions. Whereas it could be implemented in ```./p/i/```.
* It spares from having problems while serving public resources like ```favicon.ico```, ```robots.txt```, etc.
* It allows to display the logo instead of a white page while hitting a restriction or a delay during the loading process.

## Why robots.txt is located in a sub-folder?

To increase security, FreshRSS is hosted in two sections. The first section is public (```./p``` folder) and the second section is private (everything else). Therefore the ```robots.txt``` file is located in ```./p``` sub-folder.

As explained in the [security section](/en/User_documentation/Installation/Security), it is highly recommended to make only the public section available at the domain level. With that configuration, ```./p``` is the root folder for http://demo.freshrss.org/, thus making ```robots.txt``` available at the root of the application.

The same rule applies for ```favicon.ico``` and ```.htaccess```.

## Why do I have errors while registering a feed?

There can be different origins for that problem.
The feed syntax can be invalid, it can be unrecognized by the SimplePie library. the hosting server can be the root of the problem, FreshRSS can be buggy.
The first step is to identify what causes the problem.
Here are the steps to follow:

1. __Verify if the feed syntax is valid__ with the [W3C on-line tool](http://validator.w3.org/feed/ "RSS and Atom feed validator"). If it is not valid, there is nothing we can do.
1. __Verify SimplePie validation__ with the [SimplePie on-line tool](http://simplepie.org/demo/ "SimplePie official demo"). If it is not recognized, there is nothing we can do.
1. __Verify FreshRSS integration__ with the [demo](http://demo.freshrss.org "FreshRSS official demo"). If it is not working, you need to [create an issue on Github](https://github.com/FreshRSS/FreshRSS/issues/new "Create an issue for FreshRSS") so we can have a look at it. If it is working, there is probably something fishy with the hosting server.

Here is a list of feed which don't work:

* http://foulab.org/fr/rss/Foulab_News: is not a W3C valid feed (November 2014)
* http://eu.battle.net/hearthstone/fr/feed/news: is not a W3C valid feed (Novembre 2014)
* http://webseriesmag.blogs.liberation.fr/we/atom.xml: is not working for the user but succeed on all the described validations (November 2014)