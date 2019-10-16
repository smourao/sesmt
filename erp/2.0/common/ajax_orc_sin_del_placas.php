<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";

$cod_orcamento  = addslashes(strtolower($_GET[cod_orcamento]));
$id        		= addslashes(strtolower($_GET[id]));

$sql = "DELETE FROM site_orc_produto WHERE cod_orcamento = ".(int)($cod_orcamento)." AND id = ".(int)($id);
if(pg_query($sql)){
    $ret = "1";
}else{
    $ret = "0";
}
echo $ret;
?>
