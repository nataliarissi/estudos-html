<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>Coluna 1</th>
            <th>Coluna 2</th>
        </tr>
        <?php
        for ($n = 1; $n <= 10; $n++) {
            echo "<tr>";
            echo "<td>Linha $n, Coluna 1</td>";
            echo "<td>Linha $n, Coluna 2</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
