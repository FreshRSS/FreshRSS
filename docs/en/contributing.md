## Report a bug

Have you found a bug? Don't panic, here are some steps to report it with ease:

1. Search for it on [the bug tracker](https://github.com/FreshRSS/FreshRSS/issues) (don't forget to use the search bar).
2. If you find a similar bug, don't hesitate to post a comment to add more importance to the related ticket.
3. If you didn't find it, [open a new ticket](https://github.com/FreshRSS/FreshRSS/issues/new).

If you have to create a new ticket, please try to keep in mind the following advice:

* Give an explicit title to the ticket so it will be easier to find it later.
* Be as exhaustive as possible in the description: what did you do? What is the bug? What are the steps to reproduce the bug?

We also need some information:

* Your FreshRSS version (on the about page or in the `constants.php` file)
* Your server configuration: the type of hosting and the PHP version
* Your storage system (SQLite, MySQL, MariaDB, PostgreSQL)
* If possible, the related logs (PHP logs and FreshRSS logs under `data/users/your_user/log.txt`)

For a more detailed guide on writing bug reports, please refer to [the in-depth guide on reporting bugs](developers/06_Reporting_Bugs).

## Fix a bug

Would you like to fix a bug? For optimum coordination between collaborators, you should follow these indications:

1. Be sure the bug is associated with a ticket and indicate that you'll work on it.
2. [Fork the project repository](https://help.github.com/articles/fork-a-repo/).
3. [Create a new branch](https://help.github.com/articles/creating-and-deleting-branches-within-your-repository/). The name of the branch should be clear, and ideally prefixed by the related ticket id. For instance, `783-contributing-file` to fix [ticket #783](https://github.com/FreshRSS/FreshRSS/issues/783).
4. Make your changes to your fork and [send a pull request](https://help.github.com/articles/using-pull-requests/).

If you have to write code, please follow [our coding style recommendations](developers/02_First_steps.md).

**Tip:** if you're searching for easy-to-fix bugs, please have a look at the "[good first issue](https://github.com/FreshRSS/FreshRSS/issues?q=is%3Aopen+is%3Aissue+label%3A%22good+first+issue%22)" ticket label.

## Submit an idea

You have great ideas, yes! Don't be shy and open [a new ticket](https://github.com/FreshRSS/FreshRSS/issues/new) on our bug tracker to ask if we can implement it. The greatest ideas often come from the shyest suggestions!

If your idea is nice, we'll have a look at it.

## Contribute to internationalization (i18n)

Learn how to contribute to translations in [the dedicated documentation](./internationalization.md).

## Contribute to documentation

The documentation needs a lot of improvements in order to be more useful to new contributors and we are working on it.
If you want to give some help, meet us in the main repositories [docs directory](https://github.com/FreshRSS/FreshRSS/tree/master/docs)!
