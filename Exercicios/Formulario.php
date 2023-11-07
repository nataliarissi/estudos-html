<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
</head>
<body>
    <form method="post" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <input type="submit" value="Enviar">
    </form>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST["nome"];

            echo "<p>Seu nome é: $nome</p>";
        }
    ?>
</body>
</html>