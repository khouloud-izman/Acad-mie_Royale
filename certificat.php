<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php?redirect=certificat.php');
    exit();
}

require_once 'config/db.php';

// Récupérer le prénom et nom depuis la base de données
$utilisateur_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT prenom, nom FROM utilisateur WHERE utilisateur_id = ?");
$stmt->execute([$utilisateur_id]);
$user = $stmt->fetch();

if (!$user) {
    echo "Utilisateur introuvable.";
    exit();
}

$prenom = htmlspecialchars($user['prenom']);
$nom = htmlspecialchars($user['nom']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Certificat de réussite</title>
    <link rel="stylesheet" href="assets/css/certificat.css"> <!-- CSS li kayn f design dyalk -->
</head>
<body>

<div class="certificat-container">
    <h1>🎓 Certificat de Réussite</h1>

    <p>Ce certificat atteste que <strong><?= $prenom ?> <?= $nom ?></strong> a complété avec succès
    le programme de formation en pâtisserie, faisant preuve
    d’excellence et de professionnalisme.</p>

    <p>Date : <?= date('d/m/Y') ?></p>
    <p>Signature : ____________________</p>
</div>

</body>
</html>
