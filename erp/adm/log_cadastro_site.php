<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", "me", "ltda", "av", "rj", //Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", "me,", "ltda,", "av,", //Siglas com vírgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", "(me)", "(ltda)", "(av)", //Siglas entre parênteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "nbr", "nbr.", "me.", "ltda.", "av.", "a0", "a3", "a4", "(a4)"); //Siglas diversas
$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $at[$x] = strtolower($at[$x]);
   $at[$x] = strtr(strtolower($at[$x]),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
  if(in_array($at[$x], $siglas)){
     $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>2){
        $at[$x] = ucwords($at[$x]);
    }
	$temp .= $at[$x]." ";
}
return $temp;
}
$sql = "
SELECT id, email, nome, data_cadastro, telefone, cpf FROM reg_pessoa_fisica
UNION
SELECT id, email, razao_social as nome, data_cadastro, telefone, cnpj as cpf FROM reg_pessoa_juridica
ORDER BY data_cadastro DESC, id";
$res = pg_query($connect, $sql);
$buffer = pg_fetch_all($res);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista de cadastrados no site</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="../ajax.js"></script>
<style type="text/css" media="screen">
.excluir{
 font-family: verdana;
 color: #FF0000;
 font-size: 12px;
}
.excluir:hover{
 font-family: verdana;
 color: #fa3d3d;
 font-size: 12px;
}
</style>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="fontebranca12">
    <div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12">
    <div align="center" class="fontepreta14bold">
    <font color="#000000">Lista de cadastrados no site</font>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12" align=center><br>
        <input name="voltar" type="button" id="voltar" value="Voltar" onClick="javascript:location.href='index.php'">
    </td>
  </tr>
</table>
<?PHP
if($_GET['user']){
$pessoa = 0;
$sql = "SELECT * FROM reg_pessoa_fisica WHERE email='{$_GET['user']}'";
$result = pg_query($sql);
if(pg_num_rows($result)>0){
   $pessoa = 1;
}
if(pg_num_rows($result)<=0 && $pessoa == 0){
   $sql = "SELECT * FROM reg_pessoa_juridica WHERE email='{$_GET['user']}'";
   $result = pg_query($sql);
   if(pg_num_rows($result)>0){
      $pessoa = 2;
   }
}
if($pessoa > 0){
   $cd = pg_fetch_all($result);
}
if($pessoa == 2 || $pessoa == 1){
   echo "<center><b><font color=white>"; print $cd[0]['razao_social'] != "" ? $cd[0]['razao_social'] : $cd[0]['nome']; echo "</font></b></center>";
   echo "<table width=700 border=1 align=center>";
   echo "   <tr>";
   echo "      <td align=center class=fontebranca12><b>E-mail</b></td>";
   echo "      <td align=center class=fontebranca12><b>CPF/CNPJ</b></td>";
   echo "      <td align=center class=fontebranca12><b>Telefone</b></td>";
   echo "      <td align=center class=fontebranca12><b>Endereço</b></td>";
   echo "   </tr>";
   echo "   <tr>";
   echo "      <td align=center class=fontebranca10>{$cd[0]['email']}</td>";
   echo "      <td align=center class=fontebranca10>"; print $cd[0]['cnpj']!= ""? $cd[0]['cnpj'] : $cd[0]['cpf']; echo "</td>";
   echo "      <td align=center class=fontebranca10>{$cd[0]['telefone']}</td>";
   echo "      <td align=left class=fontebranca10>{$cd[0]['endereco']} {$cd[0]['numero']} - {$cd[0]['bairro']} - {$cd[0]['cidade']}/{$cd[0]['estado']}</td>";
   echo "   </tr>";

   echo "</table>";
}
}
?>
<p>
<?PHP echo "<div align=\"center\" class=\"fontebranca12\">Usuários cadastrados no site: ".pg_num_rows($res)."</div>";?>
<P>
<table width="700" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="10" class="linhatopodiresq"><div align="center" class="fontebranca12"><b>Nº</b></div></td>
    <td class="linhatopodiresq"><div align="center" class="fontebranca12"><b>E-mail</b></div></td>
    <td class="linhatopodir"><div align="center" class="fontebranca12"><b>Nome</b></div></td>
    <td width="100" class="linhatopodir"><div align="center" class="fontebranca12"><b>Telefone</b></div></td>
    <td width="12" class="linhatopodir"><div align="center" class="fontebranca12"><b>Data de Cadastro</b></div></td>
  </tr>
<?PHP
for($x=0;$x<pg_num_rows($res);$x++){
    echo "<tr>";
    if(strlen(str_replace("/", "", str_replace(".", "", str_replace("-", "",$buffer[$x]['cpf']))))>11){
       echo "<td class=\"linhatopodiresqbase\" align=center><div class=\"fontebranca10\"><font color=red>".($x+1)."</font></div></td>";
    }else{
       echo "<td class=\"linhatopodiresqbase\" align=center><div class=\"fontebranca10\">".($x+1)."</div></td>";
    }
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\">{$buffer[$x]['email']}</a></div></td>";
    echo "<td class=\"linhatopodiresqbase\"><div class=\"fontebranca10\" class=\"linksistema\">{$buffer[$x]['nome']}</div></td>";
    echo "<td class=\"linhatopodiresqbase\" align=center><div class=\"fontebranca10\">".$buffer[$x]['telefone']."</div></td>";
    echo "<td class=\"linhatopodiresqbase\" align=center><div class=\"fontebranca10\">".date("d/m/Y", strtotime($buffer[$x]['data_cadastro']))."</div></td>";
    echo "</tr>";
}
?>
</table>
</body>
</html>
