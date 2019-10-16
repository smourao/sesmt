<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];
$titulo = addslashes($_GET['titulo']);
$mensagem = addslashes($_GET['mensagem']);
$mid = $_GET['mid'];

   $sql = "UPDATE erp_simulador_message SET
   titulo = '{$titulo}', mensagem = '{$mensagem}', data_modificacao = '".date("Y-m-d")."'
   WHERE
   id = '{$mid}'
   ";
   if(pg_query($sql)){
      echo $cod_cliente."|1";
   }

?>
