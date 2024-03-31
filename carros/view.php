<?php 
    include('functions.php'); 
    if(!isset($_SESSION)) session_start();
    view($_GET['id']);
    include(HEADER_TEMPLATE); 
?>

            <h2 class="mt-2">Cliente <?php echo $carro['id']; ?></h2>
            <hr>

            <?php if (!empty($_SESSION['message'])) : ?>
                <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?php echo $_SESSION['message']; ?></div>
            <?php endif; ?>

            <dl class="dl-horizontal">
                <dt>Modelo:</dt>
                <dd><?php echo $carro['modelo']; ?></dd>

                <dt>Marca:</dt>
                <dd><?php echo $carro['marca']; ?></dd>

                <dt>Ano:</dt>
                <dd><?php echo $carro['ano']; ?></dd>

                <dt>Data de Cadastro:</dt>
                <dd><?php echo formatadata($carro['data_cad'],"d/m/Y" ) ?></dd>
            </dl>

            <dl class="dl-horizontal">
                    <dt>Foto:</dt>
                    <dd>
                        <?php
                        if (!empty($carro['foto'])) {
                            echo "<img src =\"fotos/" . $carro['foto'] . "\"" . "class=\" shadow p-1 mb-1 bg-body rounded\" width=\"300px\">";
                        } else {
                            echo "<img src =\"fotos/sem_imagem.jpg" . " class=\" shadow p-1 mb-1 bg-body rounded\" width=\"300px\">";
                        }


                        ?>

                    </dd>


            <div id="actions" class="row">
                <div class="col-md-12">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if ($_SESSION['user'] == "admin"): ?>
                        <a href="edit.php?id=<?php echo $carro['id']; ?>" class="btn btn-secondary">
                            <i class="fa-solid fa-pencil"></i>Editar
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
              
                <a href="index.php" class="btn btn-light">
                    <i class="fa-solid fa-circle-arrow-left"></i>Voltar
                </a>
                </div>
            </div>

<?php include(FOOTER_TEMPLATE); ?>