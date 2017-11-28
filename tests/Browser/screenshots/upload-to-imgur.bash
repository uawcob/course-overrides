#!/bin/bash

cd "$( dirname "${BASH_SOURCE[0]}" )"

for file in *.png; do
    [ -f "$file" ] || exit 0
    curl --request POST \
      --url https://api.imgur.com/3/image \
      --header "authorization: Client-ID $IMGUR_CLIENT_ID" \
      --form image=@"$file" |
    jq .data.link
done
