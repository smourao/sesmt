<?php
include "../sessao.php";
include "../config/connect.php";

ob_start();
if($tipo_edificacao_id!="" && $tipo_edificacao!=""){
$query_alterar="update tipo_edificacao set tipo_edificacao = '$tipo_edificacao', descricao = '$descricao' where tipo_edificacao_id = ".$tipo_edificacao_id."";
pg_query($query_alterar) or die ("Erro na query:$query_alterar".pg_last_error($connect));

echo"<script>
alert('Edifica��o Alterada com Sucesso!');
location.href='tipo_edificacao_adm.php';
</script>";
}

$query="select * from tipo_edificacao where tipo_edificacao_id=".$tipo_edificacao_id[0]."";
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

<title>Alterar Edifica��o</title><body bgcolor="#006633">
<form action="tipo_edificacao_alterar.php" method="post" enctype="multipart/form-data" name="form1">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div></td>
    </tr><br>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Tipo de Edifica��o</font></div></td>
    </tr>
	<tr>
		<td width="97" class="fontebranca12">C�digo</td>
		<td width="303"><input name="tipo_edificacao_id" type="text" id="tipo_edificacao_id" readonly="true" value="<?=$row[tipo_edificacao_id]?>" size="5"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Tipo Edifica��o</td>
		<td><input name="tipo_edificacao" type="text" id="tipo_edificacao" value="<?=$row[tipo_edificacao]?>" size="30"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Descri��o</td>
		<td><textarea name="descricao" cols="40" rows="3" class="camposform" id="descricao"><?=$row[descricao]?></textarea></td>
	</tr>
	</table><br>
	<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td><input type="submit" name="Submit" value="Alterar">
	<input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','tipo_edificacao_adm.php');return document.MM_returnValue" value="Sair"></td>
	</tr>
    </table>
</form>
</body>
</html>