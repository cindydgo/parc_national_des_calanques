# CI/CD – Parc national des Calanques

Ce document explique comment fonctionne l'intégration continue du projet, comment configurer les secrets GitHub et comment lancer les tests en local.

Fichier du workflow : [`.github/workflows/ci.yml`](.github/workflows/ci.yml)

## Quand le CI se lance

| Événement | Branche |
| --- | --- |
| `push` | `master` |
| `pull_request` | vers `master` |

Un push sur une autre branche (par exemple `fix/ci`) ne lance **pas** le CI. Il faut ouvrir une pull request vers `master`.

## Les étapes du pipeline

```text
          ┌──────────────┐     ┌───────────────┐
          │   backend    │     │   frontend    │   (en parallèle)
          │  PHP + MySQL │     │  React / Vite │
          └──────┬───────┘     └───────┬───────┘
                 └──────────┬──────────┘
                     ┌──────▼──────┐
                     │   docker    │   (seulement si les deux passent)
                     └─────────────┘
```

### Job `backend`

1. Installe PHP 8.3 avec les extensions `pdo_mysql`, `zip`, `mbstring` et `xml`.
2. Exécute `composer validate`, puis `composer install`.
3. Vérifie la syntaxe de tous les fichiers PHP (`php -l`).
4. Lance les **tests unitaires** (`phpunit --testsuite Unit`). Ils n'ont besoin d'aucun secret.
5. Vérifie que les secrets de la base de test existent. S'il en manque, le job s'arrête avec un message clair.
6. Importe `database/parc_national.sql` dans la base de test.
7. Lance les **tests d'intégration** (`phpunit --testsuite Integration`) sur cette base.

La base de test est un conteneur **MySQL 8.4** temporaire, créé pour le job puis détruit à la fin. Elle ne contient jamais de vraies données.

### Job `frontend`

1. Installe Node.js 22 avec le cache npm.
2. Lance `npm ci`, puis `npm run lint` (ESLint) et `npm run build` (Vite).

### Job `docker`

1. Valide `compose.yml` avec `docker compose --env-file .env.example config`.
2. Construit les images `api` et `frontend`.

## Les secrets GitHub

### Liste des secrets

| Secret | Utilisé par | Exemple de valeur |
| --- | --- | --- |
| `TEST_DB_USER` | utilisateur MySQL de la base de test | `ci_user` |
| `TEST_DB_PASSWORD` | mot de passe de cet utilisateur | un mot de passe long et aléatoire |

> ⚠️ N'utilise **pas** `root` comme valeur de `TEST_DB_USER` : l'image MySQL refuse de créer un utilisateur qui s'appelle `root`. Le mot de passe root du conteneur est généré au hasard (`MYSQL_RANDOM_ROOT_PASSWORD`) et ne sert jamais.

### Comment les secrets sont reliés aux tests d'intégration

```text
Secrets GitHub                  Service MySQL (CI)          Variables lues par PHPUnit
───────────────                 ──────────────────          ──────────────────────────
TEST_DB_USER      ──────────►   MYSQL_USER        ──┐
TEST_DB_PASSWORD  ──────────►   MYSQL_PASSWORD    ──┤
                                                    │
TEST_DB_USER      ──────────────────────────────────┼────►  DB_USER
TEST_DB_PASSWORD  ──────────────────────────────────┴────►  DB_PASS
                                (valeurs fixes)              DB_HOST = 127.0.0.1
                                                             DB_NAME = test_database
```

- **Côté MySQL** : au démarrage, le service crée l'utilisateur `TEST_DB_USER` avec le mot de passe `TEST_DB_PASSWORD`. Cet utilisateur a tous les droits sur `test_database`, et seulement sur elle.
- **Côté PHP** : le job expose les mêmes valeurs dans `DB_USER` et `DB_PASS`. `phpunit.xml` les transmet à `$_ENV`, que `Core\Database` utilise pour se connecter.
- **Masquage** : GitHub remplace automatiquement la valeur des secrets par `***` dans les logs.

Ordre de priorité des variables lues par les tests :

1. `api/.env.testing`, s'il existe (en local uniquement, jamais versionné) ;
2. les variables d'environnement (en CI, ce sont les secrets) ;
3. les valeurs par défaut de `api/phpunit.xml`.

### Créer les secrets

