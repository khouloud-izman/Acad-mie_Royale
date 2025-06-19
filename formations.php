<?php
// Inclusion du fichier de connexion à la base de données
include 'config/db.php';

// Démarrage de la session
session_start();

// Vérifie si l'utilisateur est connecté, sinon redirection vers la page de connexion
if (!isset($_SESSION['user_id'])) {
  header('Location: auth/login.php');
  exit();
}

$user_id = $_SESSION['user_id']; // Récupère l'ID de l'utilisateur connecté
$tests_quit = $_SESSION['tests_quit'] ?? []; // Récupère les tests abandonnés (s'ils existent dans la session)

// Récupération de toutes les formations depuis la base de données
$stmt = $pdo->query('SELECT * FROM formation');
$formations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Formations - Académie Royale</title>
  <!-- Icones Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <!-- Feuilles de style -->
  <link rel="stylesheet" href="assets/css/style8.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Inclusion du header -->
<?php include("includes/header.php"); ?>

<div class="main-content">

<?php foreach ($formations as $formation) : 
  // Valeurs par défaut
  $tooltip = "Aucun test encore passé";
  $test_status = 'not_passed';
  $score = null;

  // Vérifie si l'utilisateur a passé un test pour cette formation
  if ($user_id) {
    $stmt_test = $pdo->prepare("SELECT score, date_passée FROM test 
                                WHERE utilisateur_id = ? AND formation_id = ? 
                                ORDER BY date_passée DESC LIMIT 1");
    $stmt_test->execute([$user_id, $formation['formation_id']]);
    $test_info = $stmt_test->fetch();

    if ($test_info) {
      $score = (int)$test_info['score']; // Score du test
      $date_formatted = date('d/m/Y', strtotime($test_info['date_passée'])); // Formatage de la date

      // Vérifie si le test est réussi, échoué ou abandonné
      if ($score >= 50) {
          $test_status = 'success';
          $tooltip = "Test réussi le $date_formatted avec un score de {$score}%";
      } elseif ($score === 0) {
          $test_status = 'quit';
          $tooltip = "Test abandonné (score 0) le $date_formatted.";
      } else {
          $test_status = 'fail';
          $tooltip = "Test échoué le $date_formatted avec un score de {$score}%";
      }
    }
  }  
?>

<section class="formation">
  <!-- Titre de la formation et son niveau -->
  <h2>
    <?= htmlspecialchars($formation['titre']) ?> &nbsp;
    <small>Niveau <?= htmlspecialchars($formation['niveau']) ?></small>
  </h2>
  
  <!-- Description de la formation -->
  <p><?= htmlspecialchars($formation['description']) ?></p>

  <div class="btns">
    <!-- Lien vers les leçons de la formation -->
    <a href="lecons.php?formation_id=<?= $formation['formation_id'] ?>" class="btn">Accéder aux leçons</a>

    <!-- Affichage du bouton selon le statut du test -->
    <?php if ($test_status === 'success'): ?>
      <!-- Test réussi -->
      <a href="#" class="btn" style="background-color: #28a745; color: white; cursor: default; pointer-events: none; opacity: 0.5;">
        <i class="fas fa-check" style="color: white; opacity: 1;"></i> Test déjà passé
      </a>
      <i class="fas fa-info-circle" title="<?= htmlspecialchars($tooltip) ?>" style="color: #662A4D; cursor: help;"></i>

    <?php elseif ($test_status === 'fail'): ?>
      <!-- Test échoué -->
      <a href="#" class="btn" style="background-color: red; color: white; cursor: default; pointer-events: none; opacity: 0.5;">
        <i class="fas fa-times" style="color: white; opacity: 1;"></i> Échec du test
      </a>
      <i class="fas fa-info-circle" title="<?= htmlspecialchars($tooltip) ?>" style="color: #662A4D; cursor: help;"></i>

    <?php elseif ($test_status === 'quit'): ?>
      <!-- Test abandonné -->
      <a href="#" class="btn" style="background-color: #696969; color: white; cursor: default; pointer-events: none; opacity: 0.5;">
        <i class="fas fa-ban" style="color: white; opacity: 1;"></i> Test perdu (abandonné)
      </a>
      <i class="fas fa-info-circle" title="<?= htmlspecialchars($tooltip) ?>" style="color: #662A4D; cursor: help;"></i>

    <?php else: ?>
      <!-- Test pas encore passé -->
      <a href="conditions.php?formation_id=<?= $formation['formation_id'] ?>" class="btn">
        Passer le test
      </a>
      <i class="fas fa-info-circle" title="<?= htmlspecialchars($tooltip) ?>" style="color: #662A4D; cursor: help;"></i>
    <?php endif; ?>
  </div>
</section>

<?php endforeach; ?>

</div>

<!-- Inclusion du footer -->
<?php include("includes/footer.php"); ?>
<!-- Script JavaScript -->
<script src="assets/js/script.js"></script>

</body>
</html>
