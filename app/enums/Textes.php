<?php
namespace App\MESS\Enums;
enum Textes: string {
    case Bienvenue1 = 'Bienvenue sur';
    case ECSA = 'Ecole du code Sonatel Academy';
    case SeConnecter = 'Se Connecter';
    case PlaceholderLogin = 'matricule ou email';
    case PlaceholderMdp = 'mot de passe';
    case Login = 'Login';
    case MDP ='Mot de passe';
    case MDPOublie = 'Mot de passe oublié ?';
    case Prom='Promotion';
    case PromoExiste = 'Promotion déjà existante';
    case gerProm = 'Gerer les promotions de l\'école';
    case AjoutProm = '+ Ajouter une promotion';
    case AjoutSuccess = 'Ajouté avec succès';
    case TLO ='Tous les champs sont obligatoires';
    case LogObli ='login obligatoire';
    case PasObli = 'password obligatoire';
    case LogPasInv = 'login ou mot de passe invalide';
 
    case EMAILINT = 'Email Introuvable !';
    case DatInv='Date invalide';
    

    case ChangePass='Changer Mot de Passe';

    case ChangePassSUC='Mot de Passe changer avec succés';
    case ChangePassEr= 'Erreur lors du changement du mot de passe.';
    case EntrerEm = 'Entrer votre Email';
    case Changer= 'Changer';


    case AjoutError = 'Echec d\'enregistrement';



}


?>