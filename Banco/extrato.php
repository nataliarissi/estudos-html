<!DOCTYPE html>
<html>
<head>
    <title>Depósito na Conta</title>
</head>
<body>
    <h1>Depósito na Conta</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $valor = floatval($_POST['valor']);
        if ($valor <= 0) {
            echo "O valor do depósito deve ser maior que zero.";
        } else {
            $servidor = 'localhost';
            $usuario = 'root';
            $senha = '';
            $banco_de_dados = 'PIX';

            $conexao = new mysqli($servidor, $usuario, $senha, $banco_de_dados);
            if ($conexao->connect_error) {
                die("Erro na conexão ao banco de dados: " . $conexao->connect_error);
            }

            $conexao->query("UPDATE contas SET saldo = saldo + $valor");

            $conexao->query("INSERT INTO transacoes (tipo, valor, saldo) VALUES ('Depósito', $valor, saldo)");

            $conexao->close();

            echo "Depósito de R$ " . number_format($valor, 2) . " realizado com sucesso.";
        }
    }
    ?>

    <form action="" method="post">
        <label for="valor">Valor do Depósito:</label>
        <input type="text" name="valor" id="valor" required>
        <input type="submit" name="realizar_deposito" value="Realizar Depósito">
    </form>

    <a href="index.php">Voltar para a página inicial</a>
</body>
</html>