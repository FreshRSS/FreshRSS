# Server requirements

FreshRSS is a web application. This means you’ll need a web server to run it. FreshRSS requirements are really low, so it should run on most shared host servers, or any old computer you happen to have on hand.

You need to verify that your server can run FreshRSS before installing it. If your server has the proper requirements and FreshRSS does not work, please contact us to find a solution.

| Software      | Recommended             | Also Works With         |
| ------------- | ----------------------- | ----------------------- |
| Web server    | **Apache 2.4**          | nginx, lighttpd |
| PHP           | **PHP 8.1+**            | FreshRSS 1.24.3: PHP 7.4+<br />FreshRSS 1.22.1: PHP 7.2+ |
| PHP modules   | Required: libxml, cURL, JSON, PDO_MySQL, PCRE and ctype.<br />Required (32-bit only): GMP <br />Recommended: Zlib, mbstring, iconv, ZipArchive<br />*For the whole modules list see [Dockerfile](https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/Dockerfile-Alpine#L9-L11)* | |
| Database      | **PostgreSQL 10+**      | SQLite, MariaDB 10.6+, MySQL 8.0+ |
| Browser       | **Firefox**             | Chrome, Opera, Safari, or Edge       |

## Getting the appropriate version of FreshRSS

FreshRSS has two different release channels:

## Rolling release

If you want a rolling release with the newest features and security fixes,
or want to help testing or developing the next release,
you can use [the `edge` branch](https://github.com/FreshRSS/FreshRSS/tree/edge/).

In case of bug on this branch, they are quickly resolved, since this branch is actively used.

Branch activity can be followed for instance via [the branch RSS feed](https://github.com/FreshRSS/FreshRSS/commits/edge.atom).

Docker releases are available for this branch ; and updating via git or ZIP is also available, both manually and through the Web interface.

## Versioned release

If you prefer fewer updates, you can use [the `latest` branch](https://github.com/FreshRSS/FreshRSS/tree/latest/).
It is more stable but at the price of less security and more known bugs,
as fixes are not backported to older versions.
New versions are published a few times a year.
See the [latest release](https://github.com/FreshRSS/FreshRSS/releases/latest)
and the [list of releases](https://github.com/FreshRSS/FreshRSS/releases).

Versioned releases are not released on a set schedule. Rather, they are released whenever we consider that our goal for new features is reached.
