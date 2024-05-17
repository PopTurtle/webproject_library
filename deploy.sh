#!/bin/bash

#  Retour utilisateur
if [ -z ${DB_PASS+x} ]; then
  echo "DB_PASS is required"
  exit 1;
fi

if [ -z ${DB_HOST+x} ]; then
  export DB_HOST="database"
  echo "DB_HOST is not set, defaulting to '$DB_HOST'"
fi

if [ -z ${DB_USER+x} ]; then
  export DB_USER="root"
  echo "DB_USER is not set, defaulting to '$DB_USER'"
fi

if [ -z ${DB_NAME+x} ]; then
  export DB_NAME="webproject_library"
  echo "DB_NAME is not set, defaulting to '$DB_NAME'"
fi

echo -n "Value of KEEP_VOLUMES: "

if [ -z ${KEEP_VOLUMES+x} ] ; then
  echo "not set"
else
  echo "'$KEEP_VOLUMES'"
fi

echo "Shutting down current website if it is running"
echo "------------------------------"

if [ -z $KEEP_VOLUMES ]; then
  echo "Volumes will be erased if exists"
  docker compose down -v
else
  echo "Keeping volumes"
  docker compose down
fi

echo "Deploying website"
echo "------------------------------"

docker image rm webproject_library
docker compose up -d

#  Changer le nom du volume si docker-compose est modifié (Format: name_volume)
#  Ici: name = webproject, volume = ws_storage , donc webproject_ws_storage
storage_path=$(docker volume inspect --format '{{ .Mountpoint }}' webproject_ws_storage)
echo "Found storage path: $storage_path"
echo "Adding all permissions (including write) to the book covers directory"
sudo chmod 777 "$storage_path/Cover"

echo "Déployé avec succès !"
