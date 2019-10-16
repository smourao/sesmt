<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";

$cod_cgrt        = addslashes(strtolower($_GET[cod_cgrt]));
$cod_setor       = addslashes(strtolower($_GET[cod_setor]));

$sql = "SELECT * FROM ppra_placas WHERE id_ppra = ".(int)($cod_cgrt)." AND cod_setor = ".(int)($cod_setor);
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
    $ret .= $buffer[$x][id]."|".$buffer[$x][cod_prod]."|".$buffer[$x][quantidade]."|".$buffer[$x][descricao]."|".$buffer[$x][legenda]."£";
}
echo $ret;
?>
