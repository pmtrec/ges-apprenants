<?php
namespace App\Enums\Fonction;

enum Fonction: string{
    case Inclusion ="inclusion";
    case ReqOnce = "require_once";
    case Req = "require";
    case Connexion = "connexion";
    case TrouverMail = "TrouverMail";
    case ChangerPassword = "changerPassword";
    case Redirection = "redirection";
    case Render = "render";
    case handleError = "handleError";
    case Login = "login";
    case Logout = "logout";
    case ajoutPromo = "ajoutPromo";
    case afficherAllPromos = "afficherAllPromo";
    case chercherPromo = "chercherPromo";
    case AffichageListe = "affichageListe";
    case trouverPromoGrille = "trouverPromoGrille";
    case trouverPromoListe = "trouverPromoListe";
    case unicite = "unicite";
    case ajouterPromo = "ajouterPromo";
    case nbrFilieres = "nbrFilieres";

    case nbrPromo = "nbrPromo";
    case nbrAppr ="nbrAppr";
    case ajouterRef= "ajouterRef";
    case afficherAllRef = "afficherAllRef";
    case AffichageRef = "affichageRef";
    case AffichageToutRef = "affichageToutRef";
    case SavePhoto = "savePhoto";
    case StartSession = "startSession";
    case SetSession = "setSession";
    case GetSession = "getSession";
    case UnsetSession = "unsetSession";
    case DestroySession = "destroySession";
    case FPC = "filePutContents";
    case FGC = "fileGetContents";
    case RecupereStatut ="recupereStatut";
    case DesactiveTout = "desactiverTout";
    case ActivePromo = "activePromo";
    case AfficherRefActive= "afficherRefActive";
    case ChercherRef  = "chercherRef";

}