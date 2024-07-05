<?php

include('includes/db.php');
require_once('includes/validate.php');

if (isset($_POST['submit'])) {
	//VALIDATING
	require_once('includes/validate.php');
	$name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$input_name = $name;

	$date = date("Y/m/d h:i:sa");
	$units = filter_var($_POST['units'], FILTER_VALIDATE_INT);
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
	$tel = $_POST['tel'];
	$tmp_array = array("(", ")", "-", " ");
	$tel = str_replace($tmp_array, "", $tel);

	$fail = validateName($name);
	$fail .= validatePhone($tel);
	$fail .= validateEmail($email);


	if (preg_match('/\^/', $fail) == 0) {
		$sl = "select * from Clients where NAME LIKE '$name%'";
		$qry = mysqli_query($conn, $sl);

		//TO INSERT TICKET IN RIGHT ID
		if ($name != "") {
			if ($qry) {
				$tmp_ct = mysqli_num_rows($qry);
				$name = $name . ' ' . str_repeat(explode(' ', $name)[0] . ' ', $tmp_ct);
			}
		}
		/////////////////// 

		$in = "insert into clients (datetime, name, email, tel, units, stripe) values ('$date', '$name', '$email', '$tel', '$units', false)";
		$insert = mysqli_query($conn, $in);
		$client = mysqli_query($conn, "select * from Clients where name='$name'");
		$id = mysqli_fetch_array($client)['id'];

		//GET TICKETS	 		
		for ($i = 0; $i < $units; $i++) {
			$banch = file('tickets.txt', FILE_IGNORE_NEW_LINES);

			if(!empty($banch)) {
				$got = $banch[array_rand($banch)];
				$index_line = array_search($got, $banch);
				unset($banch[$index_line]);
				file_put_contents('tickets.txt', implode(PHP_EOL, $banch));
			}
			//INSERTING
			$in = "insert into Tickets (token, clientid, done) values ('$got', '$id', false)";
			$insert = mysqli_query($conn, $in);
		}
	} else {
		echo "<script>window.open('index.php?invalid=$fail', '_self')</script>;";
	}
} else {
	echo "<script>window.open('index.php', '_self')</script>;";
}

?>

<script type="text/javascript">
	<?php echo "var am = " . $units * 200; ?>
</script>
<html>

<meta name="title" content="Ivan Cilento aka Zanoth">
<meta name="description" content="">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="keywords" content="" />

<head>

	<script type="text/javascript" src="js/dropup1.1.js"></script>
	<!--script type="text/javascript" src="js/load.js"></script-->
	<script type="text/javascript" src="js/funcs.js"></script>
	<!--script type="text/javascript" src="bootstrap/js/bootstrap.js"></script-->
	<!--STRIPE-->
	<script src="https://js.stripe.com/v3/"></script>
</head>

<body>
	<div class="jumbotron">
		<div class="container inner">
			<h2>Falta pouco...</h2>
		</div>
	</div>
	<div class="bx">
		<div class="container">
			<?php echo $input_name . ","; ?><br>
			Para efetivar a sua participação, efetue o pagamento de R$ <b>
				<?php echo $units * 2; ?>
			</b><small> ,00</small> com cartão de crédito.
		</div>
		<!--redirect-->
		<div class="container">
			<div class="stripe">
				<form action="stripe/index.php" method="post">
					<input type="hidden" name="id" value="<?php echo $id ?>" />
					<input type="hidden" name="name" value="<?php echo $name ?>" />
					<input type="hidden" name="email" value="<?php echo $email ?>" />
					<input type="hidden" name="tel" value="<?php echo $tel ?>" />
					<input type="hidden" name="units" value="<?php echo $units ?>" />
					<button type="submit">Pagar com Cartão de Crédito</button>
					<img style="margin-top:5px;margin-left:auto;margin-right:auto;display:block;"
						src="stripe/img/stripesecure.png">
				</form>
			</div>
		</div>
		<div class="container">
			Você estará incentivando o meu tabalho.
			<br>Obrigado,<br>
			<img src="img/znt1.png" height="14px;" style="margin-top:5px;" width="auto">
		</div>
		<div class="container foot" style="text-align:center;">
			<small>
				<!--Qualquer ticket será validado somente após a efetivação do pagamento.<br-->
				Dúvidas entrar em contato pelo número +xxx</small>
			<img style="display:block;margin-left:auto;margin-right:auto;" height="60px" width="auto"
				src="img/rifa.png">
		</div>
	</div>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.css" />
	<link rel="stylesheet" href="css/style.css" />
</body>

</html>