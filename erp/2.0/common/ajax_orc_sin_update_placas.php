<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";

$cod_cliente   = addslashes(strtolower($_GET[cod_cliente]));
$cod_orcamento = addslashes(strtolower($_GET[cod_orcamento]));
$cod_produto   = addslashes(strtolower($_GET[cod_produto]));

$sql = "SELECT * FROM site_orc_produto WHERE cod_cliente = ".(int)($cod_cliente)." AND cod_orcamento = ".(int)($cod_orcamento)." AND cod_produto = ".(int)($cod_produto);
$res = pg_query($sql);
$buffer = pg_fetch_all($res);
$ret = "";
/*
if(pg_num_rows($res)>0)
    $ret = "1£";
else
    $ret = "0£";
$ret .= "<table width=100% border=0>";
$ret .= "<tr>";
$ret .= "<td class='text' width=45 align=center><b>Cód</b></td>";
$ret .= "<td class='text'><i>"+data[0]+" Item(s) encontrado(s)</i></td>";
$ret .= "</tr>";
*/
for($x=0;$x<pg_num_rows($res);$x++){
    $ret .= $buffer[$x][id]."|".$buffer[$x][cod_produto]."|".$buffer[$x][quantidade]."|".$buffer[$x][legenda]."£";
}
echo $ret;
?>
