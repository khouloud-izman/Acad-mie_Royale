<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config/db.php';
session_start();

$formation_id = $_GET['formation_id'] ?? null;
if (!$formation_id) {
  echo "Formation non spécifiée.";
  exit;
}

function convertYoutubeToEmbed($url) {
    if (strpos($url, 'youtu.be') !== false) {
        preg_match('/youtu\.be\/([^\?&]+)/', $url, $matches);
        return 'https://www.youtube.com/embed/' . ($matches[1] ?? '');
    }
    if (strpos($url, 'youtube.com/watch') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        return 'https://www.youtube.com/embed/' . ($params['v'] ?? '');
    }
    return $url;
}

$stmt = $pdo->prepare("SELECT * FROM `leçon` WHERE formation_id = ? ORDER BY ordre ASC");
$stmt->execute([$formation_id]);
$lecons = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Leçons</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style9.css" />
</head>
<body>

<?php include("includes/header.php"); ?>

<div class="main-content">

  <h1>Leçons proposés pour cette formation</h1>

  <?php foreach ($lecons as $index => $lecon): 
    $embed_url = htmlspecialchars(convertYoutubeToEmbed($lecon['vidéo_url']));
  ?>
    <section class="lecon">
      <h2>Leçon <?= htmlspecialchars($lecon['ordre']) ?> : <strong><?= htmlspecialchars($lecon['titre']) ?></strong></h2>

      <div class="media">
        <div class="image-container">
          <img src="assets/images/<?= htmlspecialchars($lecon['image_url']) ?>" alt="<?= htmlspecialchars($lecon['titre']) ?>" />
          <button class="video-btn" id="btn-<?= $index ?>" onclick="showVideo(<?= $index ?>)">Voir la vidéo</button>
        </div>

        <?php if (strpos($embed_url, 'youtube.com/embed/') !== false && strlen($embed_url) > 30): ?>
          <div class="video-container" id="video-<?= $index ?>" style="display: none;">
            <iframe src="<?= $embed_url ?>" frameborder="0" allowfullscreen></iframe>
          </div>
        <?php else: ?>
          <p style="color:red;">Lien vidéo invalide ou manquant.</p>
        <?php endif; ?>
      </div>
    </section>
  <?php endforeach; ?>

</div> <!-- نهاية div.main-content -->

<?php include("includes/footer.php"); ?>

<script>
function showVideo(index) {
  const videoDiv = document.getElementById("video-" + index);
  const button = document.getElementById("btn-" + index);

  if (videoDiv && button) {
    videoDiv.style.display = "block";
    button.style.display = "none";
  }
}
</script>
<script src="assets/js/script.js"></script>
</body>
</html>
