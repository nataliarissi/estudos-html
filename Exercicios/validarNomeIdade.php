<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variáveis de php com função</title>
</head>
<body>
    <?php
    $meuNome = "Natália"; 
    $minhaIdade = 19;

    function validarNomeIdade($meuNome, $minhaIdade) {
        if (empty($meuNome)) {
            return "Necessário o preenchimento do nome";
        } elseif ($minhaIdade <= 0 || $minhaIdade >= 100) {
            return "Necessário o preenchimento da idade";
        } else {
            return "Sucesso na validação dos dados - Nome: $meuNome, Idade: $minhaIdade";
        }
    }

    $resultado = validarNomeIdade($meuNome, $minhaIdade);
    echo $resultado;
    ?>

</body>
</html>
