<?php
include 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valor = isset($_POST['valor']) ? floatval($_POST['valor']) : 0;
    if ($valor > 0) {
        if ($valor <= $conta_saldo) {
            $conta_saldo -= $valor;
            $transacoes[] = ["Retirada", $valor, $conta_saldo];
        } else {
            echo "Saldo insuficiente para realizar a retirada.";
        }
    } else {
        echo "O valor da retirada deve ser maior que zero.";
    }
}

include 'index.php';
?>