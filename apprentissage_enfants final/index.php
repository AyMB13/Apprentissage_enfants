<?php
require_once 'includes/config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enfant Jungle</title>
    <link rel="stylesheet" href="assets/css/jungle.css">
</head>
<body>
    <div id="welcome-screen">
        <h1>Bienvenue sur Enfant Jungle</h1>
        <button onclick="startApp()">Commencer l'aventure</button>
    </div>

    <div id="main-app" style="display:none;">
        <?php include 'includes/main_app.php'; ?>
    </div>
    

    <script src="assets/js/jungle.js"></script>
</body>
</html>