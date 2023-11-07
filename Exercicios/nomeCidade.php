<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nome e cidade de nascimento</title>
</head>
<body>
    <?php
    function exibirNomeCidade() {
        $meuNome = "Natália";
        $minhaCidade = "Porto Alegre"; 
        for ($n = 0; $n < 10; $n++) {
            echo "<p><strong>Nome:</strong> $meuNome, <strong>Cidade de Nascimento:</strong> $minhaCidade</p>";
        }
    }

    exibirNomeCidade();
    ?>

</body>
</html>

