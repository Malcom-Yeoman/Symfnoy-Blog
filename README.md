# Symfony-Blog

Un projet Symfony pour la gestion et l'affichage de blog, construit en utilisant Symfony, PHP, et Bootstrap. Cette application vous permet de visualiser, commenter et gérer des articles de blog avec une interface admin intégrée.

## Fonctionnalités

- Liste d'articles de blog avec une mise en page élégante.
- Possibilité de laisser des commentaires sur chaque article.
- Interface d'administration pour gérer les articles, commentaires, et catégories.
- Optimisé pour la meilleure expérience utilisateur avec pagination.
- Personnalisez le blog selon vos besoins et préférences.

## Liste Utilisateurs

- john.doe@example.com
- jane.doe@example.com
- alice.smith@example.com
- bob.jones@example.com
- carol.wilson@example.com
- admin@example.com

mot de passe = password

## Captures d'écran

![Capture d'écran de la liste d'articles](Symfony-Blog.png)

## Comment utiliser le projet

1. Clonez ce dépôt sur votre machine locale :
   ```bash
   git clone git@github.com:Malcom-Yeoman/Symfony-Blog.git
    ```
2. Installez les dépendances :
   ```bash
   composer install
    ```
3. Configurez la base de données dans le fichier .env :
   ```bash
    DATABASE_URL="mysql://db_user:db_mdp@127.0.0.1:8889/db_name?serverVersion=5.7"  
    ```
4. Créez la base de données et effectuez les migrations :
   ```bash
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate
    ```
5. Chargez des données de test :
   ```bash
    php bin/console doctrine:fixtures:load
    ```
6. Lancez le serveur Symfony :
   ```bash
    symfony serve:start
    ```

## Personnalisation

Ce blog est flexible et conçu pour être facilement modifiable. Vous pouvez ajouter des fonctionnalités supplémentaires, personnaliser la mise en page, ajouter des catégories, ou même intégrer des plugins supplémentaires.

## Contribution

Les contributions sont les bienvenues ! Si vous avez des suggestions d'améliorations, des corrections à apporter ou de nouvelles fonctionnalités à suggérer, n'hésitez pas à créer une demande de tirage (pull request) ou à ouvrir une issue.