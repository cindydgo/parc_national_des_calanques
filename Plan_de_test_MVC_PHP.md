# Plan de test - Projet MVC PHP

# Installation de PHPUnit

| Étape | Commande / Action | Description |
|---|---|---|
| 1 | `composer require --dev phpunit/phpunit ^12` | Installer PHPUnit via Composer |
| 2 | `vendor/bin/phpunit --version` | Vérifier l'installation |
| 3 | Créer le dossier `tests/` | Contiendra les tests |
| 4 | Créer `phpunit.xml` | Configurer PHPUnit |
| 5 | `vendor/bin/phpunit` | Lancer tous les tests |

## Plan de tests unitaires

| ID | Module | Type de test | Fonction testée | Scénario | Résultat attendu | Statut |
|:---|:-------|:-------------|:----------------|:---------|:-----------------|:------:|
| T001 | JWT | Unitaire | `generateToken()` | Génération d'un JWT | Retourne une chaîne de caractères | ✅ OK |
| T002 | JWT | Unitaire | `generateToken()` | Vérification du format | Le token contient 3 parties | ✅ OK |
| T003 | JWT | Unitaire | `getPayload()` | Lecture d'un token valide | Le payload est correctement décodé | ✅ OK |
| T004 | JWT | Unitaire | `validateToken()` | Validation avec la bonne clé | Retourne `true` | ✅ OK |
| T005 | JWT | Unitaire | `validateToken()` | Validation avec une mauvaise clé | Retourne `false` | ✅ OK |
| T006 | JWT | Unitaire | `getPayload()` | Token invalide | Retourne `null` | ✅ OK |
| T007 | JWT | Unitaire | `generateToken()` | Deux générations successives | Les deux tokens sont différents | ✅ OK |
| T008 | JWT | Unitaire | Payload JWT | Vérification des champs `iat` et `exp` | Les deux champs sont présents | ✅ OK |
| T009 | Validator | Unitaire | `isValidEmail()`    | Email valide | Retourne `true` | ✅ OK |
| T010 | Validator | Unitaire | `isValidEmail()`    | Email invalide | Retourne `false` | ✅ OK |
| T011 | Validator | Unitaire | `isValidEmail()`    | Email vide | Retourne `false` | ✅ OK |
| T012 | Validator | Unitaire | `isValidUsername()` | Nom d'utilisateur valide | Retourne `true` | ✅ OK |
| T013 | Validator | Unitaire | `isValidUsername()` | Nom trop court | Retourne `false` | ✅ OK |
| T014 | Validator | Unitaire | `isValidUsername()` | Nom trop long | Retourne `false` | ✅ OK |
| T015 | Validator | Unitaire | `isValidUsername()` | Caractères interdits | Retourne `false` | ✅ OK |
| T016 | Validator | Unitaire | `isValidUsername()` | Espaces dans le nom | Retourne `false` | ✅ OK |
| T017 | Validator | Unitaire | `isValidPassword()` | Mot de passe valide | Retourne `true` | ✅ OK |
| T018 | Validator | Unitaire | `isValidPassword()` | Sans majuscule | Retourne `false` | ✅ OK |
| T019 | Validator | Unitaire | `isValidPassword()` | Sans minuscule | Retourne `false` | ✅ OK |
| T020 | Validator | Unitaire | `isValidPassword()` | Sans chiffre | Retourne `false` | ✅ OK |
| T021 | Validator | Unitaire | `isValidPassword()` | Mot de passe trop court | Retourne `false` | ✅ OK |
| T022 | Validator | Unitaire | `isValidPassword()` | Mot de passe vide | Retourne `false` | ✅ OK |
| T023 | Auth | Unitaire (Mock) | `checkAuth()` | Token valide | Retourne le payload utilisateur | ✅ OK |
| T024 | Auth | Unitaire (Mock) | `checkAuth()` | Token invalide | Retourne `null` | ✅ OK |
| T025 | Auth | Unitaire (Mock) | `checkAuth()` | Vérification du secret | Le bon secret est utilisé | ✅ OK |
| T026 | Auth | Unitaire (Mock) | `checkAuth()` | Validation échouée | `getPayload()` n'est jamais appelé | ✅ OK |
| T027 | UserModel | Intégration | `getUser()` | Recherche utilisateur | Utilisateur retourné | ⏳ À faire |
| T028 | UserModel | Intégration | `createUser()` | Création utilisateur | Nouvel ID retourné | ⏳ À faire |
| T029 | UserModel | Intégration | `updateUser()` | Modification utilisateur | Retourne `true` | ⏳ À faire |
| T030 | UserModel | Intégration | `deleteUser()` | Suppression utilisateur | Retourne `true` | ⏳ À faire |

## Résumé

| Module | Nombre de tests | Statut |
|:-------|:---------------:|:------:|
| JWT | 8 | ✅ |
| Validator | 14 | ✅ |
| Auth | 4 | ✅ |

**Total actuel : 26 tests unitaires**

## Technologies utilisées

| Technologie | Version / Outil |
|---|---|
| PHP | 8.2 |
| PHPUnit | 12 |
| Mocks | `createMock()` |
| Assertions | PHPUnit |
| Architecture | MVC |

## Conclusion

