
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php?redirect=certificat.php');
    exit();
}

require_once 'config/db.php';

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
$nom_complet = $prenom . ' ' . $nom;
$date_du_jour = date('d/m/Y');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/style17.css">
    <title>Certificat de réussite</title>

</head>
<body>

<div class="contenu-certificat">
<img src="assets/images/logo.png" alt="Logo de l'académie" class="logo-certificat">

    <h1>Académie Royale de Pâtisserie</h1>

    <p>Ce certificat atteste que <span class="nom-beneficiaire"><?= $nom_complet ?></span> a complété avec succès<br>
    le programme de formation de notre Acâdemie , faisant preuve<br>
    d’excellence et de professionnalisme.</p>
</div>

<div class="footer-infos">
    <div class="date">
        <p>La Date</p>
        <p>Le <?= $date_du_jour ?></p>
    </div>
    <div class="signature">
        <p>La Directeure Générale</p>
        <p class="signature-name">A. Hamilton</p>
    </div>
</div>

</body>
</html>
