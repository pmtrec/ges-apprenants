<?php
session_start(); // Toujours commencer par ça

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion
header("Location: /connexion");
// Ou vous pouvez rediriger vers une autre page si nécessaire
// header("Location: /autre_page");
// Terminer le script   
exit();
