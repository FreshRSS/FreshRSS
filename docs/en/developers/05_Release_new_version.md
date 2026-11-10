# Preparing the release

In order to get as much feedback as possible before a release, it’s preferable to announce it on GitHub by creating a dedicated ticket
([see examples](https://github.com/search?q=repo%3AFreshRSS%2FFreshRSS%20Call%20for%20testing&type=Issues)). This should be done **at least one week in advance**.

It’s also recommended to make the announcement on <mailing@freshrss.org>.

## Check the dev status

Before releasing a new version of FreshRSS, you must ensure that the code is stable and free of major bugs. Ideally, our tests should be automated and executed before any publication.

You must also **make sure that the CHANGELOG file is up to date** with the updates of the version to be released.

## Git process

```console
$ git checkout edge
$ git pull
$ vim constants.php
# Update version number x.y.y.z of FRESHRSS_VERSION
$ git commit -a
Version x.y.z
$ git tag -a x.y.z
Version x.y.z
$ git push && git push --tags
```

## Publicly announce the release

Create a [new GitHub release](https://github.com/FreshRSS/FreshRSS/releases/new) using the version number as tag (e.g. `1.2.3`).

As of FreshRSS 1.22.0, our automatic ZIP update system uses only GitHub
information: a GitHub release makes the new version instantly available to all
non-Git instances, without any manual change to an update server. The ZIP is
automatically downloaded from the tag (e.g.
`https://github.com/FreshRSS/FreshRSS/archive/refs/tags/1.2.3.zip`) based on
the `tag_name` field returned by the
[GitHub Releases API](https://docs.github.com/en/rest/releases/releases#get-the-latest-release).

Then announce the release:
* on <https://framapiaf.org/@freshrss>

## Starting the next version

```console
$ git checkout edge
$ vim constants.php
# Update the FRESHRSS_VERSION
$ vim CHANGELOG.md
# Prepare the changelog for the next version
$ git add CHANGELOG.md && git commit && git push
```
