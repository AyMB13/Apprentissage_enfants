

<?php
require_once 'includes/config.php';

$categoryId = $_GET['id'] ?? 0;
$isAjax = isset($_GET['ajax']);

$category = $db->prepare("SELECT * FROM categories WHERE id = ?");
$category->execute([$categoryId]);
$category = $category->fetch();

if($category) {
    $elements = $db->prepare("SELECT * FROM elements WHERE categorie_id = ?");
    $elements->execute([$categoryId]);
    
    if($isAjax) {
        while($element = $elements->fetch()): ?>
            <div class="card">
                <?php if($element['image_path']): ?>
                    <img src="assets/images/<?= htmlspecialchars($element['image_path']) ?>" alt="<?= htmlspecialchars($element['nom']) ?>">
                <?php endif; ?>
                <div class="card-content">
                    <h3><?= htmlspecialchars($element['nom']) ?></h3>
                    <p><?= htmlspecialchars($element['description']) ?></p>
                </div>
            </div>
        <?php endwhile;
        exit;
    }
    
}

require_once 'includes/config.php';




if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Catégorie non trouvée.');
}

$id = (int) $_GET['id'];


$stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$categorie = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$categorie) {
    die('Catégorie introuvable.');
}

$stmt = $db->prepare("SELECT * FROM elements WHERE categorie_id = ?");
$stmt->execute([$id]);
$elements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($categorie['nom']) ?> - Apprentissage Enfants</title>
</head>
<body>

    <header>
        <a href="index.php" class="back-link">← Retour à l'accueil</a>
    </header>

    <main>
        <section class="category-header">
            <h1><?= htmlspecialchars($categorie['nom']) ?></h1>
            <p><?= htmlspecialchars($categorie['description']) ?></p>
        </section>

        <section class="element-grid">
            <?php if (count($elements) > 0): ?>
                <?php foreach ($elements as $element): ?>
                    <div class="element-card">
                        <?php if (!empty($element['image_path'])): ?>
                            <img src="assets/images/<?= htmlspecialchars($element['image_path']) ?>" alt="<?= htmlspecialchars($element['nom']) ?>">
                        <?php endif; ?>
                        <div class="element-info">
                            <h3><?= htmlspecialchars($element['nom']) ?></h3>
                            <p><?= htmlspecialchars($element['description']) ?></p>

                            <?php if (!empty($element['audio_path'])): ?>
                                <audio controls>
                                    <source src="assets/audio/<?= htmlspecialchars($element['audio_path']) ?>" type="audio/mpeg">
                                </audio>
                            <?php endif; ?>

                            <?php if (!empty($element['video_path'])): ?>
                                <video width="100%" controls>
                                    <source src="assets/videos/<?= htmlspecialchars($element['video_path']) ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun élément dans cette catégorie.</p>
            <?php endif; ?>
        </section>
    </main>

</body>
</html>
