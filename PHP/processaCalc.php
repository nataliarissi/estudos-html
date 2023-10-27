<?php

$valor1 = $_POST["v1"];
$valor2 = $_POST["v2"];
$operacao = $_POST["op"];

if($operacao == "+"){
    echo  "A soma foi: " . ($valor1 + $valor2);
}
else if($operacao == "-"){
    echo  "A subtração foi: " . ($valor1 - $valor2);
}
else{
    echo "Operação inválida";
}
?>