> 🔐 Sur un dépôt personnel, **seul le propriétaire du dépôt** (ici `cindydgo`) peut créer ou modifier les secrets. Les collaborateurs avec le droit `push` ne voient pas cette page.

**Depuis le site GitHub**

1. Ouvrir le dépôt, puis **Settings → Secrets and variables → Actions**.
2. Cliquer sur **New repository secret**.
3. Name : `TEST_DB_USER`, Secret : `ci_user`, puis **Add secret**.
4. Recommencer avec Name : `TEST_DB_PASSWORD` et un mot de passe généré, par exemple avec `openssl rand -base64 24`.

**Avec GitHub CLI**

```bash
gh secret set TEST_DB_USER --repo cindydgo/parc_national_des_calanques --body "ci_user"
openssl rand -base64 24 | gh secret set TEST_DB_PASSWORD --repo cindydgo/parc_national_des_calanques
gh secret list --repo cindydgo/parc_national_des_calanques
```

### Vérifier que tout est branché

1. Ouvrir (ou mettre à jour) une pull request vers `master`.
2. Dans l'onglet **Actions**, ouvrir le job **Backend (PHP)**.
3. L'étape *Check test database secrets* doit passer, puis *Run integration tests* doit afficher `OK`.

Si un secret manque, le job échoue avec :

```text
Error: Secrets TEST_DB_USER et/ou TEST_DB_PASSWORD manquants (voir CI_CD.md).
```

> ℹ️ Les pull requests ouvertes **depuis un fork** n'ont pas accès aux secrets. Dans ce cas, les tests d'intégration échouent à cette étape. Il faut pousser la branche directement sur le dépôt.

## Lancer les tests en local

### Tests unitaires (sans base)

```bash
cd api
composer install
vendor/bin/phpunit --testsuite Unit
```

### Tests d'intégration (avec une base MySQL de test)

1. Démarrer une base de test jetable :

   ```bash
   docker run -d --rm --name mysql-test -p 3306:3306 \
     -e MYSQL_DATABASE=test_database \
     -e MYSQL_USER=test_user -e MYSQL_PASSWORD=change_me \
     -e MYSQL_RANDOM_ROOT_PASSWORD=yes \
     mysql:8.4
   ```

2. Attendre quelques secondes, puis importer le schéma :

   ```bash
   docker exec -i -e MYSQL_PWD=change_me mysql-test \
     mysql -h 127.0.0.1 -u test_user test_database < database/parc_national.sql
   ```

3. Créer `api/.env.testing` à partir de l'exemple. Ses valeurs correspondent déjà à la base ci-dessus, et le fichier est ignoré par Git.

   ```bash
   cp api/.env.testing.example api/.env.testing
   ```

   > Si un MySQL tourne déjà sur le port 3306 de ta machine, arrête-le d'abord : `Core\Database` ne gère pas encore de variable `DB_PORT`.

4. Lancer les tests :

   ```bash
   cd api
   vendor/bin/phpunit --testsuite Integration
   ```

5. Arrêter la base : `docker stop mysql-test`.

> ⚠️ Les tests d'intégration **vident la table `users`** (`DELETE FROM users`). Ne les lance jamais sur la base de développement de `compose.yml`.

## Ajouter un secret pour une future étape

1. Créer le secret dans **Settings → Secrets and variables → Actions**.
2. Le passer à l'étape qui en a besoin, uniquement avec `env:` :

   ```yaml
   - name: Mon étape
     env:
       MA_VARIABLE: ${{ secrets.MON_SECRET }}
     run: ./mon-script.sh
   ```

3. Ne jamais écrire un secret en clair dans un fichier versionné, et ne jamais l'afficher avec `echo`.
4. Ajouter le secret au tableau [Liste des secrets](#liste-des-secrets) de ce document.

## Et le CD (déploiement) ?

Il n'y a pas encore de déploiement automatique : le pipeline s'arrête après le build des images Docker. Pour en ajouter un, il faudrait :

1. Des Dockerfiles de production (multi-stage, `composer install --no-dev`, front buildé et servi par nginx). Les Dockerfiles actuels sont faits pour le développement.
2. Un registre d'images (par exemple GitHub Container Registry) et une étape `docker push`.
3. Un job `deploy` déclenché seulement sur `master`, avec ses propres secrets (accès au serveur, `SECRET_KEY` de production, identifiants de la base de production), idéalement dans un **Environment** GitHub protégé.
