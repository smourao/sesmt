<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$fatura = $_GET['fatura'];
$act = $_GET['act'];

if(is_numeric($fatura)){
/*
$sql= "SELECT * FROM site_fatura_info WHERE cod_fatura = '{$fatura}'";
$result = pg_query($sql);
$data = pg_fetch_array($result);

if($data['planilha_checked']){
   $sql = "UPDATE site_fatura_info SET planilha_checked = 0 WHERE cod_fatura = '{$fatura}'";
   $cod = 0;
}else{
*/
   $sql = "UPDATE site_fatura_info SET tagged = {$act} WHERE cod_fatura = '{$fatura}'";
   $cod = 1;
//}

if(pg_query($sql)){
   echo $cod;
}else{
   echo "";
}
}else{
   echo "";
}

?>
