<?php
require_once '../../includes/auth.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = cleanInput($_POST['nom']);
    $description = cleanInput($_POST['description']);
    
    // Validation des données
    if (empty($nom)) {
        $error = "Le nom de la catégorie est obligatoire";
    } else {
        $stmt = $db->prepare("INSERT INTO categories (nom, description) VALUES (?, ?)");
        if ($stmt->execute([$nom, $description])) {
            $_SESSION['success'] = "Catégorie ajoutée avec succès";
            header('Location: ../index.php');
            exit;
        } else {
            $error = "Erreur lors de l'ajout de la catégorie";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une Catégorie</title>
</head>
<body>
    <h1>Ajouter une Catégorie</h1>
    <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="nom" placeholder="Nom de la catégorie" required>
        <textarea name="description" placeholder="Description"></textarea>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