| Élément | Description |
|---|---|
| JWT | Génération et validation vérifiées |
| Validation | Emails, noms d'utilisateur et mots de passe testés |
| Authentification | Vérifiée avec des mocks PHPUnit |
| À venir | Tests d'intégration `UserModel` et tests du `AuthController` |
| Couverture | Les composants critiques liés à la sécurité sont validés |


# Installation et configuration des tests d'intégration

| Étape | Action | Description |
|:---|:---|:---|
| 1 | `composer require --dev phpunit/phpunit` | Installer PHPUnit via Composer |
| 2 | `composer require --dev vlucas/phpdotenv` | Installer Dotenv afin de charger les variables d'environnement des tests |
| 3 | Créer une base de données `test_database` | Base dédiée aux tests afin d'isoler les données de développement |
| 4 | Créer le fichier `.env.testing` | Contient les paramètres de connexion à la base de données de test |
| 5 | Créer `tests/bootstrap.php` | Charge automatiquement les variables d'environnement de `.env.testing` |
| 6 | Modifier `phpunit.xml` | Définir `tests/bootstrap.php` comme bootstrap de PHPUnit |
| 7 | Créer les classes de tests dans `tests/Integration` | Contient les tests de la classe `Database` |
| 8 | Exécuter les tests | `vendor/bin/phpunit tests/Integration` |

---

# Configuration de l'environnement de test

## Exemple du fichier `.env.testing`

```env
DB_HOST=127.0.0.1
DB_NAME=test_database
DB_USER=root
DB_PASS=
```

## Exemple du fichier `tests/bootstrap.php`

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(
    dirname(__DIR__),
    '.env.testing'
);

$dotenv->load();
```

## Configuration de PHPUnit

```xml
<phpunit bootstrap="tests/bootstrap.php">
```

Cette configuration garantit que tous les tests utilisent une base de données indépendante de la base de développement.

---

# Plan des tests d'intégration

| ID | Module | Type de test | Fonction testée | Scénario | Résultat attendu | Statut |
|:---|:-------|:-------------|:----------------|:---------|:-----------------|:------:|
| IT001 | Database | Intégration | `create()` | Création d'un utilisateur | L'utilisateur est inséré dans la base et un identifiant est généré | ✅ OK |
| IT002 | Database | Intégration | `readOne()` | Lecture d'un utilisateur existant | Les informations de l'utilisateur sont correctement retournées | ✅ OK |
| IT003 | Database | Intégration | `readOne()` | Recherche d'un utilisateur inexistant | La méthode retourne `null` | ✅ OK |
| IT004 | Database | Intégration | `update()` | Modification d'un utilisateur existant | Les nouvelles données sont enregistrées en base | ✅ OK |
| IT005 | Database | Intégration | `delete()` | Suppression d'un utilisateur | L'utilisateur est supprimé de la base de données | ✅ OK |
| IT006 | Database | Intégration | `readAll()` | Recherche avec une clause `WHERE` | Seuls les enregistrements correspondant au filtre sont retournés | ✅ OK |
| IT007 | Database | Intégration | `readAll()` | Tri des résultats avec `ORDER BY` | Les résultats sont triés selon la colonne et le sens demandés | ✅ OK |
| IT008 | Database | Intégration | `readAll()` | Limitation du nombre de résultats avec `LIMIT` | Le nombre d'enregistrements retournés respecte la limite définie | ✅ OK |

---

# Résumé des tests d'intégration

| Module | Nombre de tests | Statut |
|:-------|:---------------:|:------:|
| Database | 8 | ✅ |

**Total : 8 tests d'intégration**

---

# Technologies utilisées

| Technologie | Version / Outil |
|:---|:---|
| PHP | 8.2 |
| PHPUnit | 11 |
| Base de données | MySQL |
| Variables d'environnement | Dotenv |
| Connexion | PDO |
| Architecture | MVC |
| Type de tests | Tests d'intégration |

---

# Commandes utilisées

| Action | Commande |
|:---|:---|
| Vérifier la version de PHPUnit | `vendor/bin/phpunit --version` |
| Exécuter tous les tests | `vendor/bin/phpunit` |
| Exécuter uniquement les tests d'intégration | `vendor/bin/phpunit tests/Integration` |
| Afficher les tests avec un rapport lisible | `vendor/bin/phpunit --testdox` |

---

# Résultats obtenus

| Fonctionnalité | Résultat |
|:---|:---:|
| Connexion à la base MySQL | ✅ |
| Création (CREATE) | ✅ |
| Lecture (READ) | ✅ |
| Mise à jour (UPDATE) | ✅ |
| Suppression (DELETE) | ✅ |
| Clause `WHERE` | ✅ |
| Clause `ORDER BY` | ✅ |
| Clause `LIMIT` | ✅ |

---

# Conclusion

| Élément | Description |
|:---|:---|
| Base de données de test | Une base MySQL dédiée est utilisée afin de garantir l'isolation des tests |
| Couche d'accès aux données | Les opérations CRUD sont validées sur une base réelle |
| Construction dynamique des requêtes | Les clauses `WHERE`, `ORDER BY` et `LIMIT` sont correctement générées |
| Fiabilité | Les tests garantissent le bon fonctionnement de la classe `Database` dans un environnement proche de la production |
| Résultat final | Les **8 tests d'intégration** sont exécutés avec succès et l'ensemble des scénarios est validé. |