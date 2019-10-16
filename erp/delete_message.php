<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];
$titulo = addslashes($_GET['titulo']);
$mensagem = addslashes($_GET['mensagem']);
$mid = $_GET['id'];

$sql = "SELECT * FROM erp_simulador_message WHERE id = '{$mid}'";
$result = pg_query($sql);
$info = pg_fetch_array($result);

   $sql = "DELETE FROM erp_simulador_message
   WHERE
   id = '{$mid}'";
   
   if(pg_query($sql)){
      echo $info[simulador_id]."|1";
   }

?>
