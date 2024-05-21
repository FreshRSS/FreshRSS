# FreshRSS - YouTube video extension

This FreshRSS extension allows you to directly watch YouTube/PeerTube videos from within subscribed channel feeds.

To use it, upload the ```xExtension-YouTube``` directory to the FreshRSS `./extensions` directory on your server and enable it on the extension panel in FreshRSS.

## Features

- Embeds Youtube videos directly in FreshRSS, instead of linking to the Youtube page
- Simplifies the subscription to channel URLs by automatically detecting the channels feed URL

You can simply add Youtube video subscriptions by pasting URLs like:
- `https://www.youtube.com/channel/UCwbjxO5qQTMkSZVueqKwxuw`
- `https://www.youtube.com/user/AndrewTrials`

## Screenshots

With FreshRSS and an original Youtube Channel feed:
![screenshot before](https://github.com/kevinpapst/freshrss-youtube/blob/screenshot-readme/before.png?raw=true "Without this extension the video is not shown")

With activated Youtube extension:
![screenshot after](https://github.com/kevinpapst/freshrss-youtube/blob/screenshot-readme/after.png?raw=true "After activating the extension you can enjoy your video directly in the FreshRSS stream")

## Changelog

0.12:
- Turkish language support added

0.11:
- Modernized codebase for latest FreshRSS release 1.23.1
- Moved from [custom repo](https://github.com/kevinpapst/freshrss-youtube) to FreshRSS official extension repo

0.10:
- Enhance feed content formatting when included
- Enhance YouTube URL matching

0.9:
- Set the extension level at "user" (**users must re-enable the extension**)
- Fix calls to unset configuration variables
- Register translations when extension is disabled

0.8:
- Automatically convert channel and username URLs to feed URLs

0.7:
- Support for PeerTube feed

0.6:
- Support cookie-less domain [youtube-nocookie.com](https://www.youtube-nocookie.com) for embedding

0.5:
- Opened "API" for external usage

0.4:
- Added option to display original feed content (currently Youtube inserts a download icon link to the video file)
- Fixed config loading

0.3:
- Added installation hints

0.2:
- Fixed "Use of undefined constant FreshRSS_Context"
