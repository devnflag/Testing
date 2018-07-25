<?php
	class Mail{

		function sendMailNewUser($Mail,$FullName,$Password){
			$Contenido = $this->SingUpContentMail($Mail,$Password);
			$Contenido = html_entity_decode(preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $Contenido), ENT_QUOTES, 'UTF-8');
			$Contenido = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $Contenido);
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
			$mail->FromName = "NFLAG";
			$mail->Subject = "Bienvenid@ a NFLAG";
			$mail->IsHTML(true);
			$mail->MsgHTML($Contenido);
			$mail->AddAddress($Mail);   
			if(!$mail->Send()){   
					echo "Error al enviar, causa: " .$mail->ErrorInfo;  
					$ToReturn = false;
			}
		}
		function sendMailRecuperarClave($Mail,$Password){
			$Contenido = $this->RecuperarContentMail($Mail,$Password);
			$Contenido = html_entity_decode(preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $Contenido), ENT_QUOTES, 'UTF-8');
			$Contenido = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $Contenido);
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
			$mail->FromName = "NFLAG";
			$mail->Subject = "Bienvenid@ a NFLAG";
			$mail->IsHTML(true);
			$mail->MsgHTML($Contenido);
			$mail->AddAddress($Mail);   
			if(!$mail->Send()){   
					echo "Error al enviar, causa: " .$mail->ErrorInfo;  
					$ToReturn = false;
			}
		}
		function SingUpContentMail($Mail,$Password){
			$ToReturn = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
				"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
				<style type="text/css">
					body {
						width: 100% !important;
						height: 100% !important;
						margin: 0;
						padding: 0;
					}
					html, body, div, span, applet, object, iframe,
					h1, h2, h3, h4, h5, h6, p, blockquote, pre,
					a, abbr, acronym, address, big, cite, code,
					del, dfn, em, img, ins, kbd, q, s, samp,
					small, strike, strong, sub, sup, tt, var,
					b, u, i, center,
					dl, dt, dd, ol, ul, li,
					fieldset, form, label, legend,
					table, caption, tbody, tfoot, thead, tr, th, td,
					article, aside, canvas, details, embed,
					figure, figcaption, footer, header, hgroup,
					menu, nav, output, ruby, section, summary,
					time, mark, audio, video {
						Margin: 0;
						padding: 0;
						border: 0;
					}
					article, aside, details, figcaption, figure,
					footer, header, hgroup, menu, nav, section {
						display: block;
					}
					body {
						line-height: 1;
					}
					blockquote, q {
						quotes: none;
					}
					blockquote:before, blockquote:after,
					q:before, q:after {
						content: "";
						content: none;
					}
					table {
						border-collapse: collapse;
						border-spacing: 0;
					}
					table, td {
						mso-table-lspace: 0pt;
						mso-table-rspace: 0pt;
					}
					.fix-space-td-img {
						font-size:0px;
						line-height:0px;
					}
					@media only screen and (max-width: 479px), only screen and (max-device-width: 479px) {
						body {
							width: auto !important;
						}
						#conteneur {
							width: 100% !important;
						}
						.full {
							display: block !important;
						}
						.mobile-full-width {
							width: 100% !important;
						}
						td.full {
							display: block !important;
						}
						img {
							max-width: 100% !important;
							height: auto !important;
						}
					}
				</style>
				<!--[if !mso]><!-->
				<link href="https://fonts.googleapis.com/css?family=Bree+Serif|Ubuntu|Dancing+Script|Droid+Sans|Lato|Lobster|Montserrat|Open+Sans|Pacifico|Raleway|Roboto|Source+Sans+Pro|Titillium+Web&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
							rel="stylesheet" type="text/css">
				<style type="text/css">
					@import url(https://fonts.googleapis.com/css?family=Bree+Serif|Ubuntu|Dancing+Script|Droid+Sans|Lato|Lobster|Montserrat|Open+Sans|Pacifico|Raleway|Roboto|Source+Sans+Pro|Titillium+Web&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese);
				</style>
				<!--<![endif]-->
				<!--[if gte mso 9]>
				<style>
					li {
						text-indent: -1em;
					}
				</style>
				<xml>
					<o:OfficeDocumentSettings>
						<o:AllowPNG/>
						<o:PixelsPerInch>96</o:PixelsPerInch>
					</o:OfficeDocumentSettings>
				</xml>
				<![endif]-->
				<!--[if (gte mso 9)|(IE)]>
				<style type="text/css">
					table
					{
						mso-line-height-rule: exactly;
						mso-margin-bottom-alt: 0;
						mso-margin-top-alt: 0;
					}
				</style>
				<![endif]-->
				<title></title>
			</head>
			<body id="conteneur"
						style="width:100%; background-color:#edeff0; word-wrap: break-word;
							word-break: break-word; overflow-wrap: break-word;">
			<table id="content_root" width="100%" cellpadding="0" cellspacing="0"
							style="background-color:#edeff0;
			">
				<tr>
					<td align="center">
						<table cellpadding="0" cellspacing="0" align="center"
			>
							<tr>
								<td align="left" valign="top">
										
										<table class="structure-container" width="100%" cellpadding="0" cellspacing="0"
							style="
								">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0"
			>
							<tr>
								<td align="center"
										width="650"
									>
									<table align="center" cellpadding="0" cellspacing="0"
													class="structure mobile-full-width"
													width="100%"
													style="
																background-color: #edeff0;
															border-color: #156ba5;
														">
										<tr>
											<td align="center">
												<table align="center" class="mobile-full-width responsive" cellpadding="0" cellspacing="0"
																width="100%"
			>
														<td class="full mobile-full-width" width="100%"
					valign="top"
					style="">
				<table class="column" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; text-align: left;">
					<tr>
						<td align="center"
								style="
									padding: 15px 15px 15px 15px;">
								<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">
						<table align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" class="fix-space-td-img">
									<div>
															<img style="display: block;"  width="60" height="107"
																				src="http://img.sbc24.net/5b588236b95cee1f5b6f7a44/9_aZ6uPkQZeNnSlXivfS1g/-fRmTd7VQTqVOrG2Rg4OrA-Solo%20Logo.png"/>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
						</td>
					</tr>
				</table>
			</td>
			
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
										<table class="structure-container" width="100%" cellpadding="0" cellspacing="0"
							style="
								">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0"
			>
							<tr>
								<td align="center"
										width="650"
									>
									<table align="center" cellpadding="0" cellspacing="0"
													class="structure mobile-full-width"
													width="100%"
													style="
																background-color: #fff;
															border-color: #156ba5;
														">
										<tr>
											<td align="center">
												<table align="center" class="mobile-full-width responsive" cellpadding="0" cellspacing="0"
																width="100%"
			>
														<td class="full mobile-full-width" width="100%"
					valign="top"
					style="">
				<table class="column" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; text-align: left;">
					<tr>
						<td align="center"
								style="
									padding: 35px 35px 35px 35px;">
								<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" align="left"><![endif]-->
			<!--[if !mso]><!--><table width="100%" cellpadding="0" cellspacing="0"><!--<![endif]-->
				<tr>
					<td align="left">
						<h1 style="font-family: Arial;
							font-size: 30px;
							font-weight: normal;line-height: 42px;
							color: #393939;
							margin: 0;mso-line-height-rule: exactly;"><span style="font-size: 42px; line-height: 42px; mso-line-height-rule: exactly;"><strong style="line-height: 42px; font-size: 42px; mso-line-height-rule: exactly;"><span style="line-height: 42px; font-size: 42px; mso-line-height-rule: exactly;">BIENVENIDO</span></strong></span></h1>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
								<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" align="left"><![endif]-->
			<!--[if !mso]><!--><table width="100%" cellpadding="0" cellspacing="0"><!--<![endif]-->
				<tr>
					<td align="left">
						<p style="color: #393939;
							font-size: 17px;
							font-family: Arial;line-height: 26px;text-align: justify;
							margin: 0;mso-line-height-rule: exactly;">Su registro en nuestro sistema le regala una licencia indefinida para realizar llamadas a nivel mundial mediante nuestro servicio SIP Telecom el cual cuenta con varios planes de minutos y la posibilidad de realizar llamadas sin la necesidad de adquirir un plan.</p>
			<p style="color: #393939;
							font-size: 17px;
							font-family: Arial;line-height: 26px;text-align: justify;
							margin: 0;mso-line-height-rule: exactly;">Usuario: '.$Mail.'<br />Contraseña: '.$Password.'</p>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
								<table  border="0" cellpadding="0" cellspacing="0" width="100%" >
				<tr>
					<td style="padding-top:10px;padding-bottom:10px;mso-line-height-rule: exactly;">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td style="mso-line-height-rule: exactly;border-top: 1px solid #e0e0e0;border-collapse: collapse;
									mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><span></span></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
								<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">
						<table align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" class="fix-space-td-img">
									<div>
															<img style="display: block;"  width="580" height="362"
																				src="https://eb-static.jackmail-cdn.com/contenu/HlFttq8qWE496v7KOcmTgg.png"/>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
								<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" align="left"><![endif]-->
			<!--[if !mso]><!--><table width="100%" cellpadding="0" cellspacing="0"><!--<![endif]-->
				<tr>
					<td align="left">
						<p style="color: #393939;
							font-size: 17px;
							font-family: Arial;line-height: 26px;text-align: left;
							margin: 0;mso-line-height-rule: exactly;">Para poder utilizar nuestro servicio deben descargar una aplicación de terceros llamado "Zoiper" en el Play Store o en la App Store de su Smartphone. Los pasos para utilizar esta aplicación se encuentran en la opción "Cuenta" del menú de SIP Telecom</p>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
								<table width="100%" cellpadding="0" cellspacing="0" >
				<tr>
					<td align="left">
							<table border="0" align="left" class="mobile-full-width" cellpadding="0" cellspacing="0" style="
												background-color:#0595d6;
												border-collapse: separate;
												border: 1px solid #0595d6;
												border-radius: 5px;">
								<tr>
									<td align="left"
											style="
												padding: 10px 25px;
												color: #fff;
												font-family: Arial;
												font-size: 15px;">
										<a href="http://app.nflag.io" target="_blank" style="
													text-align: center;
													text-decoration: none;
													display: block;
													color: #fff;
													font-family: Arial;
													font-size: 15px;">
											<span style="margin: 0px;">Iniciar Sesión</span>
										</a>
									</td>
								</tr>
							</table>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
						</td>
					</tr>
				</table>
			</td>
			
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
										<table class="structure-container" width="100%" cellpadding="0" cellspacing="0"
							style="
								">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0"
			>
							<tr>
								<td align="center"
										width="650"
									>
									<table align="center" cellpadding="0" cellspacing="0"
													class="structure mobile-full-width"
													width="100%"
													style="
																background-color: #edeff0;
															border-color: #156ba5;
														">
										<tr>
											<td align="center">
												<table align="center" class="mobile-full-width responsive" cellpadding="0" cellspacing="0"
																width="100%"
			>
														<td class="full mobile-full-width" width="100%"
					valign="top"
					style="">
				<table class="column" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; text-align: left;">
					<tr>
						<td align="center"
								style="
									padding: 20px 20px 20px 20px;">
								<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">
						<table align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center">
										<a href="http://eye.sbc24.net/c?p=xBD59GZN0N7Q1UE60JU60LHQtkYODtCsxBBeCtDF0JQrFEl10Lvh0L4iA9COMVTZKmh0dHA6Ly93d3cuZmFjZWJvb2suY29tLzxmYWNlYm9vay1hY2NvdW50Prg1YjU4ODIzNmI5NWNlZTFmNWI2ZjdhNDTEENCGCNCfPDBOQRjQodCR0MjQyflZRNDXrWV5ZS5zYmMyNC5uZXTEFBXQwdCkXRj7VODQjykh8tDRDRE-U9C40Kln" target="_blank"><img src="http://img.sbc24.net/5b588236b95cee1f5b6f7a44/9_aZ6uPkQZeNnSlXivfS1g/-fRmTd7VQTqVOrG2Rg4OrA-Facebook_round_grey.png" width="40"></a>
										<a href="http://eye.sbc24.net/c?p=xBD59GZN0N7Q1UE60JU60LHQtkYODtCsxBBc0K7QitC30I5yQHzQvNCsRdDI0KTQ1DPQtNklaHR0cHM6Ly90d2l0dGVyLmNvbS88dHdpdHRlci1hY2NvdW50Prg1YjU4ODIzNmI5NWNlZTFmNWI2ZjdhNDTEENCGCNCfPDBOQRjQodCR0MjQyflZRNDXrWV5ZS5zYmMyNC5uZXTEFBXQwdCkXRj7VODQjykh8tDRDRE-U9C40Kln" target="_blank"><img src="http://img.sbc24.net/5b588236b95cee1f5b6f7a44/9_aZ6uPkQZeNnSlXivfS1g/-fRmTd7VQTqVOrG2Rg4OrA-Twitter_round_grey.png" width="40"></a>
										<a href="http://eye.sbc24.net/c?p=xBD59GZN0N7Q1UE60JU60LHQtkYODtCsxBBW0MdpfUTQuEdj0IrqXAUv0L4YW9kzaHR0cHM6Ly9wbHVzLmdvb2dsZS5jb20vPGdvb2dsZS1wbHVzLWFjY291bnQ-L3Bvc3RzuDViNTg4MjM2Yjk1Y2VlMWY1YjZmN2E0NMQQ0IYI0J88ME5BGNCh0JHQyNDJ-VlE0NetZXllLnNiYzI0Lm5ldMQUFdDB0KRdGPtU4NCPKSHy0NENET5T0LjQqWc" target="_blank"><img src="http://img.sbc24.net/5b588236b95cee1f5b6f7a44/9_aZ6uPkQZeNnSlXivfS1g/-fRmTd7VQTqVOrG2Rg4OrA-Google%2B_round_grey.png" width="40"></a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
						</td>
					</tr>
				</table>
			</td>
			
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
										<table class="structure-container" width="100%" cellpadding="0" cellspacing="0"
							style="
								background-color: #edeff0;
			">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0"
			>
							<tr>
								<td align="center"
										width="650"
									>
									<table align="center" cellpadding="0" cellspacing="0"
													class="structure mobile-full-width"
													width="100%"
													style="
															border-color: #156ba5;
														">
										<tr>
											<td align="center">
												<table align="center" class="mobile-full-width responsive" cellpadding="0" cellspacing="0"
																width="100%"
			>
														<td class="full mobile-full-width" width="100%"
					valign="top"
					style="">
				<table class="column" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; text-align: left;">
					<tr>
						<td align="center"
								style="
									padding: 20px 20px 20px 20px;">
								<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" align="left"><![endif]-->
			<!--[if !mso]><!--><table width="100%" cellpadding="0" cellspacing="0"><!--<![endif]-->
				<tr>
					<td align="left">
						<p style="color: #156ba5;
							font-size: 10px;
							font-family: Arial;line-height: 14px;text-align: center;
							margin: 0;mso-line-height-rule: exactly;"><a style="line-height: 14px; text-align: center; margin: 0px; color: #156ba5; font-size: 10px; font-family: Arial; text-decoration: underline;" href="http://eye.sbc24.net/r/USBSHOW/84/5b588236b95cee1f5b6f7a44/-fRmTd7VQTqVOrG2Rg4OrA/hgifPDBOQRihkcjJ-VlE1w?email=luis@focoestrategico.cl&adm=lponce1405@gmail.com" target="_blank" rel="noopener" data-link-type="unsubscribe"> Cliquez sur ce lien pour vous désabonner </a></p>
					</td>
				</tr>
			</table>
			
						</td>
					</tr>
				</table>
			</td>
			
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" bgcolor="#FFFFFF" style="padding:10px;"></td></tr></table></body>
			</html>';
			return $ToReturn;
		}
		function RecuperarContentMail($Mail,$Password){
			$ToReturn = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
				"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
				<style type="text/css">
					body {
						width: 100% !important;
						height: 100% !important;
						margin: 0;
						padding: 0;
					}
					html, body, div, span, applet, object, iframe,
					h1, h2, h3, h4, h5, h6, p, blockquote, pre,
					a, abbr, acronym, address, big, cite, code,
					del, dfn, em, img, ins, kbd, q, s, samp,
					small, strike, strong, sub, sup, tt, var,
					b, u, i, center,
					dl, dt, dd, ol, ul, li,
					fieldset, form, label, legend,
					table, caption, tbody, tfoot, thead, tr, th, td,
					article, aside, canvas, details, embed,
					figure, figcaption, footer, header, hgroup,
					menu, nav, output, ruby, section, summary,
					time, mark, audio, video {
						Margin: 0;
						padding: 0;
						border: 0;
					}
					article, aside, details, figcaption, figure,
					footer, header, hgroup, menu, nav, section {
						display: block;
					}
					body {
						line-height: 1;
					}
					blockquote, q {
						quotes: none;
					}
					blockquote:before, blockquote:after,
					q:before, q:after {
						content: "";
						content: none;
					}
					table {
						border-collapse: collapse;
						border-spacing: 0;
					}
					table, td {
						mso-table-lspace: 0pt;
						mso-table-rspace: 0pt;
					}
					.fix-space-td-img {
						font-size:0px;
						line-height:0px;
					}
					@media only screen and (max-width: 479px), only screen and (max-device-width: 479px) {
						body {
							width: auto !important;
						}
						#conteneur {
							width: 100% !important;
						}
						.full {
							display: block !important;
						}
						.mobile-full-width {
							width: 100% !important;
						}
						td.full {
							display: block !important;
						}
						img {
							max-width: 100% !important;
							height: auto !important;
						}
					}
				</style>
				<!--[if !mso]><!-->
				<link href="https://fonts.googleapis.com/css?family=Bree+Serif|Ubuntu|Dancing+Script|Droid+Sans|Lato|Lobster|Montserrat|Open+Sans|Pacifico|Raleway|Roboto|Source+Sans+Pro|Titillium+Web&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
							rel="stylesheet" type="text/css">
				<style type="text/css">
					@import url(https://fonts.googleapis.com/css?family=Bree+Serif|Ubuntu|Dancing+Script|Droid+Sans|Lato|Lobster|Montserrat|Open+Sans|Pacifico|Raleway|Roboto|Source+Sans+Pro|Titillium+Web&subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese);
				</style>
				<!--<![endif]-->
				<!--[if gte mso 9]>
				<style>
					li {
						text-indent: -1em;
					}
				</style>
				<xml>
					<o:OfficeDocumentSettings>
						<o:AllowPNG/>
						<o:PixelsPerInch>96</o:PixelsPerInch>
					</o:OfficeDocumentSettings>
				</xml>
				<![endif]-->
				<!--[if (gte mso 9)|(IE)]>
				<style type="text/css">
					table
					{
						mso-line-height-rule: exactly;
						mso-margin-bottom-alt: 0;
						mso-margin-top-alt: 0;
					}
				</style>
				<![endif]-->
				<title></title>
			</head>
			<body id="conteneur"
						style="width:100%; background-color:#edeff0; word-wrap: break-word;
							word-break: break-word; overflow-wrap: break-word;">
			<table id="content_root" width="100%" cellpadding="0" cellspacing="0"
							style="background-color:#edeff0;
			">
				<tr>
					<td align="center">
						<table cellpadding="0" cellspacing="0" align="center"
			>
							<tr>
								<td align="left" valign="top">
										
										<table class="structure-container" width="100%" cellpadding="0" cellspacing="0"
							style="
								">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0"
			>
							<tr>
								<td align="center"
										width="650"
									>
									<table align="center" cellpadding="0" cellspacing="0"
													class="structure mobile-full-width"
													width="100%"
													style="
																background-color: #edeff0;
															border-color: #156ba5;
														">
										<tr>
											<td align="center">
												<table align="center" class="mobile-full-width responsive" cellpadding="0" cellspacing="0"
																width="100%"
			>
														<td class="full mobile-full-width" width="100%"
					valign="top"
					style="">
				<table class="column" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; text-align: left;">
					<tr>
						<td align="center"
								style="
									padding: 15px 15px 15px 15px;">
								<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">
						<table align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" class="fix-space-td-img">
									<div>
															<img style="display: block;"  width="60" height="107"
																				src="http://img.sbc24.net/5b588236b95cee1f5b6f7a44/9_aZ6uPkQZeNnSlXivfS1g/-fRmTd7VQTqVOrG2Rg4OrA-Solo%20Logo.png"/>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
						</td>
					</tr>
				</table>
			</td>
			
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
										<table class="structure-container" width="100%" cellpadding="0" cellspacing="0"
							style="
								">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0"
			>
							<tr>
								<td align="center"
										width="650"
									>
									<table align="center" cellpadding="0" cellspacing="0"
													class="structure mobile-full-width"
													width="100%"
													style="
																background-color: #fff;
															border-color: #156ba5;
														">
										<tr>
											<td align="center">
												<table align="center" class="mobile-full-width responsive" cellpadding="0" cellspacing="0"
																width="100%"
			>
														<td class="full mobile-full-width" width="100%"
					valign="top"
					style="">
				<table class="column" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; text-align: left;">
					<tr>
						<td align="center"
								style="
									padding: 35px 35px 35px 35px;">
								<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" align="left"><![endif]-->
			<!--[if !mso]><!--><table width="100%" cellpadding="0" cellspacing="0"><!--<![endif]-->
				<tr>
					<td align="left">
						<h1 style="font-family: Arial;
							font-size: 30px;
							font-weight: normal;line-height: 42px;
							color: #393939;
							margin: 0;mso-line-height-rule: exactly;"><span style="font-size: 42px; line-height: 42px; mso-line-height-rule: exactly;"><strong style="line-height: 42px; font-size: 42px; mso-line-height-rule: exactly;"><span style="line-height: 42px; font-size: 42px; mso-line-height-rule: exactly;">BIENVENIDO</span></strong></span></h1>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
								<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" align="left"><![endif]-->
			<!--[if !mso]><!--><table width="100%" cellpadding="0" cellspacing="0"><!--<![endif]-->
				<tr>
					<td align="left">
						<p style="color: #393939;
							font-size: 17px;
							font-family: Arial;line-height: 26px;text-align: justify;
							margin: 0;mso-line-height-rule: exactly;">Su contraseña ha sido recuperada..</p>
			<p style="color: #393939;
							font-size: 17px;
							font-family: Arial;line-height: 26px;text-align: justify;
							margin: 0;mso-line-height-rule: exactly;">Usuario: '.$Mail.'<br />Contraseña: '.$Password.'</p>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
								<table  border="0" cellpadding="0" cellspacing="0" width="100%" >
				<tr>
					<td style="padding-top:10px;padding-bottom:10px;mso-line-height-rule: exactly;">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td style="mso-line-height-rule: exactly;border-top: 1px solid #e0e0e0;border-collapse: collapse;
									mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><span></span></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
								<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">
						<table align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center" class="fix-space-td-img">
									<div>
															<img style="display: block;"  width="580" height="362"
																				src="https://eb-static.jackmail-cdn.com/contenu/HlFttq8qWE496v7KOcmTgg.png"/>
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
								<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" align="left"><![endif]-->
			<!--[if !mso]><!--><table width="100%" cellpadding="0" cellspacing="0"><!--<![endif]-->
				<tr>
					<td align="left">
						<p style="color: #393939;
							font-size: 17px;
							font-family: Arial;line-height: 26px;text-align: left;
							margin: 0;mso-line-height-rule: exactly;">Para poder utilizar nuestro servicio deben descargar una aplicación de terceros llamado "Zoiper" en el Play Store o en la App Store de su Smartphone. Los pasos para utilizar esta aplicación se encuentran en la opción "Cuenta" del menú de SIP Telecom</p>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
								<table width="100%" cellpadding="0" cellspacing="0" >
				<tr>
					<td align="left">
							<table border="0" align="left" class="mobile-full-width" cellpadding="0" cellspacing="0" style="
												background-color:#0595d6;
												border-collapse: separate;
												border: 1px solid #0595d6;
												border-radius: 5px;">
								<tr>
									<td align="left"
											style="
												padding: 10px 25px;
												color: #fff;
												font-family: Arial;
												font-size: 15px;">
										<a href="http://app.nflag.io" target="_blank" style="
													text-align: center;
													text-decoration: none;
													display: block;
													color: #fff;
													font-family: Arial;
													font-size: 15px;">
											<span style="margin: 0px;">Iniciar Sesión</span>
										</a>
									</td>
								</tr>
							</table>
					</td>
				</tr>
			</table>
			
								<table cellpadding="0" cellspacing="0">
				<tr>
					<td height="20" style="font-size:20px; line-height: 20px; mso-line-height-rule:exactly;">
						 
					</td>
				</tr>
			</table>
			
						</td>
					</tr>
				</table>
			</td>
			
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
										<table class="structure-container" width="100%" cellpadding="0" cellspacing="0"
							style="
								">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0"
			>
							<tr>
								<td align="center"
										width="650"
									>
									<table align="center" cellpadding="0" cellspacing="0"
													class="structure mobile-full-width"
													width="100%"
													style="
																background-color: #edeff0;
															border-color: #156ba5;
														">
										<tr>
											<td align="center">
												<table align="center" class="mobile-full-width responsive" cellpadding="0" cellspacing="0"
																width="100%"
			>
														<td class="full mobile-full-width" width="100%"
					valign="top"
					style="">
				<table class="column" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; text-align: left;">
					<tr>
						<td align="center"
								style="
									padding: 20px 20px 20px 20px;">
								<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">
						<table align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="center">
										<a href="http://eye.sbc24.net/c?p=xBD59GZN0N7Q1UE60JU60LHQtkYODtCsxBBeCtDF0JQrFEl10Lvh0L4iA9COMVTZKmh0dHA6Ly93d3cuZmFjZWJvb2suY29tLzxmYWNlYm9vay1hY2NvdW50Prg1YjU4ODIzNmI5NWNlZTFmNWI2ZjdhNDTEENCGCNCfPDBOQRjQodCR0MjQyflZRNDXrWV5ZS5zYmMyNC5uZXTEFBXQwdCkXRj7VODQjykh8tDRDRE-U9C40Kln" target="_blank"><img src="http://img.sbc24.net/5b588236b95cee1f5b6f7a44/9_aZ6uPkQZeNnSlXivfS1g/-fRmTd7VQTqVOrG2Rg4OrA-Facebook_round_grey.png" width="40"></a>
										<a href="http://eye.sbc24.net/c?p=xBD59GZN0N7Q1UE60JU60LHQtkYODtCsxBBc0K7QitC30I5yQHzQvNCsRdDI0KTQ1DPQtNklaHR0cHM6Ly90d2l0dGVyLmNvbS88dHdpdHRlci1hY2NvdW50Prg1YjU4ODIzNmI5NWNlZTFmNWI2ZjdhNDTEENCGCNCfPDBOQRjQodCR0MjQyflZRNDXrWV5ZS5zYmMyNC5uZXTEFBXQwdCkXRj7VODQjykh8tDRDRE-U9C40Kln" target="_blank"><img src="http://img.sbc24.net/5b588236b95cee1f5b6f7a44/9_aZ6uPkQZeNnSlXivfS1g/-fRmTd7VQTqVOrG2Rg4OrA-Twitter_round_grey.png" width="40"></a>
										<a href="http://eye.sbc24.net/c?p=xBD59GZN0N7Q1UE60JU60LHQtkYODtCsxBBW0MdpfUTQuEdj0IrqXAUv0L4YW9kzaHR0cHM6Ly9wbHVzLmdvb2dsZS5jb20vPGdvb2dsZS1wbHVzLWFjY291bnQ-L3Bvc3RzuDViNTg4MjM2Yjk1Y2VlMWY1YjZmN2E0NMQQ0IYI0J88ME5BGNCh0JHQyNDJ-VlE0NetZXllLnNiYzI0Lm5ldMQUFdDB0KRdGPtU4NCPKSHy0NENET5T0LjQqWc" target="_blank"><img src="http://img.sbc24.net/5b588236b95cee1f5b6f7a44/9_aZ6uPkQZeNnSlXivfS1g/-fRmTd7VQTqVOrG2Rg4OrA-Google%2B_round_grey.png" width="40"></a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
						</td>
					</tr>
				</table>
			</td>
			
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
										<table class="structure-container" width="100%" cellpadding="0" cellspacing="0"
							style="
								background-color: #edeff0;
			">
				<tr>
					<td>
						<table cellpadding="0" cellspacing="0"
			>
							<tr>
								<td align="center"
										width="650"
									>
									<table align="center" cellpadding="0" cellspacing="0"
													class="structure mobile-full-width"
													width="100%"
													style="
															border-color: #156ba5;
														">
										<tr>
											<td align="center">
												<table align="center" class="mobile-full-width responsive" cellpadding="0" cellspacing="0"
																width="100%"
			>
														<td class="full mobile-full-width" width="100%"
					valign="top"
					style="">
				<table class="column" width="100%" cellpadding="0" cellspacing="0" style="margin: 0 auto; text-align: left;">
					<tr>
						<td align="center"
								style="
									padding: 20px 20px 20px 20px;">
								<!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" align="left"><![endif]-->
			<!--[if !mso]><!--><table width="100%" cellpadding="0" cellspacing="0"><!--<![endif]-->
				<tr>
					<td align="left">
						<p style="color: #156ba5;
							font-size: 10px;
							font-family: Arial;line-height: 14px;text-align: center;
							margin: 0;mso-line-height-rule: exactly;"><a style="line-height: 14px; text-align: center; margin: 0px; color: #156ba5; font-size: 10px; font-family: Arial; text-decoration: underline;" href="http://eye.sbc24.net/r/USBSHOW/84/5b588236b95cee1f5b6f7a44/-fRmTd7VQTqVOrG2Rg4OrA/hgifPDBOQRihkcjJ-VlE1w?email=luis@focoestrategico.cl&adm=lponce1405@gmail.com" target="_blank" rel="noopener" data-link-type="unsubscribe"> Cliquez sur ce lien pour vous désabonner </a></p>
					</td>
				</tr>
			</table>
			
						</td>
					</tr>
				</table>
			</td>
			
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td align="center" bgcolor="#FFFFFF" style="padding:10px;"></td></tr></table></body>
			</html>';
			return $ToReturn;
		}
	}
?>