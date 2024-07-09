<?php
session_start();
if ($_SESSION['user'] != 'zanoth') {
	header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>

<head>

	<meta name="title" content="Zanoth">
	<meta name="description" content="">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Unknown">
	<meta name="keywords" content="" />

	<style src="css/bootstrap.css"></style>

	<?php
	include('../includes/db.php');

	//GETTING WINNER
	$pdo = new PDO("mysql:host=localhost;dbname=rifa-dev", "root", "");
	$query = $pdo->prepare("SELECT tickets.token, clients.name, clients.tel
			 FROM tickets
			 JOIN clients ON tickets.clientid = clients.id
			 ORDER BY RAND()
			 LIMIT 1;
			 ");
	$query->execute();
	$result = $query->fetch(PDO::FETCH_OBJ);

	$ticket = $result->token;
	$name = $result->name;
	$tel = $result->tel;

	/*if (preg_match('/\s$/', $name)>0) {
								$name = substr($name, 0, strlen($name)-2);			
							}*/
	echo "<script>
		  	var ticket = '" . $ticket . "';
		  	var nam = '" . $name . "';
		  	var tel = '" . $tel . "';
		</script>";
	?>
	<script>
		function sort(name, tel) {

			var box = document.getElementsByClassName('box')[0];
			var spn = document.getElementsByClassName('spn')[0];
			var i = 0;

			function explines() {
				var incopc = 0;
				/*var spn = document.createElement('div');
				spn.setAttribute('style', 'filter:opacity(0)');
				var box = document.getElementById('box');*/
				box.innerHTML = "<b style='font-size:28px'>" + ticket + "</b>";
				spn.innerHTML = nam + "<br>" + tel;

				function cgnopc_inv() {
					spn.setAttribute('style', 'filter:opacity(' + 0.1 * incopc + ')');
					if (incopc != 0) {
						setTimeout(cgnopc_inv, 100); incopc--;
					}
				}
				function cgnopc() {
					spn.setAttribute('style', 'filter:opacity(' + 0.1 * incopc + ')');
					if (incopc != 10) {
						setTimeout(cgnopc, 100); incopc++;
					}
					//else {
					//	setTimeout(cgnopc_inv, 2000);
					//}
				}
				cgnopc();
			}

			function gear() {
				var number = parseInt(Math.random() * 1000000);
				box.innerHTML = number;
				i++;
				if (i < 100) {
					setTimeout(gear, 10);
				}
				else {
					explines();
				}
			}
			gear();
		}	
	</script>
	<style>
		.flex-container {
			background-color: rgb(250, 222, 222);
			background-color: dark;
			height: 300px;
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			align-self: center;
		}

		.child-container {
			display: flex;
			align-self: center;
			align-items: center;
			justify-content: center;
		}

		.btn {
			background-color: #9f2121;
			border-radius: 5px;
			color: rgb(250, 200, 200);
			font-size: 18px;
			padding: 10px;
			width: 100px;
		}
	</style>
</head>


<body>
	<div class="flex-container">
		<img src="../img/rifa.png" style="margin-top:0px;" width="100px">
		<p class="box" style="">
		</p>
		<p class="spn" style="">
		</p>
		<input class="btn" type="button" style="margin-bottom:10px;" onclick="sort(nam, tel)" name="sort" value="Sort" />
	</div>
</body>