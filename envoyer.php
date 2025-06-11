<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation simple
    if (!empty($nom) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($message)) {
        
        header("Location: merci.php");
        exit();
    } else {
        echo "Veuillez remplir tous les champs correctement.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>