# Updating on Debian 9/Ubuntu 16.04

This tutorial demonstrates commands for updating FreshRSS. It assumes that your main FreshRSS directory is `/usr/share/FreshRSS`; If you've installed it somewhere else, substitute your path as necessary.

## Using git

**You must have used git to install FreshRSS to use this update method.**

If your local user doesn't have write access to the FreshRSS folder, use a sudo shell (`sudo -s`), prefix the following commands with `sudo `, or switch to an account that does have write access to the folder.

1. Change to your FreshRSS directory
```
cd /usr/share/FreshRSS/
```

2. Verify the branch you're currently on. For stable releases, this should be `master`. 
```
git branch
```


3. Fetch the most recent code from the FreshRSS github Page
```
git fetch --all
```

Note: If you wish to switch to a specific version of FreshRSS, or switch to/from the dev branch, this is the time to do that. Example commands for switching branches are found below, in "Switching Branches"

4. Check for an update
```
git status
```

If there's not an update, you're done! If there is, continue the following steps:

5. Discard manual changes and delete manual additions
```
get reset --hard
git clean -f -d
```

6. Delete the file that triggers the install wizard
```
rm data/do-install.txt
```

7. Update to the new version of FreshRSS
```
git pull
```

8. Re-set correct permissions so that your web server can access the files
```
chown -R :www-data . && chmod -R g+r . && chmod -R g+w ./data/
```

### Switching Branches

Any command listed here should be run between steps 3 and 4 in the previous section.

To switch from stable to dev (if you haven't before) use the following command: `git checkout -b dev origin/dev`

If you've checked out dev and want to go back to master, the command would be `git checkout master`. After the first time you check out the dev branch, you can use this syntax to switch between the two main branches at will.

If you wish to switch to [a specific release of FreshRSS](https://github.com/FreshRSS/FreshRSS/releases), you would use the command `git checkout <release_name>`, where <release_name> is the specific release number you wish to check out (for example, `git checkout 1.12.0`). Be aware that checking out a specific release will leave you in a state where you can't automatically update; you'll need to run `git checkout master` or `git checkout dev` before you'll be able to pull updates from git automatically.

## Using the zip Archive

If your local user doesn't have write access to the FreshRSS folder, use a sudo shell (`sudo -s`), prefix the following commands with `sudo `, or switch to an account that does have write access to the folder.

1. Change to your FreshRSS directory
```
cd /usr/share/FreshRSS/
```

2. Download and unzip the update file
```
wget https://github.com/FreshRSS/FreshRSS/archive/master.zip
unzip master.zip
```

3. Overwrite all your existing files with the new ones
```
cp -R FreshRSS-master/* .
```

4. Re-set permissions
```
chown -R :www-data . && chmod -R g+r . && chmod -R g+w ./data/
```

5. Clean up the FreshRSS directory by deleting the downloaded zip, the file forcing the setup wizard and the temporary directory
```
rm -f master.zip
rm -f data/do-install.txt
rm -rf FreshRSS-master/
```
