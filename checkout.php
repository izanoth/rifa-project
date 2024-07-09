<?php

include('includes/db.php');
include('includes/pdo.php');
include('includes/functions.php');
require('vendor/autoload.php');


if (!isset($_POST['submit'])) {
	header("Location: index.php");
} else {
	//VALIDATING
	require_once('includes/validate.php');
	$name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_ENCODE_HIGH);
	$date = date("Y/m/d h:i:sa");
	$units = filter_var($_POST['units'], FILTER_VALIDATE_INT);
	$cpf = preg_replace("/[^0-9]/", "", $_POST['cpfcnpj']);
	$cpf = filter_var($cpf, FILTER_VALIDATE_INT);
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
	$phone = $_POST['tel'];
	$tmp_array = array("(", ")", "-", " ");
	$phone = str_replace($tmp_array, "", $phone);

	$fail = validateName($name);
	$fail .= validatePhone($phone);
	$fail .= validateEmail($email);
	$fail .= validateCpfCnpj(strval($cpf));

	$amount = $units * 3;

	if (preg_match('/\^/', $fail) == 0) {
		$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/./');
		$dotenv->load();
		$asaas_key = $_ENV['SANDBOX_ASAAS_KEY'];

		try {
			$pdo = new PDO("mysql:host=localhost;dbname=rifa-dev", "root", "");
			$query = "insert into clients (datetime, name, email, cpf, tel, units, amount, paid) values ('$date', '$name', '$email', '$cpf', '$phone', '$units', '$amount', false)";
			$query = $pdo->prepare($query);
			$query->execute();
			$id = $pdo->lastInsertId();
		} catch (PDOException $e) {
			echo 'Erro: ' . $e->getMessage();
		}
		/////INSERTING CLIENT///////
		//GET TICKETS	 		
		for ($i = 0; $i < $units; $i++) {
			$banch = file('tickets.txt', FILE_IGNORE_NEW_LINES);
			if (!empty($banch)) {
				$got = $banch[array_rand($banch)];
				$index_line = array_search($got, $banch);
				unset($banch[$index_line]);
				file_put_contents('tickets.txt', implode(PHP_EOL, $banch));
			}
			//INSERTING TICKETS
			$pdo = new PDO("mysql:host=localhost;dbname=rifa-dev", "root", "");
			$query = "insert into Tickets (token, clientid) values ('$got', '$id')";
			$query = $pdo->prepare($query);
			$query->execute();
			//GET/INSERTING TICKETS
		}
	} else {
		header("Location: index.php?invalid=$fail");
		//echo "<script>window.open('index.php?invalid=$fail', '_self')</script>;";
	}
}

?>

<!DOCTYPE html>

