<?php
include "sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($cnae!=""){
$query_incluir="INSERT into cnae (cnae, descricao) values ('$cnae', '$descricao')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('CNAE Incluído com Sucesso!');</script>";
//header("location: cnae_adm.php");
}

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
<title>Sistema SESMT - Incluir CNAE</title><body bgcolor="#006633">
<form name="form1" method="post" action="cnae_incluir.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">CNAE</font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="97" class="fontebranca12">CNAE</td>
            <td width="303"><input name="cnae" type="text" id="cnae" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Descri&ccedil;&atilde;o</td>
            <td><textarea name="descricao" cols="40" rows="5" class="camposform" id="descricao"></textarea></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td><input name="btn_incluir" type="submit" id="btn_incluir" value="Incluir &amp; Repetir">
            <input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','cnae_incluir.php');return document.MM_returnValue" value="Sair"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

