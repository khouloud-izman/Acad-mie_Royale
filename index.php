<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8" />
  <title>Pâtisserie Gourmandine</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
</head>
<body>
  <div class="header-container" style="position: absolute; top: -10px; left: 0; width: 100%; z-index: 200;">
    <?php include("includes/header.php"); ?>
  </div>


  <section class="hero" style="position: relative;">

  
  <section class="slider">
    <div class="slides">
      <div class="slide active" style="background-image: url('assets/images/slider1.png'); margin-top:80px"></div>
      <div class="slide" style="background-image: url('assets/images/slider2.png');margin-top:80px"></div>
      <div class="slide" style="background-image: url('assets/images/slider3.png');margin-top:80px"></div>
    </div>
    <button class="prev">&#10094;</button>
    <button class="next">&#10095;</button>

    <div class="text">
      <h1>Bienvenue à l’Académie Royale</h1>
    </div>
  </section>
</section>


<main>
  <h1>Témoignages des utilisateurs</h1>

  <section class="temoignages" id="temoignages">
    <article class="temoignage">
      <div class="photo-wrapper">
        <img src="assets/images/1.png" alt="Loubna Fadili" />
      </div>
      <div class="texte">
        <h2>Loubna Fadili</h2>
        <h4>Grâce à Académie Royale, j'ai appris à préparer des desserts que je n'aurais jamais imaginé réussir ! Merci pour la clarté des leçons et le soutien de l'équipe.</h4>
        <br>
        <div class="stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
        </div>
      </div>
    </article>

    <article class="temoignage">
      <div class="photo-wrapper">
        <img src="assets/images/2.png" alt="Mohammed Amrani" />
      </div>
      <div class="texte">
        <h2>Mohammed Amrani</h2>
        <h4>J’ai suivi les trois formations et j’ai adoré chaque moment.<br />J’ai même commencé à vendre mes gâteaux !</h4>
        <br>
        <div class="stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
        </div>
      </div>
    </article>

    <article class="temoignage">
      <div class="photo-wrapper">
        <img src="assets/images/3.png" alt="Griyech Ikram" />
      </div>
      <div class="texte">
        <h2>Zainab Alaoui</h2>
        <h4>Les formations sont bien structurées, et les chefs sont passionnés et très pédagogues. Une belle expérience !</h4>
        <br>
        <div class="stars">
          <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>
        </div>
      </div>
    </article>
  </section>
</main>

<?php include("includes/footer.php"); ?>

<script src="assets/js/script.js"></script>

</body>
</html>
