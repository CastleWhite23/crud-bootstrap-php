<?php
mysqli_report(MYSQLI_REPORT_STRICT);

function open_database()
{
	$conn = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASSWORD);
	// set the PDO error mode to exception
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $conn;
}

function close_database($conn)
{
	try {
		$conn = null;
	} catch (PDOException $e) {
		echo $e->getMessage();
	}
}
/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 */
function find($table = null, $id = null)
{
	try {
		$database = open_database();
		$found = null;
		if ($id) {
			//$conexao->prepare("SELECT id, firstname, lastname, email, reg_date FROM MyGuests");

			$sql = $database->prepare("SELECT * FROM " . $table . " WHERE id = ?");
			$sql->bindParam(1, $id, PDO::PARAM_INT);
			$result = $sql->execute();

			if ($result) {
				$found = $sql->fetch(PDO::FETCH_ASSOC);
			}
		} else {

			$sql = $database->prepare("SELECT * FROM " . $table);
			$result = $sql->execute();


			if ($result) {
				$found = array();
				$found = $sql->fetchAll(PDO::FETCH_ASSOC);

				/* Metodo alternativo
											$found = array();
											while ($row = $result->fetch_assoc()) {
											array_push($found, $row);
											} */
			}
		}
	} catch (PDOException $e) {
		$_SESSION['message'] = $e->GetMessage();
		$_SESSION['type'] = 'danger';
	}

	close_database($database);
	return $found;
}


function find_all($table)
{
	return find($table);
}

/**
 *  Insere um registro no BD
 */
function save($table = null, $data = null)
{

	$database = open_database();

	$columns = null;
	$values = null;

	//print_r($data);

	foreach ($data as $key => $value) {
		$columns .= trim($key, "'") . ",";
		$values .= "?,";
		$params[] = $value;
	}

	$columns = rtrim($columns, ',');
	$values = rtrim($values, ',');

	// Construir a consulta SQL
	$sql = "INSERT INTO $table ($columns) VALUES ($values)";

	// Preparar a consulta
	$stmt = $database->prepare($sql);

	// Vincular parâmetros
	for ($i = 0; $i < count($params); $i++) {
		$stmt->bindParam($i + 1, $params[$i]);
	}

	try {
		$stmt->execute();

		$_SESSION['message'] = 'Registro cadastrado com sucesso.';
		$_SESSION['type'] = 'success';
	} catch (PDOException $e) {

		$_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
		$_SESSION['type'] = 'danger';
	}

	close_database($database);
}


function update($table = null, $id = 0, $data = null)
{

	$database = open_database();

	$items = null;
	$params = array();

	 foreach ($data as $key => $value) {
	 	$items .= trim($key, "'") . "='$value',";
	 }


	// foreach ($data as $key => $value) {
	// 	$items .= "$key = ?,";
	// 	$params[] = $value;
	// }
	// remove a ultima virgula
	$items = rtrim($items, ',');
	echo $items;

	//prepare("UPDATE MyGuests SET firstname=?, lastname=?, email=? WHERE id = ?");
	$sql = $database->prepare("UPDATE $table SET $items WHERE id = ?");
	// $sql->bindParam(1, $items);
	 $sql->bindParam(1, $id, PDO::PARAM_INT);
	

	// for ($i = 0; $i < count($params); $i++) {
	// 	$sql->bindParam($i + 1, $params[$i]);
	// }


	try {
		$sql->execute();

		$_SESSION['message'] = 'Registro atualizado com sucesso.';
		$_SESSION['type'] = 'success';
	} catch (PDOException $e) {

		$_SESSION['message'] = 'Nao foi possivel realizar a operacao.';
		$_SESSION['type'] = 'danger';
	}

	close_database($database);
}

function remove($table = null, $id = null)
{

	$database = open_database();

	try {
		if ($id) {

			$sql = $database->prepare("DELETE FROM ".$table." WHERE id = ?");

			$sql->bindParam(1, $id, PDO::PARAM_INT);
			$result = $sql->execute();

			if ($result) {
				$_SESSION['message'] = "Registro Removido com Sucesso.";
				$_SESSION['type'] = 'success';
			}
		}
	} catch (PDOException $e) {

		$_SESSION['message'] = $e->GetMessage();
		$_SESSION['type'] = 'danger';
	}

	close_database($database);
}


