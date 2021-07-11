# Server Requirements

FreshRSS is a web application. This means you’ll need a web server to run it. FreshRSS requirements are really low, so it should run on most shared host servers, or any old computer you happen to have on hand.

You need to verify that your server can run FreshRSS before installing it. If your server has the proper requirements and FreshRSS does not work, please contact us to find a solution.

| Software      | Recommended             | Also Works With         |
| ------------- | ----------------------- | ----------------------- |
| Web server    | **Apache 2**            | Nginx, lighttpd         |
| PHP           | **PHP 7+**              |                         |
| PHP modules   | Required: libxml, cURL, JSON, PDO\_MySQL, PCRE and ctype. <br>Required (32-bit only): GMP <br> Recommended: Zlib, mbstring, iconv, ZipArchive <br> *For the whole modules list see [Dockerfile](https://github.com/FreshRSS/FreshRSS/blob/edge/Docker/Dockerfile-Alpine#L7-L9)* | |
| Database      | **MySQL 5.5.3+**        | SQLite 3.7.4+, PostgreSQL 9.5+          |
| Browser       | **Firefox**             | Chrome, Opera, Safari, or Edge          |


# Getting the appropriate version of FreshRSS

FreshRSS has two different releases. It is better if you spend some time to understand the purpose of each release.

## Stable release

[Download](https://github.com/FreshRSS/FreshRSS/releases/latest)

This version is really stable, tested thoroughly, and you should not face any major bugs.

Stable releases are not released on a set schedule. Rather, they are released whenever we consider that our goal for new features is reached, and the software is stable.

It could happen that we make two releases in a short span of time if we have a really good coding pace. In reality, we are all working on the project in our spare time, so a new release usually occurs every few months.

## Development version

[Download](https://github.com/FreshRSS/FreshRSS/archive/edge.zip)

As its name suggests, the development version is the working codebase, intended for developers. **This release may be unstable!**

If you want to keep track of the most recent enhancements or help the developers with bug reports, this is the branch for you. If you use this version, please keep in mind that you need to follow the branch activity on Github (via [the branch RSS feed](https://github.com/FreshRSS/FreshRSS/commits/edge.atom), for instance), and manually pull new commits.

Some say that the main developers use this branch on a daily basis without problem. They may know what they are doing…
