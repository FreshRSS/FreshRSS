# Configuring the email address validation

FreshRSS can verify that users give a valid email address. It is not configured
by default so you’ll have to follow these few steps to verify email addresses.

It is intended to administrators who host users and want to be sure to be able
to contact them.

## Force email validation

In your `data/config.php` file, you’ll find a `force_email_validation` item:
set it to `true`. An email field now appears on the registration page and
emails are sent when users change their email.

You can also enable this feature directly in FreshRSS: `Administration` >
`System configuration` > check `Force email addresses validation`.

## Configure the SMTP server

By default, FreshRSS will attempt to send emails with the [`mail`](https://www.php.net/manual/en/function.mail.php)
function of PHP. It is the simpler solution but it might not work as expected.
For example, we don’t support (yet?) sending emails from inside our official
Docker images. We recommend to use a proper SMTP server.

To configure a SMTP server, you’ll have to modify the `data/config.php` file.

First, change the `mailer` item to `smtp` (instead of the default `mail`).

Then, you should change the `smtp` options like you would do with a regular
email client. You can find the full list of options in the [`config.default.php` file](https://github.com/FreshRSS/FreshRSS/blob/edge/config.default.php).
If you’re not sure to what each item is corresponding, you may find useful [the
PHPMailer documentation](http://phpmailer.github.io/PHPMailer/classes/PHPMailer.PHPMailer.PHPMailer.html#properties)
(which is used by FreshRSS under the hood).

## Check your SMTP server is correctly configured

To do so, once you’ve enabled the `force_email_validation` option, you only
need to change your email address on the profile page and check that an email
arrives on the new address.

If it fails, you can change the environment (in `data/config.php` file, change
`production` to `development`). PHPMailer will become more verbose and you’ll
be able to see what happens in the PHP logs. If something’s wrong here, you’ll
probably better served by asking to your favorite search engine than asking us.
If you think that something’s wrong in FreshRSS code, don’t hesitate to open a
ticket though.

Also, make sure the email didn’t arrive in your spam.

Once you’re done, don’t forget to reconfigure your environment to `production`.

## Access the validation URL during development

You might find painful to configure a SMTP server when you’re developping and
`mail` function will not work on your local machine. For the moment, there is
no easy way to access the validation URL unless forging it. You’ll need to
information:

- the username of the user to validate (you should know it)
- its validation token, that you’ll find in its configuration file:

```console
$ # For instance, for a user called `alice`
$ grep email_validation_token data/users/alice/config.php | cut -d \' -f 4 -
3d75042a4471994a0346e18ae87602f19220a795
```

Then, the validation URL should be `http://localhost:8080/i/?c=user&a=validateEmail&username=alice&token=3d75042a4471994a0346e18ae87602f19220a795`

Don’t forget to adapt this URL with the correct port, username and token.
