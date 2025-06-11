<?php
require_once __DIR__ . '/dompdf-3.1.0/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php?redirect=certificat_pdf.php');
    exit();
}

require_once 'config/db.php';

$utilisateur_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT prenom, nom FROM utilisateur WHERE utilisateur_id = ?");
$stmt->execute([$utilisateur_id]);
$user = $stmt->fetch();

if (!$user) {
    die("Utilisateur introuvable.");
}

$prenom = htmlspecialchars($user['prenom']);
$nom = htmlspecialchars($user['nom']);
$nom_complet = $prenom . ' ' . $nom;
$date_du_jour = date('d/m/Y');

// تحويل صورة الخلفية إلى base64
$bgPath = __DIR__ . '/assets/images/certficat.jpg';
$bgData = base64_encode(file_get_contents($bgPath));

// تحويل شعار الأكاديمية إلى base64
$logoPath = __DIR__ . '/assets/images/logo.png';
$logoData = base64_encode(file_get_contents($logoPath));

// مسار الخط محلي
$fontPath = __DIR__ . '/fonts/RobotoSerif_28pt-Medium.ttf';

// HTML مع تضمين CSS، الصور، وتعريف الخط
$html = '
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <style>
        @font-face {
            font-family: "Roboto Serif";
            src: url("file://' . $fontPath . '") format("truetype");
            font-weight: normal;
            font-style: normal;
        }
        * {
            margin: 0; padding: 0; box-sizing: border-box;
        }
        body {
            margin: 0; padding: 0;
            font-family: "Roboto Serif", serif;
            background-image: url("data:image/jpg;base64,' . $bgData . '");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            position: relative;
        }
        .contenu-certificat {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
            color: #000;
            padding-top: 120px;
        }
        .contenu-certificat h1 {
            font-size: 48px;
            margin-bottom: 60px;
            font-weight: bold;
        }
        .contenu-certificat p {
            font-size: 26px;
            line-height: 2.2;
        }
        .nom-beneficiaire {
            color: #A84AC5;
            font-weight: bold;
            font-size: 30px;
        }
        .footer-infos {
            position: absolute;
            bottom: 60px;
            width: 90%;
            max-width: 1000px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            justify-content: space-between; /* espace maximal entre date et signature */
            font-size: 22px;
            color: #000;
           text-align: center;
        }
       
        .signature-name {
            font-family: "Roboto Serif", serif; /* même police que le reste */
            font-style: italic; /* italique pour effet signature */
            font-size: 32px;
        }
        .logo-certificat {
            position: absolute;
            top: 5px;
            left: 30px;
            width: 250px;
            height: auto;
            z-index: 10;
        }
    </style>
</head>
<body>

<div class="contenu-certificat">
    <img src="data:image/png;base64,' . $logoData . '" alt="Logo de l\'académie" class="logo-certificat" />
    <h1>Académie Royale de Pâtisserie</h1>
    <p>Ce certificat atteste que <span class="nom-beneficiaire">' . $nom_complet . '</span> a complété avec succès<br>
    le programme de formation de notre Académie, faisant preuve<br>
    d’excellence et de professionnalisme.</p>
</div>

<div class="footer-infos">
    <div class="date">
        <p>La Date</p>
        <p>Le ' . $date_du_jour . '</p>
    </div>
    <div class="signature">
        <p>La Directeure Générale</p>
        <p class="signature-name">A. Hamilton</p>
    </div>
</div>

</body>
</html>
';

// إنشاء PDF
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("certificat_$nom_complet.pdf", ["Attachment" => true]);
exit();
