<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
$cod_funcao = $_GET['cod_funcao'];
$id = $_GET['id'];

$sql = "SELECT * FROM setor_ambiental WHERE cod_setor = {$cod_funcao} AND id = '{$id}'";
$result = pg_query($connect, $sql);
if(pg_num_rows($result) > 0){
     $sql="DELETE FROM setor_ambiental WHERE id={$id}";
     $result = pg_query($connect, $sql);
}

$sql = "SELECT * FROM setor_ambiental WHERE cod_setor = {$cod_funcao}";
$result = pg_query($connect, $sql);
$r = pg_fetch_all($result);
for($x=0;$x<pg_num_rows($result);$x++){
     $text .= "<tr><td bgcolor=\"#009966\">".($x+1)."</td><td bgcolor=\"#009966\">".$r[$x]['descricao']."</td>
     <td align=center bgcolor=\"#009966\">
     <a href=\"javascript:remove_setor_ambiente({$r[$x]['id']});\" class=excluir>X</a>
     </td></tr>|";
}
echo $text;
?>
