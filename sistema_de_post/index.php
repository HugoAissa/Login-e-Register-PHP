<?php

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$p_dono = $_SESSION['login'];
$p_dono = $username;

$post = "";
$resposta = "";

if (isset($_POST["post"])) {
    $post = filter_input(INPUT_POST, "post", FILTER_SANITIZE_STRING);
}
try {
    $conexao = new PDO("mysql:host=localhost;dbname=redesocial", "root", "secret");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    echo ($e);
}
if ($post && $resposta) {
    $sql = "INSERT INTO posttb (p_dono,post) VALUES (:p_dono, :post);";
    $stm = $conexao->prepare($sql);
    $stm->bindParam(':post', $post, PDO::PARAM_STR);
    $stm->bindParam(':p_dono', $p_dono, PDO::PARAM_STR);

    $stm->execute();
}


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Popup com X</title>
</head>

<body>
    <input type="textbox" onclick="openPopup()">Abrir Popup</input>

    <div class="popup" id="myPopup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <form method="post">
                <label for="message">Digite algo:</label>
                <textarea name="post" id="message" rows="4" cols="50"></textarea>
                <hr>
                Selecione uma imagem:
                <input type="file" name="imagem" accept="image/*">
                <br>
                <button id='btn_submit' type='submit'>Post</button>

            </form>
        </div>
    </div>


    <script>
        function openPopup() {
            document.getElementById("myPopup").style.display = "block";
        }

        function closePopup() {
            document.getElementById("myPopup").style.display = "none";
        }

    </script>

</body>

</html>