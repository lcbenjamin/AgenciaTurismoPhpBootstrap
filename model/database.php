<?php

/**
* 
* Classe de abertura e fechamento de conexão com o banco
*
* @author Novembro/2018: Lucas Costa
*/

/** Avisa sobre erros graves no banco */
mysqli_report(MYSQLI_REPORT_STRICT);

/** Abre conexão com o banco */
function open_database()
{
    try {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        return $conn;
    } catch (Exception $e) {
        echo $e->getMessage();
        return null;
    }
}

/** Fecha conexão com o banco */
function close_database($conn)
{
    try {
        mysqli_close($conn);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

/**
 *  Pesquisa um Registro pelo ID em uma Tabela
 * @param table - Tabela onde o registro será pesquisado [obrigatorio]
 * @param nomeCampo - Nome do campo onde será realizado o select [opcional]
 * @param valorCampo - valor a ser pesquisado [opcional]
 * @param valorCampo - booleano se aceita varios resultados [opcional]
 */
function find( $table = null, $nomeCampo = null, $valorCampo = null, $multResult = false ) {
    
  $database = open_database();

  $database->set_charset("utf8");
 
  $found = null;
  
  if ($nomeCampo) {
    
    $sql = "SELECT * FROM " . $table . " WHERE " . $nomeCampo . " = " . "'" . $valorCampo . "'";
    $result = $database->query($sql);
    if ($result->num_rows > 0) {
      $found = $result->fetch_assoc();
    }
    
  }
  if($nomeCampo == null) {

    $sql = "SELECT * FROM " . $table;
    $result = $database->query($sql);
    
    if ($result->num_rows > 0) {
      $found = $result->fetch_all(MYSQLI_ASSOC);
    }
  }

  if ($nomeCampo!=null && $multResult) {
    
    $sql = "SELECT * FROM " . $table . " WHERE " . $nomeCampo . " = " . "'" . $valorCampo . "'";
    $result = $database->query($sql);
    if ($result->num_rows > 0) {
      $found = $result->fetch_all(MYSQLI_ASSOC);
    }
    
  }

	
	close_database($database);
	return $found;
}

/**
 *  Pesquisa Todos os Registros de uma Tabela
 */
function find_all( $table ) {
    return find($table);
  }


/**
*  Insere um registro no BD
*/
function save($table = null, $data = null) {

  $database = open_database();
  $database->set_charset("utf8");

  $columns = null;
  $values = null;

  foreach ($data as $key => $value) {
    $columns .= trim($key, "'") . ",";
    $values .= "'$value',";
  }
  // remove a ultima virgula
  $columns = rtrim($columns, ',');
  $values = rtrim($values, ',');
  
  $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";
  $result = $database->query($sql);

  if($result){
    $_SESSION['message'] = 'Registro cadastrado com sucesso.';
    $_SESSION['type'] = 'success';
    return true;
  } else {
    $_SESSION['message'] = 'Nao foi possivel realizar a operacao. Erro na tabela ' . $table ." { ". $database->error ." }"; 
    $_SESSION['type'] = 'danger';
    return false;
  }
  close_database($database);
}

/**
*  Insere um registro no BD
*/
function saveReturnID($table = null, $data = null) {

  $database = open_database();
  $database->set_charset("utf8");

  $columns = null;
  $values = null;

  foreach ($data as $key => $value) {
    $columns .= trim($key, "'") . ",";
    $values .= "'$value',";
  }
  // remove a ultima virgula
  $columns = rtrim($columns, ',');
  $values = rtrim($values, ',');
  
  $sql = "INSERT INTO " . $table . "($columns)" . " VALUES " . "($values);";
  $result = $database->query($sql);

  if($result){
    $_SESSION['message'] = 'Registro cadastrado com sucesso.';
    $_SESSION['type'] = 'success';  
    return $database->insert_id;
  } else {
    $_SESSION['message'] = 'Nao foi possivel realizar a operacao. Erro na tabela ' . $table ." { ". $database->error ." }"; 
    $_SESSION['type'] = 'danger';
    return 0;
  }
  close_database($database);
}


/**
 *  Atualiza um registro em uma tabela, por ID
 */
function update($table = null,$colunaChave = null, $id = 0, $data = null) {
  $database = open_database();
  $database->set_charset("utf8");
  $items = null;

  foreach ($data as $key => $value) {
    $items .= trim($key, "'") . "='$value',";
  }
  // remove a ultima virgula
  $items = rtrim($items, ',');
  $sql  = "UPDATE " . $table;
  $sql .= " SET $items";
  $sql .= " WHERE " .$colunaChave. " = " . $id . ";";
  
  $result = $database->query($sql);
  
  if ($result) {
    $_SESSION['message'] = 'Registro atualizado com sucesso.';
    $_SESSION['type'] = 'success';
  } else{
    $_SESSION['message'] = 'Nao foi possivel realizar a operacao. Erro na tabela ' . $table ." { ". $database->error ." }"; 
    $_SESSION['type'] = 'danger';
  }

  close_database($database);
}

/**
 *  Remove uma linha de uma tabela pelo ID do registro
 */
function remove( $table = null, $colunaChave = null, $id = null ) {
  $database = open_database();
	
    if ($id) {
      $sql = "DELETE FROM " . $table . " WHERE " . $colunaChave . " = " . $id;
      $result = $database->query($sql);
      
      if ($result = $database->query($sql)) {   	
        $_SESSION['message'] = "Registro Removido com Sucesso.";
        $_SESSION['type'] = 'success';
      } else {
          $_SESSION['message'] = 'Erro ao remover registro na tabela . Erro na tabela ' . $table ." { ". $database->error ." }"; 
          $_SESSION['type'] = 'danger';
      }
    }
  close_database($database);
}


/************************* 
 * CONSULTAS ESPECIFICAS *
 ************************/

function consultaIMGporIdPCT($idPacote) {

  $database = open_database();
  $database->set_charset("utf8");
  $found = null;
  
  if($idPacote) {
  
      $sql = "SELECT IMG.* FROM IMG , RPI WHERE RPI.PCT_codPacote = " . $idPacote . " AND IMG.codImagem = RPI.IMG_codImagem";
      $result = $database->query($sql);
      
      if ($result->num_rows > 0) {
          $found = $result->fetch_all(MYSQLI_ASSOC);
      }
  }

  close_database($database);
  return $found;
}

function consultaPacotesCadPorEstado(){

  $database = open_database();
  $database->set_charset("utf8");
  $found = null;
  $sql = "SELECT EST.nome AS 'Estado', COUNT(PCT.codEstadoDestino) AS 'Pacote Vendido' FROM EST,PCT WHERE EST.codEstado = PCT.codEstadoDestino GROUP BY EST.nome";

  $result = $database->query($sql);
      
  if ($result->num_rows > 0) {
      $found = $result->fetch_all(MYSQLI_ASSOC);
  }

  close_database($database);
  return $found;
}
?>