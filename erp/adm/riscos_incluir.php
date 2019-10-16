<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($risco!=""){
$query_incluir="INSERT into risco_cliente (nome, descricao) values ('$risco', '$descricao')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('CNAE Incluído com Sucesso!');</script>";
header("location: riscos_adm.php");
}

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</header>
<title>Cadastrar Riscos</title><body bgcolor="#006633">
<form name="form1" method="post" action="riscos_incluir.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Nível de Tolerância</font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="97" class="fontebranca12">Risco</td>
            <td width="303"><input name="risco" type="text" id="risco" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Descri&ccedil;&atilde;o</td>
            <td><textarea name="descricao" cols="40" rows="5" class="camposform" id="descricao"></textarea></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
			<td colspan="4" class="fontebranca12">
			<table width="200" border="0" align="left" cellpadding="0" cellspacing="0">
			<tr>
            <td class="fontebranca12"><input type="submit" name="Submit" value="Incluir"></td>
			<td class="fontebranca12"><input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','riscos_adm.php'); return document.MM_returnValue" &nbsp;&nbsp; value="&lt;&lt; Voltar"></td>
			</tr></table></td>
          </tr>
	</table></td>
    </tr>
  </table>
</form>

<html>

