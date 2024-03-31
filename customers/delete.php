<?php
require_once("functions.php");
if (!isset($_SESSION))
session_start();
if (isset($_SESSION['user'])) {
if ($_SESSION['user'] != "admin") {
    $_SESSION['message'] = "Você precisa ser um administrador pra excluir clientes!";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "customers/index.php");
}
} else {
$_SESSION['message'] = "Você precisa estar logado e ser um administrador pra acessar este recurso!";
$_SESSION['type'] = "danger";
header("Location: " . BASEURL . "customers/index.php");
}
if (isset($_GET['id'])) {
  try {
    delete($_GET['id']);

  } catch (Exception $e) {
    $_SESSION['message'] = "Não foi possivel realizar a operação" . $e->getMessage();
    $_SESSION['type'] = "danger";
  }

} else {
  die("ERRO: ID não definido.");
}


?>