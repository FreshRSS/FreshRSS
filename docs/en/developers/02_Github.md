# Branching

## Basic
If you are new to Git, here are some of the resources you might find useful:

* [GitHub's blog post](https://github.com/blog/120-new-to-git)
* <http://try.github.com/>
* <http://sixrevisions.com/resources/git-tutorials-beginners/>
* <http://rogerdudler.github.io/git-guide/>

## Getting the latest code from the FreshRSS repository
First you need to add the official repo to your remote repo list:
```bash
git remote add upstream git@github.com:FreshRSS/FreshRSS.git
```

You can verify the remote repo is successfully added by using:
```bash
git remote -v show
```

Now you can pull the latest development code:
```bash
git checkout master
git pull upstream master
```

## Starting a new development branch
```bash
git checkout -b my-development-branch
```

# Sending a patch

```bash
# Add the changed file, here actualize_script.php
git add app/actualize_script.php
# Commit the change and write a proper commit message
git commit
# Double check all looks well
git show
# Push it to your fork
git push
```

Now you can create a PR based on your branch.

## How to write a commit message

A commit message should succintly describe the changes on the first line. For example:

> Fix broken icon

If necessary, this can be followed by a blank line and a longer explanation.

For further tips, see [here](https://chris.beams.io/posts/git-commit/).
