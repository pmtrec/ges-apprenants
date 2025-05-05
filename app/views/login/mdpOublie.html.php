<?php 
require_once __DIR__ . '/../../enums/Textes.php';
use App\MESS\Enums\Textes;

$url = "http://" . $_SERVER["HTTP_HOST"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Changer mot de passe - Orange Digital Center</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: aliceblue;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cadre {
            border: 1px solid #029390;
            width: 460px;
            min-height: 700px;
            border-radius: 18px;
            background-color: white;
            box-shadow: 0px 12px 1px #029390, 13px 0px 1px #ff7901;
            padding: 20px;
        }

        .orange_digital_center {
            color: #e0914e;
            width: 100%;
            height: 45px;
            display: flex;
            font-size: 0.8rem;
            align-items: end;
            justify-content: center;
            padding-right: 40px;
        }

        .logo_titre {
            color: #53b1ab;
            width: 100%;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: bold;
            gap: 10px;
        }

        .bienenue, .bienenue_odc {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .bienenue {
            color: #5b5b5b;
            padding-top: 10px;
        }

        .bienenue_odc {
            color: #fd9338;
        }

        .se_connecter {
            color: black;
            font-weight: bold;
            width: 100%;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.4rem;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .formulaire {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        .formulaire_de_login {
            width: 87%;
        }

        input.mat {
            border: 1px solid rgb(187, 179, 179);
            width: 100%;
            height: 50px;
            border-radius: 3px;
            padding: 0 10px;
        }

        input.alert {
            border-color: red;
        }

        .mot_de_passe_oublier {
            text-align: end;
            color: red;
        }

        .mot_de_passe_oublier a {
            text-decoration: none;
            color: red;
        }

        .btn {
            font-size: 1.1rem;
            text-align: center;
            color: white;
            width: 95%;
            height: 40px;
            background-color: #ec6e00;
            border-radius: 6px;
            box-shadow: 1px 2px 1px orange;
            border: 1px solid transparent;
            margin-top: 30px;
            cursor: pointer;
        }

        .alert {
            background-color: #ffd2d2;
            color: red;
            text-align: center;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="cadre">
    <div class="orange_digital_center">Orange Digital Center</div>

    <div class="logo_titre">
        <div class="titre">SONATEL</div>
        <img src="<?= $url . Chemins::CheminAssetImage->value . "/logo_odc.png" ?>" alt="logo sonatel" width="50px">
    </div>

    <div class="bienenue"><?= Textes::Bienvenue1->value; ?></div>
    <div class="bienenue_odc"><?= Textes::ECSA->value; ?></div>
    <div class="se_connecter"><?= Textes::ChangePass->value; ?></div>

    <?php if(!empty($_SESSION['message'])): ?>
        <div class="alert"><?= $_SESSION['message'] ?></div>
    <?php endif; ?>
    <?php unset($_SESSION['message']); ?>

    <div class="formulaire">
        <div class="formulaire_de_login">
            <form action="/changer-mdp" method="POST">
                <label for="email"><?= Textes::EntrerEm->value; ?></label><br><br>
                <input 
                    type="email" 
                    class="mat <?php if(!empty($message["msgId"])) echo 'alert'; ?>" 
                    id="email" 
                    name="email" 
                    placeholder="<?= empty($message["msgId"]) ? Textes::EntrerEm->value : $message["msgId"]; ?>"
                ><br><br>

                <label for="new_password"><?= Textes::MDP->value; ?></label><br><br>
                <input 
                    type="password" 
                    class="mat <?php if(!empty($message["msgP"])) echo 'alert'; ?>" 
                    id="new_password" 
                    name="new_password" 
                    placeholder="<?= empty($message["msgP"]) ? Textes::PlaceholderMdp->value : $message["msgP"]; ?>"
                ><br><br>

                <label for="confirm_password">Confirmez le mot de passe</label><br><br>
                <input 
                    type="password" 
                    class="mat <?php if(!empty($message["msgC"])) echo 'alert'; ?>" 
                    id="confirm_password" 
                    name="confirm_password" 
                    placeholder="Confirmez votre nouveau mot de passe"
                ><br><br>

                <p class="mot_de_passe_oublier">
                    <a href="/connexion">Retour à la connexion</a>
                </p>

                <button type="submit" class="btn"><?= Textes::Changer->value; ?></button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
