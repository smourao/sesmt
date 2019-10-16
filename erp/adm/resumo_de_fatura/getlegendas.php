<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$sql = "SELECT * FROM loja_legendas WHERE categoria='{$_GET['cat']}'";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);

$tmp = "";

for($x=0;$x<pg_num_rows($result);$x++){
   //
   $tmp .= $buffer[$x]['legenda'];
   $tmp .= "|";
}

echo $tmp;

?>

