<?php


include_once("conn.php");

$cpf = $cpf_err = "";
$username =   $situacao = "";
$username_err  = $situacao_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){
if(empty(trim($_POST["nome"]))){
        $username_err = "Por favor coloque um nome de usuário.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["nome"]))){
        $username_err = "O nome de usuário pode conter apenas letras, números e sublinhados.";
    }else{
        // Prepare uma declaração selecionada
        $sql = "SELECT id FROM funcionario WHERE nome = :nome";
        
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":nome", $param_username, PDO::PARAM_STR);
            
            // Definir parâmetros
            $param_username = trim($_POST["nome"]);
            
            // Tente executar a declaração preparada
            if($stmt->execute()){
                if($stmt->rowCount() > 0){
                    $username_err = "Este nome de usuário já está em uso.";
                } else{
                    $username = trim($_POST["nome"]);
                }
            } else{
                echo "Ops! Algo deu errado. Por favor, tente novamente mais tarde.";
            }

            // Fechar declaração
            unset($stmt);
        }
    }
    
    // Validar cpf
    if(empty(trim($_POST["cpf"]))){
        $cpf_err = "Por favor insira um cpf.";     
    } 
    else{
        $cpf = trim($_POST["cpf"]);


    // Validar situacao
    if(empty(trim($_POST["situacao"]))){
        $situacao_err = "Por favor insira a situacao";     
    } elseif(strlen(trim($_POST["situacao"])) > 1){
        $situacao_err = "insira uma letra de situacao valida";
    } else{
        $situacao = trim($_POST["situacao"]);
    }
    }

 

    if(empty($username_err) && empty($cpf_err) && empty($situacao_err)){
        
        // Prepare uma declaração de inserção
        $sql = "INSERT INTO funcionario (nome, cpf, situacao) VALUES (:nome, :cpf, :situacao)";
         
        if($stmt = $pdo->prepare($sql)){
            // Vincule as variáveis à instrução preparada como parâmetros
            $stmt->bindParam(":nome", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":cpf", $param_cpf, PDO::PARAM_STR); 
            $stmt->bindParam(":situacao", $param_situacao, PDO::PARAM_STR);
            
            
            // Definir parâmetros
            $param_username = $username;
            $param_cpf = $cpf;
            $param_situacao = $situacao;
           

            // Tente executar a declaração preparada
            if($stmt->execute()){
                  header('location:index.php');
                
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
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>Projeto teste</title>
</head>
<body id="pag">
    

    <div> 
        <h1> Dados do funcionario</h1>
    </div>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="test">
    <div>
<label> Nome: </label>
</div>
    <div> 
        <input type="text" name="nome"  placeholder="Nome:"<?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?> value=<?php echo $username; ?>> 
        <span class="text-muted"><?php echo $username_err; ?></span>
    </div>
    </div>
   

    <br>
    <div class="test">
    <div >
    <label>CPF: </label>
    </div>
    <div> 
    
        <input type="number" name="cpf" placeholder="CPF:"<?php echo (!empty($cpf_err)) ? 'is-invalid' : ''; ?> value=<?php echo $cpf; ?>> 
         <span class="text-muted"><?php echo $cpf_err; ?></span>
    </div>
</div>

    <br>

    <div class="test">
    <div>
    <label> Situacao:</label>


    </div>

    
    <div> 
    <select  name="situacao" id="situacao">
  <option value="A">Ativo</option>
  <option value="I">Inativo</option>
</select>
            <span class="text-muted"><?php echo $situacao_err; ?></span>
    </div>
    </div>

    <br>


    
    <div>
    <input type="submit" class="submit" value="Enviar"> 

    </div>
    </form>
    <br>
    <a href="consulta.php"> <button class="submit"> Consultar tickets </button> </a>

<hr> 

</body>



<?php


 $sql = $pdo->prepare("SELECT * FROM funcionario");
 $sql->execute();

 $fetchClientes = $sql->fetchAll();

 foreach($fetchClientes as $key => $value){

    
     echo ' <table>' .  ' <tr> <strong>Nome:</strong>' . '<td>'. '<u>'  .$value['nome'].'</u>' . '</td>' . '</tr>'.'</table> ' ;
     echo ' <table>' .  ' <tr> <strong>cpf:</strong>' . '<td>'. '<u>' .$value['cpf']. '</u>'.'</td>' . '</tr>'.'</table> ' ;
     echo ' <table>' .  ' <tr> <strong>situacao: </strong>' . '<td>'. $value['situacao'].'</td>' . '</tr>'.'</table> ' ;

     echo '<a href="cadastro.php?id='.$value['id'].'"> <button id="button"> Cadastrar ticket </button> </a>';
     
     echo '<hr>';

 }
?>
</html>