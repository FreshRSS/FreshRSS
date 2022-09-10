# Opening a pull request

So you want to propose a patch to the community? It’s time to open a [pull request](https://github.com/FreshRSS/FreshRSS/pulls)!

When you open a PR, your message will be prefilled with a message based on [a template](https://github.com/FreshRSS/FreshRSS/blob/edge/docs/pull_request_template.md). It contains a checklist to make sure you didn’t forget anything. It is very important to verify you did everything mentioned so documentation is up-to-date, the commit history stays clear and the code is always stable.

The rest of this document explains specific points.

## How to rebase your branch on `edge`

**TODO:** Update this section. With GitHub’s *squash and merge*, rebasing (and other forms of history rewriting) is more dangerous and annoying (e.g. breaking review mechanism) than useful.

Rebasing a branch is useful to make sure your code is based on the most recent version of FreshRSS and there are no conflicts. You have two ways to do that.

If you have any doubt, please let us know and we’ll help you! We all began with Git one day and it’s not an easy thing to work with.

### Rebasing

Rebasing is the cleanest method because the Git history will be completely linear and consequently easier to read and navigate. It might also be more difficult if you’re not at ease with Git since conflicts are harder to resolve.

Note that you should never rebase a branch if someone else is working on it. Otherwise, since it rewrites the history, it can be a real mess to sort it out.

To rebase a branch:

```sh
git checkout edge       # go on edge branch
git pull upstream edge  # pull the last version of edge
git checkout -          # go back to your branch
git rebase edge         # rebase your branch on edge
```

If you feel confident, you can use `git rebase -i edge` to rewrite your history and make it clearer.

### Merging

If you prefer, you can simply merge `edge` into your own branch. Conflicts might be easier to resolve, but your Git history will be less readable. Don’t worry, we will take care of it before merging your PR back into `edge`.

To merge `edge`:

```sh
git checkout edge       # go on edge branch
git pull upstream edge  # pull the last version of edge
git checkout -          # go back to your branch
git merge edge          # merge edge into your branch
```

## How to write a Git commit message

It’s important to have proper commit messages in order to facilitate later debugging, so please read the following advice. Commit messages should explain the choices made in the past (the “why?”)

The first line should start with a verb (e.g., “Add”) and explain the objective of the commit in few words. It’s usually less than 50 characters so it remains concise. You can consider this line the subject of your commit. Think of it as the second part of a sentence that starts with the words “This commit will.”

* This commit will *add feature X*

Then, insert a blank line, and start to write the body. It’s usually wrapped at 72 characters, but you are pretty free in the tone of the message. The body is the place where you can clarify the context of your patch. For instance, you can explain what you were doing when you identified a bug, or the problem you had before your patch. Providing this information helps other developers understand why a specific choice was made, especially when a patch introduces a bug that is identified months later.

You also can add references (e.g., the URL to the initial ticket in the bug tracker, or a reference to some forum explaining a point).

You can find more information about commit messages [on this blog post](https://chris.beams.io/posts/git-commit/).

## How to write tests

FreshRSS has few tests for now, but we’re working on it. We added this point to the checklist to help us to write more tests, and we would really appreciate it if you wrote a test that ensures your patch is working.

We use [PHPUnit](https://phpunit.de/) version 7.5 ([documentation](https://phpunit.readthedocs.io/en/7.5/)).

You’ll find more information on how to run tests [in this document](03_Running_tests.md).

Feel free to ask us for assistance. Not everything will be easy to test, so don’t spend too much time on this.

## Why you should write documentation

A friendly project should have correct and complete documentation, so newcomers don’t have to ask too many questions, and users can find answers to their problems. The documentation should not be written “later” or chances are it’ll never be.

Our documentation can still be improved quite a bit, so you’re very welcome if you want to help.
