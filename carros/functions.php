<?php

include ('../config.php');
include (DBAPI);

$carro = null;
$carros = null;

/**
 *  Listagem de Usuários
 */
function index()
{
    global $carros;
    if (!empty($_POST['carros'])) {
        $carros = filter("carros", " modelo like %" . $_POST['carros'] . "%");
    } else {
        $carros = find_all("carros");

    }
}

/**  
 *  Visualização de um Usuário
 */
function view($id = null)
{
    global $carro;
    $carro = find("carros", $id);
}


/**
 *  Cadastro de Usuários
 */
function add()
{
    if (!empty($_POST['carro'])) {
        try {
            $carro = $_POST['carro'];

            if (!empty($_FILES["foto"]["name"])) {
                // Upload da foto
                $pasta_destino = "fotos/";


                $tipo_arquivo = strtolower(pathinfo(basename($_FILES["foto"]["name"]), PATHINFO_EXTENSION));

                $nomearquivo = uniqid() . "." . $tipo_arquivo;  // extensão do arquivo
                //pasta onde ficam as fotos

                $arquivo_destino = $pasta_destino . $nomearquivo;

                //Caminho completo até o arquivo que será gravado
                $tamanho_arquivo = $_FILES["foto"]["size"]; //tamanho do arquivo em bytes
                $nome_temp = $_FILES["foto"]["tmp_name"]; // nome e caminho do arquivo no servidor



                // Chamda do da função upload para gravar uma imagem
                upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $nome_temp, $tamanho_arquivo);

                $carro['foto'] = $nomearquivo;
            }

            //criptografando a senha
            $today = new DateTime('now', new DateTimeZone('America/Sao_Paulo'));

            $carro['data_cad'] = $today->format("Y-m-d H:i:s");
            save('carros', $carro);

            header('Location; index.php');
        } catch (Exception $e) {
            $_SESSION['message'] = 'Aconteceu um erro: ' . $e->getMessage();
            $_SESSION['type'] = 'danger';
        }
    }
}


/**
 *	Atualizacao/Edicao de carro
 */
function edit()
{

    //$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
    try {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];


            if (isset($_POST['carro'])) {

                $carro = $_POST['carro'];
                //var_dump($carro);
                //criptografando a senha
                if (!empty($carro['password'])) {
                    $senha = criptografia($carro['password']);
                    $carro['password'] = $senha;
                }

                if (!empty($_FILES["foto"]["name"])) {
                    // Upload da foto
                    $pasta_destino = "fotos/";


                    $tipo_arquivo = strtolower(pathinfo(basename($_FILES["foto"]["name"]), PATHINFO_EXTENSION));

                    $nomearquivo = uniqid() . "." . $tipo_arquivo;  // extensão do arquivo
                    //pasta onde ficam as fotos

                    $arquivo_destino = $pasta_destino . $nomearquivo;

                    $tamanho_arquivo = $_FILES["foto"]["size"]; //tamanho do arquivo em bytes
                    $nome_temp = $_FILES["foto"]["tmp_name"]; // nome e caminho do arquivo no servidor


                    // Chamda do da função upload para gravar uma imagem
                    upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $nome_temp, $tamanho_arquivo);

                    $carro['foto'] = $nomearquivo;
                }

                
                update('carros', $id, $carro);
                //header('location: index.php');
            } else {

                global $carro;
                $carro = find('carros', $id);
            }
        } else {
            // header('location: index.php');
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Aconteceu um erro: ' . $e->getMessage();
        $_SESSION['type'] = 'danger';
    }
}

/**
 * Exclusão de um carro
 */
function delete($id = null)
{

    global $carros;
    $carros = remove('carros', $id);

    header('Location: index.php');
}










?>