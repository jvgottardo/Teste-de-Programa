
<?php

session_start();

$nome = (int)$_GET['id'];
$_SESSION['id'] = $nome;


include_once("conn.php");

$qtd = $qtd_err = "";
 $idFuncionario = $situacao = "";
$idFuncionario_err  = $situacao_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
// Validar qtd
if(empty(trim($_POST["qtd"]))){
    $qtd_err = "Por favor insira uma qtd.";     
} 
else{
    $qtd = trim($_POST["qtd"]);

}


if(empty(trim($_POST["idFuncionario"]))){
    $idFuncionario_err = "Por favor insira uma qtd.";     
} 
else{
    $idFuncionario = trim($_POST["idFuncionario"]);

}


// Validar situacao
if(empty(trim($_POST["situacao"]))){
    $situacao_err = "Por favor insira a situacao";     
} elseif(strlen(trim($_POST["situacao"])) < 1){
    $situacao_err = "insira A ou I";
} else{
    $situacao = trim($_POST["situacao"]);
}


if(empty($qtd_err) && empty($situacao_err) && empty($idFuncionario_err)){

    // Prepare uma declaração de inserção
    $sql = "INSERT INTO tickets (idFuncionario, situacao, qtd) VALUES (:idFuncionario, :situacao, :qtd)";
    
     
    if($stmt = $pdo->prepare($sql)){
        // Vincule as variáveis à instrução preparada como parâmetros
        $stmt->bindParam(":idFuncionario", $param_idFuncionario, PDO::PARAM_STR);
        $stmt->bindParam(":situacao", $param_situacao, PDO::PARAM_STR); 
        $stmt->bindParam(":qtd", $param_qtd, PDO::PARAM_STR);
        
        
        // Definir parâmetros
        $param_idFuncionario = $idFuncionario;
        $param_qtd = $qtd;
        $param_situacao = $situacao;
       

        // Tente executar a declaração preparada
        if($stmt->execute()){
            header ("location: index.php");
        } else{
            echo "<script>alert('OPS, algo deu errado!')</script>";
            header ("location: index.php");
        }

        // Fechar declaração
        unset($stmt);
    }
}
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style_cadastro.css" rel="stylesheet">
    <title>Cadastrar</title>
</head>
<body id="pag">
    

    <div> 
        <h1> Cadastrar ticket</h1>
       <h1>Numero do funcionario: <?php echo($nome)?></h1> 
    </div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="test">
    <div>


   
    <div class="test">
    <div >
    <label>qtd de ticket: </label>
    </div>
    <div> 
    
        <input type="number" name="qtd" placeholder="qtd:"<?php echo (!empty($qtd_err)) ? 'is-invalid' : ''; ?> value=<?php echo $qtd; ?>> 
         <span class="text-muted"><?php echo $qtd_err; ?></span>
    </div>
</div>

    <br>
    <select class="form-control" name="situacao" id="situacao">
  <option value="A">Ativo</option>
  <option value="I">Inativo</option>
</select>

<br> 
    

    <br>

    <div>
    <label> Numero do funcionario:</label>
    </div>
    <input type="text" name="idFuncionario" value="<?php echo($nome)?>"/>
    <div>
        <br>
    <input type="submit" class="submit" value="Enviar"> 
    </div>
    </form>

<hr> 

</body>
</html>

