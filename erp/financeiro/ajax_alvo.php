<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include("include/db.php");

$alvo = $_GET['valor'];
$alvo = str_replace(".", "", $alvo);
$alvo = str_replace(",", ".", $alvo);

$sql = "UPDATE financeiro_config SET alvo = '{$alvo}'";

if(pg_query($sql)){
   echo number_format($alvo, 2, ',','.');
}else{
   echo "";
}

?>
