<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <?php  $urlCss = "http://" . $_SERVER["HTTP_HOST"]; ?>
    <title>Erreur 404 - Page Non Trouvée</title>
    <link rel="stylesheet" href="<?= $urlCss . Chemins::CheminAssetCss->value . '/erreur.css' ?>">
    </head>
<body>
    <div class="container">
        <div class="lost-character">
            <div class="character">
                <div class="eye eye-left">
                    <div class="pupil"></div>
                </div>
                <div class="eye eye-right">
                    <div class="pupil"></div>
                </div>
                <div class="mouth"></div>
            </div>
            <div class="map"></div>
            <div class="question-mark">?</div>
        </div>
        
        <h1>
            <span class="digit">4</span>
            <span class="digit">0</span>
            <span class="digit">4</span>
        </h1>
        
        <h2>Oups ! Page introuvable</h2>
        
        <p>Il semble que notre petit personnage se soit perdu dans le labyrinthe d'Internet, tout comme la page que vous cherchez.</p>
        
        <a href="/login" class="home-button">Retourner à l'accueil</a>
        
        <div class="maze">
            <div class="maze-line line-1"></div>
            <div class="maze-line line-2"></div>
            <div class="maze-line line-3"></div>
            <div class="maze-line line-4"></div>
        </div>
        
        <div class="circle-404 circle-1"></div>
        <div class="circle-404 circle-2"></div>
        <div class="circle-404 circle-3"></div>
        
        <div class="lost-cursor"></div>
    </div>
</body>
</html>