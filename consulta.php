
<?php

include_once("conn.php");


    $consulta = $pdo->query("SELECT idFuncionario, qtd, date_cadastro FROM tickets ORDER BY idFuncionario;");


    while ($linha = $consulta->fetch(PDO::FETCH_ASSOC)) {
    echo "idFuncionario: {$linha['idFuncionario']} - qtd: {$linha['qtd']} - data: {$linha['date_cadastro']}<br />";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar</title>
</head>
<body>
<a href="index.php"> <button id="button"> Voltar </button> </a>
</body>
</html>


