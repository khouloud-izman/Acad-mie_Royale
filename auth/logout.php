<?php
session_start();

// Détruire toutes les données de session
session_unset();    // Supprime toutes les variables de session
session_destroy();  // Détruit la session

// Rediriger vers la page de connexion
header("Location: ../index.php");
exit();
