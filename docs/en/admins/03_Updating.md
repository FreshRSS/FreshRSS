
First things first: we recommend to create a backup before updating:

```sh
# Perform all commands below in your FreshRSS directory:
cd /usr/share/FreshRSS

tar -czvf FreshRSS-backup.tgz .
```

The update process depends on your installation type, see below:


## Using the web admin panel

Change to your installation at http://localhost/FreshRSS/p/i/?c=update and hit the "Check for new updates" button.

If there is a new version you will be prompted again.


## Using git

If you manage FreshRSS via command line, then installing and updating FreshRSS can be done via git:

```sh
# If your local user does not have write access, prefix all commands by sudo:
sudo ...

# Perform all commands below in your FreshRSS directory:
cd /usr/share/FreshRSS

# Use the development version of FreshRSS
git checkout -b dev origin/dev

# Check out a specific version of FreshRSS
# See release names on https://github.com/FreshRSS/FreshRSS/releases
# You will then need to manually change version
# or checkout master or dev branch to get new versions
git checkout 1.7.0

# Verify what branch is used
git branch

# Check whether there is a new version of FreshRSS,
# assuming you are on the /master or /dev branch
git fetch --all
git status

# Discard manual changes (do a backup before)
git reset --hard
# Then re-delete the file forcing the setup wizard
rm data/do-install.txt

# Delete manual additions (do a backup before)
git clean -f -d

# Update to a newer version of FreshRSS,
# assuming you are on the /master or /dev branch
git pull

# Set the rights so that your Web server can access the files
# (Example for Debian / Ubuntu)
chown -R :www-data . && chmod -R g+r . && chmod -R g+w ./data/
```


## Using the zip archive

Perform all commands in your FreshRSS directory:
```sh
cd /usr/share/FreshRSS
```

Commands intended to be executed in order (you can c/p the whole block if desired):

```sh
wget https://github.com/FreshRSS/FreshRSS/archive/master.zip
unzip master.zip
cp -R FreshRSS-master/* .
chown -R :www-data . && chmod -R g+r . && chmod -R g+w ./data/
rm -f master.zip
rm -f data/do-install.txt
rm -rf FreshRSS-master/
```

Short explanation of the commands above:
* Download the latest version and unzip it
* Overwrite all your existing files with the new ones
* Fix possible permission issues
* Cleanup by deleting the downloaded zip, the file forcing the setup wizard and the temporary directory
