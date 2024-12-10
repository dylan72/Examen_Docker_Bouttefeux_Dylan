# Convertisseur de Hash en PHP

Cette application est une interface web permettant de crypter du texte en utilisant différentes méthodes de hashage. Elle permet également de conserver un historique des textes cryptés avec leurs méthodes de cryptage. On peut également supprimer des entrées spécifiques de l'historique.

---

## Prérequis

Avant de lancer le projet, assurez-vous d'avoir installé :

- [Docker](https://www.docker.com/get-started).
- [Docker Compose](https://docs.docker.com/compose/install/).

---

## GitHub Actions

Le projet inclut un workflow GitHub Actions qui :

1. Compile automatiquement l'image Docker à chaque **push** ou **pull request** sur la branche `main`.
2. Vérifie que l'image Docker peut être construite correctement.

---

## Installation et lancement

### Étapes d'installation

1. **Cloner le dépôt Git** :
   ```bash
   git clone https://github.com/dylan72/Examen-Docker-Bouttefeux-Dylan.git
   cd Examen-Docker-Bouttefeux-Dylan

2. **Construire l'image Docker** :
   ```bash
   docker-compose build

3. **Lancer l'application avec Docker** :
   ```bash
   docker-compose up

4. **Accéder à l'application :** :
   ```bash
   http://localhost:8082