#!/bin/bash

git config user.name "github-actions[bot]"
git config user.email "41898282+github-actions[bot]@users.noreply.github.com"
git restore .
git remote set-url origin https://github.com/FreshRSS/FreshRSS
git fetch origin pull/8093/head:target-pr
git checkout target-pr
# git remote -v > test
# cp .git/config test2
# git add test
# git add test2
git commit --allow-empty -a -m "???"
git push --set-upstream origin target-pr
