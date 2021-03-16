#!/bin/bash

# Local dos backups
mkdir ~/backup

##########
# Backup #
##########

# Parar o container
docker stop meucontainer

# Criar um container temporario com o volume e a pasta montada para backup
docker run --rm --volumes-from meucontainer -v ~/backup:/backup ubuntu bash -c "cd /var/lib/mysql && tar cvzf /backup/mysql.tar.gz ."

###########
# Restore #
###########

# Remover container e volume
docker rm -f meucontainer && docker volume rm vol-db

# Criar um container temporario para restaurar os dados e montar em um novo container
docker volume create vol-db2
docker run --rm -v vol-db2:/recover -v ~/backup:/backup ubuntu bash -c "cd /recover && tar xvzf /backup/mysql.tar.gz"
docker run -d -v vol-db2:/var/lib/mysql -p 3306:3306 mysql:8.0

# Sincronizar pasta local com pasta remota
# rsync -avz ~/backup/ administrador@192.168.0.235:/files/
