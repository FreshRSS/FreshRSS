---
name: freshrss-git
description: FreshRSS version control, git workflow, branching strategy (edge/latest), diff/compare, PR changes.
allowed-tools: Bash(git:*) Read Grep
---

# FreshRSS working with version control (git)

FreshRSS uses a rolling-release approach with a main branch called `:edge`.
This is the branch to target for most pull requests.

Releases are tracked in a branch called `:latest`.

## Check changes made in the current branch

Also useful to locally check the state of a pull-request (PR).

```sh
git diff edge...HEAD
```

## Before commiting

```sh
make fix-all
make test-all
```
