
<!DQCTYPE html>
<html lang="fr">
<?php
$url="http://".$_SERVER["HTTP_HOST"];
require_once __DIR__ . '/../../enums/Textes.php';
use App\MESS\Enums\Textes;

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $url.Chemins::CheminAssetCss->value."/login.css"; ?>">
    <title>Connexion</title>
</head>
<body>
<div class="cadre">
    <div class="orange_digital_center">Orange Digital Center</div>
    <div class="logo_titre">
        <div class="titre">SONATEL</div>
        <img src="/assets/images/logo.png" alt="image">
    </div>
    <div class="bienenue">Bienvenue sur</div>
    <div class="bienenue_odc">Ecole du code Sonatel Academy</div>
    <div class="se_connecter">Se connecter</div>
     
        <?php if(!empty($_SESSION['message'])): ?>
            <div class="alert"><?= $_SESSION['message'] ?></div>
        <?php endif; ?>
        <?php if(!empty($_SESSION['messageSuccess'])): ?>
            <div class="alertSuccess"><?= $_SESSION['messageSuccess'] ?></div>
        <?php endif; ?>

        <?php unset($_SESSION['message']); ?>

        <div class="formulaire">
    <div class="formulaire_de_login">
        <form action="/login" method="post">
            
            <label for="login" class="login"><?= Textes::Login->value; ?></label> <br><br>
            <input 
                type="text" 
                name="login" 
                id="login" 
                placeholder="<?php if(empty($message["msgId"])): ?><?= Textes::PlaceholderLogin->value; ?><?php else: ?><?= $message["msgId"] ?><?php endif; ?>" 
                value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" 
                class="<?php if(empty($message["msgId"])): ?>mat<?php else: ?>mat alert<?php endif; ?>" 
            /> 
            <br><br>

            <label for="password"><?= Textes::MDP->value; ?></label> <br><br>
            <input 
                type="text" 
                name="password" 
                id="password" 
                placeholder="<?php if(empty($message["msgP"])): ?><?= Textes::PlaceholderMdp->value; ?><?php else: ?><?= $message["msgP"] ?><?php endif; ?>" 
                value="<?= htmlspecialchars($_POST['password'] ?? '') ?>" 
                class="<?php if(empty($message["msgP"])): ?>mdp<?php else: ?>mdp alert<?php endif; ?>" 
            />
            <br><br>

            <p class="mot_de_passe_oublier">
                <a href="/MDP"><?= Textes::MDPOublie->value; ?></a>
            </p>

            <button type="submit" class="btn"><?= Textes::SeConnecter->value; ?></button>
        
        </form>
    </div>
</div>

      
    </div>
</body>
</html>