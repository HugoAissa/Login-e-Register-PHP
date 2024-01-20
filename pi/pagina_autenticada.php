<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

echo "Bem-vindo, " . $_SESSION['login'] . "! Você está logado.";

?>