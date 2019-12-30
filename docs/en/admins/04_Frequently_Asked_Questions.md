# Frequently Asked Questions

We may not have answered all of your questions in the previous sections. The FAQ contains some questions that have not been answered elsewhere.

## Promoting a user to admin

At the moment, there can be only one *admin* user for the system.
Thus promoting one user to *admin* demotes the current *admin* user.

The recommended way of promoting a user is with the help of the CLI tool.
You only have to do is to run the following command:
```sh
./cli/reconfigure.php --default_user <username>
```

Alternatively, you can edit configuration files manually.
To do so, you need to change the *default_user* value in the file *./data/config.php*.
As the file is a PHP file, you have to make sure that it's still valid after the update by running the following command:
```sh
php -l ./data/config.php
```

## Disabling self-registration

Users can register directly on the login screen only if the configuration allows them.
Under *Administration* > *System configuration*, you have access to *Max number of accounts*.
As stated on that page, there is no limitation if you input **0**, thus allowing any number of user to self-register.
If you input any other number, you will create a limitation on self-registering users.
That means that as soon as the limit is reached, users cannot self-register but they can still be registered by the *admin* user.
Using the value **1**, disables the self-registration since the spot is used by the *admin* user.
