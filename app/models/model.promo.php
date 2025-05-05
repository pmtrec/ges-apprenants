<?php
namespace App\Models\Promo;
// include __DIR__ . "/../enums/fonctionEnumu.php";
use App\Enums\Fonction\Fonction;
return [
    Fonction::unicite->value => function(array $database, string $nomPromo) {
        $unique = true;
        array_walk($database['Promotion'], function($promo) use ($nomPromo, &$unique) {
            if (isset($promo['MatriculePromo']) && $promo['MatriculePromo'] === $nomPromo) {
                $unique = false;
            }
        });
        return $unique;
    },
    Fonction::ajouterPromo->value =>function(array &$database, string $nomPromo, string $dateDebut, string $dateFin, string $referentiel, $photoPromo) {
        $database['Promotion'][] = [
            'MatriculePromo' => $nomPromo,
            'filiere' => $referentiel,
            'photoPromo' => $photoPromo,
            'debut' => $dateDebut,
            'fin' => $dateFin,
        ];
        return true;
    },
    
    Fonction::afficherAllPromos->value => fn($database) => $database['Promotion'],

    Fonction::chercherPromo->value => function($database, $nomPromo) {
                $nomPromo = trim(strtolower($nomPromo));
                $promos = array_filter($database['Promotion'], function($promo) use ($nomPromo) {
                    $matricule = trim(strtolower($promo['MatriculePromo']));
                    return $matricule === $nomPromo;
                });
    
                return !empty($promos) ? array_values($promos)[0] : null;
            },



    Fonction::nbrFilieres->value => function(array $database) {
        $filieres = array_map(function($promo) {
            return strtolower(trim($promo['filiere']));
        }, $database['Promotion']);

        $filieres = array_unique($filieres);

        return count($filieres);
    },

    Fonction::nbrPromo->value => function(array $database) {
        $Promo = array_map(function($promo) {
            return $promo['MatriculePromo'];
    }, $database['Promotion']);

        return count($Promo);
    },

    Fonction::nbrAppr->value=>function(array $database) {
       $appr= array_map(function($promo) {
            return $promo['matricule'];
        }, $database['Apprenant']);
        return count($appr);
    },
    

    
    Fonction::DesactiveTout->value => function(array &$database): bool {
        $desactive = false;
    
        if (isset($database['Promotion'])) {
            array_walk($database['Promotion'], function (&$promo) use (&$desactive) {
                if (isset($promo['etat']) && $promo['etat'] !== 'inactive') {
                    $promo['etat'] = 'inactive';
                    $desactive = true;
                }
            });
        }
    
        return $desactive;
    },
    
    
    Fonction::ActivePromo->value => function(array &$database, string $matricule): bool {
        $active = false;
    
        if (isset($database['Promotion'])) {
            array_walk($database['Promotion'], function (&$promo) use ($matricule, &$active) {
                if (isset($promo['MatriculePromo'])) {
                    $promo['etat'] = ($promo['MatriculePromo'] === $matricule) ? 'active' : 'inactive';
                    if ($promo['etat'] === 'active') {
                        $active = true;
                    }
                }
            });
        }
    
        return $active;
    },
    
];
?>
