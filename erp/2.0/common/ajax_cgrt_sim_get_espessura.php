<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";
$sql = "SELECT DISTINCT espessura FROM loja_mat_base WHERE nome='$_GET[mat]'";
$res = pg_query($sql);
$buffer = pg_fetch_all($res);
$ret = "";
for($x=0;$x<pg_num_rows($res);$x++){
    $ret .= $buffer[$x]['espessura']."|";
}

$ret .= "�";

$sql = "SELECT DISTINCT acabamento FROM loja_mat_base WHERE nome='$_GET[mat]'";
$res = pg_query($sql);
$buffer = pg_fetch_all($res);
for($x=0;$x<pg_num_rows($res);$x++){
    $ret .= $buffer[$x]['acabamento']."|";
}

echo $ret;
?>