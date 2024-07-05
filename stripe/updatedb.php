<?php
include('../includes/db.php');
header('Content-Type: application/json');
$content = file_get_contents("php://input");
$array = json_decode($content, true);

$pay_id = $array['paymentintent_id'];
$client_id = $array['client_id'];

$query = "update clients set stripe='$pay_id' where id=$client_id";
$run_query = mysqli_query($conn, $query);
$query = "update tickets set done='1' where clientid=$client_id";
$run_query = mysqli_query($conn, $query);

if ($run_query) {
	echo '{"updated":"true"}';
} else {
	echo '{"updated":"false"}';
}
?>