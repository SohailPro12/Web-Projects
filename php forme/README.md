# Gestion des utilisateurs avec PHP et HTML

Ce projet démontre comment implémenter un système CRUD (Create, Read, Update, Delete) en utilisant PHP et HTML dans un seul fichier. L'objectif est de gérer une liste d'utilisateurs stockée dans une base de données MySQL.

## Fonctionnalités

1. **Création d'utilisateur** :
   - Ajout d'un nouvel utilisateur avec un email, un mot de passe et un rôle.
   - Les données sont insérées dans la base de données via une requête SQL `INSERT`.

2. **Lecture des utilisateurs** :
   - Affichage de tous les utilisateurs dans un tableau HTML.
   - Les données sont récupérées depuis la base de données avec une requête SQL `SELECT`.

3. **Mise à jour d'utilisateur** :
   - Modification des informations d'un utilisateur existant (email, mot de passe, rôle).
   - Les données sont mises à jour dans la base de données via une requête SQL `UPDATE`.

4. **Suppression d'utilisateur** :
   - Suppression d'un utilisateur de la base de données.
   - Les données sont supprimées via une requête SQL `DELETE`.

## Structure du fichier

Le fichier combine à la fois :
- **PHP** : Pour gérer la logique serveur et interagir avec la base de données.
- **HTML** : Pour afficher les données et fournir une interface utilisateur.
- **Bootstrap** : Pour styliser l'interface utilisateur.

## Instructions pour tester le projet

1. **Configuration de la base de données** :
   - Créez une base de données MySQL nommée `enset-2025`.
   - Ajoutez une table `users` avec les colonnes suivantes :
     ```sql
     CREATE TABLE users (
         id INT AUTO_INCREMENT PRIMARY KEY,
         email VARCHAR(255) NOT NULL,
         password VARCHAR(255) NOT NULL,
         role ENUM('guest', 'author', 'admin') NOT NULL
     );
     ```

2. **Lancer le projet** :
   - Placez le fichier `index.php` dans un serveur local (ex. XAMPP, WAMP, ou MAMP).
   - Accédez au fichier via un navigateur (ex. `http://localhost/php-forme/index.php`).

3. **Tester les fonctionnalités** :
   - Ajoutez un utilisateur en remplissant le formulaire et en cliquant sur "Ajouter".
   - Modifiez un utilisateur en cliquant sur le bouton "E" dans le tableau.
   - Supprimez un utilisateur en cliquant sur le bouton "X" dans le tableau.

## Points importants

- **Validation des données** : Les entrées utilisateur ne sont pas encore validées. Il est recommandé d'ajouter des validations côté serveur et client.
- **Sécurité** : Les requêtes SQL actuelles ne sont pas protégées contre les injections SQL. Utilisez des requêtes préparées pour sécuriser le projet.
- **Améliorations possibles** :
  - Ajouter des messages de confirmation après chaque action (ajout, modification, suppression).
  - Implémenter une pagination pour le tableau des utilisateurs.

## Conclusion

Ce projet montre comment intégrer PHP et HTML dans un seul fichier pour créer une application CRUD simple. Il peut être étendu pour inclure des fonctionnalités supplémentaires comme l'authentification ou la gestion des rôles.