<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion à la base de données
require_once '../../includes/config.php';

// Vérifier que l'id est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID de l\'élément manquant.');
}

$id = (int) $_GET['id'];

// Préparer la requête de suppression
$stmt = $db->prepare("DELETE FROM elements WHERE id = ?");
if ($stmt->execute([$id])) {
    // Redirection après succès
    header('Location: ../index.php');
    exit();
} else {
    echo "Erreur lors de la suppression de l'élément.";
}
?>
