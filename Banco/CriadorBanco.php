<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $servidor = 'localhost';
        $usuario = 'root';
        $senha = '';
        $banco_de_dados = 'mysql';

        $conexao = new mysqli($servidor, $usuario, $senha, $banco_de_dados);
        if ($conexao->connect_error) {
            die("Erro na conexão ao banco de dados: " . $conexao->connect_error);
            echo "Erro";
        }
        $conexao->query("CREATE DATABASE PIX;");
        $conexao->select_db("PIX");
        $conexao->query("CREATE TABLE transacoes (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        tipo VARCHAR(255) NOT NULL,
                        valor DECIMAL(10, 2) NOT NULL,
                        saldo DECIMAL(10, 2) NOT NULL,
                        data DATETIME NOT NULL);"
                        );
        $conexao->query("CREATE TABLE chaves_pix (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        chave VARCHAR(255) NOT NULL);"
        );
    ?>
    <h1>Banco criado com sucesso</h1>
</body>
</html>