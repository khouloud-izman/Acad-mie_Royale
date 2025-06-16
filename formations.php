
<?php
include 'config/db.php';

session_start();
$user_id = $_SESSION['user_id'] ?? null;
$tests_quit = $_SESSION['tests_quit'] ?? [];

$stmt = $pdo->query('SELECT * FROM formation');
$formations = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Formations - Académie Royale</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

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
    
    if (isset($tests_quit[$formation['formation_id']]) && $test_status === 'not_passed') {
        $test_status = 'quit';
        $tooltip = "Test quitté sans être terminé.";
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
  <a href="#" class="btn" style="background-color: #28a745; color: white; cursor: default; pointer-events: none; opacity: 0.5;">
    <i class="fas fa-check" style="color: white; opacity: 1;"></i> Test déjà passé
  </a>
  <i class="fas fa-info-circle" title="<?= htmlspecialchars($tooltip) ?>" style="color: #662A4D; cursor: help;"></i>

<?php elseif ($test_status === 'fail'): ?>
  <a href="#" class="btn" style="background-color: red; color: white; cursor: default; pointer-events: none; opacity: 0.5;">
    <i class="fas fa-times" style="color: white; opacity: 1;"></i> Échec du test
  </a>
  <i class="fas fa-info-circle" title="<?= htmlspecialchars($tooltip) ?>" style="color: #662A4D; cursor: help;"></i>

<?php elseif ($test_status === 'quit'): ?>
  <a href="#" class="btn" style="background-color: #696969	; color: white; cursor: default; pointer-events: none; opacity: 0.5;">
    <i class="fas fa-ban" style="color: white; opacity: 1;"></i> Test perdu (abandonné)
  </a>
  <i class="fas fa-info-circle" title="<?= htmlspecialchars($tooltip) ?>" style="color: #662A4D; cursor: help;"></i>

<?php else: ?>
  <a href="conditions.php?formation_id=<?= $formation['formation_id'] ?>" class="btn">
    Passer le test
  </a>
  <i class="fas fa-info-circle" title="<?= htmlspecialchars($tooltip) ?>" style="color: #662A4D; cursor: help;"></i>
<?php endif; ?>


  </div>
</section>


<?php endforeach; ?>

</div>

<?php include("includes/footer.php"); ?>
<script src="assets/js/script.js"></script>

</body>
</html>
