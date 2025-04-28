<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/auth.php';

$id = intval($_GET['id'] ?? 0);

// Récupérer l'élément à modifier
$element = $db->prepare("SELECT * FROM elements WHERE id = ?");
$element->execute([$id]);
$element = $element->fetch();

if (!$element) {
    $_SESSION['error'] = "Élément introuvable";
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $categorie_id = intval($_POST['categorie_id']);
        $nom = cleanInput($_POST['nom']);
        $description = cleanInput($_POST['description']);

        // Gestion de l'image
        $image_path = $element['image_path'];
        if (!empty($_FILES['image']['name'])) {
            // Supprimer l'ancienne image si elle existe
            if ($image_path && file_exists("../../assets/images/" . $image_path)) {
                unlink("../../assets/images/" . $image_path);
            }
            $image_path = uploadFile($_FILES['image'], '../../assets/images/');
        }

        // Mise à jour
        $stmt = $db->prepare("UPDATE elements SET categorie_id = ?, nom = ?, description = ?, image_path = ? WHERE id = ?");
        
        if ($stmt->execute([$categorie_id, $nom, $description, $image_path, $id])) {
            $_SESSION['success'] = "Élément modifié avec succès!";
            header('Location: ../index.php');
            exit;
        } else {
            throw new Exception("Erreur lors de la mise à jour");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}

$categories = $db->query("SELECT * FROM categories")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'élément</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <h1>Modifier l'élément</h1>
        
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="admin-form">
            <div class="form-group">
                <label>Catégorie:</label>
                <select name="categorie_id" required class="form-control">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $element['categorie_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Nom:</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($element['nom']) ?>" required class="form-control">
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required class="form-control" rows="5"><?= htmlspecialchars($element['description']) ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Image actuelle:</label>
                <?php if ($element['image_path']): ?>
                    <img src="../../assets/images/<?= htmlspecialchars($element['image_path']) ?>" width="100" class="current-image">
                    <div class="form-check">
                        <input type="checkbox" name="remove_image" id="remove_image" class="form-check-input">
                        <label for="remove_image" class="form-check-label">Supprimer cette image</label>
                    </div>
                <?php else: ?>
                    <p>Aucune image</p>
                <?php endif; ?>
                <input type="file" name="image" accept="image/*" class="form-control mt-2">
            </div>
            
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</body>
</html>