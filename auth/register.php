<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('../config/db.php');

$nom = $prenom = $email = $telephone = $password = $confirm_password = '';

$nom_error = $prenom_error = $email_error = $telephone_error = $password_error = $confirm_password_error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

if (empty($nom) || strlen($nom) < 2 || !preg_match('/^[a-zA-ZÀ-ÿ\-\'\s]+$/u', $nom)) {
    $nom_error = 'Le nom est requis et doit contenir au moins 2 lettres sans chiffres.';
}


 if (empty($prenom) || strlen($prenom) < 2 || !preg_match('/^[a-zA-ZÀ-ÿ\-\'\s]+$/u', $prenom)) {
    $prenom_error = "Le prénom est requis et doit contenir au moins 2 lettres sans chiffres.";
}


    if (empty($email)) {
        $email_error = "L'adresse e-mail est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "L'adresse e-mail n'est pas valide.";
    }

    if (empty($telephone)) {
        $telephone_error = "Le numéro de téléphone est requis.";
    } elseif (!preg_match('/^\d{10}$/', $telephone)) {
        $telephone_error = "Le téléphone doit contenir exactement 10 chiffres.";
    }

    if (empty($password) || strlen($password) < 6) {
        $password_error = "Le mot de passe est requis (minimum 6 caractères).";
    }

    if (empty($confirm_password)) {
      $confirm_password_error = "La confirmation du mot de passe est requise.";
    } elseif ($password !== $confirm_password) {
      $confirm_password_error = "Les mots de passe ne correspondent pas.";
    }

    if (empty($nom_error) && empty($prenom_error) && empty($email_error) && empty($telephone_error) && empty($password_error) && empty($confirm_password_error)) {
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $email_error = "Cet e-mail est déjà utilisé.";
        }
    }

    if (empty($nom_error) && empty($prenom_error) && empty($email_error) && empty($telephone_error) && empty($password_error) && empty($confirm_password_error)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO utilisateur (nom, prenom, email, numéro_de_téléphone, mot_de_passe) 
                VALUES (:nom, :prenom, :email, :telephone, :mot_de_passe)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':mot_de_passe', $hashed_password);

        if ($stmt->execute()) {
          header("Location: login.php");
          exit;
        } else {
          $email_error = "❌ Une erreur s'est produite lors de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Inscription - Pâtisserie Gourmandine</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  />
  <link rel="stylesheet" href="../assets/css/style6.css" />
  <style>
    .error-message {
      color: red;
      font-weight: bold;
      margin-top: 2px;
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 0.9em;
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="form-section">
      <div class="header-logo">
        <img src="../assets/images/logo.png" alt="Logo de l'académie" />
        <h2>Inscription</h2>
      </div>
      <form class="form-side" action="register.php" method="post">
        
        <?php if ($nom_error): ?>
          <div class="error-message">
            <i class="fas fa-times-circle" style="color:red;"></i>
            <?= htmlspecialchars($nom_error) ?>
          </div>
        <?php endif; ?>
        <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($nom) ?>" />

        <?php if ($prenom_error): ?>
          <div class="error-message">
            <i class="fas fa-times-circle" style="color:red;"></i>
            <?= htmlspecialchars($prenom_error) ?>
          </div>
        <?php endif; ?>
        <input type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($prenom) ?>" />

        <?php if ($email_error): ?>
          <div class="error-message">
            <i class="fas fa-times-circle" style="color:red;"></i>
            <?= htmlspecialchars($email_error) ?>
          </div>
        <?php endif; ?>
        <input type="email" name="email" placeholder="Adresse e-mail" value="<?= htmlspecialchars($email) ?>" />

        <?php if ($telephone_error): ?>
          <div class="error-message">
            <i class="fas fa-times-circle" style="color:red;"></i>
            <?= htmlspecialchars($telephone_error) ?>
          </div>
        <?php endif; ?>
        <input type="text" name="telephone" placeholder="Numéro de téléphone" value="<?= htmlspecialchars($telephone) ?>" />

        <?php if ($password_error): ?>
          <div class="error-message">
            <i class="fas fa-times-circle" style="color:red;"></i>
            <?= htmlspecialchars($password_error) ?>
          </div>
        <?php endif; ?>
        <input type="password" name="password" placeholder="Votre Mot de passe" />

        <?php if ($confirm_password_error): ?>
          <div class="error-message">
            <i class="fas fa-times-circle" style="color:red;"></i>
            <?= htmlspecialchars($confirm_password_error) ?>
          </div>
        <?php endif; ?>
        <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe" />

        <button type="submit" class="btnnn">S'inscrire</button>
      </form>
    </div>

    <div class="image-side">
      <img src="../assets/images/image3.jpg" alt="Pâtisserie" />
    </div>
  </div>

</body>
</html>
