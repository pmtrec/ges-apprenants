<?php
return [
    'date_Valide' => $date_valide = function (string $date): bool {
        $date = str_replace('/', '', $date);

        if (strlen($date) !== 8 || !ctype_digit($date)) {
            return false;
        }

        $jour = (int)substr($date, 0, 2);
        $mois = (int)substr($date, 2, 2);
        $annee = (int)substr($date, 4, 4);

        return checkdate($mois, $jour, $annee);
    },

    'dateDebut_Inferieur_DateFin' => function (string $dateDebut, string $dateFin): bool {
    $debut = DateTime::createFromFormat('d/m/Y', $dateDebut);
    $fin = DateTime::createFromFormat('d/m/Y', $dateFin);

    if (!$debut || !$fin) {
        return false;
    }

    return $debut <= $fin;
}

];
