<?php 
session_start();
require_once 'config/db.php';

// 1. Vérifie si formation_id est valide
$formation_id = isset($_GET['formation_id']) ? (int)$_GET['formation_id'] : 0;
if ($formation_id <= 0) {
    exit("Formation non trouvée.");
}

// 2. Vérifie les réponses de l'utilisateur
if (!isset($_SESSION['reponses'][$formation_id])) {
    exit("Aucune réponse trouvée.");
}
$reponses = $_SESSION['reponses'][$formation_id];

// 3. Récupérer les bonnes réponses depuis la base
$stmt = $pdo->prepare("
    SELECT q.question_id, c.choix_id
    FROM question q
    JOIN choix c ON c.question_id = q.question_id
    WHERE q.formation_id = ? AND c.est_correct = 1
");
$stmt->execute([$formation_id]);
$bonnes_reponses = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// 4. Calcul du score
$total = count($bonnes_reponses);
$score = 0;
foreach ($bonnes_reponses as $qid => $correct_id) {
    if (isset($reponses[$qid]) && $reponses[$qid] == $correct_id) {
        $score++;
    }
}
$pourcentage = round(($score / $total) * 100);

// 5. Enregistrement du résultat
if (isset($_SESSION['user_id'])) {
    $utilisateur_id = $_SESSION['user_id'];

    // Vérifie si un test existe déjà
    $stmt_check = $pdo->prepare("SELECT score, tentative FROM test WHERE utilisateur_id = ? AND formation_id = ?");
    $stmt_check->execute([$utilisateur_id, $formation_id]);
    $test_exist = $stmt_check->fetch(PDO::FETCH_ASSOC);

    if ($test_exist) {
        $tentative = (int)$test_exist['tentative'];

        // Si tentative < 2, on met à jour le score et on augmente tentative
        if ($tentative < 2) {
            $stmt_update = $pdo->prepare("UPDATE test SET score = ?, tentative = tentative + 1, date_passée = NOW()
                                          WHERE utilisateur_id = ? AND formation_id = ?");
            $stmt_update->execute([$pourcentage, $utilisateur_id, $formation_id]);
        }
        // Sinon: tentative max atteinte, on ne fait rien
    } else {
        // Première tentative
        $stmt_insert = $pdo->prepare("INSERT INTO test (utilisateur_id, formation_id, score, tentative, date_passée)
                                      VALUES (?, ?, ?, 1, NOW())");
        $stmt_insert->execute([$utilisateur_id, $formation_id, $pourcentage]);
    }

    // Si l'utilisateur a réussi (≥ 50%), mettre à jour la progression
    if ($pourcentage >= 50) {
        $total_formations = 3; // adapte selon ton système

        $stmt_success = $pdo->prepare("SELECT COUNT(*) FROM test WHERE utilisateur_id = ? AND score >= 50");
        $stmt_success->execute([$utilisateur_id]);
        $reussis = (int)$stmt_success->fetchColumn();

        $new_progress = round(($reussis / $total_formations) * 100);

        $stmt_current = $pdo->prepare("SELECT progression FROM utilisateur WHERE utilisateur_id = ?");
        $stmt_current->execute([$utilisateur_id]);
        $current = (int)$stmt_current->fetchColumn();

        if ($new_progress > $current) {
            $stmt_update_progress = $pdo->prepare("UPDATE utilisateur SET progression = ? WHERE utilisateur_id = ?");
            $stmt_update_progress->execute([$new_progress, $utilisateur_id]);
        }
    }
}

// Nettoyer les réponses de la session (test terminé)
unset($_SESSION['reponses'][$formation_id]);

// Rediriger selon le score
if ($pourcentage >= 50) {
    header("Location: succes.php?score=$score&total=$total&pourcentage=$pourcentage");
    exit;
} else {
    header("Location: echec.php?score=$score&total=$total&pourcentage=$pourcentage&formation_id=$formation_id");
    exit;
}
?>
