# Setting Up Automatic Feed Updating

FreshRSS is updated by the `./app/actualize_script.php` script. Knowing this, we can periodically trigger it to ensure up-to-date feeds.

**Note:** the update script won’t update any particular feed more often than once every twenty minutes, so it doesn’t make sense to trigger it much more frequently than that.

**Note:** the following examples assume that FreshRSS is installed to `/usr/share/FreshRSS`. You’ll need to modify the FreshRSS path to reflect your own system.

**Note:** If you cannot configure a local Cronjob, [see an alternative using online cron](../users/03_Main_view.md#online-cron).

## Cron as a trigger

You’ll need to check the Cron documentation for your specific distribution ([Debian/Ubuntu](https://help.ubuntu.com/community/CronHowto), [Red Hat/Fedora/CentOS](https://fedoraproject.org/wiki/Administration_Guide_Draft/Cron), [Slackware](https://docs.slackware.com/fr:slackbook:process_control?#cron), [Gentoo](https://wiki.gentoo.org/wiki/Cron), [Arch Linux](https://wiki.archlinux.org/index.php/Cron) …) to make sure you set the Cron job correctly.

It’s advisable that you run the Cron job as your Web server user (often `www-data`).

### Example on Debian/Ubuntu

To run the updater script every hour, and 10 minutes past the hour:

Edit `/etc/crontab` and append the following line:
```text
10 * * * * www-data php -f /usr/share/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1
```

## Systemd as a trigger

Some systems can’t use a Cron job, but they can use systemd. It’s easy to configure it to mimic Cron’s features.

First you need to add a `freshrss.timer` file in `/etc/systemd/system/` with the following content:

```ini
[Unit]
Description=FreshRSS get new content

[Timer]
OnBootSec=30s
OnCalendar=*:0/20

[Install]
WantedBy=timers.target
```

This timer will start 30 seconds after boot and it will trigger the service every 20 minutes. Feel free to change the configuration to better suit your needs.

Then you need to add a `freshrss.service` file in the same directory. This will be the description of the service triggered by the aforementioned timer.

```ini
[Unit]
Description=FreshRSS get new content
Wants=freshrss.timer

[Service]
User=www-data
Type=simple
ExecStart=/usr/bin/php /usr/share/FreshRSS/app/actualize_script.php
```

Finally, you need to enable the timer with `systemctl enable freshrss.timer` and reload the systemd configuration with `systemctl daemon-reload`.
