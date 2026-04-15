<?php
/**
 * smtp_mailer.php
 * Returns a PHPMailer instance pre-configured with SMTP settings
 * from the constants defined in includes/config.php.
 *
 * Usage (in any *_mail.php file):
 *   require_once(SITE_ROOT.'includes/helpers/smtp_mailer.php');
 *   $mail = get_mailer();
 *   $mail->AddAddress($to, $name);
 *   $mail->Subject = '...';
 *   $mail->MsgHTML($body);
 *   @$mail->Send();
 */
function get_mailer() {
    $mail = new PHPMailer();

    // ── Use SMTP ──────────────────────────────────────────
    $mail->IsSMTP();
    $mail->SMTPAuth   = true;
    $mail->Host       = SMTP_HOST;
    $mail->Port       = SMTP_PORT;
    $mail->SMTPSecure = SMTP_SECURE;
    $mail->Username   = SMTP_USER;
    $mail->Password   = SMTP_PASS;
    $mail->SetFrom(SMTP_FROM, SMTP_FROMNAME);
    $mail->IsHTML(true);
    $mail->CharSet    = 'UTF-8';

    return $mail;
}
?>
