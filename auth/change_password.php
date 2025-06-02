<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php?redirect=auth/change_password.php");
    exit();
}

require_once '../config/db.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = trim($_POST['current_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    $user_id = $_SESSION['user_id'];

    if ($current_password === '' || $new_password === '' || $confirm_password === '') {
        $error = "Veuillez remplir tous les champs.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Les nouveaux mots de passe ne correspondent pas.";
    } elseif (strlen($new_password) < 6) {
        $error = "Le nouveau mot de passe doit contenir au moins 6 caractères.";
    } else {
        $stmt = $pdo->prepare("SELECT mot_de_passe FROM utilisateur WHERE utilisateur_id = ?");
        $stmt->execute([$user_id]);
        $hashed_password = $stmt->fetchColumn();

        if ($hashed_password && password_verify($current_password, $hashed_password)) {
            $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE utilisateur SET mot_de_passe = ? WHERE utilisateur_id = ?");
            $stmt->execute([$new_hashed, $user_id]);
            $success = "Mot de passe modifié avec succès.";
        } else {
            $error = "Mot de passe actuel incorrect.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Changer le mot de passe</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style13.css">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9em;
        }
        .success-message {
            color: #1B5E20;
            font-weight: bold;
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="main-content">
        <h2>Changer le mot de passe</h2>

        <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-times-circle" style="color:red;"></i>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php elseif ($success): ?>
            <div class="success-message">
                <i class="fas fa-check-circle" style="color:#1B5E20;"></i>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label for="current_password">Mot de passe actuel :</label>
            <input type="password" name="current_password" id="current_password">

            <label for="new_password">Nouveau mot de passe :</label>
            <input type="password" name="new_password" id="new_password">

            <label for="confirm_password">Confirmer le nouveau mot de passe :</label>
            <input type="password" name="confirm_password" id="confirm_password">

            <button type="submit" class="btn">Modifier</button>
        </form>

        <a href="../profil.php" class="btn">Retour au profil</a>
    </div>
</div>
</body>
</html>
