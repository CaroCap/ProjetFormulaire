@REM @REM permet de commenter du code dans le terminal

@REM echo yes | del migrations

@REM Pour créer la base de donnée cf env. pour le nom de la BD
@REM symfony console doctrine:database:create
@REM symfony console make:migration
@REM symfony console doctrine:migration:migrate

@REM supprime et recrée DB
symfony console doctrine:fixtures:load --no-interaction
@REM ajoute dans la DB après donc risque doublons
@REM symfony console doctrine:fixtures:load --append