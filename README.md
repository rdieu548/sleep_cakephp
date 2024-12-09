# Journal de Sommeil - Application Web CakePHP

## Description
Cette application web permet aux utilisateurs de suivre leur cycle de sommeil quotidien. Les utilisateurs peuvent enregistrer leurs heures de coucher et de lever, ainsi que d'autres informations pertinentes comme les siestes, l'activité sportive et leur niveau de forme au réveil.

## Fonctionnalités

### Gestion des Utilisateurs
- Inscription
- Connexion/Déconnexion
- Réinitialisation du mot de passe via Mailgun

### Journal de Sommeil
- Enregistrement quotidien des heures de sommeil
- Calcul automatique des cycles de sommeil (90 minutes par cycle)
- Indicateur de qualité des cycles (optimal si proche d'un nombre entier de cycles)
- Suivi des siestes (après-midi et soir)
- Notation du niveau de forme (0-10)
- Suivi de l'activité sportive
- Commentaires personnalisés

## Configuration Technique

### Prérequis
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Composer

### Base de Données
La base de données comprend deux tables principales :
- `users` : Stockage des informations utilisateurs
- `sleep_entries` : Enregistrements du journal de sommeil

### Variables d'Environnement
Créez un fichier `.env` à la racine du projet avec :

```
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
DB_DATABASE=webapp_cake
MAILGUN_HOST=smtp.mailgun.org
MAILGUN_USERNAME=votre_username_mailgun
MAILGUN_FROM_EMAIL=votre_email_mailgun
MAILGUN_FROM_NAME=WebAPP
MAILGUN_API_KEY=votre_cle_api_mailgun
```

## Installation

1. Cloner le projet :
   ```bash
   git clone https://github.com/rdieu548/sleep_cakephp.git
   cd projet_cakephp
   ```

2. Installer les dépendances :
   ```bash
   composer install
   ```

3. Créer la base de données :
   ```sql
   CREATE DATABASE webapp_cake;
   ```

4. Créer les tables :
   ```sql
   -- Table users (si non existante)
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       email VARCHAR(255) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL,
       created DATETIME DEFAULT CURRENT_TIMESTAMP,
       modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );

   -- Table sleep_entries
   CREATE TABLE sleep_entries (
       id INT AUTO_INCREMENT PRIMARY KEY,
       user_id INT NOT NULL,
       date DATE NOT NULL,
       bedtime TIME NOT NULL,
       wakeuptime TIME NOT NULL,
       afternoon_nap BOOLEAN DEFAULT FALSE,
       evening_nap BOOLEAN DEFAULT FALSE,
       morning_score INT,
       did_sport BOOLEAN DEFAULT FALSE,
       comments TEXT,
       cycles INT,
       is_optimal_cycle BOOLEAN DEFAULT FALSE,
       created DATETIME DEFAULT CURRENT_TIMESTAMP,
       modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
       FOREIGN KEY (user_id) REFERENCES users(id)
   );
   ```

5. Configurer le fichier `.env`

6. Lancer le serveur de développement :
   ```bash
   bin/cake server
   ```

## Utilisation

1. Créer un compte utilisateur via `/register`
2. Se connecter via `/login`
3. Accéder au journal de sommeil via `/sleep-calculator`
4. Ajouter une nouvelle entrée via `/calculate`

## Structure du Projet

### Contrôleurs Principaux
- `UsersController.php` : Gestion des utilisateurs
- `SleepCalculatorController.php` : Gestion du journal de sommeil

### Modèles
- `User.php` : Modèle utilisateur
- `SleepEntry.php` : Modèle des entrées de sommeil

### Vues
- `templates/Users/` : Vues liées aux utilisateurs
- `templates/SleepCalculator/` : Vues du journal de sommeil

## Sécurité
- Authentification requise pour accéder au journal
- Chaque utilisateur ne voit que ses propres entrées
- Protection CSRF active
- Mots de passe hashés

## Maintenance
- Vérifier régulièrement les logs dans `logs/`
- Sauvegarder la base de données régulièrement
- Mettre à jour les dépendances via `composer update`

## Support
Pour toute question ou problème, créer une issue dans le repository GitHub.
