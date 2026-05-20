<?php
// actions/logout_action.php

// 1. On récupère la session en cours
session_start();

// 2. On vide toutes les variables de la session (nom, role, etc.)
session_unset(); 

// 3. On détruit complètement la session
session_destroy(); 

// 4. On redirige l'utilisateur vers la page de connexion
header("Location: ../login.php");
exit();
?>