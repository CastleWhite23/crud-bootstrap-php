<?php

include('../config.php');
include(DBAPI);
include(PDF);

$usuario = null;
$usuarios = null;

/**
 *  Listagem de Usuários
 */
function index()
{
    global $usuarios;
    if(!empty($_POST['users'])) {
        $usuarios = filter("usuarios", "%" . $_POST['users'] . "%");
    } else{
        $usuarios = find_all("usuarios");
    }
}

/**  
 *  Visualização de um Usuário
 */
function view($id = null)
{
    global $usuario;
    $usuario = find("usuarios", $id);
}


/**
 *  Cadastro de Usuários
 */
function add()
{
    if (!empty($_POST['usuario'])) {
        try {
            $usuario = $_POST['usuario'];

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

                $usuario['foto'] = $nomearquivo;
            }

            //criptografando a senha
            if (!empty($usuario['password'])) {
                $senha = criptografia($usuario['password']);
                $usuario['password'] = $senha;
            }

            save('usuarios', $usuario);

            header('Location; index.php');
        } catch (Exception $e) {
            $_SESSION['message'] = 'Aconteceu um erro: ' . $e->getMessage();
            $_SESSION['type'] = 'danger';
        }
    }
}


/**
 *	Atualizacao/Edicao de Usuario
 */
function edit()
{

    //$now = date_create('now', new DateTimeZone('America/Sao_Paulo'));
    try {
        if (isset($_GET['id'])) {

            $id = $_GET['id'];

            if (isset($_POST['usuario'])) {

                $usuario = $_POST['usuario'];

                //criptografando a senha
                if (!empty($usuario['password'])) {
                    $senha = criptografia($usuario['password']);
                    $usuario['password'] = $senha;
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

                    $usuario['foto'] = $nomearquivo;
                }

                update('usuarios', $id, $usuario);
                header('location: index.php');
            } else {

                global $usuario;
                $usuario = find('usuarios', $id);
            }
        } else {
            header('location: index.php');
        }
    } catch (Exception $e) {
        $_SESSION['message'] = 'Aconteceu um erro: ' . $e->getMessage();
        $_SESSION['type'] = 'danger';
    }
}

/**
 * Exclusão de um Usuario
 */
function delete($id = null)
{

    global $usuarios;
    $usuarios = remove('usuarios', $id);

    header('Location: index.php');
}

/* 
        Gerando PDf
    */

function pdf($p = null)
{
    $pdf = new PDF();
    $pdf->setTitulo("Listagem de Usuarios");

    // $pdf->AddPage();
    // $pdf->SetFont('Times','',12);
    // $pdf->SetTitle("Listagem de Usuarios");
    if ($p) {
        $usuarios = filter("usuarios", "%" . $p . "%");
    } else {
        $usuarios = find_all("usuarios");
    }

    $header = array('ID', 'NOME', 'USERNAME', 'FOTO');
    $data = $pdf->LoadData($usuarios);
    //var_dump($data);
    $pdf->SetFont('Arial', '', 12);
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->BasicTable($header, $data);
    // $pdf->AddPage();
 //$pdf->ImprovedTable($header, $usuarios);
    // $pdf->AddPage();
   //$pdf->FancyTable($header, $data);
    // $usuarios = null;
   
    // foreach ($usuarios as $usuario) {
    //     $pdf->Cell(0, 15, $usuario['id'] . " - " . $usuario['nome'] . "-" . $usuario['user'], 0, 1);
    // }
    $pdf->Output();
}
