<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário em JavaScript</title>
    
    <script>
        function validarFormulario() {
            var meuNome = document.getElementById("nome").value;
            if (meuNome === "") {
                alert("Preencha o campo do nome");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <form method="post" action="" onsubmit="return validarFormulario();">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <input type="submit" value="Enviar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $meuNome = $_POST["nome"];

        echo "<p>Meu nome é : $meuNome</p>";
    }
    ?>
</body>
</html>