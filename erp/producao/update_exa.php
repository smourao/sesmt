<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
//$cod_exa = $_GET['cod_exa'];
$funcao_id = $_GET['id'];
//$exame_id = $_GET['id_exa'];


$sql = "SELECT * FROM exame WHERE cod_exame NOT IN (SELECT exame_id FROM funcao_exame WHERE cod_exame=".$funcao_id.") ORDER BY especialidade";// WHERE cod_exame não esteja sendo exibido
$res = pg_query($connect, $sql);
$buffer = pg_fetch_all($res);
$id = "";
$nome = "";
for($x=0;$x<pg_num_rows($res);$x++){
    $id .= $buffer[$x]['cod_exame']."|";
    $nome .= $buffer[$x]['especialidade']."|";
}
$text = $id."£".$nome;

echo $text;
?>
