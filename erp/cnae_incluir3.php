<?php
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";
ob_start();
if($cliente_id!=""){
$query_incluir="INSERT into faturas (fatura_id, filial_id, cnpj_id, cobranca) values ('$fatura_id', '$filial_id', '$cobranca', '$cnpj_id')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('fatura Incluído com Sucesso!');</script>";
//header("location: cnae_adm.php");
}

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</header>

<title>Sistema SESMT - Incluir CNAE</title><body bgcolor="#006633">
<form name="form1" method="post" action="cnae_incluir2.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Gerar
          Fatura</div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">gerar</font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="788" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="303" class="fontebranca12">cliente</td>
            <td width="303" class="fontebranca12">filial</td>
            <td width="303" class="fontebranca12">cobran&ccedil;a</td>
            <td width="322">CNPJ</td>
          </tr>
		            <tr>
            
            <td width="303">
			
            </td>
		            </tr>
		            <tr>
		              <td class="fontebranca12"><input name="fatura_id" type="text" id="cliente_id2" size="30"></td>
		              <td><input name="filial_id" type="text" id="filial_id4" size="30"></td>
		              <td><input name="cobranca" type="text" id="cobranca6" size="30"></td>
		              <td><input name="cnpj_id" type="text" id="cnpj_id" size="30"></td>
          </tr>
		            <tr>
            <td width="303" class="fontebranca12">&nbsp;</td>
            <td width="303">&nbsp;</td>
            <td width="303">&nbsp;</td>
            <td width="322">&nbsp;</td>
          </tr>
          <tr>
            <td class="fontebranca12">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input name="btn_incluir" type="submit" id="btn_incluir2" value="gerar"></td>
            <td>&nbsp;            </td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

