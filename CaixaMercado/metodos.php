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

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST["itensCadastrados"])) {
            $itensCadastrados = $_POST["itensCadastrados"];
            $itensCadastradosArray = json_decode($itensCadastrados);

            if (isset($itensCadastradosArray) && count($itensCadastradosArray) > 0) {

                $conexao = conectarBanco();

                foreach ($itensCadastradosArray as $item) {
                    $nome = $item->nome;
                    $preco = $item->preco;
                    $quantidade = $item->quantidade;
            
                    $stmt = $conexao->prepare("INSERT INTO item (nome, preco, quantidade) VALUES (?, ?, ?)");
                    $stmt->bind_param("sdi", $nome, $preco, $quantidade);
            
                    if ($stmt->execute() !== TRUE) {
                        echo json_encode(['error' => 'Erro ao inserir item no banco de dados.']);
                        exit();
                    }
            
                    $stmt->close();
                    echo "Itens inseridos com sucesso";
                }
            }
        }
        if (isset($_POST["relatorioSolicitado"])){
            $conexao = conectarBanco();
            $sql = "SELECT nome, preco, quantidade FROM item";
            $result = $conexao->query($sql);

            if ($result->num_rows > 0) {
                $dados = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                echo "Nenhum resultado encontrado.";
            }
            $html = " 
                <h2>Relatório de Compras</h2>
                <br/>
                <ul>
                ";
            foreach ($dados as $item) {
                $html .= '<li>';
                $html .= 'Nome: ';
                $html .= $item["nome"];
                $html .= ' Preço: R$';
                $html .= $item["preco"];
                $html .= ' - Quantidade: ';
                $html .= $item["quantidade"];
                $html .= '</li>';            
            }
            $html .= '</ul>';

            $sql = "SELECT SUM(PRECO * QUANTIDADE) AS RESULTADO FROM ITEM";

            $result = $conexao->query($sql);

            if ($result->num_rows > 0) {
                $valorTotal = $result->fetch_all(MYSQLI_ASSOC);
                $html .= '<p>Valor Total: R$';
                $html .= $valorTotal[0]["RESULTADO"];
                $html .= '</p>';
            }
            echo $html;
            $conexao->close();
        }
    }
?>