<?php

function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Vérifier si admin est connecté
function isAdminLoggedIn() {
    return isset($_SESSION['admin_id']);
}

// Rediriger si non connecté
function requireAdminAuth() {
    if (!isAdminLoggedIn()) {
        header('Location: ../admin/login.php');
        exit;
    }
}






function uploadFile($file, $targetDir) {
    // Vérifier les erreurs d'upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("Erreur lors de l'upload du fichier");
    }

    // Vérifier le type de fichier
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $detectedType = mime_content_type($file['tmp_name']);
    
    if (!in_array($detectedType, $allowedTypes)) {
        throw new Exception("Seuls les fichiers JPG, PNG et GIF sont autorisés");
    }

    // Vérifier la taille (max 2Mo)
    if ($file['size'] > 2 * 1024 * 1024) {
        throw new Exception("Le fichier est trop volumineux (max 2Mo)");
    }

    // Créer le dossier s'il n'existe pas
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    // Générer un nom unique
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . strtolower($extension);
    $targetPath = $targetDir . $filename;

    // Déplacer le fichier
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception("Erreur lors de l'enregistrement du fichier");
    }

    return $filename;
}

