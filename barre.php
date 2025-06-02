<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php?redirect=barre.php');
    exit();
}

require_once 'includes/db.php';

$user_id = $_SESSION['user_id'];

// جلب عدد الاختبارات اللي نجح فيهم المستخدم (نعتبر النجاح هو score >= 10)
$sql = "SELECT COUNT(*) FROM test WHERE utilisateur_id = ? AND score >= 10";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$passed_tests = $stmt->fetchColumn();

// عدد الاختبارات الكلي
$total_tests = 3;

// حساب التقدم بالنسبة المئوية
$progress = intval(($passed_tests / $total_tests) * 100);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Barre de progression</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Serif', serif;
            background-color: #FFECFE;
            padding: 40px;
        }

        .progress-container {
            width: 100%;
            max-width: 500px;
            margin: auto;
            background-color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .progress-bar {
            width: 100%;
            background-color: #eee;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 10px;
        }

        .progress {
            height: 25px;
            background-color: #CD46FF;
            width: <?= $progress ?>%;
            transition: width 0.5s ease;
        }

        .percentage {
            margin-top: 10px;
            font-size: 18px;
            color: #444;
        }
    </style>
</head>
<body>

<div class="progress-container">
    <h2>Progression de vos tests</h2>
    <div class="progress-bar">
        <div class="progress"></div>
    </div>
    <div class="percentage"><?= $progress ?>%</div>
</div>

</body>
</html>
