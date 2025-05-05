<?php
declare(strict_types=1);
namespace App\Controllers\login;
use App\Enums\Fonction\Fonction;
require_once __DIR__ ."/../enums/Textes.php";
$controller=require __DIR__ . "/controller.php";



use App\MESS\Enums\Textes;
use Chemins;

$donnee = $controller[Fonction::Inclusion->value](Chemins::Model->value);
$con = $controller[Fonction::Inclusion->value](Chemins::Service->value);



function login(array $params, array $con, array &$donnee,$controller) : void {
    $id = $params['login'] ?? '';   
    $password = $params['password'] ?? '';  
    $prenom  = $params['prenom'] ?? '';
    if ($con["connexion"](matricule: $id, email: $id, password: $password, database: $donnee["database"])) {
        $_SESSION['user'] = [
            'id' => $id,
            'password' => $password,
            'prenom' => $prenom,
        ];
        $controller[Fonction::Redirection->value]("promotion");
    } elseif ((empty($id)) && (empty($password))) {
            $_SESSION['message'] = Textes::TLO->value;
          
           $controller[Fonction::Inclusion->value](Chemins::ViewLogin->value);
        }elseif ((empty($id)) && (isset($password))) {
            $_SESSION['message'] = Textes::LogObli->value;
        
            $controller[Fonction::Inclusion->value](Chemins::ViewLogin->value);
        }
        elseif ((empty($password)) && (isset($id))) {
            $_SESSION['message'] = Textes::PasObli->value;
     
            $controller[Fonction::Inclusion->value] (Chemins::ViewLogin->value);
        }
       else {
            $_SESSION['message'] = Textes::LogPasInv->value;
            $controller[Fonction::Inclusion->value](Chemins::ViewLogin->value) ;
        }     

    }


function logout()
{
    session_destroy();
    $_SESSION = [];
    header("Location: /login");
    exit();
    // include __DIR__ . Chemins::ViewLogin->value;
}

function changerPassword(array $params, array &$donnee, array $con,$controller): void {
    $email = $params['email'] ?? '';
    $newPassword = $params['password'] ?? '';
    
    if (empty($email) || empty($newPassword)) {
        $_SESSION['message'] = Textes::TLO->value;
        $controller[Fonction::Redirection->value]("MDP");
    }

    if (!$con["TrouverMail"]($email, $donnee["database"])) {
        $_SESSION['message'] = Textes::EMAILINT->value;
    
        $controller[Fonction::Redirection->value]("MDP");
    }

    if ($con["changerPassword"]($email, $newPassword, $donnee["database"])) {
        $_SESSION['messageSuccess'] = Textes::ChangePassSUC->value;
        $controller[Fonction::FPC->value]($donnee['databaseFile'], $donnee['database']);

        $controller[Fonction::Redirection->value]("login");
    } else {
        $_SESSION['error'] = Textes::ChangePassEr->value;;
        $controller[Fonction::Redirection->value]("MDP");
    }
}


return [
    Fonction::Login->value => function(array $params) use ($con, &$donnee,$controller) {
        login($params, $con, $donnee,$controller);
    },
    Fonction::ChangerPassword->value => function(array $params) use (&$donnee, $con,$controller) {
        changerPassword($params, $donnee, $con,$controller);
    },
    Fonction::Logout->value =>function()
    {
        logout();
    }
];