<?php
declare(strict_types=1);

namespace App\ControllersPromo;
use App\Enums\Fonction\Fonction;
use App\MESS\Enums\Textes;
use Chemins;
$controller=require __DIR__ . "/controller.php";
$servicePromo = $controller[Fonction::Inclusion->value](Chemins::ServicePromo->value);
$validator = $controller[Fonction::Inclusion->value](Chemins::Validator->value);




function ajoutPromo(array $params, array $validator, array $servicePromo,$controller): array {
    $donnee = include __DIR__ . Chemins::Model->value;
    $database = &$donnee['database'];
    $databaseFile = $donnee['databaseFile'];

    $nomPromo = $params['nomPromo'] ?? '';
    $dateDebut = $params['date_debut'] ?? '';
    $dateFin = $params['date_fin'] ?? '';
    $referentiel = $params['referentiel'] ?? '';
    $photoPromo = $_FILES['photo'] ?? null;

    $erreurs = [];

    if (empty($referentiel) || empty($nomPromo) || empty($dateDebut) || empty($dateFin) || empty($photoPromo['name'])) {
        $erreurs[] = Textes::TLO->value;
    }

    if (!$validator['date_Valide']($dateDebut) || !$validator['date_Valide']($dateFin)) {
        $erreurs[] = "Date invalide";
    } else {
        if (!$validator['dateDebut_Inferieur_DateFin']($dateDebut, $dateFin)) {
            $erreurs[] = "La date de début doit être inférieure ou égale à la date de fin.";
        }
    }

    if (!$servicePromo['unicite']($database, $nomPromo)) {
        $erreurs[] = Textes::PromoExiste->value;
    }

    if (!empty($erreurs)) {
        
        return $erreurs;
    }

    $photoPromoPath= $controller[Fonction::SavePhoto->value]($photoPromo);

    if ($servicePromo['ajouterPromo']($database, $nomPromo, $dateDebut, $dateFin, $referentiel, $photoPromoPath)) {
        $controller[Fonction::FPC->value]($databaseFile, $database);
        $_SESSION['message'] = Textes::AjoutSuccess->value;
        return [];
    }

    return ["Erreur lors de l'ajout dans la base de données"];
}



function affichageAllPromo(array $servicePromo, $controller): void {
    $donnee = include __DIR__ . Chemins::Model->value;
    $database = $donnee['database'];

    $infoPromo = $servicePromo['afficherAllPromo']($database);

    $promotions = array_filter($infoPromo, function($promo) {
        return 
            isset($promo['MatriculePromo'], $promo['filiere'], $promo['photoPromo'], $promo['debut'], $promo['fin']) &&
            !empty($promo['MatriculePromo']) && !empty($promo['filiere']) && !empty($promo['photoPromo']) && !empty($promo['debut']) && !empty($promo['fin']);
    });

    $promoActive = array_filter($promotions, function($promo) {
        return isset($promo['etat']) && strtolower($promo['etat']) === 'active';
    });

    if (!empty($promoActive)) {
       
        $promotions = array_values($promoActive);
    } else {
        $promotions = array_values($promotions);
    }

    
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = 6;

    $totalPromotions = count($promotions);
    $totalPages = ceil($totalPromotions / $perPage);

    $offset = ($page - 1) * $perPage;
    $promotionsPage = array_slice($promotions, $offset, $perPage);

    
    $data = [
        'Promotion' => $promotionsPage,
        'nbrRef' => $servicePromo['nbrFilieres']($database),
        'nbrProm' => $servicePromo['nbrPromo']($database),
        'nbrAppr' => $servicePromo['nbrAppr']($database),
        'totalPages' => $totalPages,
        'pageActuelle' => $page,
    ];

    $grillePromotion = $controller[Fonction::Inclusion->value](Chemins::Promotion->value);
    $layout = $controller[Fonction::Inclusion->value](Chemins::Layout->value);

    echo $layout($grillePromotion($data));
}


