<?php
include 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valor = isset($_POST['valor']) ? floatval($_POST['valor']) : 0; 

    if ($valor > 0) {
        $conta_saldo += $valor;
        $transacoes[] = ["Depósito", $valor, $conta_saldo];
    } else {
        echo "O valor do depósito deve ser maior que zero.";
    }
}

include 'index.php';
?>