<?php
require 'vendor/autoload.php';
use Stripe\Stripe;

if (!isset($_GET['payid'])) {
	header('Location: ../index.php');
} else {
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/./');
	$dotenv->load();
	$key = $_ENV['STRIPE_PUB_KEY'];
	\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

	$paymentIntentId = $_GET['payid'];
	$id = $_GET['client'];

	////TREATMENT////*
	$pdo = new PDO("mysql:host=localhost;dbname=rifa-dev", "root", "");
	$query = $pdo->prepare("SELECT * FROM CLIENTS WHERE id=$id");
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);
	$name = html_entity_decode($result->name);
	$amount = $result->amount;

	try {
		$paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
		$client_secret = $paymentIntent->client_secret;
	} catch (\Stripe\Exception\ApiErrorException $e) {
		// Lidar com erros da API do Stripe
		echo 'Erro ao recuperar o Pagamento: ' . $e->getMessage();
	}
}

?>

<!DOCTYPE html>

<head>
	<meta name="title" content="Rifart">
	<meta name="description" content="Sorteios digitais">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="" />
	<meta name="author" content="Unknown">

	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/global.css" />
	<script src="https://js.stripe.com/v3/"></script>

	<style>
		/* Animated form */

		.sr-root {
			animation: 0.4s form-in;
			animation-fill-mode: both;
			animation-timing-function: ease;
		}

		@keyframes form-in {
			0% {
				opacity: 0;
				transform: scale(0.98);
			}

			100% {
				opacity: 1;
				transform: scale(1);
			}
		}
	</style>

</head>
<html>

<body>
	<div id="film" style="width:100%;height:100%;position:fixed">
	</div>
	<div class="sr-root" style="margin: 0 auto">
		<div class="sr-main" style="width:300px;flex-direction: column">
			<div style="display:flex;flex-direction:column">
				<h3>
					<?= $name ?>, bom ter você de volta!
				</h3><br>
				<h5>Efetve a sua participação concluindo o pagamento de R$
					<?= $amount ?>,00 :&#41;
				</h5>
			</div>
			<section class="container">
				<img id="rifalogo" src="../img/rifa.png" width="320" height="auto">
				<form id="payment-form" data-secret="<?= $client_secret ?>">
					<!-- Display a payment form -->
					<div class="payment-element form">
						<label for="cardnum">Número do Cartão de Crédito: </label>
						<div id="cardnum">
						</div>

						<label for="cardexp">Vencimento: </label>
						<div id="cardexp">
						</div>

						<label for="cardcvc">Código de Segurança: </label>
						<div id="cardcvc">
						</div>
						<button id="submit" disabled>
							<div class="spinner hidden" id="spinner"></div>
							<span id="button-text">Pagar agora</span>
						</button>
						<input type="hidden" name="id" value="<?= $id ?>" />
						<!--Input value=id injected by charge.php-->
					</div>
					<div class="payment-message status"></div>
				</form>
				<div style="padding-bottom:23px;position:relative;" class="top">
					<img style="position:absolute;right:0px;vertical-align:bottom" src="img/stripelogo.png">
				</div>
			</section>
			<div id="error-message"></div>
		</div>
	</div>
</body>

</html>

<script type="text/javascript">
	const stripe = Stripe(<?php echo "'" . $key . "'"; ?>);
</script>
<script src="script.js" defer></script>