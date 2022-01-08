# General Installation Instructions

These instructions are intended as general guidelines for installing FreshRSS. You may wish to consult the [Step-by-step Tutorial for installing FreshRSS on Debian 9/Ubuntu 16.04](06_LinuxInstall.md) if you don’t currently have a web server and don’t have experience setting one up.

Before you begin, make sure that you have read the [prerequisites](02_Prerequisites.md) for running FreshRSS. As shorthand, `.` refers to the directory to which your FreshRSS installation lives.

1. If the computer you’re running on is not currently running a web server, you’ll first need to install and configure a web server, a version of PHP, and an appropriate database, as listed in the prerequisites. Specially, if you are using NGINX, please keep in mind that FreshRSS needs some specified variables to run properly. So make sure you have checked our configuration file. [Example Apache and Nginx configuration files can be found here](10_ServerConfig.md).

2. Download your chosen version of FreshRSS, or fetch it via git. It’s advisable that you put FreshRSS in `/usr/share/`, and symlink the `./p/` folder to the root of your web server.[^1]

3. Give ownership of the FreshRSS folder to your web server user (often `www-data`). Give group read permissions to all files in `.`[^2], and group write permissions to `./data/`.

4. Install needed PHP modules. A precise and up-to-date list can be found in [the Dockerfile](https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/Dockerfile#L11-L12).

5. Create a database for FreshRSS to use. Note the username and password for this database, as it will be needed during installation!

6. Using your supported web browser of choice, navigate to the address you have installed your server to complete the installation from the GUI.[^3]

7. You can then customize [the configuration of your instance](https://github.com/FreshRSS/FreshRSS/blob/edge/config.default.php#L3-L4), [the default configuration for new users](https://github.com/FreshRSS/FreshRSS/blob/edge/config-user.default.php#L3-L5) or [the default set of feeds for new users](https://github.com/FreshRSS/FreshRSS/blob/edge/opml.default.xml#L2-L5).

---

[^1]: Make sure to expose only the `./p/` folder to the Web, as the other directories contain personal and sensitive data.

[^2]: If you wish to allow updates from the web interface, also give group write permissions to this folder.

[^3]: Assuming your server is `http://example.net`, this address could be `http://example.net/p/` if you didn’t follow our previous advice about not exposing the `./p/` folder.
