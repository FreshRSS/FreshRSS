# Access Control

FreshRSS offers three methods of Access control: Form Authentication using JavaScript, HTTP based Authentication, or an uncontrolled state with no authentication required.

## Form Authentication

Form Authentication requires the use of JavaScript. It will work on any supported version of PHP,
but version 5.5 or newer is recommended (see footnote 1 in [prerequisites](02_Prerequisites.md) for the reason why).

This option requires nothing more than selecting Form Authentication during installation.

## HTTP Authentication

You may also choose to use HTTP Authentication provided by your web server.[^1]

If you choose to use this option, create a `./p/i/.htaccess` file with a matching `.htpasswd` file.

You can also use any authentication backend as long as your web server exposes the authenticated user through the `REMOTE_USER` variable.

By default, new users allowed by HTTP Basic Auth will automatically be created in FreshRSS the first time they log in.
You can disable auto-registration of new users by setting `http_auth_auto_register` to `false` in the configuration file.
When using auto-registration, you can optionally use the `http_auth_auto_register_email_field` to specify the name of a web server
variable containing the email address of the authenticated user (e.g. `REMOTE_USER_EMAIL`).

## External Authentication

You may also use the `HTTP_REMOTE_USER` header to integrate with a your reverse-proxy's authentication.

To enable this feature, you need to add the IP range (in CIDR notation) of your trusted proxy in the `trusted_sources` configuration option.
To allow only one IP, you can use a `/32` like this: `trusted_sources => array('192.168.1.10/32')`.

WARNING: FreshRSS will trust any IP configured in the `trusted_sources` option, if your proxy isn't properly secured, an attacker could simply attach this header and get admin access.

## No Authentication

Not using authentication on your server is dangerous, as anyone with access to your server would be able to make changes as an admin.
It is never advisable to not use any form of authentication, but **never** chose this option on a server that is able to be accessed outside of your home network.

## Hints

You can switch your authentication method at any time by editing the `./data/config.php` file, on the line that begins `'auth_type'`.

[^1]: See [the Apache documentation](https://httpd.apache.org/docs/trunk/howto/auth.html)
