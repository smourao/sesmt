<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($classe!=""){
$query_incluir="INSERT into brigadistas (classe, sub_classe, descricao, ate_10, mais_10) values ('$classe', '$sub_classe', '$descricao', ".$ate_10.", ".$mais_10.")";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('Classe de Brigada Incluída com Sucesso!');</script>";
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
<title>Cadastrar Bigada de Inc&ecirc;ndio</title><body bgcolor="#006633">
<form name="form1" method="post" action="brigada_incluir.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Brigada</font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="97" class="fontebranca12">Classe</td>
            <td width="303"><input name="classe" type="text" id="classe" size="30"></td>
          </tr>
		            <tr>
            <td width="97" class="fontebranca12">Sub_classe</td>
            <td width="303"><input name="sub_classe" type="text" id="sub_classe" size="30"></td>
		            </tr>
		            <tr>
            <td width="97" class="fontebranca12">Descricao</td>
            <td width="303"><textarea name="descricao" cols="35" rows="4" id="descricao"></textarea></td>
          </tr>
          <tr>
            <td class="fontebranca12">At&eacute; 10 </td>
            <td><input name="ate_10" type="text" class="camposform" id="ate_10" value="" size="10">
            <span class="fontebranca12">            Somente N&uacute;meros </span></td>
          </tr>
		            <tr>
            <td class="fontebranca12">Acima de  10 </td>
            <td><input name="mais_10" type="text" class="camposform" id="mais_10" value="" size="10">
              <span class="fontebranca12">Somente N&uacute;meros </span></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td><input name="btn_incluir" type="submit" id="btn_incluir" value="Incluir &amp; Repetir">
            <input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','brigada_adm.php');return document.MM_returnValue" value="Sair"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

