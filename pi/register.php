<?php
$mensagem = "Preencha seus dados ";
$login = "";
$password = "";
$username = "";

if (isset($_POST["login"], $_POST["password"], $_POST["username"])) {
    $login = filter_input(INPUT_POST, "login", FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);

    try {
        // Conectando ao banco de dados
        $conexao = new PDO("mysql:host=localhost;dbname=contasdb", "root", "root");
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificando se o usuário já existe
        $sql = "SELECT * FROM contastb WHERE username = :username";
        $stm = $conexao->prepare($sql);
        $stm->bindParam(':username', $username, PDO::PARAM_STR);
        $stm->execute();

        if ($stm->rowCount() > 0) {
            $mensagem = "Este usuário já está em uso.";
        } else {
            // Verificando se há dados inválidos
            if (!$login || !$password || !$username) {
                $mensagem = "Dados inválidos, tente novamente";
            } else {
                // Inserindo valores no banco de dados de forma segura
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO contastb (login, password, username) VALUES (:login, :password, :username)";
                $stm = $conexao->prepare($sql);
                $stm->bindParam(':login', $login, PDO::PARAM_STR);
                $stm->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                $stm->bindParam(':username', $username, PDO::PARAM_STR);
                $stm->execute();

                $mensagem = "Registrado com sucesso";
            }
        }
    } catch (PDOException $e) {
        echo ($e);
    } finally {
        // Fechando conexão com o banco de dados
        $conexao = null;
    }
}
?>
