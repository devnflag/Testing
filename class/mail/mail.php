<?php
    class Mail{

        function sendMailNewUser($Mail,$FullName,$Password){
            $mail = new PHPMailer();
            $mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
            );
            //$mail->SMTPSecure = "ssl";
            $mail->SMTPSecure = "TLS";
            $mail->Host = "smtp.gmail.com"; 
            //$mail->SMTPDebug = 1;  
            $mail->Port = 587; 
            $mail->Username = "jonathanurbina92@gmail.com";  
            $mail->Password = "090192jjur";
            $mail->From = "jonathanurbina92@gmail.com";   
            $mail->FromName = "Jonathan Urbina";
            $mail->Subject = "Asunto...";
            $mail->IsHTML(true);
            $mail->MsgHTML("Bienvenida ".$FullName." su usuario es: ".$Mail." y su clave es: ".$Password);
            $mail->AddAddress($Mail);   
            if(!$mail->Send()){   
                echo "Error al enviar, causa: " .$mail->ErrorInfo;  
                $ToReturn = false;
            }
        }
    }
?>