<head>
	<style>
		/********PIX *********/
		.main {
			display: flex;
			flex-direction: row;
			justify-content: space-around;
		}

		.box {
			width: 300px;
			align-self: rigth;
		}

		.container {
			width: 768px;
		}

		.donate-box {
			width: 100%;
			margin: auto;
			border: 0px;
			border-radius: 10px;
			padding: 30px;
			background-color: #eee;
		}

		@media (max-width: 768px) {
			.main {
				flex-direction: column;
				justify-content: center;
			}
		}



		.film {
			display: none;
			width: 100%;
			height: 100%;
			background-color: #000;
			filter: opacity(0.5);
			z-index: 1;
			position: absolute;
			top: 0px;
			left: 0px;
		}

		.startbox {
			display: none;
			flex-direction: column;
			justify-content: center;
			border: 1px;
			border-radius: 10px;
			position: fixed;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			z-index: 2;
			background-color: white;
		}

		.startbox p {
			padding: 20px;
		}

		.fa-times {
			position: absolute;
			top: 20px;
			right: 20px;
			font-size: 50px;
			color: rgb(50, 100, 250);
			cursor: pointer;
		}

		#payload {
			padding: 5px;
			font-size: 18px;
			font-weight: bold;
		}
	</style>

	<script src="js/jquery.3.7.1.js"></script>
	<script src="js/functions.js"></script>
	<!--script src="https://code.jquery.com/jquery-3.6.0.min.js"></script-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

	<meta name="title" content="Rifart">
	<meta name="description" content="Sorteios digitais">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="" />
	<meta name="author" content="Unknown">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/style.css" />

	<script>
		async function gen_pix_qrcode() {
			let response = await fetch('asaas/api.php', {
				method: 'POST',
				headers: {
					'Accept': 'application/json, text/plain, */*',
					"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
				},
				body: JSON.stringify({
					key: '<?php echo $asaas_key ?>',
					client_id: '<?php echo $id ?>',
					name: '<?php echo $name ?>',
					cpf: '<?php echo $cpf ?>',
					phone: '<?php echo $phone ?>',
					value: '<?php echo $amount ?>'
				})
			})
			if (response.status === 200) {
				let data = await response.text();
				data = JSON.parse(data);
				var id = data.id;
				var payload = data.payload;
				var qr = data.qrcode;
				$('#payload').attr('onclick', 'navigator.clipboard.writeText("' + payload + '");copied()');
				$('#qr').html("<img height='200' width='200' src='data:image/png;base64,"+qr+"'/>");
				polling();
			}
		}

		async function polling() {
			let response = await fetch('asaas/polling.php?id='+<?php echo $id; ?>, {
				method: 'GET',
				headers: {
					'Accept': 'application/json, text/plain, */*',
					"Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
				},
			})
			if (response.status === 200) {
				let data = await response.text();
				data = JSON.parse(data);
				if (data.confirmed == true) {
					$('#qr').fadeOut('slow');
					$('#qr').html("<i style='font-size:200px;color:green' class='fa-solid fa-check'></i>").fadeIn('slow');
					setTimeout(window.open('success.php?id='+<?php echo $id; ?>, '_self'), 3000);
				}
				else {
					setTimeout(polling, 3000);
				}
			}
		}

		$(window).ready(function () {
			$('.film').hide();
			$('.showup').on('click', function () {
				$('.startbox').fadeIn(1000).css('display', 'flex').css('justify-content', 'center');
				$('.film').fadeIn('slow');
			});
			$('.fas').on('click', function () {
				$('.startbox').fadeOut(1000);
				$('.film').fadeOut('slow');
			});
		});
		function copied() {
			$('#payload').html('<i class="fa-solid fa-clipboard"></i> Copiado!');
			$('#payload').find('i').attr('class', 'fa-solid fa-clipboard');
		}
	</script>
</head>
<html>

<body>
	<div class="film"><i class="fas fa-times"></i></div>
	<div class="startbox">
		<button id="payload"><i class="fa-solid fa-copy"></i> PIX Copia e Cola</button>
		<div id="qr"></div>
	</div>
	<div class="jumbotron">
		<div class="stripe-head">
			<h2>Falta pouco...</h2>
		</div>
	</div>
	<div class="container">
		<p><b>
				<?= $name ?>
			</b>, para efetivar a sua participação, realize o pagamento de
			R$
			<?= $amount ?>,00 escolhendo um método de pagamento.
		</p>
		<div class="row">
			<div class="col-md-6 inner-dial">
				<div class="custom-btn showup">
					<img onclick="gen_pix_qrcode();"
						style="cursor:pointer;filter:invert(0.7);margin-left:auto;margin-right:auto;display:block;position:relative;left:-18px;"
						src="img/pix.png" height="100" width="auto" />
				</div>
			</div>
			<div class="col-md-6 inner-dial">
				<!--redirect-->
				<div class="custom-btn">
					<form action="stripe/index.php" method="post">
						<input type="hidden" name="id" value="<?php echo $id ?>" />
						<input type="hidden" name="name" value="<?php echo $name ?>" />
						<input type="hidden" name="email" value="<?php echo $email ?>" />
						<input type="hidden" name="tel" value="<?php echo $phone ?>" />
						<input type="hidden" name="units" value="<?php echo $units ?>" />
						<button style="cursor:pointer" type="submit">Pagar com Cartão de Crédito</button>
						<img style="margin-top:5px;margin-left:auto;margin-right:auto;display:block;"
							src="stripe/img/stripesecure.png">
					</form>
				</div>
			</div>
		</div>
	</div>

	</div>
	<div class="footer">
		<div>
			<small>Dúvidas entrar em contato pelo e-mail contato@rifart.com.br</small>
			<img style="display:block;margin-left:auto;margin-right:auto;" height="60px" width="auto"
				src="img/rifa.png">
		</div>
	</div>
</body>

</html>