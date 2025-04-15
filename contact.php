<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Utilise correctement le namespace même si le dossier s'appelle différemment
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Corrige les chemins en fonction du nom exact du dossier sur ton hébergement
require __DIR__ . '/PHPmailer/PHPMailer.php';
require __DIR__ . '/PHPmailer/SMTP.php';
require __DIR__ . '/PHPmailer/Exception.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et sécurisation des données
    $name = htmlspecialchars(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subjectInput = htmlspecialchars(trim($_POST["subject"]));
    $type = htmlspecialchars(trim($_POST["budget"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // Contenu de l'email
    $to = "pg.mr.portfolio@gmail.com";
    $subject = "Portfolio - Mael";
    $emailMessage = "Vous avez reçu un nouveau message depuis votre site portfolio :\n\n";
    $emailMessage .= "Nom : $name\n";
    $emailMessage .= "Email : $email\n";
    $emailMessage .= "Projet : $subjectInput\n";
    $emailMessage .= "Type : $type\n";
    $emailMessage .= "Message :\n$message\n";

    // Envoi via PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuration serveur SMTP (Gmail)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pg.mr.portfolio@gmail.com'; // Ton adresse Gmail
        $mail->Password = 'kuaf ikrj tvem xecp'; // Mot de passe d'application Gmail
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Infos de l'email
        $mail->setFrom($email, $name);
        $mail->addAddress($to, 'Portfolio');
        $mail->Subject = $subject;
        $mail->Body = $emailMessage;

        $mail->send();
        echo "Merci de m'avoir contacté, je vous recontacte au plus vite !";
    } catch (Exception $e) {
        echo "Il y a eu une erreur lors de l'envoi du formulaire : {$mail->ErrorInfo}";
    }
} else {
    echo "Méthode de requête invalide.";
}
?>
