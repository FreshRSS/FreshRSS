# News Assistant

Using the ai api of `OpenAI`, `Anthropic`, `Groq` by [Portkey-AI/gateway](https://github.com/Portkey-AI/gateway/) to summary the news.

## Features

- [x] summary the same topic news cross over different rss feeds.
- [ ] add the topic tag automatically
- [x] change the summary rss feed to read status
- [x] support a lot of ai api by [Portkey-AI/gateway](https://github.com/Portkey-AI/gateway/)

## Usage

There are two methods to use it. One is only for `openai`, and second supports a lot of ai api by gateway which is `recommended` because  supporting those difference api is not the goal of this project.

### OpenAI(Legacy method)

This method is only for openai as a previous version of this extension. You don't need to do anything after upgrading this extension if you are using openai before.

#### Get the token of OpenAI

1. create your OpenAI account
2. go to [there](https://platform.openai.com/account/api-keys) to generate a new API key, and copy it.

### Gateway(Recommend)

This method is using [Portkey-AI/gateway](https://github.com/Portkey-AI/gateway/) to support a lot of ai api. But you need to deploy a service to achieve this.

#### Deploy

[You could deploy to Cloudflare Workers or running docker container.](https://github.com/Portkey-AI/gateway/blob/main/docs/installation-deployments.md#deploy-to-cloudflare-workers)

## Setup the extension

https://user-images.githubusercontent.com/6359152/232393261-0874fd35-563b-43ad-846c-f4bb48aef143.mp4

1. click the navigation button to get the summary report of the news feed.
2. open a side webview to show the summary report of the news feed.
