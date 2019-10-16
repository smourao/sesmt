<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
$curso = $_GET['curso'];

$sql = "SELECT count(*) as n FROM bt_info WHERE curso = '{$curso}'";
$r = pg_query($sql);
$linhas = pg_fetch_array($r);
if($linhas[n] == 0)
   $linhas[n] = 1;
   
$f = ceil($linhas[n] / 31);

$sql = "SELECT livro FROM bt_cursos WHERE id = '{$curso}'";
$res = pg_query($sql);
$livro = pg_fetch_array($res);

$sql = "SELECT MAX(reg_certificado) as maxc FROM bt_info WHERE curso = '{$curso}'";
$res = pg_query($sql);
$max = pg_fetch_array($res);

echo $f."|".$livro[livro]."|".($max[maxc]+1);
?>
