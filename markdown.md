# Sujet choisi : Authentification/Autorisation

## Objectifs

- Authentification au sein de l'application (user/mot de passe) via un formulaire de login donc un contrôleur avec la méthode POST.
- Gestion de la session en cas d'authentification réussie : écriture d'un service de gestion de session qui permettrait, via un objet, d'interagir avec le tableau superglobal `$_SESSION`.
- Pour les autorisations : écriture d'un attribut applicable au-dessus d'un contrôleur, qui permettrait d'indiquer si on doit être connecté ou non pour accéder au contrôleur.
- Note : pas besoin de faire des rôles.

## Implémentation

### AuthController.php :

Dans mon projet, j'ai implémenté AuthController.php pour gérer l'authentification des utilisateurs. Voici les points clés :

- Dépendances Injectées :
  UserRepository : Utilisé pour récupérer les informations des utilisateurs depuis la base de données.
  SessionManager : Gère les sessions utilisateur, ce qui est crucial pour maintenir l'état de connexion d'un utilisateur.
- Le Constructeur :
  Le constructeur initialise UserRepository et SessionManager. Cela me permet d'accéder à la base de données et de gérer les sessions utilisateur directement depuis le contrôleur.

- La Méthode login :
  Si la requête est de type GET, le formulaire de connexion est affiché.
  Pour les requêtes POST, je récupère les informations d'identification de l'utilisateur (username et password) et vérifie si elles sont correctes.
  Si les identifiants sont valides, je démarre une session utilisateur et redirige l'utilisateur vers la page d'accueil.
  En cas d'échec, l'utilisateur est informé que ses identifiants sont incorrects.

- La Méthode logout :
  Cette méthode détruit la session en cours, déconnectant ainsi l'utilisateur, et le redirige vers le formulaire de connexion.

Cette classe AuthController est un élément essentiel de mon système d'authentification, car elle gère à la fois le processus de connexion et de déconnexion, assurant ainsi la sécurité et une bonne gestion des sessions utilisateur.

### UserRepository.php :

Dans mon projet, j'ai créé la classe UserRepository pour interagir avec la base de données concernant les informations des utilisateurs. Voici les détails importants :

- Connexion à la Base de Données :
  La classe utilise l'objet PDO pour la connexion à la base de données. PDO est un outil puissant en PHP qui permet d'interagir de manière sécurisée avec différents types de bases de données.

        Le constructeur reçoit un objet PDO en tant que paramètre et l'initialise pour l'usage interne de la classe. Cela me permet d'utiliser cet objet PDO pour exécuter des requêtes SQL.

- La Méthode findByUsername :
  Cette méthode est essentielle pour le processus d'authentification. Elle prend un nom d'utilisateur (username) en paramètre et prépare une requête SQL pour récupérer les informations de cet utilisateur dans la base de données.
  J'utilise des requêtes préparées pour éviter les injections SQL, une pratique de sécurité importante. La méthode bindParam associe le nom d'utilisateur à la requête préparée.
  Après l'exécution de la requête, je récupère les résultats avec fetch(PDO::FETCH_ASSOC), qui renvoie les informations de l'utilisateur sous forme de tableau associatif.

Cette classe UserRepository est donc un composant clé de mon système d'authentification. Elle me permet de récupérer de manière sûre et efficace les informations des utilisateurs depuis la base de données, ce qui est crucial pour vérifier les identifiants lors de la connexion.

### RequireLogin.php :

- Dans mon projet, j'ai implémenté RequireLogin.php pour gérer les accès autorisés aux différentes parties de l'application. C'est un attribut personnalisé qui aide à contrôler l'accès aux contrôleurs ou aux méthodes spécifiques en fonction de l'état de connexion de l'utilisateur.

### SessionManager.php :

Pour gérer efficacement les sessions utilisateurs dans mon application, j'ai créé la classe SessionManager. Cette classe est essentielle pour maintenir l'état de connexion de l'utilisateur à travers les différentes requêtes. Voici comment elle fonctionne :

- Démarrage de la Session :
  La méthode startSession vérifie si une session est déjà active (session_status() == PHP_SESSION_NONE). Si aucune session n'est active, elle en démarre une nouvelle avec session_start(). Cela garantit qu'une session est toujours disponible pour stocker et accéder aux données de l'utilisateur.

- Destruction de la Session :
  destroySession est utilisée pour terminer une session active avec session_destroy(). Cela est utile pour la déconnexion, effaçant toutes les données enregistrées dans la session.

- Vérification de l'Authentification :
  isAuthenticated vérifie si l'utilisateur est actuellement connecté. Elle démarre d'abord une session si nécessaire, puis vérifie si les données de l'utilisateur ($\_SESSION['user']) sont présentes. Si oui, cela signifie que l'utilisateur est authentifié.

En utilisant SessionManager, je m'assure que la gestion des sessions est centralisée, sécurisée et cohérente dans toute l'application. Cela facilite la mise en œuvre de l'authentification et la vérification de l'état de connexion des utilisateurs, tout en rendant le code plus propre et plus maintenable.

### Login.html.twig :

Dans mon application, login.html.twig est le modèle Twig utilisé pour afficher le formulaire de connexion. Voici les éléments clés :

- Structure HTML Basique :
  Le fichier commence par la structure de base HTML avec les balises <html>, <head> et <body>.
  Le titre de la page est défini à "Login" dans la balise <title>.

- Formulaire de Connexion :
  Un formulaire HTML est créé pour permettre aux utilisateurs de saisir leurs identifiants.
  Le formulaire utilise la méthode POST pour envoyer les données de manière sécurisée. L'action du formulaire est réglée sur "/", ce qui signifie qu'il envoie les données à la racine du site.

- Champs du Formulaire :
  Deux champs de saisie sont fournis : un pour le nom d'utilisateur (username) et un autre pour le mot de passe (password). Ces champs sont marqués comme required, ce qui signifie que l'utilisateur ne peut pas soumettre le formulaire sans les remplir.

- Bouton de Soumission :
  Un bouton de type submit est inclus pour permettre la soumission du formulaire.

- Gestion des Erreurs :
  Le modèle utilise la syntaxe Twig pour vérifier la présence d'un message d'erreur ({% if error %}). Si un message d'erreur est présent, il est affiché dans un paragraphe <p>.

Ce fichier login.html.twig est crucial pour l'interface utilisateur de la page de connexion. Il fournit une interface simple et intuitive pour que les utilisateurs puissent se connecter à l'application. En utilisant Twig, je peux facilement intégrer des logiques côté serveur, comme l'affichage des messages d'erreur, rendant l'expérience utilisateur plus réactive et conviviale.
