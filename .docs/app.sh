#!/bin/bash

# Vérifiez si PHP est installé
if ! type "php" > /dev/null; then
  echo "PHP n'est pas installé. Veuillez installer PHP pour continuer."
  exit 1
fi

# Lancez le serveur web de l'application
cd /Users/pommestore/abousoft
php artisan serve &

# Création d'une icône sur le bureau pour MacOS
echo "[Desktop Entry]
Type=Application
Name=Abousoft Server
Exec=/Users/pommestore/abousoft/app.sh
Icon=/Users/pommestore/abousoft/icon.png
Terminal=true" > ~/Desktop/AbousoftServer.desktop

chmod +x ~/Desktop/AbousoftServer.desktop
