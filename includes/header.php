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
    <div class="burger" aria-label="Toggle menu">
      <span class="burger-line"></span>
      <span class="burger-line"></span>
      <span class="burger-line"></span>
    </div>

    <ul class="nav-links">
      <li><a href="/academie_royale/index.php" class="nav-link">Accueil</a></li>
      <li><a href="/academie_royale/about.php" class="nav-link">À propos</a></li>
      <li><a href="/academie_royale/index.php#temoignages" class="nav-link">Témoignages</a></li>

      <?php
      $formations_link = isset($_SESSION['user_id']) ? 'formations.php' : 'auth/login.php?redirect=formations.php';
      ?>
      <li>
        <a href="<?= $formations_link ?>" class="btn-primary nav-link">
          <i class="fas fa-book"></i> Découvrir nos formations
        </a>
      </li>

      <li>
        <a href="profil.php" class="btn-profil nav-link">
          <i class="fas fa-user"></i> Mon Profil
        </a>
      </li>

      <li>
        <div class="close-btn" aria-label="Fermer le menu">
          <i class="fas fa-times"></i>
        </div>
      </li>

      <a href="contact.php" class="contact nav-link">
        <i class="fas fa-envelope" style="margin-right: 8px; font-size:20px; margin-top:10px"></i> 
      </a>
    </ul>
  </nav>
</header>
<script src="assets/js/script.js"></script>
</body>
</html>
