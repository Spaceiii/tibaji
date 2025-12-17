# 🎯 Projet Laravel - Armurerie en Ligne
Bienvenue sur le dépôt de notre application de gestion d'armurerie. Ce projet a été développé dans le cadre scolaire pour répondre à une problématique métier complexe : la gestion mixte de ventes libres (accessoires) et de ventes réglementées (armes).

# 👥 L'Équipe
Dulieux Baptiste
Meyer Timothée
Froehly Jean-Baptiste

# 📝 Description du Projet
L'objectif de cette application est de digitaliser la gestion d'une armurerie physique en connectant trois acteurs : l'Armurier (Admin), le Client et le Visiteur.
L'application gère une logique de vente différenciée :
Vente directe pour les équipements tactiques et accessoires (non soumis à déclaration).
Vente réglementée pour les armes (Catégorie ```B``` et ```C```), nécessitant une vérification administrative stricte (upload et validation de licence).

# 🛠️ Stack Technique
Framework : Laravel
Base de Données : MySQL
Authentification : Laravel Breeze
Sécurité : Middleware personnalisé & Protection par rôles
Architecture : Structure de la BDD générée intégralement par migrations

# 🚀 Fonctionnalités
## 1. Partie Publique (Visiteur)

Catalogue Unifié : Consultation des articles avec filtres (Armes de poing, Fusils, Accessoires, Optiques).
Restriction d'accès : Les prix et le bouton "Réserver" sont masqués pour les visiteurs non connectés.
Authentification : Connexion et inscription requises pour interagir.

## 2. Espace Client (Connecté)
Accès complet : Visualisation des prix et des stocks.
Profil : Gestion des informations personnelles.
Flux d'achat différencié :
🟢 Accessoires : Ajout au panier et réservation directe.
🔴 Armes : Ajout au panier possible, mais la validation est bloquée tant qu'une licence (SIA/Permis) n'est pas uploadée et validée.

## 3. Espace Armurier (Administration)
CRUD Armes (Weapon) : Gestion stricte (Numéro de série, Calibre, Catégorie).
CRUD Accessoires (Accessory) : Gestion simplifiée (Nom, Type, Prix, Stock).
Gestion des Réservations : Vue liste des demandes et validation de la remise de l'arme après vérification physique.

# 💾 Structure de la Base de Données
Le projet repose sur 4 modèles principaux :

| Table | Champs Principaux | Description |
| users | id, name, email, role | role est un enum ('admin', 'client') |
| weapons | id, model, brand, caliber, category, serial_number, price, quantity | Produits réglementés (Catégorie B ou C) |
| accessories | id, name, type, price, quantity, description | Produits en vente libre (Optique, vêtements...) |
| licenses | id, user_id, license_number, expiration_date, type | Documents de validité du client |
# ⚙️ Installation en local
Pour installer et lancer le projet :
Cloner le dépôt
```sh
git clone [https://github.com/votre-user/votre-repo.git](https://github.com/votre-user/votre-repo.git)
```

## Installer les dépendances
```sh
composer install
npm install
```


## Configurer l'environnement
```sh
cp .env.example .env
php artisan key:generate
```


N'oubliez pas de configurer votre base de données dans le fichier .env.
Exécuter les migrations
```sh
php artisan migrate
```


Lancer le serveur
```sh
npm run dev
php artisan serve
```


Dernière mise à jour : 17 Décembre 2025
