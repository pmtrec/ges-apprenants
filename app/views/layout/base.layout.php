<?php
session_start(); 
use App\MESS\Enums\Textes;
if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit();
}
?>

<?php 
return function($contenu){
    ob_start();
    

    $path = "http://" . $_SERVER["HTTP_HOST"];
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $path .Chemins::CheminAssetCss->value."/layout.css"?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Document</title>


</head>

<body>
    <div class="container">
        <div class="sidebar">
            <div class="logPRO">
                <div class="log">
                    <img src="<?= $path.Chemins::CheminAssetImage->value."/logo_odc.png"?>" alt="logo sonatel">
                </div>
                <div class="Prom">
                    <h5>Promotion - 2025</h5>
                </div>
            </div>

            <div class="menu">
                <div class="trait"></div>

                <a href="#" class="<?= ($currentPath == '/dashboard') ? 'active' : '' ?>">
                    <div><i class="fa-solid fa-house"></i></div>
                    <div>Tableau de bord</div>
                </a>

                <a href="/promotion" class="<?= ($currentPath == '/promotion') ? 'active' : '' ?>">
                    <div><i class="fa-regular fa-folder"></i></div>
                    <div>Promotions</div>
                </a>

                <a href="/referentiels" class="<?= ($currentPath == '/referentiels') ? 'active' : '' ?>">
                    <div><i class="fa-solid fa-book"></i></div>
                    <div>Référentiels</div>
                </a>

                <a href="#" class="<?= ($currentPath == '/apprenants') ? 'active' : '' ?>">
                    <div><i class="fa-regular fa-user"></i></div>
                    <div>Apprenants</div>
                </a>

                <a href="#" class="<?= ($currentPath == '/presences') ? 'active' : '' ?>">
                    <div><i class="fa-solid fa-file"></i></div>
                    <div>Gestion des présences</div>
                </a>

                <a href="#" class="<?= ($currentPath == '/kits') ? 'active' : '' ?>">
                    <div><i class="fa-solid fa-laptop"></i></div>
                    <div>Kits & Laptops</div>
                </a>

                <a href="#" class="<?= ($currentPath == '/rapports') ? 'active' : '' ?>">
                    <div><i class="fa-solid fa-signal"></i></div>
                    <div>Rapports & stats</div>
                </a>
            </div>

            <div class="saysay"></div>

            <div class="form">
            <form action="/logout" method="post">
    <button type="submit" class="decon">
        <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
    </button>
</form>
            </div>
        </div>

        <div class="droite">
            <div class="nav">
            <div class="cherche">
    <form method="get" action="">
    <div class="cherche">
    <form method="get" action="">
        <label for="filtre">Rechercher par :</label>
        <select id="filtre" name="filtre" onchange="afficherChecklist()">
            <option value="">-- Choisir --</option>
            <option value="apprenant" <?= ($_GET['filtre'] ?? '') === 'apprenant' ? 'selected' : '' ?>>Apprenant</option>
            <option value="promotion" <?= ($_GET['filtre'] ?? '') === 'promotion' ? 'selected' : '' ?>>Promotion</option>
        </select>

        <div id="checklist-apprenant" class="checklist" style="display: none; margin-top: 10px;">
            <p><strong>Choisissez les apprenants :</strong></p>
            <?php 
            $apprenants = ['Aliou', 'Fatou', 'Moussa'];
            foreach ($apprenants as $a): 
                $checked = in_array($a, $_GET['options'] ?? []) ? 'checked' : '';
            ?>
                <label><input type="checkbox" name="options[]" value="<?= $a ?>" <?= $checked ?>> <?= $a ?></label><br>
            <?php endforeach; ?>
        </div>

        <div id="checklist-promotion" class="checklist" style="display: none; margin-top: 10px;">
            <p><strong>Choisissez les promotions :</strong></p>
            <?php 
            $promotions = ['L1', 'L2', 'M1'];
            foreach ($promotions as $p): 
                $checked = in_array($p, $_GET['options'] ?? []) ? 'checked' : '';
            ?>
                <label><input type="checkbox" name="options[]" value="<?= $p ?>" <?= $checked ?>> <?= $p ?></label><br>
            <?php endforeach; ?>
        </div>
        

        <button type="submit" style="margin-top: 10px;">Rechercher</button>
    </form>
</div>


    </form>
</div>

                <div class="infUser">
                    <div class="cloche"><i class="fa-regular fa-bell"></i></div>
                    <div class="icPrenom">A</div>
                    <div class="loginfo">
                    <?= htmlspecialchars($_SESSION['user']['id'] ?? 'Non connecté') ?>                        <div class="Admi">Administrateur</div>
                    </div>
                </div>
            </div>
            <div class="variant">
                 <?=  $contenu ?>
            </div>
        </div>
    </div>
</body>

</html>

<?php 
 return ob_get_clean();
};
?>
