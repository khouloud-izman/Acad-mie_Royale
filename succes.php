<?php
session_start();

if (isset($_GET['score'])) {
    $score = $_GET['score'];
} else {
    $score = 0;
}

if (isset($_GET['total'])) {
    $total = $_GET['total'];
} else {
    $total = 0;
}

if (isset($_GET['pourcentage'])) {
    $pourcentage = $_GET['pourcentage'];
} else {
    $pourcentage = 0;
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test réussi !</title>

      <link rel="stylesheet" href="assets/css/style.css" />
              <link rel="stylesheet" href="assets/css/style4.css">

          <link rel="stylesheet" href="assets/css/style14.css">


    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
        <?php include("includes/header.php"); ?>

    <div class="card success">
        <h1><i class="fa-solid fa-trophy"></i>	 Félicitations !</h1>
        <p>Vous avez obtenu : <strong><?= $score ?> / <?= $total ?> (<?= $pourcentage ?>%)</strong></p>
        <p>Votre parcours d’apprentissage progresse avec brio.<br>
        Le certificat sera disponible une fois toutes les formations complétées.<br>
        Continuez sur cette belle lancée !</p>

        <form action="formations.php" method="get">
            <button type="submit">Retour aux formations</button>
        </form>
    </div>
    <br>
    <br>

    <script src="assets/js/script.js"></script>

</body>
</html>

