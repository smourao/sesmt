<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "config/connect.php";
$code = 0;

$sql = "DELETE FROM site_fatura_produto WHERE id = {$_GET['cod_produto']}";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);

if($result){
 $code = 1;
}else{
 $code = 2;
}

echo $code;

?>
