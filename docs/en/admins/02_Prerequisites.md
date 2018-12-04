# Server Requirements

FreshRSS is a web application. This means you’ll need a web server to run it. FreshRSS requirements are really low, so it should run on most shared host servers, or any old computer you happen to have on hand.

You need to verify that your server can run FreshRSS before installing it. If your server has the proper requirements and FreshRSS does not work, please contact us to find a solution.

| Software      | Recommended             | Also Works With         |
| ------------- | ----------------------- | ----------------------- |
| Web server    | **Apache 2**            | Nginx                   |
| PHP           | **PHP 5.5+**            | PHP 5.3.8+[^1]            |
| PHP modules   | **Required:** libxml, cURL, PDO_MySQL, PCRE, ctype<br>**Required (32-bit only):** GMP<br>**Recommended:** JSON, Zlib, mbstring, iconv, ZipArchive | |
| Database      | **MySQL 5.5.3+**        | SQLite 3.7.4+           |
| Browser       | **Firefox**             | Chrome, Opera, Safari, or IE11/Edge[^2] |  


# Getting the appropriate version of FreshRSS

FreshRSS has three different releases or branches. Each branch has its own release frequency. So it is better if you spend some time to understand the purpose of each release.

## Stable release

[Download](https://github.com/FreshRSS/FreshRSS/archive/master.zip)

This version is really stable, tested thoroughly, and you should not face any major bugs.

Stable releases are not released on a set schedule. Rather, they are released whenever we consider that our goal for new features is reached, and the software is stable.

It could happen that we make two releases in a short span of time if we have a really good coding pace. In reality, we are all working on the project in our spare time, so a new release usually occurs every few months. 

## Development version

[Download](https://github.com/FreshRSS/FreshRSS/archive/dev.zip)

As its name suggests, the development version is the working codebase, intended for developers. **This release may be unstable!**

If you want to keep track of the most recent enhancements or help the developers with bug reports, this is the branch for you. If you use this version, please keep in mind that you need to follow the branch activity on Github (via [the branch RSS feed](https://github.com/FreshRSS/FreshRSS/commits/dev.atom), for instance), and manually pull new commits.

Some say that the main developers use this branch on a daily basis without problem. They may know what they are doing...

[^1]: When installed using a supported version of PHP older than 5.5, specific functions available in the [''password_compat'' library](https://github.com/ircmaxell/password_compat#requirements) are used for form authentication. 

[^2]: IE11/Edge may not support all features found in FreshRSS on other browsers
