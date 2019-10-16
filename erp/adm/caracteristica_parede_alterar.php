<?php
include "../sessao.php";
include "../config/connect.php";

ob_start();
if($cod_parede!="" && $nome_parede!=""){
$query_alterar="update parede set nome_parede = '$nome_parede', decicao_parede = '$decicao' where cod_parede = ".$cod_parede."";
pg_query($query_alterar) or die ("Erro na query:$query_alterar".pg_last_error($connect));

echo"<script>
alert('Parede Alterada com Sucesso!!!');
location.href='caracteristica_parede_adm.php';
</script>";
}

$query="select * from parede where cod_parede=".$cod_parede[0]."";
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

<title>Alterar da Parede</title><body bgcolor="#006633">
<form action="caracteristica_parede_alterar.php" method="post" enctype="multipart/form-data" name="form1">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div></td>
    </tr><br>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Tipo de Parede</font></div></td>
    </tr>
	<tr>
		<td width="97" class="fontebranca12">Código</td>
		<td width="303"><input name="cod_parede" type="text" id="cod_parede" readonly="true" value="<?=$row[cod_parede]?>" size="5"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Tipo de parede</td>
		<td><input name="nome_parede" type="text" id="nome_parede" value="<?=$row[nome_parede]?>" size="30"></td>
	</tr>
	<tr>
		<td class="fontebranca12">Descrição</td>
		<td><textarea name="decicao" cols="40" rows="3" class="camposform" id="decicao"><?=$row[decicao_parede]?></textarea></td>
	</tr>
	</table><br>
	<table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	<td><input type="submit" name="Submit" value="Alterar">
	<input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','caracteristica_parede_adm.php');return document.MM_returnValue" value="Sair"></td>
	</tr>
    </table>
</form>
</body>
</html>