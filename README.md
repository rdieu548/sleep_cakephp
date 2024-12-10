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
# Base de données
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
DB_DATABASE=webapp_cake

# Mailgun (à configurer avec vos informations Mailgun)
MAILGUN_HOST=smtp.mailgun.org
MAILGUN_USERNAME=votre_username_mailgun
MAILGUN_PASSWORD=votre_password_mailgun
MAILGUN_FROM_EMAIL=votre_email_mailgun
MAILGUN_FROM_NAME=CakeSleepCalculator
```

Remplacez les valeurs par vos propres informations de connexion. Pour Mailgun, vous devez utiliser les identifiants fournis dans votre compte Mailgun.

## Installation

1. Clonez le projet :
   ```bash
   git clone https://github.com/rdieu548/sleep_cakephp.git
   cd sleep_cakephp
   ```

2. Installez les dépendances :
   ```bash
   composer install
   ```

3. Créez la base de données :
   ```sql
   CREATE DATABASE webapp_cake;
   ```

4. Configurez le fichier `.env` avec vos informations de base de données :
   ```plaintext
   # Base de données
   DB_USERNAME=votre_utilisateur
   DB_PASSWORD=votre_mot_de_passe
   DB_DATABASE=webapp_cake
   ```

5. Exécutez les migrations pour créer les tables :
   ```bash
   bin/cake migrations migrate
   ```

6. Lancez le serveur de développement :
   ```bash
   bin/cake server
   ```

## Utilisation

1. Créez un compte utilisateur via `/register`
2. Connectez-vous via `/login`
3. Accédez au journal de sommeil via `/sleep-calculator`
4. Ajoutez une nouvelle entrée via `/calculate`

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
