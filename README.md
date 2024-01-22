# TP Automatisation du developpement - Test - Rendu 3

Membres du Binôme : 
Vincent Brach et Pellizzari Théo

Mini projet pour le rendu numéro 3 du cours d'automatisation du développement sur les tests.

Ce projet contient seulement 3 classes qui intéragissent entre elle :

- `Person` : Classe qui permet de créer une personne
- `Wallet` : Classe qui permet de créer un portefeuille avec une devise spécifique
- `Product` : Classe qui permet de créer un produit avec une catégorie et une liste de prix par devise.

## Technologie utilisées

- PHP 8.2
- PHPUnit 10.5

## Installation

### Docker

Vous pouvez utilisez Docker pour faire fonctionner ce projet

```sh
docker compose up
```

Sinon il suffit de lancer l'installation des packages via composer :

```sh
composer install
```

## Script

Si vous utilisez Docker ces commandes sont à lancer depuis le container ou avec le prefix `docker compose exec php`

### Run test with [PHPUnit](https://phpunit.de/)

```sh
composer test
```

utilise la configuration disponible dans le fichier `phpunit.xml`

### Run test and coverage

```sh
composer test:coverage
```

édite un rapport au format HTML dans le dossier `coverage`

### Linter

```sh
composer phpcs
```

```sh
composer phpcs:fix
```

### PHPStan

```sh
composer phpstan
```

## Structure du projet

- **src** : Contient le code source de l'application
  - **Entity** : Contient les classes entités du projet
- **tests** : Contient le code source des tests
- **coverage** : Dossier contentant les rapports de test coverage

## Attendu

Après avoir parcours les différentes classes, vous devrez écrire les tests pour couvrir l'intégralité des use case de ce projet.

Pour cela vous devrez créer un fichier `phpunit.xml` pour la configuration de PHPUnit. Vous devrez avoir une attention particulière à la structure de votre dossier test.

Utilisez des dataProvider et des fixtures lorque que cela vous semble pertinant.

### Tips

Servez vous des rapports de code coverage pour vérifier la pertinence de vos tests.

Si vous rencontrer l'erreur :
  > No code coverage driver available

C'est que vous n'avez pas l'extention XDebug de configuré avec PHP. Pour l'ajouter suivez le [guide d'installation](https://xdebug.org/docs/install) pour votre OS.
