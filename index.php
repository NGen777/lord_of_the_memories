<!-- 
Initialisation de la page HTML
Ajout des Métadonnées (données facilitant le travail des navigateurs et des robots d'indexation) 
& des Scripts permemttant la stylisation et le dynamisme de la page
-->


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Jeu de mémoire basé sur l'univers du Seigneur des anneux - Tolkien">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Styles/main.css">
    <script src="JS/main.js" defer></script>

    <title>LOTM</title>
</head>

<!-- 
Contenu traduit et affiché par le navigateur
Class & Id permettant la stylisation ainsi que la récupération des éléments HTML pour le JS
 -->

<body>

    <div>
        <h1>Lord Of The Memories</h1>
    </div>

    <h2 class="start">Commencer une partie</h2>

    <div class="container">
        <div class="score">
            <div class="display-score">
                <h2>Meilleurs scores :</h2>
                <ul>
                    <?php
                    /*
                    Inclusion de code PHP permettant un affichage dynamique de la page (en fonction de la BDD)
                    En l'occurence les meilleurs scores et leurs Pseudos associés
                    */
                    include_once("Models/Score.php");
                    foreach (Score::findThreeBest() as $score) { ?>
                        <li><?= $score['score_nickname'] ?> - <?= $score['score_time'] ?> sec -</li>
                    <?php } ?>
                </ul>
                <h2>Temps restant :</h2>
                <div class="timeline"></div>
            </div>
        </div>
        <!--
        Elément grid vide avant initialisation de l'app
        Chargement du JS qui injecte le contenu (JS/mainjs::createGrid())        
        -->
        <div class="grid"></div>
    </div>

</body>

</html>