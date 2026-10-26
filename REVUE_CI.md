# Revue du CI et du code

Revue faite le 26/10/2026 sur le commit `5f8ce97`. Toutes les étapes de `.github/workflows/ci_cd.yml` ont été relancées en local, la partie PHP dans un conteneur PHP 8.x.

> **Statut : corrigé.** Tous les points ci-dessous ont été corrigés, sauf les images Docker de production (voir la fin du document). Le workflow s'appelle maintenant `.github/workflows/ci.yml`. Vérifié en local : 35 tests PHP sur MySQL 8.4 (63 assertions), lint et build du front, `docker compose config` et build des deux images.

## Résumé

| Étape du CI | Résultat |
| --- | --- |
| Déclenchement du workflow | ❌ Ne se lance jamais (mauvaise branche) |
| `composer validate` / `composer install` | ✅ OK |
| Vérification syntaxe PHP | ✅ OK |
| PHPUnit | ❌ Plante dans le bootstrap (`.env.testing` absent) |
| Tests unitaires seuls | ✅ 26 tests, 45 assertions |
| Tests d'intégration | ❌ 8 erreurs (pas de base de données, schéma incompatible) |
| `npm ci` / `npm run lint` | ✅ OK |
| `npm run build` | ❌ Import avec une mauvaise casse |
| `docker compose config` | ⚠️ OK, mais 7 variables vides |

## Bloqueurs

### 1. Le workflow surveille la mauvaise branche

`ci_cd.yml` se déclenche sur `main`, mais le dépôt n'a que `master`. Aucun push et aucune PR ne lancent le CI.

```yaml
on:
  push:
    branches: [master]
  pull_request:
    branches: [master]
```

### 2. PHPUnit plante avant le premier test

```
Error in bootstrap script: Dotenv\Exception\InvalidPathException:
Unable to read any of the environment file(s) at [/app/.env.testing].
```

`api/tests/bootstrap.php` exige un fichier `.env.testing`. Ce fichier n'est pas versionné, et `.gitignore` l'exclut avec `.env.*`. Les variables de test sont déjà définies dans `phpunit.xml` (`<env>`), donc il suffit de charger le fichier uniquement s'il existe :

```php
$dotenv->safeLoad(); // au lieu de load()
```

### 3. Les tests d'intégration ne peuvent pas passer

- **Pas de base MySQL en CI** : les 8 tests de `DatabaseTest` finissent en erreur de connexion. Il faut un bloc `services: mysql` dans le job et un import du schéma.
- **Schéma incompatible** : la table `users` n'a pas de colonne `name`. Elle a `username`, ainsi que `password` et `role_id`, qui sont `NOT NULL`. Les `INSERT` des tests échouent.
- **`testDeleteUser` ne teste rien** : il supprime l'id `1` en dur. Après `DELETE FROM users`, l'auto-increment n'est pas remis à zéro, donc cet id n'existe pas et le test passe sans rien vérifier. Il faut utiliser l'id renvoyé par `createUser()`.

En attendant, lancer seulement les tests unitaires en CI :

```yaml
- name: Run PHPUnit tests
  working-directory: api
  run: vendor/bin/phpunit --testsuite Unit
```

### 4. Le build frontend échoue

```
Could not resolve "./Navbar.jsx" from "src/components/Header.jsx"
```

Le fichier s'appelle `NavBar.jsx`. Linux, donc GitHub Actions, respecte la casse des noms de fichiers. Dans `frontend/src/components/Header.jsx`, il faut corriger l'import :

```js
import NavBar from "./NavBar.jsx"
```

## Améliorations du workflow

- **`docker compose config`** affiche 7 warnings de variables vides. Utiliser `docker compose --env-file .env.example config` pour vérifier une configuration réaliste.
- **Épinglage des actions** : `actions/checkout` est épinglé par SHA, mais `setup-php@v2` et `setup-node@v4` ne le sont pas. Choisir une seule règle pour toutes les actions.
- **Nom du fichier** : il n'y a aucune étape de déploiement. `ci.yml` serait plus juste que `ci_cd.yml`.
- **Séparer les jobs** : un job `backend` et un job `frontend` en parallèle iraient plus vite, et on verrait directement quelle partie échoue.
- **Test inutile** : `if [ -d tests ]` ne sert à rien, puisque `phpunit` échoue déjà tout seul si le dossier manque.

## Remarques hors CI

- **Fichiers versionnés par erreur** : `api/node_modules/` et `api/package.json` (qui contient `{}`), ainsi qu'une capture d'écran dans `frontend/public/images/`.
- **Risque d'injection SQL** dans `api/Core/Database.php` : `order_by`, `group_by` et les noms de colonnes des filtres sont insérés directement dans la requête. Si ces valeurs viennent de la requête HTTP, il faut une liste blanche des colonnes autorisées.
- **Erreurs PHP affichées** : `api/config/bootstrap.php` active `display_errors` dans tous les environnements, y compris en production.
- **Images Docker de dev** : l'image de l'API installe les dépendances de dev, et celle du front lance le serveur de dev Vite. Ça convient pour du développement, mais pas pour une image de production. *Non corrigé volontairement : ces images servent au développement avec `compose.yml`. Il faudra des Dockerfiles de production (multi-stage, `composer install --no-dev`, front servi par nginx) le jour où il y aura un déploiement.*
- **Encodage du README** : `README.md` est en UTF-16, ce qui peut mal s'afficher dans certains outils. Mieux vaut le convertir en UTF-8.

## Ordre de correction conseillé

1. Remplacer `main` par `master` dans le workflow.
2. Remplacer `load()` par `safeLoad()` dans `api/tests/bootstrap.php`.
3. Corriger l'import `./NavBar.jsx`.
4. Ne lancer que `--testsuite Unit` en CI.
5. Ensuite : ajouter le service MySQL et adapter `DatabaseTest` au vrai schéma de `users`.
