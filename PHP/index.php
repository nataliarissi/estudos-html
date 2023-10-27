<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INDEX</title>
</head>
<body>
    isso é html puro

    <?php
        echo "<br>agora o texto é PHP<br>";
        $nome = "Luke";
        $idade = 1;
        echo "Meu nome é " . $nome;
        echo "<br>";
        echo "Minha idade é" . $idade;
        
        if($idade >= 18){
            echo "<br>Maior de idade<br>";
        }
        return "<br>Menor de idade<br>";

        if($nome == ""){
            echo "Nome em branco";
        }

        if($idade < 0 || $nome == ""){
            echo "Dados inválidos";
        }
        echo "<br>";
        for($n=0; $n < 2; $n++ ){
            echo "</br>isso é um for" . $n;
        }

        if($n = 0; $n < sizeof($arr); $n++){
            echo "</br>isso é um for<br>" . $arr[$n];
        }

        echo "<br>"
        $arr = array(1, 2, 3, 4);
        foreach($arr as $valor ){
            echo $valor . "<br>";
        }
    ?>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    isso é html puro

    <?php
        echo "<br>agora este texto é PHP<br>";
        $nome = "pedro";
        $idade = 17;
        echo "Meu nome é " . $nome;
        echo "<br>";
        echo "Minha idade é " . $idade;
        if($idade >= 18 ){
            echo "<br>vc é maior de idade";
        }else{
            echo "<br>vc é menor de idade";
        }
        if($idade < 0 || $nome =="" ){
            echo "Parametros inválidos";
        }
        for($i=0; $i < 2; $i++ ){
            echo "</br>isso é um for" . $i;
        }
        echo "<br>";
        $arr = array(1, 2, 3, 4);
        foreach ($arr as $valor) {
            echo $valor . "<br>";
        }

        for($i=0; $i < sizeof($arr); $i++ ){
            echo "</br>isso é um for" .
            $arr[$i];
        }

        // and &&
        // or ||
        // !

        if($nome == ""){
            echo "vc não digitou seu nome";
        }
    ?>

</body>
</html>