<?php
// config/database.php

$host = 'localhost';
$dbname = 'sae_stages_mmi'; // Le nom de la base qu'on a créée en SQL
$username = 'root';         // L'utilisateur par défaut de XAMPP
$password = '';             // Pas de mot de passe par défaut sur XAMPP Windows

try {
    // Connexion à la base de données via PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
        PDO::ATTR_EMULATE_PREPARES => false, 
    ]);
} catch (PDOException $e) {
    // Si la connexion échoue, on affiche l'erreur
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>