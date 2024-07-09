<?php


function get_tickets($id, $units)
{
    for ($i = 0; $i < $units; $i++) {
        $banch = file('tickets.txt', FILE_IGNORE_NEW_LINES);
        if (!empty($banch)) {
            $got = $banch[array_rand($banch)];
            $index_line = array_search($got, $banch);
            unset($banch[$index_line]);
            file_put_contents('tickets.txt', implode(PHP_EOL, $banch));
        }
        //INSERTING TICKETS
        $pdo = new PDO("mysql:host=localhost;dbname=rifa-dev", "root", "");
        $query = "insert into Tickets (token, clientid) values ('$got', '$id')";
        $query = $pdo->prepare($query);
        $query->execute();
        //GET/INSERTING TICKETS
    }
}


?>