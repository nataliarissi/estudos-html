<!DOCTYPE html>
<html>
<head>
    <title>Conta Bancária e PIX</title>
    <style>
        body {
            background-image: url('gir.gif');
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat; 
            padding: 0;
            height: 100vh;
        }

        /* * {
            color: white;
        } */

    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#chave_pix').inputmask("999.999.999-99");

        $('#tipo_chave_pix').change(function () {
            var tipoChave = $(this).val();
            if (tipoChave == 'cpf') {
                $('#chave_pix').inputmask("999.999.999-99");
            } else if (tipoChave == 'celular') {
                $('#chave_pix').inputmask("(99) 99999-9999");
            }
        });

        $('#nova_chave_pix').inputmask("999.999.999-99");

        $('#tipo_chave_favorita').change(function () {
            var tipoChaveFavorita = $(this).val();
            var mascara = tipoChaveFavorita === 'cpf' ? "999.999.999-99" : "(99) 99999-9999";
            $('#chave_favorita').inputmask(mascara);
        });
    });
</script>

</head>
<body>
    <h1>Conta Bancária</h1>

    <?php
    $conta_saldo = 1000.00;
    $chaves_favoritas = array();

    $servidor = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco_de_dados = 'PIX';

    $conexao = new mysqli($servidor, $usuario, $senha, $banco_de_dados);
    if ($conexao->connect_error) {
        die("Erro na conexão ao banco de dados: " . $conexao->connect_error);
    }

    function adicionarTransacao($conexao, $tipo, $valor, $conta_saldo) {
        $conexao->query("INSERT INTO transacoes (tipo, valor, saldo) VALUES ('$tipo', $valor, $conta_saldo)");
    }

    function limparHistorico($conexao) {
        $conexao->query("DELETE FROM transacoes");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['deposito'])) {
            $valor = floatval($_POST['valor']);
            if ($valor <= 0) {
                echo "O valor do depósito deve ser maior que zero.";
            } else {
                $conta_saldo += $valor;
                adicionarTransacao($conexao, 'Depósito', $valor, $conta_saldo);
            }
        } elseif (isset($_POST['retirada'])) {
            $valor = floatval($_POST['valor']);
            if ($valor <= 0) {
                echo "O valor da retirada deve ser maior que zero.";
            } elseif ($valor > $conta_saldo) {
                echo "Saldo insuficiente para realizar a retirada.";
            } else {
                $conta_saldo -= $valor;
                adicionarTransacao($conexao, 'Retirada', $valor, $conta_saldo);
            }
        } elseif (isset($_POST['enviar_pix'])) {
            $valor = floatval($_POST['valor']);
            $chave_pix = $_POST['chave_pix'];

            if ($valor <= 0) {
                echo "O valor do PIX deve ser maior que zero.";
            } elseif ($valor > $conta_saldo) {
                echo "Saldo insuficiente para realizar o PIX.";
            } else {
                if (validaChavePIX($chave_pix)) {
                    $conta_saldo -= $valor;
                    adicionarTransacao($conexao, "PIX para $chave_pix", $valor, $conta_saldo);
                } else {
                    echo "Chave PIX inválida.";
                }
            }
        }} elseif (isset($_POST['cadastrar_chave_pix'])) {
            $nova_chave_pix = $_POST['nova_chave_pix'];
            $tipo_chave_pix = $_POST['tipo_chave_pix'];
        
            if (empty($nova_chave_pix) || empty($tipo_chave_pix)) {
                echo "Por favor, preencha todos os campos.";
            } else {
                if ($tipo_chave_pix == 'cpf' && !validaCPF($nova_chave_pix)) {
                    echo "CPF inválido.";
                } elseif ($tipo_chave_pix == 'celular' && !validaTelefone($nova_chave_pix)) {
                    echo "Número de celular inválido.";
                } elseif ($tipo_chave_pix == 'email' && !filter_var($nova_chave_pix, FILTER_VALIDATE_EMAIL)) {
                    echo "E-mail inválido.";
                } else {
                    $conexao->query("INSERT INTO chaves_pix (chave, tipo_chave) VALUES ('$nova_chave_pix', '$tipo_chave_pix')");
                    echo "Chave PIX cadastrada com sucesso.";
                }
            }
        }   

        $chaves_pix = array(); 

        $result_chaves_pix = $conexao->query("SELECT chave FROM chaves_pix");
        
        if ($result_chaves_pix->num_rows > 0) {
            while ($row = $result_chaves_pix->fetch_assoc()) {
                $chaves_pix[] = $row["chave"];
            }
        }

        if (isset($_POST['adicionar_favorito'])) {
            $chave_favorita = $_POST['chave_favorita'];
            if (!in_array($chave_favorita, $chaves_favoritas)) {
                $chaves_favoritas[] = $chave_favorita;
                echo "Chave PIX adicionada aos favoritos.";
            }
        }

        if (isset($_POST['remover_favorito'])) {
            $chave_favorita = $_POST['chave_favorita'];
            if (($key = array_search($chave_favorita, $chaves_favoritas)) !== false) {
                unset($chaves_favoritas[$key]);
                echo "Chave PIX removida dos favoritos.";
            }
        }
        
        if (isset($_POST['limpar_historico'])) {
            limparHistorico($conexao);
            echo "Histórico de transações foi limpo.";
        }

    function validaChavePIX($chave_pix) {
        return true; 
    }

    $transacoes = array();
    $result_transacoes = $conexao->query("SELECT * FROM transacoes");

    if ($result_transacoes->num_rows > 0) {
        while ($row = $result_transacoes->fetch_assoc()) {
            $transacoes[] = ["tipo" => $row["tipo"], "valor" => $row["valor"], "saldo" => $row["saldo"]];
        }
    }

    $conexao->close();
    ?>

    <h2>Saldo Atual: R$ <?php echo number_format($conta_saldo, 2); ?></h2>

    <h3>Transações:</h3>
    <table>
        <tr>
            <th>Tipo de Transação</th>
            <th>Valor</th>
            <th>Saldo Atual</th>
        </tr>
        <?php
        foreach ($transacoes as $transacao) {
            echo "<tr>";
            echo "<td>{$transacao['tipo']}</td>";
            echo "<td>R$ " . number_format($transacao['valor'], 2) . "</td>";
            echo "<td>R$ " . number_format($transacao['saldo'], 2) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <form action="" method="post">
        <label for="valor">Valor:</label>
        <input type="text" name="valor" id="valor" required>
        <input type="submit" name="deposito" value="Depositar">
        <input type="submit" name="retirada" value="Retirar">
    </form>

    <h1>Módulo PIX</h1>

    <form action="" method="post">
        <label for="valor_pix">Valor PIX:</label>
        <input type="text" name="valor" id="valor_pix" required>

        <label for="tipo_chave_pix">Tipo de Chave PIX:</label>
        <select name="tipo_chave_pix" id="tipo_chave_pix">
            <option value="cpf">CPF</option>
            <option value="celular">Número de Celular</option>
        </select>

        <label for="chave_pix">Chave PIX:</label>
        <input type="text" name="chave_pix" id="chave_pix" required>

        <input type="submit" name="enviar_pix" value="Enviar PIX">
    </form>

    <h3>Chaves PIX Cadastradas:</h3>
    <ul>
        <?php
        foreach ($chaves_pix as $chave) {
            echo "<li>$chave</li>";
        }
        ?>
    </ul>

    <h3>Chaves PIX Favoritas:</h3>
    <ul>
        <?php
        foreach ($chaves_favoritas as $chave_favorita) {
            echo "<li>$chave_favorita</li>";
        }
        ?>
    </ul>

    <form action="" method="post">
    <label for="chave_favorita">Chave PIX:</label>
    <input type="text" name="chave_favorita" id="chave_favorita" required>

    <label for="tipo_chave_favorita">Tipo de Chave PIX:</label>
    <select name="tipo_chave_favorita" id="tipo_chave_favorita">
        <option value="cpf">CPF</option>
        <option value="celular">Número de Celular</option>
    </select>

    <input type="submit" name="adicionar_favorito" value="Adicionar aos Favoritos">
    <input type="submit" name="remover_favorito" value="Remover dos Favoritos">
</form>

    <form action="" method="post">
        <input type="submit" name="limpar_historico" value="Limpar Histórico">
    </form>
</body>
</html>