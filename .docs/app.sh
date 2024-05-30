#!/bin/bash

# Vérifiez si PHP est installé
if ! type "php" > /dev/null; then
  echo "PHP n'est pas installé. Veuillez installer PHP pour continuer."
  exit 1
fi
# Lancez le serveur web de l'application
cd /Users/pommestore/abousoft
php artisan serve
