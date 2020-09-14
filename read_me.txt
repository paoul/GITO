L'application de gestion de l'institut de technologie d'owendo est une application qui permet à chaque personnel administratif d'effectuer des activités au sein de l'éttablisssement.

***CONFIG***
Ce dossier contient tous les fichies de configuration de l'application qui renseignent tout sur la base de donnée de notre application
 - dbConnect.php qui contient le code de connexion à la base de données
 - procedures.sql contient toutes les procedures stockée de la base de donnée.

***PARTIALS***
Ce dossier contient tous les fichiers contenant des morceaux de code pouvant être utilisé plus d'une fois
Par exemple le code qui concerne le menu au lieu de le copier dans plusieurs fichiers,
on le met dans un seul fichier et on l'inclut dans les endroits où on a besoin du menu

***VUES***
Ce dossier contient tous les fichiers qui vont afficher les interfaces graphiques
Chaque fichier se trouvant à la racine a une vue correspondante se trouvant dans le dossier VUES

Les fichiers se trouvant à la racine contiennent tout ce qui concerne la logique ! C.a.d, tout ce qui concerne
la connexion à la base de données, les requêtes SQL, etc
