# Setting Up Automatic Feed Updating

FreshRSS updating is controlled by a script located at
`./app/actualize_script.php`. Knowing this, we can create a Cron job to
launch the update script.

**Note:** the update script will not fetch feeds more often than every twenty minutes, so there's no sense in setting the Cron job to run anymore often than that.

You will need to check the Cron documentation for your specific distribution
([Debian/Ubuntu](https://help.ubuntu.com/community/CronHowto), [Red
Hat/Fedora/CentOS](https://fedoraproject.org/wiki/Administration_Guide_Draft/Cron),
[Slackware](https://docs.slackware.com/fr:slackbook:process_control?#cron),
[Gentoo](https://wiki.gentoo.org/wiki/Cron), [Arch
Linux](https://wiki.archlinux.org/index.php/Cron)...) to insure you set the
Cron job correctly.

It's advisable that you run the Cron job as your Web server user (often
`www-data`).

## Example on Debian/Ubuntu
To run the updater script every hour, and 10 minutes past the hour:

Run `sudo crontab -e` and copy the following line into the crontab:
```
10 * * * * www-data php -f /usr/share/FreshRSS/app/actualize_script.php > /tmp/FreshRSS.log 2>&1

```


This crontab example, of course, assumes that FreshRSS is installed in
`/usr/share/FreshRSS`; if you've installed it somewhere else, be sure to
correct the path in your crontab entry.
