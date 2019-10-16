<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];

$sql = "SELECT * FROM cliente_comercial WHERE cliente_id = '{$cod_cliente}'";
$result = pg_query($sql);
$buffer = pg_fetch_array($result);

$sql = "SELECT * FROM erp_simulador_message WHERE id = '{$cod_cliente}'";
$result = pg_query($sql);
$data = pg_fetch_array($result);

echo $data[titulo]."|".$data[mensagem];

/*
   $sql = "INSERT INTO erp_simulador_message (razao_social, simulador_id, titulo, mensagem,
   data_criacao, data_modificacao) VALUES
   ('{$buffer[razao_social]}', '{$cod_cliente}', '{$titulo}', '{$mensagem}', '".date("Y-m-d")."', '".date("Y-m-d")."')";
   if(pg_query($sql)){
      echo $cod_cliente."|1";
   }
*/

?>
