<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Hash de Senha</title>
</head>
<body>
    <h2>Gerar Hash de Senha</h2>

    <?php
    $senha = '';  // Variável para armazenar a senha inserida

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtém a senha do campo de entrada
        $senha = $_POST["senha"];

        // Verifica se a senha não está vazia
        if (!empty($senha)) {
            $hash = md5($senha);
            echo "<p>Hash Gerado: $hash</p>";
            $file = '.env';
            file_put_contents($file, "ADMIN_KEY=$hash" . PHP_EOL, FILE_APPEND);
        } else {
            echo "<p>Por favor, insira uma senha.</p>";
        }
    }
    ?>

    <!-- Formulário para inserir a senha -->
    <form method="post" action="">
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>
        <button type="submit">Gerar Hash</button>
    </form>
</body>
</html>
