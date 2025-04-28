<?php
session_start();
require_once '../includes/config.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = cleanInput($_POST['username']);
    $password = $_POST['password'];
    
    $stmt = $db->prepare("SELECT * FROM administrateurs WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        :root {
            --primary: #4CAF50;
            --primary-dark: #388E3C;
            --accent: #8BC34A;
            --background: #E8F5E9;
            --card-bg: #ffffff;
            --text: #333333;
            --shadow: rgba(0, 0, 0, 0.1);
            --gradient-1: linear-gradient(135deg, #81C784 0%, #388E3C 100%);
            --gradient-2: linear-gradient(135deg, #A5D6A7 0%, #4CAF50 100%);
        }

        .login-container {
            max-width: 400px;
            margin: 4rem auto;
            padding: 2rem;
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: 0 4px 6px var(--shadow);
        }

        .login-title {
            color: var(--primary-dark);
            text-align: center;
            font-size: 2rem;
            margin-bottom: 2rem;
            font-weight: 700;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            color: var(--text);
            font-weight: 600;
        }

        .form-group input {
            padding: 0.8rem 1.5rem;
            border: 2px solid #E8F5E9;
            border-radius: 25px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .login-button {
            background: var(--gradient-1);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            background: var(--gradient-2);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(76, 175, 80, 0.2);
        }

        .error-message {
            background: #FFEBEE;
            color: #C62828;
            padding: 1rem;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 1rem;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            color: var(--primary-dark);
        }

        body {
            background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h1 class="login-title">Connexion Administrateur</h1>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" id="username" name="username" placeholder="Entrez votre nom d'utilisateur" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                </div>

                <button type="submit" class="login-button">Se connecter</button>
            </form>

            <a href="../index.php" class="back-link">Retour à l'accueil</a>
        </div>
    </div>
</body>
</html>