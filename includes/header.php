<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>Pâtisserie Gourmandine</title>
  <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

<header class="main-header">
  <div class="logo">
  <a href="index.php">
    <img src="assets/images/logo.png" alt="Logo">
</a>


  </div>

  <nav class="navbar">
    <button class="burger" aria-label="Toggle menu">
      <span class="burger-line"></span>
      <span class="burger-line"></span>
      <span class="burger-line"></span>
    </button>
  

    <ul class="nav-links">

    <li><a href="/academie_royale/index.php">Accueil</a></li>
<li><a href="/academie_royale/about.php">À propos</a></li>
<li><a href="/academie_royale/index.php#temoignages">Témoignages</a></li>

      <?php

$formations_link = isset($_SESSION['user_id']) ? 'formations.php' : 'auth/login.php?redirect=formations.php';
?>

<a href="<?= $formations_link ?>" class="btn-primary"> <i class="fas fa-book"></i>	
  Découvrir nos formations
</a>


        <a href="profil.php" class="btn-profil">
          <i class="fas fa-user"></i> Mon Profil
        </a>
      </li>
      <button class="close-btn" aria-label="Fermer le menu">
    <i class="fas fa-times"></i>
    </button>
    </ul>
  </nav>
</header>

<script src="assets/js/script2.js"></script>



