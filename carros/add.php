<?php
include('functions.php');
if (!isset($_SESSION))
session_start();
if (isset($_SESSION['user'])) {
if ($_SESSION['user'] != "admin") {
    $_SESSION['message'] = "Você precisa ser um administrador pra adicionar clientes!";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "carros/index.php");
}
} else {
$_SESSION['message'] = "Você precisa estar logado e ser um administrador pra acessar este recurso!";
$_SESSION['type'] = "danger";
header("Location: " . BASEURL . "carros/index.php");
}
add();
include(HEADER_TEMPLATE); 
?>

            <h2 class="mt-2">Novo Carro</h2>

            <form action="add.php" method="post" enctype="multipart/form-data">
                <!-- area de campos do form -->
                <hr />
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">Modelo</label>
                        <input type="text" class="form-control" name="carro['modelo']" required>
                    </div>                  
                </div>

                <div class="row">
                <div class="form-group col-md-3">
                        <label for="campo2">Marca</label>
                        <input type="text" class="form-control" name="carro['marca']" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="campo1">Ano</label>
                        <input type="int" class="form-control" name="carro['ano']" required>
                    </div>

                </div>

                <div class="row">

                        <div class="form-group col-md-4">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>

                        <div class="form-group col-md-2">
                            <label for="imgPreview">Pré visualização</label>
                            <img class="form-control rounded" id="imgPreview" src="./fotos/sem_imagem.jpg" alt="" srcset="">
                        </div>

                        </div>
                        <div id="actions" class="row mt-2">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-sd-card"></i> Salvar</button>
                            <a href="index.php" class="btn btn-light"><i class="fa-solid fa-circle-arrow-left"></i> Cancelar</a>
                        </div>
                </div>
            </form>

<?php include(FOOTER_TEMPLATE); ?>
<script>
    $(document).ready(() => {
        $("#foto").change(function () {
            const file = this.files[0];
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    $("#imgPreview").attr("src", event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
