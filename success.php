<?php

if (isset($_GET['id'])) {
	$id = $_GET['id'];

	$pdo = new PDO("mysql:host=localhost;dbname=rifa-dev", "root", "");
	$query = $pdo->prepare("select clients.name, clients.email, GROUP_CONCAT(tickets.token) as tokens from clients join tickets on clients.id=tickets.clientid where clients.id=$id;");
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_OBJ);

	$name = $result[0]->name;
	$email = $result[0]->email;
	$ticket = explode(',', $result[0]->tokens);

	$query = $pdo->prepare("update clients set paid='stripe' where id=$id");
	$query->execute();	
} else {
	header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta name="title" content="Ivan Cilento aka Zanoth">
	<meta name="description" content="">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Unknown">
	<meta name="keywords" content="" />

	<link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
	<script type="text/javascript" src="js/funcs.js"></script>

	<style>
		body {
			text-align: center;
		}

		.inner {
			padding-top: 30px;
			color: #ffffff
		}

		.inner [type='submit'] {
			background-color: #9f2121;
			border-radius: 5px;
			color: #e9e9e9;
			font-size: 18px;

			padding: 10px;
			transition: 2s background-color, color;
		}

		.inner [type='submit']:hover {
			background-color: #e9e9e9;
			color: #9f2121;
		}

		.inner button {
			background-color: #9f2121;
			border-radius: 15px;
			color: #e9e9e9;
			font-size: 18px;

			padding: 10px;
			transition: 2s background-color, color;
		}

		.inner button:hover {
			background-color: #e9e9e9;
			color: #9f2121;
		}

		.mn {
			font-size: 42px;
			font-family: serif;
			color: #cf5555;
			display: inline-block;
		}

		.jumbotron {
			background-color: #efaaaa
		}

		p.mask {
			background: url(img/mask.png) 0 0 / cover repeat;
			color: #de466c;
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
		}

		.tokbg {
			background-image: url('img/maskbg2.png');
			background-repeat: repeat;
			color: white;
			width: 320px;
			margin: auto;
			text-align: center;
		}

		.tokbg img {
			mix-tokbg-mode: lighten;
		}

		.fix {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
		}
	</style>
</head>

<body>
	<div class="fix">
		<div class="container" style="padding-top:10px;padding-bottom:10px;">
			Nós já lhe enviamos um e-mail de confirmação.
			<div class="inner tokbg"
				style="padding-bottom:10px;text-align:center;margin-bottom:10px;border-radius:30px;">
				<?php
				echo "<table class='' style='color:#000;font-weight:900;width:100%;position:relative;text-align:center;'>
								<tr>
									<td style='font-size:12px;'>Nome: " . html_entity_decode($name) . "</td>
									<td style='font-size:12px;'>Data :" . date('d/m/y') . "</td>
								</tr>
								<tr>
									<td colspan='2' style='padding:10px;font-size:12px;'>Sorteio: 000000001</td>
								<tr>";
				for ($i = 0; $i < count($ticket); $i++) {
					echo "<tr>
		 							<td colspan='2' style='text-align:center;font-size:32px;text-shadow:1px 1px 2px dark;'><p class='mask'>" . $ticket[$i] . "</p></td>
		 						</tr>";
				}
				echo "</table>";
				?>
			</div>

			<div class="container" style="text-align:center;">
				<small>Dúvidas entrar em contato pelo e-mail contato@rifart.com.br </small>
			</div>
			<div class="container">
				<img style="display:block;margin-left:auto;margin-right:auto;" width="auto" height="60px"
					src="img/rifa.png">
			</div>
		</div>
	</div>


	<?php
	require 'vendor/autoload.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	$mail = new PHPMailer(true);

	try {
		// Configurações do servidor SMTP local (MailHog)
		$mail->isSMTP();
		$mail->Host = '127.0.0.1';
		$mail->Port = 25;

		// Outras configurações de e-mail
		$mail->setFrom('contato@rifart.com.br', 'Equipe Rifart');
		$mail->addAddress($email, $name);
		$mail->Subject = "Você está concorrendo na Rifart!";
		$mail->isHTML(true);

		$tickets = "";
		$sorteio = "?";
		for ($i = 0; $i < count($ticket); $i++) {
			$tickets .= "<p>" . $ticket[$i] . "</p>";
		}
		$mail->CharSet = 'UTF-8';

		//toBase64//////////////
		$imagemOriginal = 'img/rifa.png';
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
            <h1>Agradecemos pela sua participação, ' . html_entity_decode($name) . '!</h1>
            <p>Você já está concorrendo e iremos lhe informando!</p>
            <p style="text-align: center;"><b>' . $tickets . '</b></p>
            <p>Esperamos que tenha uma ótima experiência!</p>
            <p>Atenciosamente,</p>
            <div class="signature">
                <img src="data:image/png;base64,' . $imagemBase64 . '" alt="Assinatura da Empresa">
            </div>
        </div>
    </body>
    </html>
';

		$mail->send();
	} catch (Exception $e) {
		echo 'Erro ao enviar e-mail: ', $mail->ErrorInfo;
	}


	?>

</body>

</html>