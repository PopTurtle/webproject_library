#!/bin/bash

echo "Deploying website"

if [ -z $KEEP_VOLUME ]; then
  echo "Volumes will be erased if exists"
  docker compose down -v
else
  docker compose down
fi

docker image rm webproject_library
docker compose up -d
