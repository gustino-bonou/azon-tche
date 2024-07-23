Assurez-vous d'avoir les prérequis installés : Node.js, npm, Composer, PHP.

1-pour demarrer le front  


-Ouvre un terminal
-Navigue jusqu'au répertoire où tu souhaites cloner le projet.
-Exécute la commande 

git clone -b frontv1 https://github.com/gustino-bonou/azon-tche.git  --single-branch

-Naviguer dans le répertoire du projet :

cd <nom-du-repertoire-du-projet>

-Installer les dépendances :

npm install

-demarrer le front  

npm install




2-pour demarrer le backend  


-Ouvre un nouveau terminal
-Navigue jusqu'au répertoire où tu souhaites cloner le projet.
-Exécute la commande 

git clone -b backv1 https://github.com/gustino-bonou/azon-tche.git  --single-branch

-Naviguer dans le répertoire du projet :

cd <nom-du-repertoire-du-projet>

-Installer les dépendances :

composer install

-demarrer le front  
 
npm install

-Configurer les variables d'environnement :

cp .env.example .env

-Générer une clé d'application

php artisan key:generate

-Créer une client d'authentification

php artisan passport:client --personal (authClient pour le prompt)

-sous windows, demarrer le serveur local de simulation de mail, dans le repertoire du projet, exécuter 

./MailHog_windows_amd64.exe

-acceder à l'interface du serveur de mail sur l'url   

http://0.0.0.0:8025/

-Demarrer le l'ecoute des jobs    

php artisan queue:listen     

-Demarrer le backend :

php artisan serve





Foncinalités: 
Création de projet    
Organisation de taches dans de projets
Assignation de tache à un utilisateur inscrit sur l'application grace à son email    
Modification de tache   
Liste de tache   
Liste de projet   
Quand l'utilisateur est connecté, il voit la liste de ses projets créés ou les projets dans lesquelles une tache lui a été assigné une fois
Pour assgner une tache, on clique sur la partie de la tache présentant l'icon utilisateur  , on renseigne l'email. Avec au moins trois lettres de l'email renseignées, les utilisateur ayant ces emails sont sont affichés