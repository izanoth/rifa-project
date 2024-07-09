<?php
function do_query($query, ...$vars)
{
    $pdo = new PDO("mysql:host=localhost;dbname=rifa", "root", "");
    $consulta = $pdo->prepare($query);
    $consulta->execute();
    $result = $consulta->fetch(PDO::FETCH_OBJ);
    return $result;
}
?>