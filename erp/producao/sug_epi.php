<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";
$search = $_GET['texto'];

if(!empty($search)){
   //$sql = "SELECT distinct(BTRIM(descricao)) as descricao FROM funcao_epi WHERE lower(descricao) LIKE '%".strtolower($search)."%' ORDER BY descricao";// WHERE cod_exame não esteja sendo exibido
   $sql = "SELECT distinct(BTRIM(desc_detalhada_prod)) as descricao, cod_prod FROM produto
   WHERE cod_atividade = 2 AND lower(desc_detalhada_prod) LIKE '%".strtolower($search)."%' ORDER BY descricao";
   $res = pg_query($connect, $sql);
   $buffer = pg_fetch_all($res);
   $ret  = "";
   $ret .= "<table border=0 width=100% height=100% cellspacing=0 cellpadding=0>";
   for($x=0;$x<pg_num_rows($res);$x++){
      $ret .= "<tr>";
      $ret .= "<td class=hl1 style=\"cursor:pointer;\" onclick=\"document.getElementById('funcao').value='".trim($buffer[$x][descricao])."';document.getElementById('cod_prod').value='".trim($buffer[$x][cod_prod])."';document.getElementById('funcao').focus();\"><font size=1 color=white>".trim($buffer[$x][descricao])."</font></td>";
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
