# How to contribute to FreshRSS?

## Report a bug

You found a bug? Don't panic, here are some steps to report it easily:

1. Search for it on [the bug tracker](https://github.com/FreshRSS/FreshRSS/issues) (don't forget to use the search bar).
2. If you find a similar bug, don't hesitate to post a comment to add more importance to the related ticket.
3. If you didn't find it, [open a new ticket](https://github.com/FreshRSS/FreshRSS/issues/new).

If you have to create a new ticket, try to apply the following advices:

- Give an explicit title to the ticket so it will be easier to find it later.
- Be as exhaustive as possible in the description: what did you do? What is the bug? What are the steps to reproduce the bug?
- We also need some information:
    + Your FreshRSS version (on about page or `constants.php` file)
    + Your server configuration: type of hosting, PHP version
    + Your storage system (MySQL / MariaDB or SQLite)
    + If possible, the related logs (PHP logs and FreshRSS logs under `data/users/your_user/log.txt`)

## Fix a bug

Did you want to fix a bug? To keep a great coordination between collaborators, you will have to follow these indications:

1. Be sure the bug is associated to a ticket and say you work on it.
2. Fork the FreshRSS repository.
3. Get your repository `git clone -b dev git@github.com:your_username/FreshRSS.git && cd FreshRSS`
4. It's better to create a dedicated branch to fix your bug: the name of the branch must be explicit and being prefixed by the related ticket id. For instance, `783-contributing-file` to fix [ticket #783](https://github.com/FreshRSS/FreshRSS/issues/783).
5. Once you'll have finished, commit your work, push your branch upstream (`git push --set-upstream origin your_branch_name`) and do a [pull request](https://github.com/FreshRSS/FreshRSS/compare) on the **dev branch**.
6. Wait and see.

If you have to write code, please follow [our coding style recommendations](http://doc2.freshrss.org/en/Developer_documentation/First_steps/Coding_style).

**Tip:** if you are searching for bugs easy to fix, have a look at the « [New comers](https://github.com/FreshRSS/FreshRSS/labels/New%20comers) » ticket label.

## Submit an idea

You have great ideas, yes! Don't be shy and open [a new ticket](https://github.com/FreshRSS/FreshRSS/issues/new) on our bug tracker to ask if we can implement it. The greatest ideas often come from the shyest suggestions!

If your idea is nice, we'll have a look at it.

TODO: complete

## Contribute to internationalization (i18n)

If you want to improve internationalization, please open a new ticket first and follow indications from « Fix a bug » section.

TODO: finish

We are working on a better way to handle internationalization.

## Contribute to documentation

The documentation needs a lot of improvements in order to be more useful to new contributors and we are working on it. If you want to give some help, meet us on [the dedicated repository](https://github.com/FreshRSS/documentation)!

TODO: finish
