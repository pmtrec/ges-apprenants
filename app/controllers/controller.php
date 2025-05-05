<?php
//factorise les fonctions communes a plusieurs controller
//il veut ici redirection ,render,savePhoto
declare(strict_types=1);

namespace App\Controllers;
use Chemins;

use App\Enums\Fonction\Fonction;

return [
    Fonction::Redirection->value => function(string $routes): void {
        header("Location:/" . $routes);
        exit;
    },

    Fonction::Inclusion->value => fn(string $routes) =>include __DIR__ . $routes,

    Fonction::ReqOnce->value => fn(string $routes) =>require_once __DIR__ . $routes,

    Fonction::Req->value => fn(string $routes) =>require __DIR__ . $routes,


    Fonction::Render->value => function(string $layoutPath, string $contentPath, array $data = []): void {
        
        ob_start();
        include __DIR__ . $layoutPath;

        foreach ($data as $key => $value) {
            $$key = $value;  
        }

        include __DIR__ . $contentPath;
        
        
        echo ob_get_clean();
    },

    Fonction::SavePhoto->value => function(array $photo): ?string {
        $rootPath = dirname(__DIR__, 2);
        $uploadDir = $rootPath . '/public' . Chemins::CheminAssetImage->value;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = basename($photo['name']);
        $filePath = $uploadDir . '/' . $filename;

        if (move_uploaded_file($photo['tmp_name'], $filePath)) {
            return Chemins::CheminAssetImage->value . '/' . $filename;
        }

        return null;
    },

    Fonction::FPC->value => function(string $databaseFile,$database): string {
        $result = file_put_contents($databaseFile, json_encode($database, JSON_PRETTY_PRINT));
        return $result !== false ? (string)$result : '';
        ;
    },

];

