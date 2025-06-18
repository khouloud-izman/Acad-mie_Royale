<?php
session_start();
include('../config/db.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['user_id'])) {
    $redirect_url = 'formations.php';
    if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
        $redirect_url = $_GET['redirect'];
    }
    header("Location: ../" . $redirect_url);
    exit(); 
}

$erroremail = $errorpass = '';
$email = $pass = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connecter'])) {
  $email = trim($_POST['email']);
  $pass = $_POST['pass'];

  if (empty($email)) {
      $erroremail = '<i class="fas fa-times-circle" style="color:red;"></i> Veuillez remplir ce champ';
  }
  if (empty($pass)) {
      $errorpass = '<i class="fas fa-times-circle" style="color:red;"></i> Veuillez remplir ce champ';
  }

  if (empty($erroremail) && empty($errorpass)) {
      $query = 'SELECT * FROM utilisateur WHERE email = ?';
      $stmt = $pdo->prepare($query);
      $stmt->execute([$email]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user && password_verify($pass, $user['mot_de_passe'])) {
          $_SESSION['user_id'] = $user['utilisateur_id'];
          $_SESSION['user_prenom'] = $user['prenom'];
          $_SESSION['user_email'] = $user['email'];
          $_SESSION['user_nom'] = $user['nom'];

          $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'profil.php';
          $allowed_pages = ['profil.php', 'formations.php', 'index.php'];
          $redirect = in_array($redirect, $allowed_pages) ? $redirect : 'profil.php';

          header("Location: ../$redirect");
          exit();
      } else {
          if (!$user) {
              $erroremail = '<i class="fas fa-times-circle" style="color:red;"></i> Email non trouvé';
          } else {
              $errorpass = '<i class="fas fa-times-circle" style="color:red;"></i> Mot de passe incorrect';
          }
      }
  }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion - Pâtisserie Gourmandine</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/style7.css">
</head>
<body>
  <div class="container">
    <div class="form-section">
      <div class="header-logo">
        <img src="../assets/images/logo.png" alt="Logo de l'académie">
        <h2>Connexion</h2>
      </div>

      <form class="form-side" action="login.php<?php if (isset($_GET['redirect'])) echo '?redirect=' . htmlspecialchars($_GET['redirect']); ?>" method="post">
        <span style="color:red;font-weight: bold;"><?= $erroremail ?></span><br>
        <input type="email" name="email" placeholder="Entrez votre Adresse e-mail" value="<?= htmlspecialchars($email) ?>"><br><br>

        <span style="color:red; font-weight: bold;"><?= $errorpass ?></span><br>
        <input type="password" name="pass" placeholder="Entrez votre Mot de passe"><br><br>

        <div class="a">
          <button type="submit" class="btnnn" name="connecter">Se connecter</button>
          <a href="register.php">Vous n'avez pas de compte ?</a>
        </div>
      </form>
    </div>

    <div class="image-side">
      <img src="../assets/images/image3.jpg" alt="Pâtisserie">
    </div>
  </div>
</body>
</html>
