<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
$instrutor = $_GET['instrutor'];

$sql = "SELECT f.*, c.nome as cname FROM funcionario f, cargo c
WHERE f.nome = '{$instrutor}'
AND
f.cargo_id = c.cargo_id
";
$res = pg_query($sql);
$func = pg_fetch_array($res);

echo $func[cname]."|".$func[registro]."|".$func[funcionario_id];
?>
