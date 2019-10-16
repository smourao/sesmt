<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($cnae!=""){
$query_incluir="INSERT into cnae_atual (cnae, cnae_novo, descricao, grau_risco, grupo_cipa) values ('$cnae', '$cnae_novo', '$descricao', '$grau_risco', '$grupo_cipa')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('CNAE Incluído com Sucesso!');</script>";
//header("location: cnae_atual_adm.php");
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
<title>Cadastro do CNAE</title><body bgcolor="#006633">
<form name="form1" method="post" action="cnae_atual_incluir.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">CNAE ATUAL</font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="97" class="fontebranca12">CNAE</td>
            <td width="303"><input name="cnae" type="text" id="cnae" size="30"></td>
          </tr>
		  <tr>
            <td width="97" class="fontebranca12">CNAE_NOVO</td>
            <td width="303"><input name="cnae_novo" type="text" id="cnae_novo" size="30"></td>
          </tr>
		            <tr>
            <td width="97" class="fontebranca12">Grau de Risco </td>
            <td width="303">
			<select name="grau_risco">
              <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			  <option value="4">4</option>
			 
            </select>
            </td>
		            </tr>
		            <tr>
            <td width="97" class="fontebranca12">Grupo</td>
            <td width="303"><input name="grupo_cipa" type="text" id="grupo_cipa" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Descri&ccedil;&atilde;o</td>
            <td><textarea name="descricao" cols="40" rows="5" class="camposform" id="descricao"></textarea></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td><input name="btn_incluir" type="submit" id="btn_incluir" value="Incluir &amp; Repetir">
            <input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','cnae_atual_adm.php');return document.MM_returnValue" value="Sair"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

