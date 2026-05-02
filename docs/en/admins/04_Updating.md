# Updating

This is the general procedure; for specific Linux commands, see [Updating on Linux](07_LinuxUpdate.md).

> ℹ️ Update version by version (e.g. from 1.26.0, go to 1.27.1 before 1.28.1) and verify FreshRSS runs after each step. The web interface walks this path automatically; with git or a zip archive, pick intermediate versions yourself.

## Backing up

Before updating, back up:

- `./data/`
- `./extensions/` if you use third-party extensions
- `./i/themes/` if you have custom themes
- Your database, if using MySQL, MariaDB, or PostgreSQL

See the [Backup page](05_Backup.md) for the full list and procedures.

## Using the web interface

Web updates require group write permissions on the FreshRSS source folder.

Log in as admin, open the Settings menu (top right), choose Administration, then Update, and press "Check for new updates". The page is also reachable at `http://<your_server>/i/?c=update`. This will check for and apply a new stable version, if available.

## Using git

Use git to update, change branches, or switch to a specific version. From your FreshRSS install directory:

> ⚠️ Make sure your backup is outside the FreshRSS directory before starting.

```sh
git fetch --all
git reset --hard          # discards local changes to tracked files
git clean -f -d           # removes untracked files (custom themes, extensions, local edits)
git checkout edge         # or `latest` for stable, or a tag like `1.27.1` for a specific version
git pull --ff-only        # skip for a tag checkout
```

Then re-apply file ownership and permissions.

See [Updating on Linux](07_LinuxUpdate.md#using-git) for the same flow with `sudo` and the FreshRSS permissions helper.

## Using a zip archive

Updating from a zip archive works for any source installation.

1. Download the latest [stable](https://github.com/FreshRSS/FreshRSS/archive/latest.zip) or [rolling](https://github.com/FreshRSS/FreshRSS/archive/edge.zip) release and extract it (for a specific version, use the [releases page](https://github.com/FreshRSS/FreshRSS/releases)). The archive contains a top-level `FreshRSS-X.Y.Z/` folder.
2. Copy the extracted contents into your FreshRSS directory, overwriting existing files. Your user data, extensions, and custom themes are preserved.
3. Re-apply file ownership and permissions.

Note that overwriting does not remove files that were deleted in newer releases; this is rarely a problem in practice.

## Using Docker

If you run FreshRSS in Docker, see [How to update](https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/README.md#how-to-update) in the Docker README.
