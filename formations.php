<?php
include 'config/db.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;  // Hna ndirna 'user_id' bach nwaf9o m3a script dyalek dyal test

$stmt = $pdo->query('SELECT * FROM formation');
$formations = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Formations - Académie Royale</title>
  <link rel="stylesheet" href="assets/css/style8.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php include("includes/header.php"); ?>

<div class="main-content">
<?php foreach ($formations as $formation) : 
  $tooltip = "Aucun test encore passé";
  $test_status = 'not_passed';
  $score = null;

  if ($user_id) {
    $stmt_test = $pdo->prepare("SELECT score, date_passée FROM test 
                                WHERE utilisateur_id = ? AND formation_id = ? 
                                ORDER BY date_passée DESC LIMIT 1");
    $stmt_test->execute([$user_id, $formation['formation_id']]);
    $test_info = $stmt_test->fetch();

    if ($test_info) {
      $score = (int)$test_info['score'];
      $date_formatted = date('d/m/Y', strtotime($test_info['date_passée']));
      $tooltip = "Test passé le $date_formatted avec un score de {$score}%";

      if ($score >= 50) {
        $test_status = 'success';
      } else {
        $test_status = 'fail';
      }
    }
  }
?>

<section class="formation">
  <h2>
    <?= htmlspecialchars($formation['titre']) ?> &nbsp;
    <small>Niveau <?= htmlspecialchars($formation['niveau']) ?></small>
  </h2>
  <p><?= htmlspecialchars($formation['description']) ?></p>
  <div class="btns">
    <a href="lecons.php?formation_id=<?= $formation['formation_id'] ?>" class="btn">Accéder aux leçons</a>

    <?php if ($test_status === 'success'): ?>
      <span class="btn disabled" title="<?= htmlspecialchars($tooltip) ?>" style="opacity: 0.7; cursor: not-allowed;"><i class="fas fa-check"></i>
 Test déjà passé</span>
    <?php elseif ($test_status === 'fail'): ?>
      <a href="#" class="btn disabled" title="<?= htmlspecialchars($tooltip) ?>" style="background-color: #ff5e5e; cursor: not-allowed; opacity: 0.7;"><i class="fas fa-times"></i>
 Échec du test</a>
    <?php else: ?>
      <a href="conditions.php?formation_id=<?= $formation['formation_id'] ?>" class="btn">Passer le test</a>
    <?php endif; ?>

    <span class="info-icon" title="<?= htmlspecialchars($tooltip) ?>">ℹ</span>
  </div>
</section>

<?php endforeach; ?>



</div>

<?php include("includes/footer.php"); ?>
<script src="assets/js/script.js"></script>

</body>
</html>
