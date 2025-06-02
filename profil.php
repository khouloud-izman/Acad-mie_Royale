<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php?redirect=profil.php');
    exit();
}

require_once 'config/db.php';

$utilisateur_id = $_SESSION['user_id'];

// 1. Récupérer la progression
$stmt = $pdo->prepare("SELECT progression FROM utilisateur WHERE utilisateur_id = ?");
$stmt->execute([$utilisateur_id]);
$progress = (int)$stmt->fetchColumn();

// 2. Vérifier le nombre total de formations
$stmt = $pdo->prepare("SELECT COUNT(*) FROM formation");
$stmt->execute();
$totalFormations = (int)$stmt->fetchColumn();

// 3. Vérifier combien de tests l'utilisateur a réussis (score >= 50)
$stmt = $pdo->prepare("
    SELECT COUNT(DISTINCT formation_id) 
    FROM test 
    WHERE utilisateur_id = ? AND score >= 50
");
$stmt->execute([$utilisateur_id]);
$tests_reussis = (int)$stmt->fetchColumn();

// 4. Condition d'éligibilité au certificat
$certificat_disponible = ($progress === 100 && $tests_reussis === $totalFormations);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - Pâtisserie Gourmandine</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style11.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="profil-container">
    <div class="profil-left">
        <?php if ($certificat_disponible): ?>
            <a class="certificat-btn" href="certificat.php">📄 Télécharger mon certificat</a>
        <?php else: ?>
            <a class="certificat-btn disabled" onclick="alert('Vous devez terminer toutes les formations et réussir les tests pour télécharger le certificat.')" style="cursor:not-allowed; opacity:0.5;">📄 Télécharger mon certificat</a>
        <?php endif; ?>
        <?php include("includes/header.php"); ?>

        <!-- Bouton certificat -->
        

        <div class="para">
            <p><strong>Nom :</strong> <?= htmlspecialchars($_SESSION['user_nom']) ?></p>
            <p><strong>Prénom :</strong> <?= htmlspecialchars($_SESSION['user_prenom']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($_SESSION['user_email']) ?></p>
        </div>

        <p><strong>Progression globale</strong></p>
        <div class="progress-bar">
            <div class="progress" style="width: <?= $progress ?>%;"></div>
        </div>
        <span><?= $progress ?>%</span>

        <br><br>
        <a class="btn" href="auth/change_password.php"><i class="fas fa-user-lock"></i>Modifier le mot de passe</a>
        <a class="btn" href="auth/logout.php"><i class="fas fa-sign-out-alt"></i>Se déconnecter</a>
    </div>

    <div class="profil-right">
        <img src="assets/images/profil.jpg" alt="Pâtisserie">
    </div>
</div>

<script src="assets/js/script.js"></script>
</body>
</html>
