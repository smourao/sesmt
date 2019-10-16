<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
$cod_exa = $_GET['cod_exa'];
$desc = $_GET['desc'];
$exame_id = $_GET['id'];

$sql = "SELECT * FROM funcao_exame WHERE cod_exame = {$cod_exa} AND descricao = '{$desc}'";
$result = pg_query($connect, $sql);
/*
$sql = "SELECT MAX(id)+1 FROM funcao_exame";
$r = pg_query($connect, $sql);
$max = pg_fetch_array($r);
*/
if(pg_num_rows($result) < 1){
     $sql="INSERT INTO funcao_exame (cod_exame, descricao, exame_id) values ({$cod_exa}, '{$desc}', {$exame_id})";
     $result = pg_query($connect, $sql);
}

$sql = "SELECT * FROM funcao_exame WHERE cod_exame = {$cod_exa}";
$result = pg_query($connect, $sql);
$r = pg_fetch_all($result);

for($x=0;$x<pg_num_rows($result);$x++){
     $text .= "<tr><td bgcolor=\"#009966\">".($x+1)."</td><td bgcolor=\"#009966\">".$r[$x]['descricao']."</td>
     <td align=center bgcolor=\"#009966\">
     <a href=\"javascript:remove_exa({$r[$x]['id']});\" class=excluir>X</a>
     </td></tr>|";
}

echo $text;
?>
