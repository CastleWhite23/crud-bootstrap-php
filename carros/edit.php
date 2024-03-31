<?php 
require_once('functions.php');
edit();
if (!isset($_SESSION))
    session_start();
if (isset($_SESSION['user'])) {
    if (isset($_SESSION['user']) != "admin") {
        $_SESSION['message'] = "Você precisa ser um administrador pra usar este recurso!";
        $_SESSION['type'] = "danger";
        header("Location: " . BASEURL . "carros/index.php");
    }
} else {
    $_SESSION['message'] = "Você precisa estar logado e ser um administrador pra acessar este recurso!";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "carros/index.php");
}
include(HEADER_TEMPLATE); ?>

            <h2 class="mt-2">Atualizar Carro</h2>

            <form action="edit.php?id=<?php echo $carro['id']; ?>" method="post" enctype="multipart/form-data">
                <hr />
                <div class="row">
                    <div class="form-group col-md-8">
                        <label for="name">Modelo</label>
                        <input type="text" class="form-control" name="carro[modelo]" value="<?php echo $carro['modelo']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="campo2">Marca</label>
                        <input type="text" class="form-control" name="carro['marca']" value="<?php echo $carro['marca']; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="campo3">Ano</label>
                        <input type="int" class="form-control" name="carro['ano']" value="<?php echo $carro['ano']; ?>">
                    </div>
                </div>
                <div class="row">
                    <?php 
                        $foto = "";
                        if (empty($carro['foto'])) {
                            $foto = "sem_imagem.jpg";
                        } else {
                            $foto = $carro['foto'];
                        }
                    ?>
                    <div class="form-group col-md-4">
                        <label for="campo1">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto" value="fotos/<?php echo $foto; ?>">
                    </div>
                        
                    <div class="form-group col-md-2">
                        <label for="pre">Pré-Visualização</label>
                        <img class="form-control shadow p-2 mb-2 bg-body rounded" id="imgPreview" src="fotos/<?php echo $foto ;?>" alt="Foto do usuário" srcset="">
                    </div>
                </div>

                    <!-- <div class="form-group col-md-2">   
                        <label for="campo3">CEP</label>
                        <input type="text" class="form-control" name="customer['zip_code']" value="// echo $customer['zip_code']; ?>">
                    </div> -->
                </div>
                
                <div id="actions" class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-sd-card"></i> Salvar</button>
                        <a href="index.php" class="btn btn-light"><i class="fa-solid fa-rotate-left"></i> Cancelar</a>
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