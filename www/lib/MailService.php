<?php
// www/lib/MailService.php

// Charge PHPMailer depuis le dossier vendor
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    // Envoie un mail d'activation de compte
    public static function envoyerActivation(string $email, string $username, string $token): bool
    {
        // Construit le lien d'activation
        $lien = 'http://localhost:8080/activation?token=' . $token;

        $mail = new PHPMailer(true);

        try {
            // --- Configuration SMTP Mailpit ---
            $mail->isSMTP();
            $mail->Host     = MAIL_HOST;  // 'mailpit' (défini dans .env)
            $mail->Port     = MAIL_PORT;  // 1025
            $mail->SMTPAuth = false;      // Mailpit n'a pas besoin d'authentification

            // --- Expéditeur et destinataire ---
            $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
            $mail->addAddress($email, $username);

            // --- Contenu du mail ---
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Activez votre compte CMS';
            $mail->Body    = "
                <h2>Bonjour $username !</h2>
                <p>Merci de vous être inscrit. Cliquez sur le lien ci-dessous pour activer votre compte :</p>
                <p><a href='$lien'>$lien</a></p>
                <p>Ce lien est valable 24h.</p>
            ";

            // Version texte (pour les clients mail qui n'affichent pas le HTML)
            $mail->AltBody = "Bonjour $username ! Activez votre compte : $lien";

            $mail->send();
            return true;

        } catch (Exception $e) {
            // En cas d'erreur on affiche le message pour déboguer
            error_log("Erreur envoi mail : " . $mail->ErrorInfo);
            return false;
        }
    }
}