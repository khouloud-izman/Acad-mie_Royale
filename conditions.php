<?php
session_start();
require_once 'config/db.php';

$formation_id = isset($_GET['formation_id']) && is_numeric($_GET['formation_id']) ? (int)$_GET['formation_id'] : 0;
if ($formation_id <= 0) {
    die("Formation non spécifiée ou invalide.");
}

$sql = "SELECT * FROM formation WHERE formation_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$formation_id]);
$formation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$formation) {
    die("Formation non trouvée.");
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Conditions pour obtenir le certificat</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style12.css">
      <link rel="stylesheet" href="assets/css/style.css">

</head>
<body>
        <?php include("includes/header.php"); ?>

<div class="main-content">

<h2>Conditions pour obtenir le certificat d'Académie Royale</h2>

  <div class="condition">
    <span class="condition-title">1. Compléttion de la formation :</span><br>
    vous devez avoir suivi complété toutes les modules et leçons de cette formation.
  </div>

  <div class="condition">
    <span class="condition-title">2. Seuil de réussite :</span><br>
    Pour valider la formation et obtenir votre certificat, vous devez obtenir un score d’au moins 50% au test final.
  </div>

  <div class="condition">
    <span class="condition-title">3. Repassage possible :</span><br>
    En cas d’échec, une seule tentative supplémentaire est autorisée, y compris immédiatement après.

</div>

  <div class="condition">
    <span class="condition-title">4. Certificat disponible :</span><br>
    Une fois que tous les tests sont réussis, votre certificat sera disponible dans la section "Mon profil", via un bouton dédié.

</div>

<a href="test.php?formation_id=<?=($_GET['formation_id']) ?>&page=1" class="start-btn">Commencez le test</a>
</div>
<script src="assets/js/script.js"></script>

</body>
</html>
