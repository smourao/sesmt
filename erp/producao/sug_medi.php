<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";
$search = $_GET['texto'];

if(!empty($search)){
   $sql = "SELECT distinct(BTRIM(descricao)) as descricao FROM funcao_medi WHERE lower(descricao) LIKE '%".strtolower($search)."%' ORDER BY descricao";// WHERE cod_exame não esteja sendo exibido
   $res = pg_query($connect, $sql);
   $buffer = pg_fetch_all($res);
   $ret  = "";
   $ret .= "<table border=0 width=100% height=100% cellspacing=0 cellpadding=0>";
   for($x=0;$x<pg_num_rows($res);$x++){
      $ret .= "<tr>";
      $ret .= "<td class=hl1 style=\"cursor:pointer;\" onclick=\"document.getElementById('funcao_medi').value='{$buffer[$x][descricao]}';document.getElementById('funcao_medi').focus();\"><font size=1 color=white>{$buffer[$x][descricao]}</font></td>";
      $ret .= "</tr>";
   }
   $ret .= "</table>";
   echo $ret;
}else{
   $ret  = "";
   $ret .= "<table border=0 width=100% height=100% cellspacing=0 cellpadding=0>";
   $ret .= "<tr>";
   $ret .= "<td class=hl1 style=\"cursor:pointer;\" onclick=\"document.getElementById('funcao').focus();\"><font size=1 color=white></font></td>";
   $ret .= "</tr>";
   $ret .= "</table>";
   echo $ret;
}
?>
