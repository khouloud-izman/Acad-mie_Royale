<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'config/db.php';

// Récupérer l'ID de la formation depuis l'URL, sinon 0
$formation_id = isset($_GET['formation_id']) && is_numeric($_GET['formation_id']) ? (int)$_GET['formation_id'] : 0;
if ($formation_id <= 0) {
    die("Formation non spécifiée ou invalide.");
}

// Récupérer infos formation (titre, niveau)
$sql_formation = "SELECT titre, niveau FROM formation WHERE formation_id = ?";
$stmt_formation = $pdo->prepare($sql_formation);
$stmt_formation->execute([$formation_id]);
$formation = $stmt_formation->fetch(PDO::FETCH_ASSOC);

if (!$formation) {
    die("Formation non trouvée.");
}

// Récupérer toutes les questions de la formation
$sql = "SELECT question_id, question_texte FROM question WHERE formation_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$formation_id]);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total = count($questions);
if ($total == 0) {
    die("Aucune question disponible pour cette formation.");
}

// Page (numéro de question)
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1 || $page > $total) {
    header("Location: test.php?formation_id=$formation_id&page=1");
    exit;
}

$current_question = $questions[$page - 1];
$question_id = $current_question['question_id'];

// Récupérer les choix de la question courante
$sql = "SELECT choix_id, choix_texte FROM choix WHERE question_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$question_id]);
$choix = $stmt->fetchAll(PDO::FETCH_ASSOC);
$error = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['choix'])) {
        $error = "S'il vous plaît, choisissez une réponse.";
    } else {
        // Enregistrer la réponse en session (par formation et question)
        $_SESSION['reponses'][$formation_id][$question_id] = $_POST['choix'];

        if ($page < $total) {
            // Passer à la question suivante
            header("Location: test.php?formation_id=$formation_id&page=" . ($page + 1));
        } else {
            // Fin du test, aller à la correction
            header("Location: corrige.php?formation_id=$formation_id");
        }
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Test QCM - <?= htmlspecialchars($formation['titre']) ?></title>
<link rel="stylesheet" href="assets/css/style10.css">
<link rel="stylesheet" href="assets/css/style.css">

</head>
<body>

<div class="container">
<?php include("includes/header.php"); ?>

<h1><?= htmlspecialchars($formation['titre']) ?> <small>Niveau <?= htmlspecialchars($formation['niveau']) ?></small></h1>

<h2>Question <?= $page ?> / <?= $total ?></h2>
<p><strong><?= htmlspecialchars($current_question['question_texte']) ?></strong></p>

<?php if ($error): ?>
  <div class="error"><?= $error ?></div>
<?php endif; ?>

<form method="post">
  <div class="labels">
  <?php foreach ($choix as $c): ?>
    <input type="radio" id="choix<?= $c['choix_id'] ?>" name="choix" value="<?= $c['choix_id'] ?>"
      <?php 
        if (isset($_SESSION['reponses'][$formation_id][$question_id]) && $_SESSION['reponses'][$formation_id][$question_id] == $c['choix_id']) 
            echo 'checked';
      ?>
    >
    <label for="choix<?= $c['choix_id'] ?>"><?= htmlspecialchars($c['choix_texte']) ?></label>
  <?php endforeach; ?>
  </div>

<button type="submit"><?= $page == $total ? 'Valider mes réponses' : 'Suivant' ?></button>
</form>
<button id="btnQuit">Quitter le test</button>



<div id="confirmModal" class="modal" style="display:none;">
  <div class="modal-content">
    <p>Êtes-vous sûr de vouloir quitter le test ?
        <br> Votre progression sera perdue.</p>
    <button id="confirmYes">Oui</button>
    <button id="confirmNo">Non</button>
  </div>
</div>

</div>

<script src="assets/js/script.js"></script>
<script src="assets/js/script4.js"></script>

<script>
  const btnQuit = document.getElementById('btnQuit');
  const modal = document.getElementById('confirmModal');
  const btnYes = document.getElementById('confirmYes');
  const btnNo = document.getElementById('confirmNo');

  btnQuit.addEventListener('click', () => {
    modal.style.display = 'flex';  
  });

  btnNo.addEventListener('click', () => {
    modal.style.display = 'none';
  });

  btnYes.addEventListener('click', () => {
    fetch('test_quit.php?formation_id=<?= $formation_id ?>', { method: 'POST' })
      .then(() => {
        window.location.href = 'index.php'; 
      });
  });

  const navLinks = document.querySelectorAll('.nav-link');
  navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      modal.style.display = 'flex';

      btnYes.onclick = () => {
        fetch('test_quit.php?formation_id=<?= $formation_id ?>', { method: 'POST' })
          .then(() => {
            window.location.href = link.href;
          });
      };

      btnNo.onclick = () => {
        modal.style.display = 'none';
      };
    });
  });

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>

</body>
</html>