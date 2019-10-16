<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";

$cod_cgrt        = addslashes(strtolower($_GET[cod_cgrt]));
$id_prod        = addslashes(strtolower($_GET[id_prod]));

$sql = "DELETE FROM ppra_placas WHERE id_ppra = ".(int)($cod_cgrt)." AND id = ".(int)($id_prod);
if(pg_query($sql)){
    $ret = "1";
}else{
    $ret = "0";
}
echo $ret;
?>
