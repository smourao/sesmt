<?php
include "../sessao.php";
include "../config/connect.php";

ob_start();
if($cod_vent_art!="" && $nome_vent_art!=""){
$query_alterar="update ventilacao_artificial set nome_vent_art = '$nome_vent_art', decricao_vent_art = '$decricao_vent_art' where cod_vent_art = ".$cod_vent_art."";
pg_query($query_alterar) or die ("Erro na query:$query_alterar".pg_last_error($connect));

echo"<script>
alert('Ventila��o Artificial Alterada com Sucesso!');
location.href='tipo_ventilacao_artificial_adm.php';
</script>";
}

$query="select * from ventilacao_artificial where cod_vent_art=".$cod_vent_art[0]."";
$result=pg_query($query)or die("Erro na query $query".pg_last_error($connect));
$row=pg_fetch_array($result);
?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</header>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>

<title>Alterar Ventila��o Natural</title><body bgcolor="#006633">
<form action="tipo_ventilacao_artificial_alterar.php" method="post" enctype="multipart/form-data" name="form1">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div></td>
    </tr><br>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Tipo de Ventila��o Artificial</font></div></td>
    </tr>
	<tr>
		<td width="97" class="fontebranca12">C�digo</td>
		<td width="303"><input name="cod_vent_art" type="text" id="cod_vent_art" readonly="true" value="<?=$row[cod_vent_art]?>" size="5"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Tipo Ventila��o Artificial</td>
		<td><input name="nome_vent_art" type="text" id="nome_vent_art" value="<?=$row[nome_vent_art]?>" size="30"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Descri��o</td>
		<td><textarea name="decricao_vent_art" cols="40" rows="3" class="camposform" id="decricao_vent_art"><?=$row[decricao_vent_art]?></textarea></td>
	</tr>
	</table><br>
	<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td><input type="submit" name="Submit" value="Alterar">
	<input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','tipo_ventilacao_artificial_adm.php');return document.MM_returnValue" value="Sair"></td>
	</tr>
    </table>
</form>
</body>
</html>