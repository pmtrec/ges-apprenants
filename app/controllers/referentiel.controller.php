<?php
    declare(strict_types=1);

    namespace App\Controllersdescription;

    use App\Enums\Fonction\Fonction;
    use App\MESS\Enums\Textes;
    use Chemins;
    $controller=require __DIR__ . "/controller.php";
    $modelRef = $controller[Fonction::Inclusion->value](Chemins::ServiceRef->value);

    function ajouterRef($params, $controller)
    {

        $donnee = $controller[Fonction::Inclusion->value](Chemins::Model->value);
        $database = $donnee['database'];
        $databaseFile = $donnee['databaseFile'];

        $modelRef = require __DIR__ . Chemins::ServiceRef->value;
        $erreurs = [];
    

        if (empty($params['nomRef']) || empty($params['description']) || empty($params['nbrApprenant']) || empty($params['nbrModule']) || empty($params['photo']['name'])) {
            $erreurs[] = Textes::TLO->value;
        }
    

        if (!$modelRef['unicite']($database, $params['nomRef'])) {
            $erreurs[] = Textes::PromoExiste->value;
        }
    

        if (!empty($erreurs)) {
            $_SESSION['old'] = $params;
            $_SESSION['erreurs'] = $erreurs;
            $controller['redirection']('referentiels#referentielModal'); 
        } else {
    
            $photorefPath = $controller[Fonction::SavePhoto->value]($params['photo']);
    
            if ($modelRef['ajouterRef']($database, nomModule:$params['nomRef'],nbrApr:$params['nbrApprenant'], nbrModule:$params['nbrModule'], desRef:$params['description'], photoRef:$photorefPath)) {
                $controller[Fonction::FPC->value]($databaseFile, $database);
                $controller[Fonction::Redirection->value]('referentiels'); 
            } else {
                $_SESSION['message'] = Textes::AjoutError->value;
                $controller['redirection']('referentiels#referentielModal'); 
            }
        }
    }
    
    
    
    function affichageRef($controller): void
    {
        $donnee = $controller[Fonction::Inclusion->value](Chemins::Model->value);
        $database = $donnee['database'];
    
        $serviceRef = $controller[Fonction::Inclusion->value](Chemins::ServiceRef->value);
        $infoRef = $serviceRef[Fonction::AfficherRefActive->value]($database);
    
        $tousReferentiels = $database['Referentiels'];
    
        $referentielsRestants = array_filter($tousReferentiels, function($ref) use ($infoRef) {
            return !in_array($ref['Nom'], array_column($infoRef, 'Nom'));
        });

        $couleurs = [
            '#A8E6CF',
            '#DCE775',
            '#B3E5FC',
            '#D1C4E9',
            '#FFCC80',
            '#FF8A80',
            '#F8BBD0',
            '#FFF59D',
            '#80DEEA',
            '#B2DFDB',
        ];
    
        $referentielsRestants = array_map(function($ref) use ($couleurs) {
            $ref['Couleur'] = $couleurs[array_rand($couleurs)];
            return $ref;
        }, $referentielsRestants);
    
        $ref = $controller[Fonction::Inclusion->value](Chemins::Referentiel->value);
        $layout = $controller[Fonction::Inclusion->value](Chemins::Layout->value);
    
        echo $layout($ref([
            'referentiels' => array_values($referentielsRestants),
            'referentiels_actifs' => $infoRef
        ]));
    }
    

    function affichageToutRef($controller): void
    {

        $donnee = $controller[Fonction::Inclusion->value](Chemins::Model->value);
        $database = $donnee['database'];

        $serviceRef = $controller[Fonction::Inclusion->value](Chemins::ServiceRef->value);
        $infoRef = $serviceRef['afficherAllRef']($database);

        $ref = $controller[Fonction::Inclusion->value](Chemins::Tous_referentiel->value);
        $layout = $controller[Fonction::Inclusion->value](Chemins::Layout->value);

        echo $layout($ref($infoRef));
    
        
    }

    function trouverRef($nomRef, $modelRef, $controller)
    {
        $donnee = $controller[Fonction::Inclusion->value](Chemins::Model->value);
        $database = $donnee['database'];
    
        $refCherchee = $modelRef['chercherRef'](database:$database, nomRef:$nomRef);
    
        if ($refCherchee) {
            if (!isset($refCherchee[0])) {
                $refCherchee = [$refCherchee];
            }
            $data = $refCherchee;
         
        } else {
            $data = [
                'Referentiels' => [],
                'message' => 'Aucun référentiel trouvé pour ce terme de recherche.'
            ];
        }
    
      
       
        $ref = $controller[Fonction::Inclusion->value](Chemins::Tous_referentiel->value);
        $layout = $controller[Fonction::Inclusion->value](Chemins::Layout->value);
    
        echo $layout($ref($data));
    }
    


    return [
        Fonction::AffichageRef->value => function() use ($controller) {
            affichageRef($controller);
        },
        Fonction::AffichageToutRef->value  => function() use ($controller) {
            affichageToutRef($controller);
        },
        Fonction::ajouterRef->value  => function($params) use ($controller) {
            ajouterRef($params, $controller);
        },

        Fonction::ChercherRef->value => function($nomRef) use ($modelRef, $controller) {
            trouverRef($nomRef, $modelRef,$controller);
        },
    ];