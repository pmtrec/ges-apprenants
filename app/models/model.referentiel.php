<?php
namespace App\ModelsRef;
use App\Enums\Fonction\Fonction;
return [
    Fonction::ajouterRef->value => function(array &$database, string $nomModule, int $nbrModule, string $desRef, int $nbrApr, $photoRef) {
        $database['Referentiels'][] = [
            'Nom' => $nomModule,
            'NombresModule' => $nbrModule,
            'Description' => $desRef,
            'NombresApprenant' => $nbrApr,
            'photoRef' => $photoRef,
            'statut' => 'inactive'
        ];


        return true;
    },
    Fonction::afficherAllRef->value => fn($database) => $database['Referentiels'],

    Fonction::RecupereStatut->value => function(array $database) {
        
        $promotionsActives = array_filter($database['Promotion'], function($promo) {
            return isset($promo['etat']) && $promo['etat'] === 'active';
        });

        return $promotionsActives;
    },

    Fonction::AfficherRefActive->value => function($database) {

        $promosActives = array_filter($database['Promotion'], function($promo) {
            return isset($promo['etat']) && $promo['etat'] === 'active';
        });
    

        $referentielsActifsNoms = array_unique(array_merge(...array_map(function($promo) {
            return $promo['referentiels'] ?? [];
        }, $promosActives)));
    

        $referentielsActifs = array_filter($database['Referentiels'], function($ref) use ($referentielsActifsNoms) {
            return in_array(strtolower($ref['Nom']), array_map('strtolower', $referentielsActifsNoms));
        });
    
        return array_values($referentielsActifs);
    },
    


    Fonction::unicite->value => function(array $database, string $nomRef) {
        $unique = true;
        array_walk($database['Referentiels'], function($Ref) use ($nomRef, &$unique) {
            if (isset($Ref['Nom']) && $Ref['Nom'] === $nomRef) {
                $unique = false;
            }
        });
        return $unique;
    },

    Fonction::ChercherRef->value => function($database, $nomRef) {
        $nomRef = trim(strtolower($nomRef));
    
        $refs = array_filter($database['Referentiels'], function($ref) use ($nomRef) {
            $nom = trim(strtolower($ref['Nom']));
            return strpos($nom, $nomRef) !== false;
        });
    
        return !empty($refs) ? array_values($refs) : null;
    },
    


    
];
?>
