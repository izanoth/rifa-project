<?php
session_start();
if ($_SESSION['user'] != 'zanoth') {
	header('Location: index.php');
}
?>
<style>
	td {
		padding-left: 20px;
	}
</style>
<div class="jumbotron">
	<h1>Control Panel</h1>
</div>



	


<form method="post" action="">
	<input type="text" name="sql-query" />
	<buton onclick="" type="button">Atualizar</button>
</form>

<form action="logout.php" method="post">
	<button type="submit">Encerrar Sessão</button>
</form>

<form method="post">
	<input type="submit" name="del_tickets" />
	<table class="table">
		<thead>
			<th>ID</th>
			<th>Data</th>
			<th>Name</th>
			<th>E-mail</th>
			<th>Phone</th>
			<th>Ticket(s)</th>
			<th>Amount</th>
			<th>Pay ID</th>
			<th>Done</th>
		</thead>
		<tbody>

		<?php
		include('../includes/db.php');
		global $conn;
		$get_clients = "SELECT * from Clients;";
		$run_clients = mysqli_query($conn, $get_clients);

		while ($row = mysqli_fetch_array($run_clients)) {
			$id = $row['id'];
			$date = $row['datetime'];
			$name = $row['name'];
			$email = $row['email'];
			$phone = $row['tel'];
			$units = $row['units'];
			$amount = $row['amount'];
			$payment_id = $row['payment_id'];
			$done = $row['stripe'];



			echo "<tr>
								<td>" . $id . "</td>
								<td>" . $date . "</td>
								<td>" . $name . "</td>
								<td>" . $email . "</td>
                                <td>" . $phone . "</td>
                                <td>";

			$query = "SELECT tickets.token FROM tickets JOIN clients ON tickets.clientid = clients.id WHERE clients.id = $id;";
			$get_tickets = mysqli_query($conn, $query);
			$array = [];
			while ($obj = $get_tickets->fetch_object()) {
				array_push($array, $obj->token);
			}
			$tokens = implode(', ', $array);
								echo $tokens . "</td>";

			echo 				"<td>R$ " . $amount . ",00</td>
								<td>" . $payment_id . "</td>
								<td>" . $done . "</td>
							</tr>";
		}
		?>
		</tbody>
	</table>
</form>

	<?php
	//REINSERTING TICKETS
/*if(isset($_POST['del_tickets'])) {
	   
	   $tickets = $_POST[]	|| form.name	<<<<<<<<<<<<<<<<<<< CHECKBOX ITERATION
	   while() {
		   $fl = fopen('tickets.txt', 'rw');
		   fwrite($fl, $tickets[)
		   fclose($fl);	
	   }
   }*/
	?>