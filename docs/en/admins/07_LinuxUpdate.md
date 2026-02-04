# Updating on Linux

This tutorial demonstrates commands for updating FreshRSS. It assumes that your main FreshRSS directory is `/usr/share/FreshRSS`; If you’ve installed it somewhere else, substitute your path as necessary.

**Note that FreshRSS contains a built-in update system.** It’s easier to use if you don’t understand the commands that follow. It’s available through the web interface of your FreshRSS installation, Administration → Update.

Please read the general advice from “[Backing Up and Updating FreshRSS](04_Updating.md)” before applying any command from this guide.

## Pausing automatic feed updates

If [Automatic Feed Updating](08_FeedUpdates.md) has been configured, temporarily suspend the automatic feed updates during the upgrade process.

Before performing the upgrade:

1. cron method: run `sudo crontab -e` and comment out the task
2. systemd method: run `sudo systemctl stop freshrss.timer`

After performing the upgrade:

1. cron method: run `sudo crontab -e` and uncomment the task
2. systemd method: run `sudo systemctl start freshrss.timer`

You may wish to run the cron task or systemd unit (`freshrss.service`) immediately after the upgrade to ensure the automatic feed updates are functioning correctly.

## Using git

**You must have used git to install FreshRSS to use this update method.**

If your local user doesn’t have write access to the FreshRSS folder, use a sudo shell (`sudo -s`), prefix the following commands with `sudo`, or switch to an account that does have write access to the folder.

1. Change to your FreshRSS directory
	```sh
	cd /usr/share/FreshRSS/
	```

2. Fetch the most recent code from GitHub
	```sh
	git fetch --all
	```

3. Discard manual changes and delete manual additions
	```sh
	git reset --hard
	git clean -f -d
	```

	Note: If you wish to keep your changes, it’s better to [create a pull request](https://github.com/FreshRSS/FreshRSS/compare) or [an extension](../developers/03_Backend/05_Extensions.md).

4. Update FreshRSS
	```sh
	git checkout edge
	git pull --ff-only
	```

	> ℹ️ Use `edge` for the rolling release or `latest` for the latest stable release.

5. (optional) Make sure you use the correct version
	```sh
	git status
	```

	The command should tell you the branch that you’re using. It must be the same as the one associated with [the latest release on GitHub](https://github.com/FreshRSS/FreshRSS/releases/latest).
	If you use the rolling release, it should tell you that your `edge` branch is up to date with `origin`.

6. Re-set correct permissions so that your web server can access the files
	```sh
	cli/access-permissions.sh
	```

## Using the Zip archive

If your local user doesn’t have write access to the FreshRSS folder, use a sudo shell (`sudo -s`), prefix the following commands with `sudo`, or switch to an account that does have write access to the folder.

1. Change to your FreshRSS directory
	```sh
	cd /usr/share/FreshRSS/
	```

2. Get the link to the Zip archive for [the latest release](https://github.com/FreshRSS/FreshRSS/releases/latest): [`https://github.com/FreshRSS/FreshRSS/archive/latest.zip`](https://github.com/FreshRSS/FreshRSS/archive/latest.zip). If you want to use the rolling release, the link is [`https://github.com/FreshRSS/FreshRSS/archive/edge.zip`](https://github.com/FreshRSS/FreshRSS/archive/edge.zip).

3. Download and unzip the update file
	```sh
	wget -O freshrss.zip https://github.com/FreshRSS/FreshRSS/archive/latest.zip
	unzip freshrss.zip
	```

4. Overwrite all your existing files with the new ones
	```sh
	cp -R FreshRSS-*/* .
	```

5. Re-set permissions
	```sh
	cli/access-permissions.sh
	```

6. Clean up the FreshRSS directory by deleting the downloaded zip and the temporary directory
	```sh
	rm -f freshrss.zip
	rm -rf FreshRSS-*/
	```
