# parc_national_des_calanques

# Dockerisation du projet

Le projet **Parc des Calanques** est composé de trois services exécutés avec **Docker Compose** :

* **Frontend** : application React/Vite
* **Backend** : API PHP
* **Database** : base de données MySQL 8.4

Docker Compose permet de lancer et de connecter automatiquement ces différents services.

## Structure Docker

```text
parc_des_calanques/
│
├── api/
│   ├── Dockerfile
│   ├── .dockerignore
│   ├── composer.json
│   └── ...
│
├── frontend/
│   ├── Dockerfile
│   ├── .dockerignore
│   ├── package.json
│   ├── package-lock.json
│   └── ...
│
├── database/
│   └── parc_national.sql
│
├── .env
├── .env.example
├── .gitignore
└── compose.yaml
```

## Prérequis

Pour lancer le projet avec Docker, il faut installer :

* Docker Desktop
* Docker Compose (inclus avec Docker Desktop)
* WSL 2 sous Windows

Vérifier que Docker fonctionne :

```bash
docker --version
docker compose version
```

## Configuration des variables d'environnement

Les informations sensibles, comme les mots de passe et les clés secrètes, sont stockées dans un fichier `.env` à la racine du projet.

Le fichier `.env` n'est pas versionné sur GitHub.

Un fichier `.env.example` est fourni afin d'indiquer les variables nécessaires à la configuration du projet.

Créer le fichier `.env` à partir du fichier d'exemple :

```bash
cp .env.example .env
```

Sous PowerShell :

```powershell
Copy-Item .env.example .env
```

Puis renseigner les valeurs nécessaires dans `.env`.

## Lancer le projet

Depuis le dossier racine du projet :

```bash
docker compose up --build
```

L'option `--build` permet de reconstruire les images Docker à partir des Dockerfiles.

Après le démarrage, les services sont accessibles aux adresses suivantes :

| Service  | Adresse                             |
| -------- | ----------------------------------- |
| Frontend | http://localhost:5173               |
| Backend  | http://localhost:8000               |
| MySQL    | Port 3306, réseau Docker uniquement |

## Démarrer les conteneurs

Une fois les images construites :

```bash
docker compose up
```

Pour démarrer les conteneurs en arrière-plan :

```bash
docker compose up -d
```

## Arrêter les conteneurs

Pour arrêter et supprimer les conteneurs du projet :

```bash
docker compose down
```

Les images et les données MySQL sont conservées.

## Reconstruire les images

Après une modification d'un Dockerfile ou d'une dépendance :

```bash
docker compose build
```

Puis :

```bash
docker compose up
```

Il est également possible de tout faire en une seule commande :

```bash
docker compose up --build
```

## Base de données MySQL

La base de données utilise l'image officielle **MySQL 8.4**.

Les paramètres MySQL sont récupérés depuis le fichier `.env` :

```yaml
environment:
  MYSQL_DATABASE: ${MYSQL_DATABASE}
  MYSQL_ROOT_PASSWORD: ${MYSQL_ROOT_PASSWORD}
```

Le backend utilise également les variables d'environnement définies dans `.env` :

```yaml
environment:
  DB_HOST: ${DB_HOST}
  DB_NAME: ${DB_NAME}
  DB_USER: ${DB_USER}
  DB_PASS: ${DB_PASS}
```

Dans Docker, `DB_HOST` doit être `database` et non `localhost`, car MySQL fonctionne dans un conteneur séparé.

Le fichier SQL :

```text
database/parc_national.sql
```

est automatiquement monté dans :

```text
/docker-entrypoint-initdb.d/
```

Lors de la création initiale du conteneur MySQL, ce fichier permet d'initialiser la base de données.

## Nettoyer les conteneurs

Pour arrêter et supprimer les conteneurs :

```bash
docker compose down
```

Pour supprimer également le volume de la base de données :

```bash
docker compose down -v
```

> `docker compose down -v` supprime les données persistées de MySQL. La base sera donc réinitialisée lors de la prochaine création du conteneur.

Pour supprimer les conteneurs Docker arrêtés :

```bash
docker container prune
```

## Vérifier l'état des conteneurs

Pour voir les conteneurs du projet :

```bash
docker compose ps
```

Pour voir tous les conteneurs Docker :

```bash
docker ps -a
```

## Consulter les logs

Pour afficher les logs de tous les services :

```bash
docker compose logs
```

Pour suivre les logs en temps réel :

```bash
docker compose logs -f
```

Pour consulter uniquement les logs du backend :

```bash
docker compose logs -f backend
```

Pour le frontend :

```bash
docker compose logs -f frontend
```

Pour MySQL :

```bash
docker compose logs -f database
```

## Variables d'environnement

### Frontend

Le frontend utilise :

```env
VITE_API_PATH=http://localhost:8000/api/
```

### Backend

Le backend utilise :

```env
DB_HOST=database
DB_NAME=parc_national
DB_USER=root
DB_PASS=change_me
SECRET_KEY=change_me
```

Les valeurs réelles doivent être renseignées dans le fichier `.env` et **ne doivent pas être publiées sur GitHub**.

Le fichier `.env.example` peut être versionné afin de fournir un modèle de configuration sans exposer de données sensibles.

## CI/CD

Le fonctionnement du pipeline, la configuration des secrets GitHub et le lancement des tests en local sont décrits dans [CI_CD.md](CI_CD.md).
