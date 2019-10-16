<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($cliente_id!=""){
$query_incluir="INSERT into fatura2 (nome, cliente_id, filial_id) values ('$nome', '$cliente_id', '$filial_id')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('fatura  Incluída com Sucesso!');</script>";
//header("location: cnae007.php");
}

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</header>

<body bgcolor="#006633">
<form name="form1" method="post" action="cnae007.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">fatura</font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="97" class="fontebranca12">nome</td>
            <td width="303"><input name="nome" type="text" id="nome" size="30"></td>
          </tr>
		            <tr>
            <td width="97" class="fontebranca12">cliente id</td>
            <td width="303"><input name="cliente_id" type="text" id="cliente_id" size="30">
</td>
		            </tr>
		            <tr>
            <td width="97" class="fontebranca12">filial id</td>
            <td width="303"><input name="filial_id" type="text" id="filial_id" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">fatura_id</td>
            <td><input type="text" size="30"></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td><input name="btn_incluir" type="submit" id="btn_incluir" value="gerar">
            </td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

