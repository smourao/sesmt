<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($cidade!=""){
$query_incluir="INSERT into cidade (uf, cidade, ddd) values ('$uf', '$cidade', '$ddd')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('Cidade Incluída com Sucesso!');</script>";
header("location: cidade_adm.php");
}

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</header>
<title>Cadastro de Cidades</title><body bgcolor="#006633">
<form name="form1" method="post" action="cidade_incluir.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Cidade</font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="97" class="fontebranca12">Estado</td>
            <td width="303"><select name="uf" id="uf">
			<?php
			$query_uf="select * from uf";
			$result_uf=pg_query($query_uf)or die("Erro na query: $query_uf".pg_last_error($connect));
			while($row_uf=pg_fetch_array($result_uf)){
			echo "<option value='".$row_uf[estado]."'>".$row_uf[estado]."</option>";
			} 
			?>
            </select>
            </td>
          </tr>
          <tr>
            <td class="fontebranca12">Cidade</td>
            <td><input name="cidade" type="text" class="camposform" id="cidade" value="" size="40"></td>
          </tr>
          <tr>
            <td class="fontebranca12">C&oacute;d. DDD</td>
            <td><input name="ddd" type="text" class="camposform" id="ddd" value="" size="40"> 
              <span class="fontebranca10">(n&atilde;o colocar o zero ex: 21)</span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
			<td colspan="4" class="fontebranca12">
			<table width="200" border="0" align="left" cellpadding="0" cellspacing="0">
			<tr>
            <td class="fontebranca12"><input type="submit" name="Submit" value="Incluir"></td>
			<td class="fontebranca12"><input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','cidade_adm.php'); return document.MM_returnValue" &nbsp;&nbsp; value="&lt;&lt; Voltar"></td>
			</tr></table>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

