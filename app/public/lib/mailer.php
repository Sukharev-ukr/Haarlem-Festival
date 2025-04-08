<?php
// app/lib/mailer.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmailRegister($username, $email, $verify_token)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'igorsu415@gmail.com'; // Your Gmail address
        $mail->Password   = 'xsed fxcr rshr zpdr';           // Your Gmail App Password (2FA required)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('igorsu415@gmail.com', 'Haarlem Festival');
        $mail->addAddress($email, $username);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification from Haarlem Festival';
        $mail->Body    = "Hello $username,<br>Please click the link below to verify your email address:<br>"
                       . "<a href='http://localhost/verify-email?token=" . urlencode($verify_token) . "'>Verify Email</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        $_SESSION['email_error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

function sendEmailReset($email, $reset_token)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'igorsu415@gmail.com';
        $mail->Password   = 'xsed fxcr rshr zpdr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('igorsu415@gmail.com', 'Haarlem Festival');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request from Haarlem Festival';
        $resetLink = "http://localhost/user/reset?token=" . urlencode($reset_token);
        $mail->Body    = "Hello,<br>We received a request to reset your password.<br>"
                       . "Please click on the link below to reset your password:<br>"
                       . "<a href='$resetLink'>Reset Password</a><br>"
                       . "If you did not request this, please ignore this email.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        $_SESSION['email_error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }

    function sendInvoiceAndTickets($username, $email, $invoicePath, $ticketPaths = [])
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'igorsu415@gmail.com';
            $mail->Password   = 'xsed fxcr rshr zpdr';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            $mail->setFrom('igorsu415@gmail.com', 'Haarlem Festival');
            $mail->addAddress($email, $username);

            $mail->isHTML(true);
            $mail->Subject = 'Your Haarlem Festival Invoice & Tickets';
            $mail->Body    = "Hi $username,<br><br>Thank you for your purchase! Please find your invoice and tickets attached.<br><br>Enjoy the event!<br><strong>Haarlem Festival Team</strong>";

            // Attach invoice PDF
            $mail->addAttachment($invoicePath, 'invoice.pdf');

            // Attach tickets if any
            foreach ($ticketPaths as $index => $ticketPath) {
                $mail->addAttachment($ticketPath, "ticket_" . ($index + 1) . ".pdf");
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            $_SESSION['email_error'] = "Failed to send invoice/tickets: {$mail->ErrorInfo}";
            return false;
        }
    }

}
