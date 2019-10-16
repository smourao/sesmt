<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$id = $_GET['id'];
$data = $_GET['data'];
$d = explode("/", $data);
$ndata = $d[2]."/".$d[1]."/".$d[0];

if(is_numeric($id) && $data != "null"){
   $sql = "UPDATE site_orc_info SET data_agendada = '{$ndata}', envio_agendado = '0' WHERE cod_orcamento = '{$id}'";
   if(pg_query($sql)){
      echo $data."|".$id;
   }else{
      echo "";
   }
}
?>
