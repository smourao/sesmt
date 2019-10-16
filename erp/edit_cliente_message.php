<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];

$sql = "SELECT * FROM cliente WHERE cliente_id = '{$cod_cliente}'";
$result = pg_query($sql);
$buffer = pg_fetch_array($result);

$sql = "SELECT * FROM erp_cliente_message WHERE id = '{$cod_cliente}'";
$result = pg_query($sql);
$data = pg_fetch_array($result);

echo $data[titulo]."|".$data[mensagem];
?>
