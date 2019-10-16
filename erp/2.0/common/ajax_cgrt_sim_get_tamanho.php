<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";
$sql = "SELECT DISTINCT acabamento FROM loja_mat_base WHERE nome='$_GET[tam]'";
$res = pg_query($sql);
$buffer = pg_fetch_all($res);
$ret = "";
for($x=0;$x<pg_num_rows($res);$x++){
    $ret .= $buffer[$x]['espessura']."|";
}
echo $ret;
?>
