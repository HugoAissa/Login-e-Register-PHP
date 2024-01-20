<?php
//DECLARANDO AS VARIAVEIS 
$mensagem = "Preencha seus dados ";
$login = "";
$password = "";
$username = "";
// FILTRANDO OS INPUT E DECLARANDO COMO STRING
if (isset($_POST["login"], $_POST["password"], $_POST["username"])) {
    $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);


    #CODIGO DO CHAT GPT JUNTANDO OQUE EU JA TINHA

    try {
        $conexao = new PDO("mysql:host=localhost;dbname=contasdb", "root", "root");
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo ($e);
    }


    $padrao	 = $_POST['username']; // Supondo que você está recebendo isso de algum formulário

    // Query SQL
    $sql = "SELECT * FROM contastb WHERE username LIKE :username";

    // Preparar a query
    $stm = $conexao->prepare($sql);
    $stm->bindParam(':username', $padrao, PDO::PARAM_STR);
    // Executar a query
    $stm->execute();
    $conexao = null;

    // Verificar se há resultados
    if ($stm->rowCount() > 0) {
        // Ação a ser executada se houver resultados
        echo "Encontrado!";
        $mensagem = $username." Esté usuario ja está em uso.";

        // Adicione aqui o código que você deseja executar
    } else {
        // VERIFICANDO SEM TEM CARACTERE NO INPUT CASO TENHA AS INFORMAÇOES IRA PARA O BANCO DE DADOS

        if (!$login || !$password || !$username) {

            $mensagem = "Dados invalidos tente novamente";
    
    
        } else {
            // Ação a ser executada se NÃO houver resultados
            echo "Não encontrado!";
            // Adicione aqui o código que você deseja executar

            //CODIGO PARA INSERIR VALORES NO BANCO DE DADOS
            $conexao = new PDO("mysql:host=localhost;dbname=contasdb", "root", "root");
    
            $stm = $conexao->prepare('INSERT INTO contastb(login,password,username) VALUES (:login,:password,:username)');
            $stm->bindParam('login', $login);
            $stm->bindParam('password', $password);
            $stm->bindParam('username', $username);
            $stm->execute();
    
            $mensagem = "Registrado com sucesso";
            // FECHANDO CONEXEÇÃO COM BANCO DE DADOS

            $conexao = null;

        }
    }




    

}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>
    <main>
        <div>
            <?php echo ($mensagem) ?>
        </div>
        <form method="POST">
            <input id='inp_login'value='' type='text' name='login' placeholder='Login' require /><br><br>
            <input id='inp_password'value='' type='text' name='password' placeholder='Password' require><br><br>
            <input id='inp_username' value=''type='text' name='username' placeholder='Username' require /><br><br>

            <a href="login.php">Login</a>
            <button id='btn_submit' type='submit'> Enviar </button>
        </form>
    </main>
</body>

</html>