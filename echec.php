<?php
require_once 'config/db.php';
session_start();

$formation_id = $_GET['formation_id'] ?? 0;
$utilisateur_id = $_SESSION['user_id'] ?? 0;

$tentative = 0;
$tentative_dispo = false;

if ($formation_id && $utilisateur_id) {
    $stmt = $pdo->prepare("SELECT tentative FROM test WHERE utilisateur_id = ? AND formation_id = ?");
    $stmt->execute([$utilisateur_id, $formation_id]);
    $tentative = $stmt->fetchColumn() ?: 0;

    if ($tentative >= 2) {
        header("Location: formations.php");
        exit();
    } else {
        $tentative_dispo = true;
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Résultat insuffisant</title>

    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

        <link rel="stylesheet" href="assets/css/style16.css" />
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet" />

</head>
<body>
            <?php include("includes/header.php"); ?>

    <div class="card">

        <h1><i class="bi bi-exclamation-triangle-fill" style="color: orange;"></i> Résultat insuffisant</h1>

        <p>Vous avez obtenu un score en dessous de <strong class="red">50%</strong></p>
        <p>Ne vous découragez pas ! Chaque erreur est une occasion d’apprendre.</p>
        <p>Prenez le temps de consolider vos connaissances,<br>puis retentez le test lorsque vous vous sentirez prêt(e)</p>
        <p><strong>Vous pouvez le faire !</strong></p>
        <p><strong style="color:red; font-size:15px">(Il reste  <?= $tentative ?> tentative)</strong> </p>


        <div class="button-container">
            <?php if ($tentative_dispo): ?>
                <form action="test.php" method="get">
                    <input type="hidden" name="formation_id" value="<?= htmlspecialchars($formation_id) ?>">
                    <input type="hidden" name="page" value="1">
                    <button type="submit">Recommencez le test</button>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <script src="assets/js/script.js"></script>

</body>
</html>
