<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        
        $categorie_id = intval($_POST['categorie_id']);
        $nom = cleanInput($_POST['nom']);
        $description = cleanInput($_POST['description']);

        // Gestion de l'image
        $image_path = null;
        if (!empty($_FILES['image']['name'])) {
            $image_path = uploadFile($_FILES['image'], '../../assets/images/');
        }
        

        // Insertion dans la base
        $stmt = $db->prepare("INSERT INTO elements (categorie_id, nom, description, image_path) VALUES (?, ?, ?, ?)");
        
        if ($stmt->execute([$categorie_id, $nom, $description, $image_path])) {
            $_SESSION['success'] = "Élément ajouté avec succès!";
            header('Location: ../index.php');
            exit;
        } else {
            throw new Exception("Erreur lors de l'ajout à la base de données");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

// Récupérer les catégories
$categories = $db->query("SELECT * FROM categories")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un élément</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Ajouter un nouvel élément</h1>
        
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="admin-form">
            <div class="form-group">
                <label>Catégorie:</label>
                <select name="categorie_id" required class="form-control">
                    <option value="">-- Sélectionnez --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Nom:</label>
                <input type="text" name="nom" required class="form-control">
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required class="form-control" rows="5"></textarea>
            </div>
            
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" accept="image/*" class="form-control">
            </div>
            
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>
</html>
