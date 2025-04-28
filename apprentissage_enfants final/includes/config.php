
<?php
// Configuration base de données
$host = 'localhost';
$dbname = 'apprentissage_enfants'; // Ton nom de base de données
$username = 'root'; // XAMPP = root par défaut
$password = ''; // XAMPP = mot de passe vide par défaut

// Créer une connexion

try {
    $db = new PDO('mysql:host=localhost;dbname=apprentissage_enfants;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

define('SITE_NAME', 'Apprentissage Enfants'); // Laissez le nom sans balises HTML
?>
