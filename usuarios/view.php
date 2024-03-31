<?php
include('functions.php');
view($_GET['id']);
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
include(HEADER_TEMPLATE);
?>

            <?php if (!empty($_SESSION['message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show mt-4" role="alert">
                    <?php echo $_SESSION['message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php clear_messages(); ?>
            <?php else: ?>
                <h2 class="mt-2">Cliente
                    <?php echo $usuario['id']; ?>
                </h2>
                <hr>

                <?php if (!empty($_SESSION['message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['type']; ?>">
                        <?php echo $_SESSION['message']; ?>
                    </div>
                <?php endif; ?>

                <dl class="dl-horizontal">
                    <dt>Nome :</dt>
                    <dd>
                        <?php echo $usuario['nome']; ?>
                    </dd>

                    <dt>Username</dt>
                    <dd>
                        <?php echo $usuario['user']; ?>
                    </dd>

                    <dt>Password</dt>
                    <dd>
                        <?php echo $usuario['password']; ?>
                    </dd>
                </dl>

                <dl class="dl-horizontal">
                    <dt>Foto:</dt>
                    <dd>
                        <?php
                        if (!empty($usuario['foto'])) {
                            echo "<img src =\"fotos/" . $usuario['foto'] . "\"" . "class=\" shadow p-1 mb-1 bg-body rounded\" width=\"300px\">";
                        } else {
                            echo "<img src =\"fotos/sem_imagem.jpg" . " class=\" shadow p-1 mb-1 bg-body rounded\" width=\"300px\">";
                        }


                        ?>

                    </dd>


                </dl>
            <?php endif; ?>
            <div id="actions" class="row">
                <div class="col-md-12">
                    <?php if(empty($_SESSION['message'])):?>
                    <a href="edit.php?id=<?php echo $usuario['id']; ?>" class="btn btn-secondary">
                        <i class="fa-solid fa-pencil"></i>Editar
                    </a>
                    <?php endif;?>
                    <a href="index.php" class="btn btn-light">
                        <i class="fa-solid fa-circle-arrow-left"></i>Voltar
                    </a>
                </div>
            </div>
    

<?php 
    clear_messages();
    include(FOOTER_TEMPLATE); 
?>