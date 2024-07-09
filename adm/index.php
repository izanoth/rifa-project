<link rel="stylesheet" href="css/style.css" />
<div class="flex-container">
    <div class="head">
        <h2>Control Panel</h2>
    </div>
    <div class="child-container">
        <form action="" method="post">
            <input type="text" name="adm" />
            <input type="password" name="pass" />
            <button type="submit" name="auth">Acessar</button>
        </form>
    </div>
    <img width="150" height="auto" src="../img/znt24.png">

</div>

<?php
if (isset($_POST['auth'])) {
    require '../stripe/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/./');
    $dotenv->load();
    $hash = $_ENV['ADMIN_KEY'];
    $key_inputted = $_POST['pass'];
    $key = md5($key_inputted);
    var_dump($key == $hash);

    if (($key == $hash) && $_POST['adm'] == 'zanoth') {
        session_start();
        $_SESSION['user'] = 'zanoth';
        header("Location: main.php");
    } else {
        echo "Credenciais inválidas.";
    }
}
?>