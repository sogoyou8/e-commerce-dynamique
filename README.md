# E-commerce Dynamique

## Description du projet

Ce projet consiste à développer un site e-commerce dynamique en PHP, utilisant une base de données MySQL. Le site permet aux utilisateurs de consulter des articles, de s'inscrire et de se connecter, de gérer un panier, et d'effectuer des opérations CRUD via une interface d'administration (back-office).

## Fonctionnalités

### Front-office

1. **Accueil**
   - Présente une vue d'ensemble du site avec une bannière et quelques produits en avant.

2. **Qui sommes-nous ?**
   - Page statique présentant l'équipe et la mission du projet.

3. **Articles (catalogue des produits)**
   - Affiche la liste des produits disponibles avec photo, nom, prix et description courte.
   - Possibilité de cliquer sur un produit pour voir une fiche produit détaillée.
   - Système de recherche et filtrage des produits.

4. **Inscription/Connexion**
   - Formulaire pour créer un compte utilisateur avec validation des données.
   - Formulaire de connexion pour permettre aux utilisateurs de se connecter.
   - Authentification sécurisée (hachage des mots de passe via `password_hash`).
   - Système de réinitialisation de mot de passe.

5. **Panier**
   - Les utilisateurs peuvent ajouter des articles dans leur panier depuis la page articles.
   - Une page dédiée permet de visualiser le contenu du panier : liste des articles avec leur quantité et leur prix total.
   - Option pour modifier les quantités, supprimer un article du panier ou vider complètement le panier.
   - Processus de commande avec formulaire d'adresse de livraison.

6. **Favoris**
   - Les utilisateurs peuvent ajouter des articles à leurs favoris pour les retrouver facilement plus tard.
   - Gestion des favoris temporaires pour les utilisateurs non connectés.

7. **Gestion du profil utilisateur**
   - Mise à jour des informations personnelles (nom, email).
   - Changement de mot de passe.
   - Suppression de compte.

8. **Commandes et Factures**
   - Les utilisateurs peuvent consulter l'historique de leurs commandes.
   - Affichage des détails de chaque commande.

### Back-office (administration)

1. **Connexion (authentification admin)**
   - Authentification via un formulaire réservé aux administrateurs.
   - Dashboard d'administration avec menu de navigation.

2. **Gestion des produits (CRUD)**
   - Ajouter un nouvel article (avec images multiples, nom, description, prix, stock).
   - Modifier les informations d'un article existant.
   - Supprimer un article.
   - Afficher la liste des articles avec leurs détails.

3. **Gestion des utilisateurs**
   - Visualiser la liste des utilisateurs inscrits.
   - Modifier les informations d'un utilisateur.
   - Supprimer un utilisateur (avec suppression des données associées).

4. **Gestion des commandes**
   - Visualiser la liste des commandes passées par les utilisateurs.
   - Modifier le statut des commandes (en attente, expédiée, livrée, annulée).

5. **Gestion des administrateurs**
   - Création de nouveaux comptes administrateurs.

## Technologies utilisées

- **Backend** : PHP 7.4+
- **Base de données** : MySQL
- **Frontend** : HTML5, CSS3, JavaScript
- **Framework CSS** : Bootstrap 4.5.2
- **Serveur local** : XAMPP/MAMP

## Structure du projet

```
e-commerce-dynamique/
├── admin/                  # Interface d'administration
│   ├── includes/          # Headers et footers admin
│   ├── dashboard.php      # Page d'accueil admin
│   ├── list_products.php  # Gestion des produits
│   ├── list_users.php     # Gestion des utilisateurs
│   └── list_orders.php    # Gestion des commandes
├── assets/
│   ├── css/              # Fichiers CSS
│   ├── js/               # Fichiers JavaScript
│   └── images/           # Images du site
├── includes/             # Fichiers inclus (header, footer, DB)
├── uploads/              # Images téléchargées
└── *.php                # Pages principales du site
```

## Prérequis

- [XAMPP](https://www.apachefriends.org/index.html) ou [MAMP](https://www.mamp.info/en/)
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Un navigateur web moderne

## Installation

### 1. Cloner le projet

```bash
git clone [URL_DU_DEPOT]
cd e-commerce-dynamique
```

### 2. Configuration de la base de données

1. Démarrez XAMPP/MAMP
2. Accédez à phpMyAdmin (http://localhost/phpmyadmin)
3. Créez une nouvelle base de données nommée `ecommerce_db`
4. Importez le fichier SQL fourni (si disponible) ou créez les tables nécessaires

### 3. Configuration de la connexion

Modifiez le fichier `includes/db.php` avec vos paramètres de base de données :

```php
$host = 'localhost';
$dbname = 'ecommerce_db';
$username = 'root';
$password = '';
```

### 4. Accès au site

- **Site principal** : http://localhost/e-commerce-dynamique/
- **Administration** : http://localhost/e-commerce-dynamique/admin/

## Comptes par défaut

### Administrateur
- Email : admin@example.com
- Mot de passe : admin123

## Fonctionnalités de sécurité

- Hachage des mots de passe avec `password_hash()`
- Protection contre les injections SQL avec PDO
- Validation et nettoyage des données utilisateur
- Sessions sécurisées
- Protection CSRF sur les formulaires critiques

## Auteurs

- **Yoann Sogoyou** - [yoann.sogoyou@ynov.com](mailto:yoann.sogoyou@ynov.com)
- **Matthias Pollet** - [matthias.pollet@ynov.com](mailto:matthias.pollet@ynov.com)
- **Jennie Beython Nkwedjan** - [jenniebeython.nkwedjan@ynov.com](mailto:jenniebeython.nkwedjan@ynov.com)

## Licence

Ce projet est réalisé dans le cadre d'un projet académique à Ynov.