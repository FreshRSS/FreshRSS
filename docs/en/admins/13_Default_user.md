# Default User

Currently, we have one `main user`, also called `default user`, or `admin`. All the others are `regular users`.

The default user is the first created user within the install routine.

## Manage

The default user is always an administrator.

It is impossible to demote or disable the user.

## Anonymous reading mode

The default user is used for the anonymous reading.

How to enable the anonymous reading mode:
* go to settings `Administration` → `Authentication`
* enable the checkbox of `Allow anonymous reading of the default user’s articles`
* when no user is logged in then the feeds of the default user is shown

## Change the default user

There is no UI for changing the default user, but a CLI (`./cli/reconfigure.php --default_user YourNewAdmin`) is provided. It can also be changed manually by editing the text file `./FreshRSS/data/config.php` and changing `'default_user' => 'alice'`, to the desired user.
