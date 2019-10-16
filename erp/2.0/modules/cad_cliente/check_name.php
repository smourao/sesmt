<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";
$search = addslashes($_GET['name']);
$cod_cliente = addslashes($_GET[cod_cliente]);

if(!empty($search)){
   $sql = "SELECT * FROM funcionarios WHERE lower(nome_func) LIKE '%".strtolower($search)."%' AND cod_cliente = $cod_cliente ORDER BY nome_func";
   $res = pg_query($connect, $sql);
   $buffer = pg_fetch_all($res);
   $ret  = "";
   $ret .= "<table border=0 width=100% height=100% cellspacing=0 cellpadding=0>";
   for($x=0;$x<pg_num_rows($res);$x++){
      $ret .= "<tr>";
      //$ret .= "<td class=hl1 style=\"cursor:pointer;\" onclick=\"document.getElementById('empresa').value='".trim($buffer[$x][razao_social])."';document.getElementById('cod_cliente').value='".trim($buffer[$x][cliente_id])."';document.getElementById('cod_filial').value='".trim($buffer[$x][filial_id])."';document.getElementById('empresa').focus();document.getElementById('sgt').style.display = 'none';\"><font size=1 color=white>".trim($buffer[$x][razao_social])."</font></td>";
      $ret .= "<td class=hl1 style=\"cursor:pointer;\" onclick=\"document.getElementById('sgt').style.display = 'none';\"><font size=1 color=white>".trim($buffer[$x][nome_func])."</font></td>";
      $ret .= "</tr>";
   }
   $ret .= "</table>";
   echo $ret;
}else{
   $ret  = "";
   $ret .= "<table border=0 width=100% height=100% cellspacing=0 cellpadding=0>";
   $ret .= "<tr>";
   $ret .= "<td class=hl1 style=\"cursor:pointer;\"><font size=1 color=white></font></td>";
   $ret .= "</tr>";
   $ret .= "</table>";
   echo $ret;
}
?>
