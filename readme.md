## Projet YMA Server

Description en cours

### Installation

Cloner le projet.

Mettre à jour les dépendances en saisissant en console :

    composer install
    
Créer des clefs de chiffrement :

    Clef privée :
        $ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
        (La passphrase sera à saisir dans le .env.local)
    Clef publique :
        $ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout

Créer un fichier .env.local à la racine du projet avec à l'intérieur les variables suivantes :

    ### Infos base de données
    DATABASE_URL=mysql://login:password@127.0.0.1:3306/nombdd?serverVersion=8.0.18
    
    ### Infos authentification
    JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
    JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
    JWT_PASSPHRASE=PassphraseClefChiffrementPourAuthentification
    
Créer automatiquement une base de donnée en fonction des parametres saisis dans le .env.local :

    php bin/console doctrine:schema:create
    
Mettre à jour les tables :

    php bin/console doctrine:migrations:migrate
    
Créer les fixtures (remplissage de la base de donnée) :

    php bin/console doctrine:fixtures:load
    
Créer les clefs pour l'authentification

    Créer le dossier 'jwt' dans le repertoire /config du projet et se positionner dans ce nouveau répertoire
    Créer les clefs de chiffrement avec les commandes suivantes :
        openssl genpkey -out private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
        openssl pkey -in private.pem -out public.pem -pubout
            
