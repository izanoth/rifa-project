<?php

include('includes/db.php');
global $conn;  
/*$get_tickets = mysqli_query($conn, $query);
var_dump(do_query($query));
var_dump(mysqli_query($conn, $query));*/


$pdo = new PDO("mysql:host=localhost;dbname=rifa-dev", "root", "");
/*$query = $pdo->prepare("SELECT tickets.token, clients.name, clients.tel
FROM tickets
JOIN clients ON tickets.clientid = clients.id
ORDER BY RAND()
LIMIT 1;
");*/
$date = date("Y/m/d h:i:sa");
$nome = "José Aguiar";
$email = "jose@aguiar.com";
$tel = "11111111111";
$units = 2;
$pay_id = "pi_IASJHDiahsdihasd";
$amount = 4;
$stripe = false;

$stmt = $pdo->prepare("INSERT INTO clients (datetime, name, email, tel, units, payment_id, amount, stripe) VALUES (:date, :nome, :email, :tel, :units, :payment_id, :amount, :stripe)");
$stmt->bindParam(':date', $date);
$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':tel', $tel);
$stmt->bindParam(':units', $units);
$stmt->bindParam(':payment_id', $pay_id);
$stmt->bindParam(':amount', $amount);
$stmt->bindParam(':stripe', $stripe);
var_dump($stmt);
$result = $stmt->fetch(PDO::FETCH_OBJ);
var_dump($result);
$stmt->execute();

   
//$result = $query->fetch(PDO::FETCH_OBJ);


//var_dump(($result));






