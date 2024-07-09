<?php
session_start();
if ($_SESSION['user'] != 'zanoth') {
	header('Location: ../index.php');
}

require '../../stripe/phpmailer/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$curr_date = new DateTime();
	////////CLIENT DATA////////
	$pdo = new PDO("mysql:host=localhost;dbname=rifa-dev", "root", "");
	$query = $pdo->prepare("select * from Clients where stripe=0");
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $index => $values) {
		$email = $result[$index]['email'];
		$name = $result[$index]['name'];
		$id = $result[$index]['id'];
		$PaymentIntentId = $result[$index]['payment_id'];

		$mail = new PHPMailer(true);

		try {
			// Configurações do servidor SMTP local (MailHog)
			$mail->isSMTP();
			$mail->Host = '127.0.0.1';
			$mail->Port = 25;

			// Outras configurações de e-mail
			$mail->setFrom('contato@rifart.com.br', 'Equipe Rifart');
			$mail->addAddress($email, $name);
			$mail->Subject = "Ainda dá tempo de participar da Rifa!";
			$mail->isHTML(true);

			$tickets = "";
			$sorteio = "?";

			$mail->CharSet = 'UTF-8';

			//toBase64//////////////
			$imagemOriginal = '../../img/rifa.png';
			$novaLargura = 100;
			$novaAltura = 58;
			list($larguraOriginal, $alturaOriginal) = getimagesize($imagemOriginal);
			$ratio = $larguraOriginal / $alturaOriginal;
			$novaImagem = imagecreatetruecolor($novaLargura, $novaAltura);
			$imagemOriginal = imagecreatefrompng($imagemOriginal);
			imagecopyresampled($novaImagem, $imagemOriginal, 0, 0, 0, 0, $novaLargura, $novaAltura, $larguraOriginal, $alturaOriginal);
			imagefilter($novaImagem, IMG_FILTER_NEGATE);
			ob_start();
			imagepng($novaImagem);
			$imagemBase64 = base64_encode(ob_get_clean());
			/////////////////////
			$mail->Body = '
		<html>
		<head>
			<style>
				body {
					font-family: Arial, sans-serif;
					background-color: #990000; /* Matiz vermelha mais escura para o plano de fundo */
					color: #ffffff; /* Texto em branco */
					padding: 20px;
				}

				.container {
					max-width: 600px;
					margin: 0 auto;
				}

				h1 {
					color: #ff3333; /* Matiz vermelha mais clara para o título */
				}

				p {
					font-size: 18px;
				}

				.signature img {
					max-width: 100%;
				}
			</style>
		</head>
		<body>
			<div class="container">
				<h1>Olá, ' . html_entity_decode($name) . '!</h1>
				<p>Notamos que você realizou o cadastro, mas ainda não efetivou a sua participação!</p>
				<p>Você pode concluir o pagamento e participar do sorteio, acessando <a href="../../stripe/retrieve.php?payid='.$PaymentIntentId.'&client='.$id.'">esse link</a></b></p>
				<p>Esperamos que tenha uma ótima experiência!</p>
				<p>Atenciosamente,</p>
				<div class="signature">
					<img src="data:image/png;base64,' . $imagemBase64 . '" alt="Assinatura da Empresa">
				</div>
			</div>
		</body>
		</html>';

		$mail->send();
		//file_put_contents('../.invites', $curr_date, PHP_EOL, FILE_APPEND);

		echo "E-mails enviados com sucesso! ";
		} catch (Exception $e) {
			echo 'Erro ao enviar e-mail: ', $mail->ErrorInfo;
		}

}
	

	

?>