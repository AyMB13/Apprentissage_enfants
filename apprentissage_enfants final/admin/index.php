<!-- admin/index.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin - Apprentissage Enfants</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <header>
        <h1>Tableau de bord Admin</h1>
    </header>

    <main>
        <section class="admin-dashboard">
            <div class="dashboard-item">
                <h3>Catégories</h3>
                <a href="categories/ajouter.php" class="btn">Ajouter une catégorie</a>
                <ul>
                    <?php
                    require_once '../includes/config.php';
                    $stmt = $db->query("SELECT * FROM categories");
                    while ($category = $stmt->fetch()) {
                        echo "<li>" . htmlspecialchars($category['nom']) . " - <a href='categories/modifier.php?id=" . $category['id'] . "'>Modifier</a> | <a href='categories/supprimer.php?id=" . $category['id'] . "'>Supprimer</a></li>";
                    }
                    ?>
                </ul>
            </div>

            <div class="dashboard-item">
                <h3>Éléments</h3>
                <a href="elements/ajouter.php" class="btn">Ajouter un élément</a>
                <ul>
                    <?php
                    $stmt = $db->query("SELECT * FROM elements");
                    while ($element = $stmt->fetch()) {
                        echo "<li>" . htmlspecialchars($element['nom']) . " - <a href='elements/modifier.php?id=" . $element['id'] . "'>Modifier</a> | <a href='elements/supprimer.php?id=" . $element['id'] . "'>Supprimer</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </section>
    </main>

    <footer>
        <p>© 2025 Apprentissage Enfants</p>
    </footer>
</body>
</html>
