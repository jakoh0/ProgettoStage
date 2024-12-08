<?php
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\SMTP;
		use PHPMailer\PHPMailer\Exception;

		require 'PHPMailer/src/PHPMailer.php';
		require 'PHPMailer/src/SMTP.php';
		require 'PHPMailer/src/Exception.php';
		

		
		function registrato($to,$subject,$body){

			$mail = new PHPMailer();
			// Start with PHPMailer class
			$mail->isSMTP();
			$mail->Host = 'sandbox.smtp.mailtrap.io';
			$mail->SMTPAuth = true;
			$mail->Port = 25;
			$mail->Username = '39ad46b28d7402';
			$mail->Password = '897a45da78c474';
			$mail->setFrom("jacopo.toffolo@antonioscara.edu.it");
			$mail->addAddress($to);
			$mail->Subject = $subject; 
			$mail->isHTML(TRUE);
			$mail->Body = $body;
			
			/* PER ALLEGARE ANCHE UN FILE */
			// add attachment 
			// just add the '/path/to/file.pdf'
			/*$attachmentPath = "registrato.gif";
			if (file_exists($attachmentPath)) {
				$mail->addAttachment($attachmentPath, 'registrato.gif');
			}*/
			// send the message
			$mail->send();
		}
?>	