function formatadata($date, $formato)
{
	$dt = new Datetime($date, new DatetimeZone("America/Sao_Paulo"));
	return $dt->format($formato);
}

function formatacep($cep)
{
	$cp = substr($cep, 0, 5) . "-" . substr($cep, 5);
	return $cp;
}


function formatarTelefoneCelular($numero)
{
	// Remove caracteres não numéricos do número
	$numero = preg_replace('/[^0-9]/', '', $numero);

	// Verifica se o número tem 11 dígitos (formato com DDD)
	if (strlen($numero) == 11) {
		return '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 5) . '-' . substr($numero, 7);
	}
	// Verifica se o número tem 10 dígitos (formato sem DDD)
	elseif (strlen($numero) == 10) {
		return '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 4) . '-' . substr($numero, 6);
	}

	// Se o número não tiver 10 ou 11 dígitos, retorna o número original
	return $numero;
}

function formatarTelefoneFixo($numero)
{
	// Remove caracteres não numéricos do número
	$numero = preg_replace('/[^0-9]/', '', $numero);

	// Verifica se o número tem 10 dígitos
	if (strlen($numero) == 10) {
		return '(' . substr($numero, 0, 2) . ') ' . substr($numero, 2, 4) . '-' . substr($numero, 6);
	}

	// Se o número não tiver 10 dígitos, retorna o número original
	return $numero;
}





//   Função de criptografia
function criptografia($senha)
{
	$custo = '08';
	$salt = 'Cf1f11ePArKlBJomM0F6aJ';

	// Gera um hash baseado em bcrypt
	$hash = crypt($senha, '$2a$' . $custo . '$' . $salt . '$');
	return $hash;
}


//upload de imagemfunction
function upload($pasta_destino, $arquivo_destino, $tipo_arquivo, $nome_temp, $tamanho_arquivo)
{

	$uploadOk = 1;
	$tipo_arquivo = strtolower(pathinfo($arquivo_destino, PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	if (isset($_POST["submit"])) {
		$check = getimagesize($nome_temp);
		if ($check !== false) {

			$_SESSION['message'] = "O arquivo é uma imagem";
			$_SESSION['type'] = 'success';
			//echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			throw new Exception("O arquivo não é uma imagem");
			// echo "File is not an image.";
			$uploadOk = 0;
		}
	}

	// Check if file already exists
	if (file_exists($arquivo_destino)) {
		throw new Exception("O arquivo já existe");
		//echo "Sorry, file already exists.";
		$uploadOk = 0;
	}

	// Check file size
	if ($tamanho_arquivo > 5000000) {
		throw new Exception("O arquivo é grande");
		$uploadOk = 0;
	}

	// Allow certain file formats
	if (
		$tipo_arquivo != "jpg" && $tipo_arquivo != "png" && $tipo_arquivo != "jpeg"
		&& $tipo_arquivo != "gif"
	) {
		throw new Exception("O arquivo tem que ser JPG, JPEG, PNG & GIF ");
		//echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		throw new Exception("Falha ao gravar o arquivo ");
		//echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
	} else {

		if (move_uploaded_file($nome_temp, $arquivo_destino)) {
			$_SESSION['message'] = "O arquivo foi gravado no servidor";
			$_SESSION['type'] = 'success';
			//echo "The file " . htmlspecialchars(basename($_FILES["foto"]["name"])) . " has been uploaded.";
		} else {
			throw new Exception("Falha ao gravar o arquivo ");
		}
	}
}


function filter($table = null, $p = null)
{

	$database = open_database();
	$found = null;

	try {
		if ($p) {

			$sql = $database->prepare("SELECT * FROM " . $table . " WHERE ?");
			$sql->bindParam(1, $p);
			$sql->execute();

			$result = $sql->fetchAll(PDO::FETCH_ASSOC);


			if ($result) {
				$found = array();
				while ($row = $sql->fetchAll(PDO::FETCH_ASSOC)) {
					array_push($found, $row);
				}
			} else {
				throw new PDOException("Não foram encontrados registros de dados!");
			}
		}
	} catch (PDOException $e) {
		$_SESSION['message'] = "Ocorreu um erro: " . $e->GetMessage();
		$_SESSION['type'] = "danger";
	}

	close_database($database);
	return $found;
}

function clear_messages()
{
	$_SESSION['message'] = null;
	$_SESSION['type'] = null;
}