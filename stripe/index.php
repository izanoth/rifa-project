<?php
require 'vendor/autoload.php';
use Stripe\Stripe;

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$units = $_POST['units'];

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/./');
$dotenv->load();

$key = $_ENV['STRIPE_PUB_KEY'];

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

$intent = \Stripe\PaymentIntent::create([
	'amount' => $units * 200,
	'currency' => 'brl',
	'capture_method' => 'automatic',
	'receipt_email' => $email,
	'description' => 'Rifart',
	//'metadata' => ['integration_check' => 'accept_a_payment'],
]);

?>

<!DOCTYPE html>

<head>
	<link rel="stylesheet" href="css/normalize.css" />
	<link rel="stylesheet" href="css/global.css" />
	<script src="https://js.stripe.com/v3/"></script>

</head>
<html>

<body>
	<div id="bk" style="width:100%;height:100%;position:fixed">
	</div>
	<div class="sr-root">
		<div class="sr-main">
			<section class="container">
				<img id="rifalogo" src="../img/rifa.png" width="320" height="auto">
				<form id="payment-form" data-secret="<?= $intent->client_secret ?>">
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
						<input type="hidden" name="id" value="<?php echo $id ?>" />
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