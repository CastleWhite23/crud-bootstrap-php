<!DOCTYPE html>
<html>
    <head>
        <title>My Page Title</title>
        <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
        <meta charset="utf-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Free Web tutorials">
        <meta name="keywords" content="HTML, CSS, JavaScript">
        <meta name="author" content="John Doe">
        <style>
            table, th, td {
                border: 1px solid #000000;
            }
        </style>
    </head>
    <body>
        <?php
       
        include("database.php");
       
        // Verificar se foi enviando dados via POST
       
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
           
            $id = (isset($_POST["id"]) && $_POST["id"] != null) ? $_POST["id"] : "";
            $nome = (isset($_POST["nome"]) && $_POST["nome"] != null) ? $_POST["nome"] : "";
            $sobrenome = (isset($_POST["sobrenome"]) && $_POST["sobrenome"] != null) ? $_POST["sobrenome"] : "";
            $email = (isset($_POST["email"]) && $_POST["email"] != null) ? $_POST["email"] : "";
           
        } else if (!isset($id)) {
            // Se não se não foi setado nenhum valor para variável $id
            $id = (isset($_GET["id"]) && $_GET["id"] != null) ? $_GET["id"] : "";
            $nome = NULL;
            $sobrenome = NULL;
            $email = NULL;
        }
       
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "save" && $nome != "") {
           
            try {
                $conexao = conecta();
                //$stmt = $conexao->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
               
                if ($id != "") {
                    $stmt = $conexao->prepare("UPDATE MyGuests SET firstname=?, lastname=?, email=? WHERE id = ?");
                    $stmt->bindParam(4, $id);
                } else {
                    $stmt = $conexao->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
                }
               
 
                $stmt->bindParam(1, $nome);
                $stmt->bindParam(2, $sobrenome);
                $stmt->bindParam(3, $email);
               
                 
                $stmt->execute();
               
                if ($stmt->rowCount() > 0) {
                   
                    echo "<h4>Dados cadastrados com sucesso!</h4>";
                    $id = null;
                    $nome = null;
                    $sobrenome = null;
                    $email = null;
                   
                } else {
                    echo "<h4>Erro ao tentar efetivar cadastro</h4>";
                }
               
            } catch (PDOException $erro) {
               
                echo "<h4> Erro: " . $erro->getMessage() . "</h4>/n";
            }
        }
       
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "upd" && $id != "") {
            try {
                $conexao = conecta();
                $stmt = $conexao->prepare("SELECT * FROM MyGuests WHERE id = ?");
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                   
                $rs = $stmt->fetch(PDO::FETCH_OBJ);
                $id = $rs->id;
                $nome = $rs->firstname;
                $sobrenome = $rs-> lastname;
                $email = $rs->email;
                   
            } catch (PDOException $erro) {
                echo "<h4> Erro: " . $erro->getMessage() . "</h4>/n";  
            }
        }
 
        if (isset($_REQUEST["act"]) && $_REQUEST["act"] == "del" && $id != "") {
 
            try {
                $conexao = conecta();
                $stmt = $conexao->prepare("DELETE FROM MyGuests WHERE id = ?");
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                echo "<h3>Registo foi excluído com êxito</h3>";
                $id = null;
               
            } catch (PDOException $erro) {
                echo "Erro: ".$erro->getMessage();
            }
        }
 
       
        ?>
       
        <h2>Exemplo PDO</h2>
 
        <form action="?act=save" method="POST" name="cad">
                <hr>
                <input type="hidden" name="id"
                    <?php
                    // Preenche o id no campo id com um valor "value"
                        if (isset($id) && $id != null || $id != "")
                        {
                            echo "value=\"$id\"";
                        }
                    ?>
                >
                Nome:
                <input type="text" name="nome"
                <?php
                // Preenche o nome no campo nome com um valor "value"
                    if (isset($nome) && $nome != null || $nome != "")
                    {
                        echo "value=\"$nome\"";
                    }
                ?>
                >
                Sobrenome:
                <input type="text" name="sobrenome"
                <?php
                // Preenche o sobrenome no campo email com um valor "value"
                    if (isset($sobrenome) && $sobrenome != null || $sobrenome != ""){
                        echo "value=\"$sobrenome\"";
                    }
                ?>
                >
                E-mail:
                <input type="email" name="email"
                <?php
                // Preenche o email no campo email com um valor "value"
                    if (isset($email) && $email != null || $email != "")
                    {
                        echo "value=\"$email\"";
                    }
                ?>
                >
                <input type="submit" value="Salvar">
                <input type="reset" value="Novo">
                <hr>
            </form>
       
        <table>
            <thead>
                <tr>
                    <th>ID:</th>
                    <th>Nome:</th>
                    <th>Sobrenome:</th>
                    <th>Email:</th>
                    <th>Data cad.:</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
                try {
                    $conexao = conecta();
                    $stmt = $conexao->prepare("SELECT id, firstname, lastname, email, reg_date FROM MyGuests");
                    $stmt->execute();
                   
                    echo "<h2>Trazendo os dados em objeto</h2>";
                    //trazendo os dados em objeto
                   
                    while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                           
                        $data = new DateTime( $rs->reg_date,
                        new DateTimeZone("America/sao_paulo"));
           
                        echo "<tr>\n"
                                ."<td>" . $rs->id . "<br></td>\n"
                                ."<td>" . $rs->firstname . "<br></td>\n"
                                ."<td>" . $rs->lastname . "<br></td>\n"
                                ."<td>" . $rs->email . "<br></td>\n"
                                ."<td>" . $data->format ("d/m/y H:i:s"). "</td>\n"
                                . "<td><a href=\"?act=upd&id=" . $rs->id . "\">[Alterar]</a>"
                                ."&nbsp;&nbsp;&nbsp;"
                                ."<a href=\"?act=del&id=" . $rs->id . "\">[Excluir]</a></td>\n"
                                . "</tr>\n";
                       
                    }
                    /*
                    trazendo os dados num vetor
                   
                    while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
                       
                        $data = new DateTime( $rs['reg_date'],
                            new DateTimeZone("America/sao_paulo"));
                       
                        echo "<p> ID: " . $rs['id'] . "<br>\n"
                            ."<p> nome: " . $rs['firstname'] . "<br>\n"
                            ."<p> sobrenome: " . $rs['lastname'] . "<br>\n"
                            ."<p> email: " . $rs['email'] . "<br>\n"
                            ."<p> data cad.: " . $data->format ("d/m/y H:i:s")
                            . "<br><br>\n"
                            . "</p>\n";
                       
                    }
                    */
               
                    // echo "<p>Conectado com sucesso!</p>";
                   
                } catch (Exception $e) {
                    echo "<p>Erro no banco de dados:<br>" . $e->getMessage() . "</p>";
                }
            ?>
            </tbody>
        </table>
    </body>
</html>