<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Contact – Académie Royale</title>
  <link rel="stylesheet" href="assets/css/style5.css">
    <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet">
</head>
<body>

<?php include("includes/header.php"); ?>

<main>
  <section class="contact-page">
    <h1>Contactez-nous</h1>
    <p>Vous avez une question concernant nos formations, les inscriptions, ou tout autre sujet ? N'hésitez pas à nous écrire.</p>

    <form action="envoyer.php" method="post" class="contact-form">
      <input type="text" name="nom" placeholder="Nom complet" required>
      <input type="email" name="email" placeholder="Adresse e-mail" required>
      <textarea name="message" placeholder="Votre message..." required></textarea>
      <button type="submit">Envoyer</button>
    </form>
  </section>
</main>

<br><br><br>

<?php include("includes/footer.php"); ?>
<script src="assets/js/script.js"></script>

</body>
</html>
