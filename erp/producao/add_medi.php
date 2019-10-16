<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
$cod_medi = $_GET['cod_medi'];
$desc = $_GET['id'];

$sql = "SELECT * FROM funcao_medi WHERE cod_medi = {$cod_medi} AND descricao = '{$desc}'";
$result = pg_query($connect, $sql);
if(pg_num_rows($result) < 1){
     $sql="INSERT INTO funcao_medi (cod_medi, descricao)values({$cod_medi}, '{$desc}')";
     $result = pg_query($connect, $sql);
}

$sql = "SELECT * FROM funcao_medi WHERE cod_medi = {$cod_medi}";
$result = pg_query($connect, $sql);
$r = pg_fetch_all($result);

for($x=0;$x<pg_num_rows($result);$x++){
     $text .= "<tr><td bgcolor=\"#009966\">".($x+1)."</td><td bgcolor=\"#009966\">".$r[$x]['descricao']."</td>
     <td align=center bgcolor=\"#009966\">
     <a href=\"javascript:remove_medi({$r[$x]['id']});\" class=excluir>X</a>
     </td></tr>|";
}

echo $text;
?>
