<?php
include('includes/db.php');
include('includes/pdo.php');
?>

<!DOCTYPE html>
<html>

<meta name="title" content="Rifart">
<meta name="description" content="Sorteios digitais">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="" />
<meta name="author" content="Unknown">

<head>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/style.css" />

	<script type="text/javascript" src="js/validate.js"></script>
	<script type="text/javascript" src="js/dropup1.1.js"></script>
	<script type="text/javascript" src="js/funcs.js"></script>
	<script type="text/javascript" src="js/jquery.3.7.1.js"></script>
	<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
	<script src="https://unpkg.com/imask@6.4.2/dist/imask.js"></script>
	<script>
		window.onload = function () {
			var element = document.getElementById('tel');
			var phone_mask = IMask(element, {
				mask: '(00) 00000-0000'
			});
		}

		function calc(param) {
			var result = param.value * 4;
			var box = document.getElementById('result');
			box.innerHTML = "R$ <strong style='font-size:28px;'>" + result.toString() + "</strong>, ";
			console.log(result.toString());
		}

		$(window).ready(function () {
			$('.show-prod').hide();
			$('#prod').on('click', function () {
				$('.show-prod').fadeIn(1000);
			});
			$('.close-x').on('click', function () {
				$('.show-prod').fadeOut(1000);
			});
		});
	</script>
</head>

<body>
	<header>
		<div class="container-fluid">
			<div id="header" class="container">
				<div class="row">
					<div class="col-md-6">
						<img id="rifalogo" src="img/rifa.png">
					</div>
					<?php
					$start = new DateTime();
					$end = new DateTime('08/04/2024 00:00:00');
					$diff = $end->diff($start);
					$days = $diff->days;
					?>
					<div class="col-md-6">
						<div class="aside">
							<small>Encerramento do sorteio em</small>
							<b>
								<?= $days; ?>
							</b>
							<small>
								<?php if ($days == 1) {
									echo "dia";
								} else {
									echo "dias";
								} ?>
							</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<section>
		<div class="container">
			<div class="container inner adv">
				<div class="row">
					<div class="col-md-12">
						<h3>Você estará concorrendo a um <a href="https://www.samsung.com/br/computers/samsung-book/galaxy-book2-15inch-i5-8gb-256gb-np550xed-kf4br/" target="_blank"><img src="img/galaxybook2.png" height="35" width="auto"></a></h3>
					</div>
				</div>
			</div>
		</div>
		<div id="main" class="container">
			<form method="post" action="stripe/index.php">
				<div class="container inner" style="border:1px;border-color:blue;">
					<div class="row" style="position:relative">
						<div class="col-md-4">
							<h3>Nome</h3>
						</div>
						<div class="col-md-8">
							<label class="lbl-inp" for="name" id="label-name"></label>
							<input type="text" id="name" name="name"
								style="width:100%;border:0px;background-color:#9f2121;color:#ebebeb;" />
						</div>
					</div>
				</div>
				<div class="container inner" style="border:1px;border-color:blue;">
					<div class="row" style="position:relative">
						<div class="col-md-4">
							<h3>E-mail</h3>
						</div>
						<div class="col-md-8">
							<label class="lbl-inp" for="email" id="label-email"></label>
							<input type="text" id="email" name="email"
								style="width:100%;border:0px;background-color:#9f2121;color:#ebebeb;" />
						</div>
					</div>
				</div>
				<div class="container inner" style="border:1px;border-color:blue;">
					<div class="row" style="position:relative">
						<div class="col-md-4">
							<h3>Celular</h3>
						</div>
						<div class="col-md-8">
							<label class="lbl-inp" for="tel" id="label-tel"></label>
							<input type="text" name="tel" id="tel"
								style="width:100%;border:0px;background-color:#9f2121;color:#ebebeb;" value="" />
						</div>
					</div>
				</div>
				<div class="container inner" style="border:3px;border-color:blue;">
					<div class="row">
						<div class="col-md-4">
							<h3>Unidades</h3>
						</div>
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-6">
									<input type="number" value="1" size="10" maxlength="5" min="1" name="units"
										style="border:0px;background-color:#9f2121;color:#ebebeb;"
										onchange="calc(this)" />
								</div>
								<div class="col-md-6" style="text-align:center;">
									<table style="text-align:center;width:100%;">
										<tr>
											<td>
												<span id="result">R$ <strong style="font-size:26px;">4
													</strong>,</span><span><small>00</small></span>
											</td>
											<td>
												<table id="card-flags" style="width:100%;" border="0">
													<tr>
														<td>
															<img style="display:block;margin-left: auto; margin-right: auto;;"
																height="35px" src="img/mastec.png">
														</td>
														<td>
															<img style="display:block;margin-left: auto; margin-right: auto;;"
																height="35px" src="img/visa.png">
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container inner rules" style="padding-bottom:30px;border:3px;border-color:blue;">
					<small>Leia as </small><button id="btn-rules" onclick="infoup('includes/rules.html')"
						type="button">Regras
						Gerais
						da Rifa</button>
					<input type="submit" name="submit" value="Participar" style="width:100%;" />
				</div>
			</form>
		</div>
	</section>
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-6 foot-left">
					<div class="reg">
						Rifart.com.br &reg 2022
					</div>
				</div>
				<div class="col-md-6 foot-right">
					<div class="by">
						<small id="by">Desenvolvido por</small>
						<img src="img/znt1.png" width="auto" height="15px;">
						<small id="cnpj" style="font-size:8px;">46.118.941/0001-25</small>
					</div>
				</div>
			</div>
		</div>
	</footer>
</body>

</html>

<?php
if (isset($_GET['invalid'])) {

	$frags = explode('*', $_GET['invalid']);
	$count = count($frags);

	for ($x = 0; $x < $count - 1; $x++) {

		if (preg_match('[-okcp8RY5Mc58]', $frags[$x]) != 0) {
			$part = explode('-okcp8RY5Mc58', $frags[$x]);
			$input = $part[0];
			$input_id = $part[1];
			echo "<script>
              document.getElementById('$input_id').setAttribute('value', '$input');
            </script>";
		} else {
			$part = explode('^', $frags[$x]);
			$id = $part[0];
			$msg_rtn = $part[1];


			echo
				"<script>
        			var input = document.getElementById('$id');
        			var stl = input.getAttribute('style');
        			input.setAttribute('style', stl+'border:2px solid red;');

        			var label = document.getElementById('label-$id');
        			label.innerHTML = '$msg_rtn';
        		</script>";
		}
	}
}
?>