function trouverPromo($nomPromo, $servicePromo,$mode,$controller) {
    $donnee = $controller[Fonction::Inclusion->value](Chemins::Model->value);
    $database = $donnee['database'];

    $promoCherchee = $servicePromo['chercherPromo'](database: $database, nomPromo: $nomPromo);

    if ($promoCherchee) {
    
        if (!isset($promoCherchee[0])) {
            $promoCherchee = [$promoCherchee];
        }
    
        $data = [
            'Promotion' => $promoCherchee,
            'nbrRef' => $servicePromo['nbrFilieres']($database),
            'nbrProm' => $servicePromo['nbrPromo']($database),
            'nbrAppr' => $servicePromo['nbrAppr']($database),
        ];
    } else {
        $data = [
            'Promotion' => null,
            'message' => 'Aucune promotion trouvée pour ce terme de recherche.'
        ];
    }
    

    echo $mode($data);

}
function activePromo($nomPromo = null, $servicePromo, $controller) {
    if (isset($nomPromo)) {
        $donnee = $controller[Fonction::Inclusion->value](Chemins::Model->value);
        $database = &$donnee['database']; 


        $promoTrouvee = array_filter($database['Promotion'], function($promo) use ($nomPromo) {
            return isset($promo['MatriculePromo']) && $promo['MatriculePromo'] === $nomPromo;
        });

        $promoActuelle = reset($promoTrouvee);

        if ($promoActuelle) {
            if ($promoActuelle['etat'] === 'active') {

                $servicePromo[Fonction::DesactiveTout->value]($database);
            } else {

                $servicePromo[Fonction::DesactiveTout->value]($database);
                $servicePromo[Fonction::ActivePromo->value]($database, $nomPromo);
            }
        }

        $controller[Fonction::FPC->value]($donnee['databaseFile'], $database);
    }

    affichageAllPromo($servicePromo, $controller);
}



function affichageListe(array $servicePromo,$controller){
    $donnee = include __DIR__ . Chemins::Model->value;
    $database = $donnee['database'];

    $infoPromo = $servicePromo['afficherAllPromo']($database);
    $promotions = array_filter($infoPromo, function($promo) {
        return
            isset($promo['MatriculePromo'], $promo['filiere'], $promo['photoPromo'], $promo['debut'], $promo['fin']) &&
            !empty($promo['MatriculePromo']) && !empty($promo['filiere']) && !empty($promo['photoPromo']) && !empty($promo['debut']) && !empty($promo['fin']);
    });


    $promotions = array_values($promotions);

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 6;

    $totalPromotions = count($promotions);
    $totalPages = ceil($totalPromotions / $perPage);

    $offset = ($page - 1) * $perPage;
    $promotionsPage = array_slice($promotions, $offset, $perPage);


    $data = [
        'Promotion' => $promotionsPage,
        'REF'=>$database['Referentiels'],
        'nbrRef' => $servicePromo['nbrFilieres']($database),
        'nbrProm' => $servicePromo['nbrPromo']($database),
        'nbrAppr' => $servicePromo['nbrAppr']($database),
        'totalPages' => $totalPages,
        'pageActuelle' => $page,
    ];

    

    $ListePromotion = $controller[Fonction::Inclusion->value](Chemins::PromotionListe->value);


    echo  $ListePromotion($data);
}

$grillePromoti=$controller[Fonction::Inclusion->value](Chemins::Promotion->value);
$layout =$controller[Fonction::Inclusion->value](Chemins::Layout->value);

$grillePromotion=fn($data)=>$layout($grillePromoti($data));

$ListePromotion = $controller[Fonction::Inclusion->value](Chemins::PromotionListe->value);


return [
    Fonction::ajoutPromo->value => function(array $params) use ($validator, $servicePromo,$controller) {
        return ajoutPromo($params, $validator, $servicePromo,$controller);
    },
    Fonction::afficherAllPromos->value => function() use ($servicePromo,$controller) {

        affichageAllPromo($servicePromo,$controller);
    },

    Fonction::AffichageListe->value => function() use ($servicePromo,$controller) {

        affichageListe($servicePromo,$controller);
    },

    Fonction::trouverPromoGrille->value => function($nomPromo) use ($servicePromo,$grillePromotion,$controller) {
        return trouverPromo($nomPromo, $servicePromo, $grillePromotion,$controller);
    },

    Fonction::trouverPromoListe->value => function($nomPromo) use ($servicePromo,$ListePromotion,$controller) {
        return trouverPromo($nomPromo, $servicePromo, $ListePromotion,$controller);
    },
    Fonction::ActivePromo->value => function($nomPromo) use ($servicePromo, $controller) {
        activePromo($nomPromo, $servicePromo, $controller);
    
    },
];
