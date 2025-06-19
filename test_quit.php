<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
$user_id = $_SESSION['user_id'];

if (isset($_GET['formation_id'])) {
    $formation_id = (int) $_GET['formation_id'];
} else {
    $formation_id = 0;
}

if ($formation_id <= 0) {
    header('Location: index.php');
    exit;
}


$stmt = $pdo->prepare("INSERT INTO test (utilisateur_id, formation_id, score, tentative) VALUES (?, ?, 0, 1)");
$stmt->execute([$user_id, $formation_id]);

header('Location: index.php');
exit;
