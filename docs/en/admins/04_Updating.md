# Backing Up and Updating FreshRSS

The following is general procedure; [specific commands for Linux may be found here](07_LinuxUpdate.md).

## Backing Up

Before you update to a new version of FreshRSS, it’s always a good idea to backup your current installation. Simply make an archive of your FreshRSS directory, which can be restored if needed by following the "Updating from a Zip Archive" section at the bottom of this document.

## Updating From the Web

If you enabled web updates from your installation (see footnote 2 in [installation](03_Installation.md)), you can log into your admin account, select the update option under Administration in the Settings dropdown found on the top right of the webpage, and press the "Check for new updates" button. Alternatively, this page can be reached directly at `http://<your_server>/i/?c=update`.

This will check for and apply a new Stable version, if available.

## Updating manually

There are two options to update manually: with git (recommended if you’ve installed FreshRSS this way), or from a Zip archive.

In both cases, **it is highly recommended to update version by version.** For instance, if you are running FreshRSS 1.17.0, you should update to version 1.18.1 (i.e. the latest of the branch 1.18.x) before updating to 1.19.2. After each update, check that FreshRSS is still running correctly. If it’s not, it will help to understand what is broken.

### Using git

If you installed FreshRSS using git, you can update, change branches, or switch to a specific version from the command line.

Generally, the update procedure via git works as follows:

1. Making sure you’re in your FreshRSS install directory, and fetch updates.
2. Checkout the branch you wish to use.
3. Perform a hard reset to discard local changes.
4. Delete manual additions. Be sure to move your backup out of the directory before doing this step!
5. Pull the new version.
6. Re-set group read (and write, if you wish) permissions on all files in `.`, and group write permissions on `./data/`.

### From a Zip Archive

Updating to a new version from a zip archive is always an option. Begin by unzipping the archive into your FreshRSS directory, overwriting old files, and finally re-set group read (and write, if you wish) permissions on all files in `.` and group write permissions on `./data/`.
