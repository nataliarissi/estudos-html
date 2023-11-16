<?php
$servidor = 'localhost';
$usuario = 'root';
$senha = '';
$banco_de_dados = 'caixa';

function conectarBanco() {
    global $servidor, $usuario, $senha, $banco_de_dados;
    $conexao = new mysqli($servidor, $usuario, $senha, $banco_de_dados);
    if ($conexao->connect_error) {
        die("Erro na conexão ao banco de dados: " . $conexao->connect_error);
    }
    return $conexao;
}

function criarBancoETabela() {
    $conexao = conectarBanco();
    $conexao->query("CREATE DATABASE IF NOT EXISTS $banco_de_dados;");
    $conexao->select_db($banco_de_dados);
    $conexao->query("CREATE TABLE IF NOT EXISTS item (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nome VARCHAR(255) NOT NULL,
                    preco DECIMAL(10, 2) NOT NULL,
                    quantidade INT NOT NULL DEFAULT 1);"
    );
    $conexao->close();
}

criarBancoETabela();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $items = $data['items'];
    $totalAmount = $data['totalAmount'];

    $conexao = conectarBanco();

    foreach ($items as $item) {
        $nome = $conexao->real_escape_string($item['nome']);
        $preco = $item['preco'];
        $quantidade = $item['quantidade'];

        $stmt = $conexao->prepare("INSERT INTO item (nome, preco, quantidade) VALUES (?, ?, ?)");
        $stmt->bind_param("sdi", $nome, $preco, $quantidade);

        if ($stmt->execute() !== TRUE) {
            echo json_encode(['error' => 'Erro ao inserir item no banco de dados.']);
            exit();
        }

        $stmt->close();
    }

    echo json_encode(['message' => 'Compra finalizada com sucesso!', 'totalAmount' => $totalAmount]);

    $conexao->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    obterDadosRelatorio();
} else {
    echo json_encode(['error' => 'Método não permitido.']);
}

function obterDadosRelatorio() {

    global $servidor, $usuario, $senha, $banco_de_dados;

    $conn = new mysqli($servidor, $usuario, $senha, $banco_de_dados);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT nome, preco, quantidade FROM item";
    $result = $conn->query($sql);

    $reportItems = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reportItems[] = array(
                'nome' => $row['nome'],
                'preco' => $row['preco'],
                'quantidade' => $row['quantidade']
            );
        }
    }

    $reportTotalAmount = array_reduce($reportItems, function ($carry, $item) {
        return $carry + ($item['preco'] * $item['quantidade']);
    }, 0);

    $reportData = array(
        'reportItems' => $reportItems,
        'reportTotalAmount' => $reportTotalAmount
    );

    $conn->close();

    echo $_GET['callback'] . '(' . json_encode($reportData) . ')';
}
?>