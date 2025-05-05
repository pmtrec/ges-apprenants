<?php
namespace App\error;
use App\Enums\Fonction\Fonction;
use App\MESS\Enums\Textes;
use Chemins;

$controller=require __DIR__ . "/controller.php";


function notFoud($controller)
{
    http_response_code(404);
    $controller[Fonction::Inclusion->value](Chemins::Error->value);
    
}

return notFoud($controller);