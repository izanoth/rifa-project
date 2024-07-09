<?php
session_start();
if ($_SESSION['user'] != 'zanoth') {
    header('Location: index.php');
}
?>



<style>
    body {
        font-family: sans-serif;
    }

    .container {
        height: 100%;
    }

    .flex-container {
        background-color: #ccc;
        height: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
    }

    .child-container {
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        align-items: left;
    }

    .child-container input {
        width: 100%;
        height: 50%;

    }

    input {
        display: block;
    }

    button {
        width: 100%;
        padding: 20px;
        font-size: 20px;
    }

    .panel {
        border: 2px;
        border-color: #000;
        padding: 10px;
    }
</style>
<?php
$pdo = new PDO("mysql:host=localhost;dbname=rifa-dev", "root", "");
$curr_date = new DateTime();
?>


<div class="container">
    <h1>Painel de Controle</h1>
    <img src="../img/znt24.png" style="position:absolute;right:10px;top:10px;">
    <div class="flex-container">
        <div class="child-container">
            <div class="panel">
                <div>
                    <?php
                    include('../includes/db.php');

                    $query = mysqli_query($conn, "SELECT * FROM clients");

                    $clients = mysqli_num_rows($query);
                    echo $clients;
                    ?>

                    cadastros
                </div>
                <div>
                    <?php

                    $query = mysqli_query($conn, "SELECT * FROM clients WHERE stripe=1");
                    $well_succed = mysqli_num_rows($query);
                    echo $well_succed;
                    ?>
                    ordens bem sucedidas
                </div>
            </div>
            <div>
                <?php

                $query = mysqli_query($conn, "select * from Clients where stripe=0");
                $pendent_clients = mysqli_fetch_array($query);
                echo mysqli_num_rows($query);
                $query = mysqli_query($conn, "select datetime from Clients where stripe=0");
                $datetime = mysqli_fetch_row($query);
                ?>
                clients não efetivaram a participação.
            </div>
            <div>
                <?php
                $count = 0;
                /*foreach ($datetime as $index => $value) {
                    $date = DateTime::createFromFormat("Y-m-d H:i:s", $datetime[$index]);
                    $diff = $curr_date->diff($date);
                    $days = $diff->days;

                    if ($days < 7) {
                        ++$count;
                    }
                }
                echo $count*/
                    ?>
                deles ainda a tempo de participar.
            </div>
            <script>
                function confirm_invite() {
                    var choice = prompt("Tem certeza de que deseja enviar os e-mails? (Y or N)");
                    if (choice == 's' || choice == 'Y') {
                        /*fetch('resources/invite.php')
                                .then(response => {
                                    // Verificando se a requisição foi bem-sucedida (status 200-299)
                                    if (!response.ok) {
                                        throw new Error('Erro na requisição: ' + response.statusText);
                                    }
                                    // Parseando a resposta como JSON
                                    return response.json();
                                })
                                .then(data => {
                                    // Manipulando os dados recebidos
                                    console.log('Dados recebidos:', data);
                                })
                                .catch(error => {
                                    // Lidando com erros
                                    console.error('Erro na requisição:', error);
                                });
                        }*/


                        async function invite() {
                            let response = await fetch('resources/invite.php', {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json, text/plain, */*',
                                    "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8"
                                }
                            });
                            if (response.status === 200) {
                                let data = await response.text();
                                var arr = data.split('!');
                                alert(arr[0]);
                            }
                        }
                        invite();
                    }
                }


            </script>
            <button onclick="confirm_invite()" href="">Reconvidar</button>
        </div>


        <div class="child-container">
            Último convite em
            <!--php
                
            
            ?-->

        </div>


        <div class="child-container">
            <a href="control.php" style="">Acessar dados</a>

        </div>
        <div class="child-container">

            <a href="sorteio.php">Sortear</a>
        </div>
    </div>
</div>
<form action="logout.php" method="post">
    <button type="submit">Encerrar Sessão</button>
</form>