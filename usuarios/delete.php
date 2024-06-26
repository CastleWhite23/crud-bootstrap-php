<?php
// require_once('functions.php'); 

// if (isset($_GET['id'])){
//   delete($_GET['id']);
// } else {
//   die("ERRO: ID não definido.");
// }

//esse é o delete.php
include("functions.php");

if (!isset($_SESSION))
  session_start();
if (isset($_SESSION['user'])) {
  if (isset($_SESSION['user']) != "admin") {
    $_SESSION['message'] = "Você precisa ser um administrador pra usar este recurso!";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "index.php");
  }
} else {
  $_SESSION['message'] = "Você precisa estar logado e ser um administrador pra acessar este recurso!";
  $_SESSION['type'] = "danger";
  header("Location: " . BASEURL . "index.php");
}

if (isset($_GET['id'])) {
  try {
    //consultando o usuário para obter o nome do arquivo da foto
    $usuario = find("usuarios", $_GET['id']);
    // Chamando a função delete para apagar o usuário do banco de dados

    // Apagando o arquivo da foto do usuário pasta fotos
    unlink("fotos/" . $usuario['foto']);
    delete($_GET['id']);

  } catch (Exception $e) {
    $_SESSION['message'] = "Não foi possivel realizar a operação" . $e->getMessage();
    $_SESSION['type'] = "danger";
  }
}
?>