Voici le fichier `README.md` mis à jour. J'ai intégré les **nouvelles tables** (notamment la structure complète des licences avec le statut, les dates de soumission/vérification, et les commentaires admin) ainsi que les nouvelles fonctionnalités que nous avons développées (Dashboard "Tactique", Upload avec prévisualisation, Workflow de validation).

---

# 🎯 Projet Laravel - Armurerie en Ligne

Bienvenue sur le dépôt de notre application de gestion d'armurerie. Ce projet a été développé dans le cadre scolaire pour répondre à une problématique métier complexe : la gestion mixte de ventes libres (accessoires) et de ventes réglementées (armes), avec un accent particulier sur la conformité légale (SIA).

# 👥 L'Équipe

* **Dulieux Baptiste**
* **Meyer Timothée**
* **Froehly Jean-Baptiste**

# 📝 Description du Projet

L'objectif de cette application est de digitaliser la gestion d'une armurerie physique en connectant trois acteurs : l'Armurier (Admin), le Client et le Visiteur.

L'application gère une logique de vente différenciée et sécurisée :

* **Vente directe** pour les équipements tactiques et accessoires.
* **Vente réglementée** pour les armes (Catégories **B**, **C**), nécessitant une vérification administrative stricte.
* **Workflow de validation** : Un client ne peut pas commander d'arme tant que son dossier (Licence de tir ou Permis de chasse) n'a pas été vérifié et validé manuellement par un administrateur.

# 🛠️ Stack Technique

* **Framework** : Laravel 11
* **Base de Données** : MySQL
* **Authentification** : Laravel Breeze
* **Frontend** : Blade, Tailwind CSS, Alpine.js (Gestion dynamique des uploads et sliders)
* **Sécurité** : Middleware `admin`, Validation de formulaires stricte, Policies.
* **Fichiers** : Gestion du stockage local (`storage/app/public`) pour les images produits et les scans de licences.

# 🚀 Fonctionnalités

## 1. Partie Publique (Visiteur)

* **Accueil Immersif** : Carrousel dynamique mettant en avant les nouveautés et les catégories.
* **Catalogue Unifié** : Consultation des armes avec indicateurs de stock (En stock / Rupture) et badges de catégorie (B/C).
* **Restriction d'accès** : Les prix et les boutons d'actions sont masqués ou incitent à la connexion pour les visiteurs.

## 2. Espace Client (Tireur/Chasseur)

* **Dashboard Tactique** : Vue d'ensemble de l'état du compte (Validé / En attente / Refusé).
* **Gestion du Dossier Administratif** :
* Formulaire d'upload de licence (PDF/Image) avec prévisualisation dynamique (Alpine.js).
* Champs spécifiques : Numéro SIA, Date d'expiration, Catégorie visée.
* Suivi en temps réel du statut de validation.
* Gestion des refus : Affichage du motif du refus par l'admin et possibilité de ré-uploader.



## 3. Espace Armurier (Administration)

* **Gestion du Stock (Armes)** : CRUD complet avec gestion des images produits.
* **Centre de Vérification** :
* Liste des licences en attente.
* Visualisation/Téléchargement des scans envoyés par les clients.
* Actions : **Valider** (débloque l'achat) ou **Refuser** (avec motif obligatoire).


* **Indicateurs** : Vue rapide des stocks faibles et des dossiers à traiter.

# 💾 Structure de la Base de Données

Le projet repose sur une structure relationnelle robuste. Voici les tables mises à jour :

### 1. Utilisateurs & Sécurité

| Table | Champs Clés | Description |
| --- | --- | --- |
| **users** | `id`, `name`, `email`, `password`, `role` | `role` : 'admin' ou 'client'. |

### 2. Catalogue Produits

| Table | Champs Clés | Description |
| --- | --- | --- |
| **weapon_types** | `id`, `name` | Types (Pistolet, Fusil, Carabine...). |
| **weapons** | `id`, `weapon_type_id`, `brand`, `model`, `description`, `caliber`, `category`, `serial_number`, `price`, `quantity`, `image` | `category` : 'B', 'C' ou 'D'. `image` : chemin de stockage. |
| **accessories** | `id`, `name`, `accessory_type_id`, `price`, `quantity`, `description` | *(À venir)* Produits non réglementés. |

### 3. Administratif & Conformité (Mise à jour majeure)

| Table | Champs Clés | Description |
| --- | --- | --- |
| **licenses** | `id`, `user_id`, `license_number`, `expiration_date`, `level`, `file_path`, `status`, `admin_comment`, `submitted_at`, `verified_at` | Table pivot de la législation. |

**Détails des champs `licenses` :**

* `level` : Type de document ('B' pour Auto préfectorale, 'C' pour Permis chasse/Licence Tir).
* `file_path` : Chemin sécurisé vers le scan du document.
* `status` : Enum (`pending`, `approved`, `rejected`).
* `admin_comment` : Raison du refus (ex: "Document illisible", "Date expirée").

## Relations Clés

* `users` (1) ↔ (1) `licenses` : Un utilisateur possède un seul dossier administratif actif.
* `weapons` (N) ↔ (1) `weapon_types`.

# ⚙️ Installation en local

## Prérequis

* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL >= 8.0

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

### 4. Créer le lien symbolique (Important pour les images)

Pour que les images des armes et les avatars soient visibles :

```sh
php artisan storage:link

```

### 5. Exécuter les migrations et seeders

```sh
php artisan migrate --seed

```

### 6. Lancer le serveur

```sh
# Terminal 1 : Serveur Laravel
php artisan serve

# Terminal 2 : Build des assets (Tailwind/Alpine)
npm run dev

```

L'application sera accessible à l'adresse : `http://localhost:8000`

## Comptes de test

Après le seeding, vous pouvez vous connecter avec :

* **Admin** : `admin@tibaji.fr` / `password`
* **Client** : `client@tibaji.fr` / `password`

---

*Dernière mise à jour : Janvier 2026*
