<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");
$id = $_GET['id'];
$valor = $_GET['valor'];
$resumo = $_GET['resumo'];
$detalhado = $_GET['detalhado'];

echo $id."<br>".$valor."<br>".$resumo."<br>".$detalhado."<br>";
?>
