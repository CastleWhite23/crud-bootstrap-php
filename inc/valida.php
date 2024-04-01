<?php
include("../config.php");
include(DBAPI);
include(HEADER_TEMPLATE);

if (!empty($_POST) and (empty($_POST['login']) or empty($_POST['senha']))) {
    header("Location:" . BASEURL . "index.php");
    exit;
}

$bd = open_database();

try {

    $bd = open_database();
    $usuario = $_POST['login'];
    $senha = $_POST['senha'];


    if (!empty($usuario) && !empty($senha)) {
        $senha = criptografia($_POST['senha']);

        $sql = $bd->prepare("SELECT id, nome, user, password FROM usuarios WHERE user = ? AND password = ? LIMIT 1");
        $sql->bindParam(1, $usuario, PDO::PARAM_STR);
        $sql->bindParam(2, $senha, PDO::PARAM_STR);


        $sql->execute();


        if ($row = $sql->rowCount() > 0) {
			
            $dados = $sql->fetch(PDO::FETCH_ASSOC);
			
            echo "<b>";
            var_dump($dados);
            echo "<b>";

            $id = $dados['id'];
            $nome = $dados['nome'];
            $user = $dados['user'];
            $password = $dados['password'];
            var_dump($user);

            if (!empty($user)) {
                if (!isset($_SESSION))
                    session_start();
                $_SESSION['message'] = "Bem vindo " . $nome . "!";
                $_SESSION['type'] = "info";
                $_SESSION['id'] = $id;
                $_SESSION['nome'] = $nome;
                $_SESSION['user'] = $user;

                echo "<b>";
                var_dump($user);
                echo "<b>";
            } else {
                throw new Exception("Não foi possivel se conectar!<br>Verifique seu usuário e senha.");
            }
            header("Location: " . BASEURL . "index.php");
        } else {
            throw new Exception("Não foi possivel se conectar!<br>Verifique seu usuário e senha.");
        }
    } else {
        throw new Exception("Não foi possivel se conectar!<br>Verifique seu usuário e senha.");
    }

} catch (Exception $e) {
    $_SESSION['message'] = "Ocorreu um erro: " . $e->getMessage();
    $_SESSION['type'] = "danger";
}
?>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show mt-4" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php clear_messages(); ?>
<?php endif; ?>

<header>
    <a href="<?php echo BASEURL?>index.php" class="btn btn-light mt-4"><i class="fa-solid fa-rotate-left"></i> Voltar</a>
</header>

<?php 
    include(FOOTER_TEMPLATE);
?>
