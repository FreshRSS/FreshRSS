# How to contribute to FreshRSS?

## Chat with us

Do you want to ask us some questions? Do you want to discuss with us?
Don’t hesitate to [join our Mattermost chat](https://framateam.org/signup_user_complete/?id=e2680d3e3128b9fac8fdb3003b0024ee)!


## Report a bug

You found a bug? Don’t panic, here are some steps to report it easily:

1. Search for it on [the bug tracker](https://github.com/FreshRSS/FreshRSS/issues) (don’t forget to use the search bar).
2. If you find a similar bug, don’t hesitate to post a comment to add more importance to the related ticket.
3. If you didn’t find it, [open a new ticket](https://github.com/FreshRSS/FreshRSS/issues/new).

If you have to create a new ticket, try to apply the following advices:

- Give an explicit title to the ticket so it will be easier to find it later.
- Be as exhaustive as possible in the description: what did you do? What is the bug? What are the steps to reproduce the bug?
- We also need some information:
    + Your FreshRSS version (on about page or `constants.php` file)
    + Your server configuration: type of hosting, PHP version
    + Your storage system (SQLite, MySQL, MariaDB, PostgreSQL)
    + If possible, the related logs (PHP logs and FreshRSS logs under `data/users/your_user/log.txt`)

## Fix a bug

Did you want to fix a bug? To keep a great coordination between collaborators, you will have to follow these indications:

1. Be sure the bug is associated to a ticket and say you work on it.
2. [Fork this project repository](https://help.github.com/articles/fork-a-repo/).
3. [Create a new branch](https://help.github.com/articles/creating-and-deleting-branches-within-your-repository/). The name of the branch must be explicit and being prefixed by the related ticket id. For instance, `783-contributing-file` to fix [ticket #783](https://github.com/FreshRSS/FreshRSS/issues/783).
4. Make your changes to your fork and [send a pull request](https://help.github.com/articles/using-pull-requests/) on the **master branch**.

If you have to write code, please follow [our coding style recommendations](https://freshrss.github.io/FreshRSS/en/developers/01_First_steps.html).

**Tip:** if you are searching for bugs easy to fix, have a look at the « [Good first issue](https://github.com/FreshRSS/FreshRSS/issues?q=label%3A%22good+first+issue+%3Ababy%3A%22) » and/or « [Help wanted](https://github.com/FreshRSS/FreshRSS/issues?q=label%3A%22help+wanted+%3Aoctocat%3A%22) » ticket labels.

## Submit an idea

You have great ideas, yes! Don't be shy and open [a new ticket](https://github.com/FreshRSS/FreshRSS/issues/new) on our bug tracker to ask if we can implement it. The greatest ideas often come from the shyest suggestions!

If your idea is nice, we’ll have a look at it.

## Contribute to internationalization (i18n)

If you want to improve internationalization, please open a new ticket first and follow indications from « Fix a bug » section.

Translations are present in the subdirectories of `./app/i18n/`.

We are working on a better way to handle internationalization but don’t hesitate to suggest any idea!

## Contribute to documentation

[The documentation](https://freshrss.github.io/FreshRSS/) always needs improvements in order to be more useful to newcomers. If you want to give some help, meet us on [the dedicated sub-folder](https://github.com/FreshRSS/FreshRSS/tree/master/docs)!
