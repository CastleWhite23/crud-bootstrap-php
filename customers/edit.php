<?php 
require_once('functions.php');
if (!isset($_SESSION))
session_start();
if (isset($_SESSION['user'])) {
if ($_SESSION['user'] != "admin") {
    $_SESSION['message'] = "Você precisa ser um administrador pra editar clientes!";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "customers/index.php");
}
} else {
$_SESSION['message'] = "Você precisa estar logado e ser um administrador pra acessar este recurso!";
$_SESSION['type'] = "danger";
header("Location: " . BASEURL . "customers/index.php");
}
edit();
include(HEADER_TEMPLATE); ?>

            <h2 class="mt-2">Atualizar Cliente</h2>

            <form action="edit.php?id=<?php echo $customer['id']; ?>" method="post">
                <hr />
                <div class="row">
                    <div class="form-group col-md-7">
                        <label for="name">Nome / Razão Social</label>
                        <input type="text" class="form-control" name="customer['name']" value="<?php echo $customer['name']; ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="campo2">CNPJ / CPF</label>
                        <input type="text" class="form-control" id="cpf" name="customer['cpf_cnpj']" value="<?php echo $customer['cpf_cnpj']; ?>"
                        id="cpf"
                        maxlength="14">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="campo3">Data de Nascimento</label>
                        <input type="date" class="form-control" name="customer['birthdate']" value="<?php echo formatadata($customer['birthdate'],"Y-m-d"); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-7">
                        <label for="campo1">Endereço</label>
                        <input type="text" class="form-control" name="customer['address']" value="<?php echo $customer['address']; ?>">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="campo2">Bairro</label>
                        <input type="text" class="form-control" name="customer['hood']" value="<?php echo $customer['hood']; ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="campo3">CEP</label>
                        <input type="text" class="form-control" id="zip-code" name="customer['zip_code']" value="<?php echo $customer['zip_code']; ?>"  maxlength="9" onkeyup="handleZipCode(event)">
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="campo1">Município</label>
                        <input type="text" class="form-control" name="customer['city']" value="<?php echo $customer['city']; ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="campo2">Telefone</label>
                        <input type="text" class="form-control" id = "telefone" maxlength="14" name="customer['phone']" value="<?php echo $customer['phone']; ?>">
                    </div>

                    <div class="form-group col-md-2">
                        <label for="campo3">Celular</label>
                        <input type="text" class="form-control" id = "celular" maxlength="15" name="customer['mobile']" value="<?php echo $customer['mobile']; ?>">
                    </div>

                   
                    <div class="form-group col-md-3">
                        <label for="campo3">Inscrição Estadual</label>
                        <input type="text" class="form-control" name="customer['ie']" value="<?php echo $customer['ie']; ?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="campo3">UF</label>
                        <input type="text" class="form-control" name="customer['state']" value="<?php echo $customer['state']; ?>">
                    </div>

                </div>
                <div id="actions" class="row mt-2">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-dark">Salvar</button>
                        <a href="index.php" class="btn btn-light">Cancelar</a>
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