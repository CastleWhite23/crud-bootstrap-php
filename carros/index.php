<?php
include('functions.php');
if(!isset($_SESSION)) session_start();
index();

include(HEADER_TEMPLATE);
?>

<header style="margin-top: 10px;">
    <div class="row">
        <div class="col-sm-6">
            <h2>Carros</h2>
        </div>
        <div class="col-sm-6 text-end h2">
                    <?php if (isset($_SESSION['user'])): ?>
                            <?php if ($_SESSION['user'] == "admin"): ?>
                                <a class="btn btn-secondary" href="add.php"><i class="fa fa-plus"></i> Novo Carro</a>
                            <?php endif; ?>
                        <?php endif; ?>
            
            <a class="btn btn-light" href="index.php"><i class="fas fa-sync-alt"></i> Atualizar</a>
        </div>
    </div>
</header>
<form name="filtro" action="index.php" method="post">
    <div class="row">
        <div class="form-group col-md-4">
            <div class="input-group mb-3">
                <input type="text" class="form-control" maxlength="80" name="carros" required>
                <button type="submit" class="btn btn-secondary"><i class="fas fa-search"></i> Consultar</button>
            </div>
        </div>
    </div>
</form>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show mt-4" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php clear_messages(); ?>
<?php endif; ?>



<hr>
<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th width="30%">Modelo</th>
            <th>Marca</th>
            <th>Ano</th>
            <th>Data Cadastro</th>
            <th>Foto</th>

            <th class="text-start">Opções</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($carros): ?>
            <?php foreach ($carros as $carro):
                $deleteLink = "delete.php?id=" . $carro['id'];

                ?>
                <tr>
                    <td>
                        <?php echo $carro['id']; ?>
                    </td>
                    <td>
                        <?php echo $carro['modelo']; ?>
                    </td>
                    <td>
                        <?php echo $carro['marca']; ?>
                    </td>
                    <td>
                        <?php echo $carro['ano']; ?>
                    </td>
                    <td>
                        <?php echo formatadata($carro['data_cad'],"d/m/Y"); ?>
                    </td>
                    <td>
                        <?php
                        if (!empty($carro['foto'])) {
                            echo '<img src="fotos/' . $carro['foto'] . '" alt="" class="shadow p-1 mb-1 bg-body rounded" width="100px">';
                        } else {
                            echo '<img src="fotos/sem_imagem.jpg" alt="" class="shadow p-1 mb-1 bg-body rounded" width="100px">';
                        }
                        ?>
                    </td>


                    <td class="actions text-start">
                        <a href="view.php?id=<?php echo $carro['id']; ?>" class="btn btn-sm btn-light"><i
                                class="fa fa-eye"></i> Visualizar</a>
                        <?php if (isset($_SESSION['user'])): ?>
                            <?php if ($_SESSION['user'] == "admin"): ?>
                                    <a href="edit.php?id=<?php echo $carro['id']; ?>" class="btn btn-sm btn-secondary"><i
                                        class="fa fa-pencil"></i> Editar</a>

                                    <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                        data-bs-custumer="<?php echo $carro['id']; ?>" data-bs-target="#exampleModal">
                                        <i class="fa fa-trash"></i>Excluir
                                    </button>
                            <?php endif; ?>
                        <?php endif; ?>

                       
                                 
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Nenhum registro encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>



<?php
//entao ele quer 1 modal pra todos os links, 
//criar uma function com js pra passar o link do id no http e o modal usar isso?

include('modal.php');
include(FOOTER_TEMPLATE);
?>