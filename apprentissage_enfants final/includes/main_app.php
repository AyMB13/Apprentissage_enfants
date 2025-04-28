<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jungle Aventure</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    // Connexion à la base de données (si ce n'est pas déjà fait)
    $categories = $db->query("SELECT * FROM categories")->fetchAll();
    ?>

    <header class="navbar">
        <div class="logo">🌴 Jungle <span>Aventure</span></div>

        <div class="admin-link">
            <a href="admin/login.php">Admin</a>
        </div>

        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Rechercher une catégorie...">
            <button onclick="searchItems()">Rechercher</button>
        </div>
    </header>



    <main>
        <h1>Découvrez les merveilles de la jungle</h1>

        <section class="categories">
            <h2>Catégories</h2>
            <div class="category-grid">
                <?php foreach ($categories as $category): ?>
                    <a href="categorie.php?id=<?= $category['id'] ?>" class="category-card-link">
                        <div class="category-card">
                            <h3><?= htmlspecialchars($category['nom']) ?></h3>
                            <p><?= htmlspecialchars($category['description']) ?></p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

</body>
</html>


