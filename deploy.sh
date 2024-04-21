#!/bin/bash

docker compose down -v
docker image rm webproject_library
docker compose up -d
