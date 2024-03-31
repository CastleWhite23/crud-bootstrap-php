<?php
include('functions.php');
if (!isset($_SESSION))
session_start();
if (isset($_SESSION['user'])) {
if ($_SESSION['user'] != "admin") {
    $_SESSION['message'] = "Você precisa ser um administrador pra adicionar clientes!";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "customers/index.php");
}
} else {
$_SESSION['message'] = "Você precisa estar logado e ser um administrador pra acessar este recurso!";
$_SESSION['type'] = "danger";
header("Location: " . BASEURL . "customers/index.php");
}
add();
include(HEADER_TEMPLATE); 
?>

            <h2 class="mt-2">Novo Cliente</h2>

            <form action="add.php" method="post">
                <!-- area de campos do form -->
                <hr />
                <div class="row">
                    <div class="form-group col-md-7">
                        <label for="name">Nome / Razão Social</label>
                        <input type="text" class="form-control" name="customer['name']" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="campo2">CNPJ / CPF</label>
                        <input type="text" id="cpf" class="form-control" name="customer['cpf_cnpj']" 
                        maxlength="14"
                        required>
                        
                    </div>

                    <div class="form-group col-md-2">
                        <label for="campo3">Data de Nascimento</label>
                        <input type="date" class="form-control" name="customer['birthdate']" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-7">
                        <label for="campo1">Endereço</label>
                        <input type="text" class="form-control" name="customer['address']" required>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="campo2">Bairro</label>
                        <input type="text" class="form-control" name="customer['hood']" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="campo3">CEP</label>
                        <input type="text" class="form-control" name="customer['zip_code']" id="zip-code"  maxlength="9" onkeyup="handleZipCode(event)" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-5">
                        <label for="campo1">Município</label>
                        <input type="text" class="form-control" name="customer['city']" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="campo2">Telefone</label>
                        <input type="text" id="telefone" class="form-control" maxlength="14"  name="customer['phone']" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="campo3">Celular</label>
                        <input type="text" class="form-control" id="celular" maxlength="15"  name="customer['mobile']" required>
                    </div>

                    <div class="form-group col-md-1">
                        <label for="campo3">UF</label>
                        <input type="text" class="form-control" name="customer['state']" required>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="campo3">Inscrição Estadual</label>
                        <input type="text" class="form-control" name="customer['ie']" required>
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
    const input = document.querySelector("#zip-code");
   const handleZipCode = (event) => {
        let input = event.target
        input.value = zipCodeMask(input.value)
    }

const zipCodeMask = (value) => {
  if (!value) return ""
  value = value.replace(/\D/g,'')
  value = value.replace(/(\d{5})(\d)/,'$1-$2')
  return value
}


const inputCpf = document.querySelector("#cpf");

inputCpf.addEventListener("keyup", formatarCPF);

function formatarCPF(e){

    var v=e.target.value.replace(/\D/g,"");

    v=v.replace(/(\d{3})(\d)/,"$1.$2");

    v=v.replace(/(\d{3})(\d)/,"$1.$2");

    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2");

    e.target.value = v;

} 


</script>