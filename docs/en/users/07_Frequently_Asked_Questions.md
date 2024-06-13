We may not have answered all of your questions in the previous sections. The FAQ contains some questions that have not been answered elsewhere.

## What is `/i` at the end of the application URL?

Of course, ```/i``` has a purpose! It’s used for performance and usability:

* It allows for serving icons, images, styles and scripts without cookies. Without that trick, those files would be downloaded more often, especially when form authentication is used. Also, HTTP requests would be heavier.
* The ```./p/``` public root can be served without any HTTP access restrictions. Whereas it could be implemented in ```./p/i/```.
* It avoids problems while serving public resources like ```favicon.ico```, ```robots.txt```, etc.
* It allows the logo to be displayed instead of a white page while hitting a restriction or a delay during the loading process.

## Why is `robots.txt` located in a sub-folder?

To increase security, FreshRSS is hosted in two sections. The first section is public (the `./p` folder) and the second section is private (everything else). Therefore the `robots.txt` file is located in the `./p` sub-folder.

As explained in the [security section](../admins/09_AccessControl.html), it’s highly recommended to make only the public section available at the domain level.
With that configuration, `./p` is the root folder for <https://demo.freshrss.org/>, thus making `robots.txt` available at the root of the application.

The same principle applies to `favicon.ico` and `.htaccess`.

## Why do I have errors while registering a feed?

There can be different origins for that problem.
The feed syntax can be invalid, it can be unrecognized by the SimplePie library, the hosting server can be the root of the problem, or FreshRSS can be buggy.
The first step is to identify what causes the problem.
Here are the steps to follow:

1. __Verify if the feed syntax is valid__ with the [W3C on-line tool](https://validator.w3.org/feed/ "RSS and Atom feed validator"). If it’s not valid, there’s nothing we can do.
1. __Verify SimplePie validation__ with the [SimplePie on-line tool](https://simplepie.org/demo/ "SimplePie official demo"). If it’s not recognized, there’s nothing we can do.
1. __Verify FreshRSS integration__ with the [demo](https://demo.freshrss.org "FreshRSS official demo"). If it’s not working, you need to [create an issue on GitHub](https://github.com/FreshRSS/FreshRSS/issues/new "Create an issue for FreshRSS") so we can have a look at it. If it’s working, there’s probably something fishy with the hosting server.

## How can you change a forgotten password?

Since the [1.10.0](https://github.com/FreshRSS/FreshRSS/releases/tag/1.10.0) release, admins can change user passwords directly from the interface. This interface is available under  ```Administration → Manage users```.
Select a user, enter a password, and validate.

Since the [1.8.0](https://github.com/FreshRSS/FreshRSS/releases/tag/1.8.0) release, admins can change user passwords using a terminal. It worth mentioning that you must have access to PHP CLI. Open a terminal, and type the following command:

```sh
./cli/update_user.php --user <username> --password <password>
```

For more information on that matter, please refer to the [dedicated documentation](https://github.com/FreshRSS/FreshRSS/blob/edge/cli/README.md).

## Permissions under SELinux

Some Linux distribution, like Fedora or RedHat Enterprise Linux, have SELinux enabled. This acts similar to a firewall application, so that applications can’t write or modify files under certain conditions. While installing FreshRSS, step 2 can fail if the httpd process can’t write to some data sub-directories. The following command should be executed as root to fix this problem:

```sh
semanage fcontext -a -t httpd_sys_rw_content_t '/usr/share/FreshRSS/data(/.*)?'
restorecon -Rv /usr/share/FreshRSS/data
```

## Why do I have a blank page while trying to configure the sharing options?

The `sharing` word in the URL is a trigger word for some ad-blocker rules. Starting with version 1.16, `sharing` has been replaced by `integration` in the faulty URL while keeping the exact same wording throughout the application.

If you are using a version prior to 1.16, you can disable your ad-blocker for FreshRSS or you can add a rule to allow the `sharing` page to be accessed.

Examples with _uBlock_:

* Whitelist your FreshRSS instance by adding it in _uBlock > Open the dashboard > Whitelist_.
* Authorize your FreshRSS instance to call `sharing` configuration page by adding the rule `*sharing,domain=~yourdomain.com` in _uBlock > Open the dashboard > My filters_

## Problems with firewalls

If you have the error "Blast! This feed has encountered a problem. Please verify that it is always reachable then update it.", it might be because of a firewall misconfiguration.

To identify the problem, here are the steps to follow:

* step 1: Try to reach the feed locally to discard a problem with the feed itself. You can use your browser to this purpose.
* step 2: Try to reach the feed from the host in which FreshRSS is installed. Something like `time curl -v 'https://github.com/FreshRSS/FreshRSS/commits/edge.atom'` should make the deal. If you are running FreshRSS within a Docker container, then you can check connectivity from within the container itself with something similar to `sudo docker exec freshrss php -r "readfile('https://github.com/FreshRSS/FreshRSS/commits/edge.atom');"`. If none of this works, then it might be a problem with your firewall.

Then to fix it, you need to do check your firewall configuration and ensure that you are not blocking connections to IPs and/or ports in which your feeds are located. If using iptables and you are blocking inbound connections to ports 80/443, check that the rules are properly configured and you are not also blocking outbound connections to the very same ports.

For example, when using the firewall provided by Synology, you can block traffic for certain applications (i.e., ports). One could think that these rules would be applied only to incoming connections but specifying * for the originating host of the requests will also include your local networks. To deal with this issue, you will have to add exceptions for your local networks to be able to access those ports with a higher priority than the one blocking incoming connections. This could be similar for other frontends to iptables. Please check the following discussion about a [similar issue](https://www.reddit.com/r/synology/comments/8fo2sj/ds918_firewall_blocking_outgoing_traffic_from/).
