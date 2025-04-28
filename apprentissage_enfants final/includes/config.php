
<?php
// Configuration base de données
$host = 'localhost';
$dbname = 'apprentissage_enfants';
$username = 'root'; 
$password = ''; 



try {
    $db = new PDO('mysql:host=localhost;dbname=apprentissage_enfants;charset=utf8', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

define('SITE_NAME', 'Apprentissage Enfants'); 
?>
