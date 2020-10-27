<?php

namespace app\Controller;
use app\Controller\AppController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
/**
 * 
 */
class MailController extends AppController{


	public function send($subject, $msg, $adresses){

		// Load Composer's autoloader
		require 'vendor/autoload.php';

		// Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer(true);

		try {
		    //Server settings
		    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
		    $mail->isSMTP();                                            // Send using SMTP
		    $mail->Host       = 'smtp.gmail.com';                    	// Set the SMTP server to send through
		    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		    $mail->Username   = 'shukidy.jdr@gmail.com';                // SMTP username
		    $mail->Password   = getenv('GMAIL_PASSWORD');               // SMTP password
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
		    $mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
		    $mail->SMTPOptions = array(
		                    'ssl' => array(
		                        'verify_peer' => false,
		                        'verify_peer_name' => false,
		                        'allow_self_signed' => true
		                    )
		                );

		    //Recipients
		    $mail->setFrom('shukidy.jdr@gmail.com', 'Shukidy');
		    foreach ($adresses as $adresse) {
			    $mail->addBCC($adresse);     // Add a recipient
		    }

		    // Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = $subject;
		    $mail->Body    = $msg;
		    $mail->AltBody = $msg;

		    $mail->send();
		    echo 'Message has been sent';
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}


	}

}

?>