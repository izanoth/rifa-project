<?php
include('../includes/pdo.php');
header('Content-Type: application/json');
$content = file_get_contents("php://input");
$query = json_decode($content, true);
echo $query;

/*$pdo = new PDO("mysql:host=localhost;dbname=rifa", "root", "");
$query = $pdo->prepare($query->query);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);

echo $result;



/*$id = $row['id'];
$date = $row['datetime'];
$name = $row['name'];
$email = $row['email'];
$phone = $row['tel'];
$query = "SELECT tickets.token FROM tickets JOIN clients ON tickets.clientid = clients.id WHERE clients.id = $id;";
			$get_tickets = mysqli_query($conn, $query);
			$array = [];
			while ($obj = $get_tickets->fetch_object()) {
				array_push($array, $obj->token);
			}
			$tokens = implode(', ', $array);
$tickets = $tokens;
//$units = $row['units'];
$payment_id = $row['stripe'];



if ($run_query) {
	echo '{"updated":"true"}';
} else {
	echo '{"updated":"false"}';
}*/
?>