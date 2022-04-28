On souhaite construire une application de surveillance de la qualité de l'eau. Les utilisateurs potentiels sont, par exemple, les communes dont les maires doivent prendre des décisions lorsque certains seuils sont dépassés.

Pour cela, on utilise des données officielles issues du site Hub’eau qui recense les mesures de paramètres sur la qualité des rivières et la qualité de l'eau potable.

[API Hub’eau](https://hubeau.eaufrance.fr/page/apis)

De surcroît, on aimerait également prévoir de mesure la qualité de l'air,sont les données sont issues de la fédération des AASQA.

[API des AASQA](https://atmo-france.org/les-donnees/)

**Question 1 : Lisez les API et proposez un modèle de données pour les différentes API.**

Les API peuvent naturellement être consultées à la volée, mais on souhaite éviter le risque de l'interruption du service (réel) et pouvoir gérer les données de manière autonome.

Pour cela, nous allons importer régulièrement les données de puis le site d'origine et les stocker sur un support local.

**Question 1.1 : Que remarquez-vous dans la réponse de l'API Hub’eau ?** 

**Partie 2 : Construire une commande pour l'import des données**

Dans un premier temps, on souhaitera juste conserver les données dans un fichier au format JSON. Pour cela nous allons créer une commande pour la console de Symfony qui nous permettra d'exécuter cette opération depuis la ligne de commande. Par la suite, on voudra programmer des tâches dans le système d'exploitation de amnière à ce que les imports soient effectués à intervalle régulier automatiquement (`cron jobs`). 

**Exercice 1 : Ecrire une commande pour Symfony qui importe les données des mesures de l’eau potable**

1. Pour créer la classe de la commande, utilisez la commande `make:command`
2. Configurez la commande de manière à ce que :
   1. La commande admette en argument une ou plusieurs communes (par code ou par nom)
   2. En option, on pourra préciser :
      1. un ou plusieurs paramètres de mesures
      2. le nombre de résultats par page
      3. le n° de la page souhaitée
      4. la date de début et la date de fin des mesures
   3. On écrira également une documentation qui permettra à l'utilisateur de comprendre le fonctionnement de la commande grâce àl'option `--help`

_(En option, il est possible d'ajouter un mpdule d'auto-completion pàour les commandes de la console)_
3. Si aucune date n'est donnée, nous souhaiterions que la question soit posée à l'utilisateur. Dans ce ce cas, implémenter la méthode `interact` qui :
   1. par défaut prendra le mois précéden la date du jour pour période de consultation
   2. demandera à l'utilisateur de valider les dates de début et de fin
   3. échouera si les dates ne sont pas valides
4. Ecrire la méthode d'exécution (`execute`) qui se chargera de conbsulter l'API, de collecter la réponse et d'archiver les données

Contraintes :
- Traiter les différents cas d'erreurs
- Réfléchir à une architecture correcte du code
- Tester la commande les test unitaires ne sont pas nécessaires dans ce cas)

Options :
- Dans la mesure où cela est possible, essayer de mettre en forme et en couleur les messages de la manière la plus pertinente.

**Question 2.1 : Vérifiez que vous pouvez stocker la réponse dans un fichier.**

Toutefois, à l'intérieur du jeu de données reçu, on ne souhaite conserver que la partie réellement signifiante.

**Question 2.2 : Déterminez la partie signifiante de la réponse dans les différents cas**

Pour pouvoir traiter facilement des arbres JSON, on utilisera la bibliothèque `halaxa/json-machine`.

Pour pouvoir manipuler les données reçues de l'API, nous devons les transformer en tableau PHP. Cela peut cuase des erreurs de dépassement de la capacité mémoire de l'ordinateur. Nous voulons donc pouvoir choisir entre deux méthodes d'import :

- `impatient` (_eager_) : importe les données intégralement avant de les traiter
- `paresseux` (_lazy_) : traite les données à mesure qu'elles arrivent.

**Exercice 2.3 : Paramétrer la méthode d'import**

1. Ajouter une option à la commande pour permettre à l'utilisateur de choisir la méthode d'import
2. En fonction du choix, déterminer la méthode `HttpClient` adéquate
3. Modifier le processus pour pouvoir exécuter soit une méthode `saveEager`, soit une méthode `saveLazy`

**Question 2.4 : Quelle est la différence entre les méthodes du composant `HTTPClient` ?**

Nous souhiatons maintenant étendre les fonctionnalités de notre module d'import. Pour le moment, nous sauvegardons les données dans desfichiers, mais cela n'est pas pratique et nous voudrions utiliser une base de données. Et en réalité, nous voudrions pouvoir ne pas être limités dans le choix de notre support (e.g. pouvoir ajouter d'autres types de base de données comme Elasticsearch ou Redis, dans un fichier Excel, etc. options que nous ne connaissons pas _a priori_)

**Exercice 2.5 : Modifier l'architecture du code pour pouvoir faire l'un ou l'autre (fichier ou base de données)**

1. Créer les entités nécessaires et configurer la base de données.
2. Ajouter à la commande une option de choix de la méthode d'import
3. Modifier l'architecure des classes pour prendre en compte les différentes possibilités de stockage.
4. Configurer les services pour rendre les dépendances les plus modulaires possibles :
   1. Pour cela, on utilisera les “tags” des services et on créera un tag propre à notre besoin
      1. Créer un service “principal” qui agrégera toutes les options
      2. Référencer ce service en déclarant le tag associé à la directive `!tagged_iterator`
      3. Créer des classes pour chaque pilote de stockage
      4. Référencer chaque classe en l'associant au tag personnalisé
      5. Traiter la liste des pilotes dans le constructeur du service principal
5. Modifier la commande de amnière à appeler le “bon” service

**Exercice 3.1 : Etendre le système créé pour importer des données d'autres API, comme la qualité des rivières ou les données de pollution atmosphérique.**


**Exercice 3.2 : Ecrire un script qui automatise l'esxécution d'une commande à plusieurw reprises avec des paramètres différents**

Les données sont très volumineuses et la API Hub’eau n'autorise qu'un nombre limité de résultats dans la réponse. On voudrait maintenant faire un import massif qui liste les paramètres mesurés par les contrôleurs. Or, cux-là ne sont pas directment disponibles (et il y en a beaucoup). 

Plutôt que de passer par les liens HATEOAS, on voudrait relancer plusieurs fois la commande Symfony avec des paramètres différents et construire un tableau de tous les paramètres avec le nombre de leurs occurrences.

A la fin, les résultat seront stockés dans un fichier trié par nombre d'occurrences décroissant.

1. Ecrire le script PHP
   1. Le script admet comme paramètres (optionnels)
      1. une année
      2. un intervalle de mois
2. Utiliser les variables `$argc` et `$argv` pour injecter des paramètres dans le script 

_(vous tiendrez compte des limitations de la ligne de commande)_


4. Notifications

5. Cache

6. Messenger

7. Annotations et attributs PHP 8

7 Créer des “bundles”