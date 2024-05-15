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

#  Changer le nom de l'image si docker-compose est modifié (Format: name_volume)
#  Ici: name = webproject, volume = ws_storage , donc webproject_ws_storage
storage_path=$(docker volume inspect --format '{{ .Mountpoint }}' webproject_ws_storage)
echo "Found storage path: $storage_path"
echo "Ajout de la permission d'écrire dans le dossier des couvertures"
sudo chmod 777 "$storage_path/Cover"
