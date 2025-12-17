# 🎯 Projet Laravel - Armurerie en Ligne
Bienvenue sur le dépôt de notre application de gestion d'armurerie. Ce projet a été développé dans le cadre scolaire pour répondre à une problématique métier complexe : la gestion mixte de ventes libres (accessoires) et de ventes réglementées (armes).

# 👥 L'Équipe
- **Dulieux Baptiste**
- **Meyer Timothée**
- **Froehly Jean-Baptiste**

# 📝 Description du Projet
L'objectif de cette application est de digitaliser la gestion d'une armurerie physique en connectant trois acteurs : l'Armurier (Admin), le Client et le Visiteur.

L'application gère une logique de vente différenciée :
- **Vente directe** pour les équipements tactiques et accessoires (non soumis à déclaration).
- **Vente réglementée** pour les armes (Catégories **B**, **C** et **D**), nécessitant une vérification administrative stricte (upload et validation de permis).

# 🛠️ Stack Technique
- **Framework** : Laravel 11
- **Base de Données** : MySQL
- **Authentification** : Laravel Breeze
- **Frontend** : Blade, Tailwind CSS, Alpine.js
- **Sécurité** : Middleware personnalisé & Protection par rôles
- **Architecture** : Structure de la BDD générée intégralement par migrations

# 🚀 Fonctionnalités
## 1. Partie Publique (Visiteur)
- **Catalogue Unifié** : Consultation des articles avec filtres par types (Armes, Accessoires, Optiques).
- **Restriction d'accès** : Les prix et le bouton "Réserver" sont masqués pour les visiteurs non connectés.
- **Authentification** : Connexion et inscription requises pour interagir.

## 2. Espace Client (Connecté)
- **Accès complet** : Visualisation des prix et des stocks.
- **Profil** : Gestion des informations personnelles.
- **Flux d'achat différencié** :
  - 🟢 **Accessoires** : Ajout au panier et réservation directe.
  - 🔴 **Armes** : Ajout au panier possible, mais la validation est bloquée tant qu'un permis de port d'arme valide n'est pas uploadé et validé.

## 3. Espace Armurier (Administration)
- **CRUD Armes** : Gestion complète (Modèle, Marque, Type, Numéro de série, Calibre, Catégorie, Prix, Stock).
- **CRUD Types d'armes** : Gestion des catégories d'armes (Pistolet, Fusil, etc.).
- **CRUD Accessoires** : Gestion complète (Nom, Type, Prix, Stock, Description).
- **CRUD Types d'accessoires** : Gestion des catégories d'accessoires.
- **Gestion des Réservations** : Vue liste des demandes et validation de la remise après vérification physique.

# 💾 Structure de la Base de Données
Le projet repose sur 6 tables principales :

| Table | Champs Principaux | Description |
| --- | --- | --- |
| **users** | id, name, email, password, role, email_verified_at, remember_token | Utilisateurs (role : 'admin' ou 'client') |
| **weapons** | id, model, brand, weapon_type_id, caliber, category, serial_number, price, quantity | Produits réglementés (Catégorie B, C ou D) |
| **weapon_types** | id, name | Types d'armes (Pistolet, Fusil, etc.) |
| **accessories** | id, name, accessory_type_id, price, quantity, description | Produits en vente libre (Optiques, vêtements, etc.) |
| **accessory_types** | id, name | Types d'accessoires (Optique, Vêtement, Munitions, etc.) |
| **licenses** | id, user_id, license_number, expiration_date, level | Permis du client (level : 'B', 'C' ou 'D') |

## Relations clés
- `weapons.weapon_type_id` → `weapon_types.id` (Restrict on Delete)
- `accessories.accessory_type_id` → `accessory_types.id` (Cascade on Delete)
- `licenses.user_id` → `users.id` (Cascade on Delete)

# ⚙️ Installation en local

## Prérequis
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL >= 8.0

## Étapes d'installation

### 1. Cloner le dépôt
```sh
git clone https://github.com/Spaceiii/tibaji.git
cd tibaji
```

### 2. Installer les dépendances
```sh
composer install
npm install
```

### 3. Configurer l'environnement
```sh
cp .env.example .env
php artisan key:generate
```

Modifiez le fichier `.env` pour configurer votre base de données :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tibaji
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Créer la base de données
Créez une base de données MySQL nommée `tibaji` (ou le nom configuré dans `.env`).

### 5. Exécuter les migrations et seeders
```sh
php artisan migrate --seed
```

Cette commande va créer toutes les tables et insérer des données de test.

### 6. Lancer le serveur
```sh
# Terminal 1 : Serveur Laravel
php artisan serve

# Terminal 2 : Build des assets
npm run dev
```

L'application sera accessible à l'adresse : `http://localhost:8000`

## Comptes de test
Après le seeding, vous pouvez vous connecter avec :
- **Admin** : admin@tibaji.fr / password
- **Client** : client@tibaji.fr / password


Dernière mise à jour : 17 Décembre 2025
