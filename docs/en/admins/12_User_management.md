# User Management

## User list

Settings page: `Administration` -> `Manage Users`.

The [default user](13_Default_user.md) is marked with italic letters.

## Create new user

Settings page: `Administration` → `Manage Users`.

For a new user the following information is necessary:
* language
* username
* is it an administrator account?
* password

If in the `System configuration` the `Force email address validation` is enabled, then the email address input is shown and mandatory.

## User registration form

New users could use the self registration form in the frontend.

The user registration form is available via the login form, when the maximum number of accounts is smaller than the number of created accounts (Set up in `Administration` → `System configuration`). If the maximum number of accounts is 0, than there is no limit on the number of user accounts.

If in the `System configuration` the `Force email address validation` is enabled, than the email address input is shown and mandatory.

It is optional to have a `Terms of Service` (`ToS`). If ToS is enabled, then it is mandatory to check it for registration.

### Enable Terms of Service (ToS)

Create a file `tos.html` in `./data`.

Example of TOS: see `./data/tos.example.html`
