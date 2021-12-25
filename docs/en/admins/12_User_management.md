# User Management

## User list

Settings page: `Administation` -> `Manage Users`.

The [default user](13_Default_user.md) is marked with italic letters.

## Create new user

Settings page: `Administation` -> `Manage Users`.

For a new user follwing information are necessary:
* language
* username
* is it an administrator account?
* password

If in the `System configuration` the `Force email addres validation` is enabled, than the email address input is shown and mandatory.

## User registration form

New users could use the self registration form in the frontend.

The user registration form is availabale via the login form, when maximal number of accounts is smaller than number of created accounts (Set up in `Administration` -> `System configuration`). If maximal number of account is 0, than there is no limit of user accounts' number.

If in the `System configuration` the `Force email addres validation` is enabled, than the email address input is shown and mandatory.

It is optional to have a `Terms of Service` (`ToS`). If ToS is enabled, then it is mandatory to check it for registration.

### Enable Terms of Service (ToS)

Create a file `tos.html` in `./data`.

Example of TOS: see `./data/tos.example.html`