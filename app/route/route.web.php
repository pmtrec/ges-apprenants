<?php

declare(strict_types=1);

use App\Controllers;
use App\Enums\Fonction\Fonction;

$controller = __DIR__ . Chemins::Controller->value;

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$allowedPaths = ['/login', '/logout','/','', '/MDP'];

if (in_array($path, $allowedPaths, true)) {
    $authController = require __DIR__ . Chemins::Controller->value;

    if (($path === '/login') ||($path ==='/' ) || ($path ==='' )) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController['login']($_POST);
        } else {
            include __DIR__ . Chemins::ViewLogin->value;
        }
    } elseif ($path === '/logout') {
        $authController['logout']();
    } elseif ($path === '/MDP') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $authController['changerPassword']($_POST);
        } else {
            include __DIR__ . Chemins::ChangePass->value;
        }
    }

    exit;
}

if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit;
}

$promotionController = require __DIR__ . Chemins::PromoController->value;
$referentielController = require __DIR__ . Chemins::RefController->value;
$authController = require __DIR__ . Chemins::Controller->value;

$routes = [
    '/promotion' => function () use ($promotionController) {
        $recherche = $_GET['recherche'] ?? '';
        if (!empty($recherche)) {
            $promotionController['trouverPromoGrille']($recherche);
        } else {
            $promotionController['afficherAllPromo']();
        }
    },

    '/promotion/active' => function () use ($promotionController) {

        $nomPromo = $_GET['matriculePromo'] ?? null;


        if ($nomPromo) {
            $promotionController['activePromo']($nomPromo);
        } else {
            $promotionController['activePromo']();
        }
    },

    '/promotion/liste' => function () use ($promotionController) {
        $recherche = $_GET['recherche'] ?? '';
        if (!empty($recherche)) {
            $promotionController['trouverPromoListe']($recherche);
        } else {
            $promotionController['affichageListe']();
        }
    },
    '/promotion/ajout' => function () use ($promotionController, $controller) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $params = [
                'nomPromo' => $_POST['nomPromo'] ?? '',
                'date_debut' => $_POST['date_debut'] ?? '',
                'date_fin' => $_POST['date_fin'] ?? '',
                'referentiel' => $_POST['referentiel'] ?? '',
                'photo' => $_FILES['photo'] ?? null,
            ];

            $erreurs = $promotionController['ajoutPromo'](
                $params,
            );

            if (!empty($erreurs)) {
                $_SESSION['old'] = $params;
                $_SESSION['erreurs'] = $erreurs;
                $controller['redirection']("promotion#form-popup");
                exit;
            } else {
                $controller['redirection']("promotion");
            }
        }
    },





    '/referentiels' => function () use ($referentielController) {
    $recherche = $_GET['recherche'] ?? '';
    if (!empty($recherche)) {
        $referentielController['chercherRef']($recherche);
    } else {
        $referentielController['affichageRef']();
    }
    },

    '/Tout_referentiels' => $referentielController['affichageToutRef'],


'/referentiel/ajout' => function () use ($referentielController) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $params = [
            'nomRef' => $_POST['nomReferentiel'] ?? '',
            'description' => $_POST['description'] ?? '',
            'nbrApprenant' => (int)($_POST['capacite'] ?? 0),
            'nbrModule' => (int)str_replace(' session', '', $_POST['nombre_sessions']) ?? 0,
            'photo' => $_FILES['photo'] ?? null,
        ];

    
        $referentielController[Fonction::ajouterRef->value]($params);
    }
},


];

if (isset($routes[$path])) {
    $handler = $routes[$path];
    $handler();
} else {
    http_response_code(404);
    include __DIR__ . Chemins::Erreur404->value;
}
if ($_SERVER['REQUEST_URI'] === '/logout') {
    require_once __DIR__ . '/../views/login/logout.php';
    exit();
}
