<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$formation_id = isset($_GET['formation_id']) ? (int)$_GET['formation_id'] : 0;
if ($formation_id <= 0) {
    header('Location: index.php');
    exit;
}

$_SESSION['tests_quit'][$formation_id] = true;

header('Location: index.php');
exit;
