<?php
session_start();

$mensagem = "Preencha seus dados";
$login = "";
$password = "";

if (isset($_POST["login"], $_POST["password"])) {
    $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

    if ($login && $password) {
        try {
            $conexao = new PDO("mysql:host=localhost;dbname=contasdb", "root", "root");
            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo ($e);
        }

        $sql = "SELECT * FROM contastb WHERE login = :login AND password = :password";
        $stm = $conexao->prepare($sql);
        $stm->bindParam(':login', $login, PDO::PARAM_STR);
        $stm->bindParam(':password', $password, PDO::PARAM_STR);

        $stm->execute();

        if ($stm->rowCount() > 0) {
            $_SESSION['login'] = $login;
            header("Location: pagina_autenticada.php");
            exit();
        } else {
            $mensagem = "Usuário ou senha inválidos";
        }

        $conexao = null;
    } else {
        $mensagem = "Por favor, preencha todos os campos";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <main>
        <div>
            <?php echo ($mensagem) ?>
        </div>
        <form method="POST">
            <input id='inp_login' value='' type='text' name='login' placeholder='Login' require /><br><br>
            <input id='inp_password' value='' type='text' name='password' placeholder='Password' require><br><br>

            <a href="register.php">Register</a>
            <button id='btn_submit' type='submit'> Enviar </button>
        </form>
    </main>
</body>

</html>