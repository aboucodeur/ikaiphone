# IphoneApp

Une plateforme web qui vas faciliter la gestion des ventes d'iphones
ici le but est de la rendre multi-utilisateur pour plusieurs utilisateurs
par entreprise (boutique).

## ARCHITECTURE MULTI-UTILISATEUR ~

_ Avoir un administrateur globale (qui gere l'ensemble des utilisateurs)
celui-ci vas faciliter l'utilisation et l'expansion de la plateforme, et
correspond a un modele economique rentable

La table principale de l'application : Entreprise

- [*] Fournisseur
- [*] Clients
- [*] Modeles
- [*] Retours
- [*] Users
- [*] Mettre a jour les requetes du tableaux du bord pour l'entreprise donner
- [*] Mettre a jour les reqeutes des documents pdf
- [*] Modifier les informations de l'entreprise sur le documents pdf
- [ ] Upload des logo de l'entreprise (Par l'administrateur globales)
- [*] Enlever les parties ben services de l'application
  - [*] Mise a jour de la page login
  - [*] Modification du header
  - [*] Ajout de nouveaux utilisateurs via un modal

- [*] Afficher les ventes et achats de l'entreprise
      Faire une transaction lors de l'ajout des commandes ventes et achats
- [*] Scanne de l'iphone lors de la vente (Revoir le message !)
- [*] Adapter le retour a l'architecture multi-utilisateur (la partie ou j'ai pas bien coder)
- [*] Corriger le probleme au niveaux de la facture impayer par clients

- [*] Simplifier l'ajout d'iphone avec insertion grouper simple et facile (ameliore bien l'application)
        Cela veut dire lors de l'ajout d'un modele
        on peut chosir un fournisseurs, et mettre en description plusieurs produits
        qui seront ajouter avec la quantite.
        et aussi prendre en compte si le modele existe deja

Ameliorations de l'experience utilisateur !

- [*] Ajouter la details au niveaux des modele d'iphones
- Rendre dynamique l'application avec htmx ! : Cela a permit de reduire le code javascript de l'application
  - Verification de l'iphone lors de la vente (OK)
  - Verification de l'iphone lors du retour (OK)
  - Utilisation de htmx pour optimiser les performances

### MAINTENANCE & TEST

Je vais corriger les petites problemes pour preparer la plateforme a un deploiement
et utilisation pour des clients

- Corriger des bugs et documentation du code
- Suppressions des fichiers inutiles
- Enlever les fonctionnalites que j'utilise pas !

## DEPLOY

```sh
rsync -avz --no-perms --exclude='.git' --exclude='vendor' --exclude='node_modules' -e ssh /home/abou/dev/projets/BenServices/ root@97.107.129.199:/var/www/laravel/

ln -s /etc/nginx/sites-available/ben /etc/nginx/sites-enabled/
nginx -t

certbot --nginx -d etsbenservices.com -d www.etsbenservices.com

```

## MARKETING

Bientot la fete de Tabaski, je dois faire un max de revenus pour subvenir a mes besoins
c'est pour cela meme que j'ai rendu l'application multi-utilisateur pour faciliter l'utilisation
et offrir a plusieurs utilisateurs.

MON PLAN : Pour avoir mes 250.000 F !

Il faut que je la re-propose aux premiers clients !

Proposer l'application a des vendeurs d'iphone
commencer par les deux engages.
    - Cible : Halle de Bamako et Grande Marche Malitel DA
    - Prix Minimum : 200.000 F
    - Prix Maximum : 250.000 F

La prospection commence a partir du 25/05/2024 !
ma technique de prospection est la suivante :
    - B2B demarcher physiquement le client !
    - Envoyer un message whatsapp a des numeros trouver sur le web
    - Utilisation des reseaux sociaux comme :
        - Tiktok (pour voir si sa marche rellement)

SOMME OBJECTIF : 200.000 F
ECHEANCE : 05/06/2024
