<?php header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?PHP
include "../config/connect.php";
$cod_medi = $_GET['cod_medi'];
$desc = $_GET['id'];

$items = array("Álcool 70%", "Algodão em golinha", "Gases", "Cotonete", "Atadura",
"Reparil Gel (Hematomas)",
"Esparadrapo", "Tesoura", "Solução anti séptica (Povedine)", "Termômetro", "Água Oxigenada",
"Soro Fisiológico (Limpeza de ferimentos)", "Luva Descartável", "Pinça", "Repelente de Insetos",
"Curativo adesivo tipo band-aid", "relação dos materiais e quantidade contida no armário.",
"controle de retirada", "Vaselina liquida ou Dersani (para queimaduras)");


for($x=0;$x<count($items);$x++){
   $sql = "SELECT * FROM funcao_medi WHERE cod_medi = {$cod_medi} AND descricao = '{$items[$x]}'";
   $result = pg_query($connect, $sql);
   if(pg_num_rows($result) < 1){
       $sql="INSERT INTO funcao_medi (cod_medi, descricao)values({$cod_medi}, '{$items[$x]}')";
       $result = pg_query($connect, $sql);
   }
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
