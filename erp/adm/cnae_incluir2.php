<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
if($valor=="gravar"){

	$query_insert="insert into faturas (razao_social, fatura_id, cliente_id, filial_id) values('$razao_social', '$fatura_id', '$cliente_id', $filial_id)";
	$result_insert=pg_query($query_insert)or die("erro ao inserir dados $query_insert".pg_last_error($connect));
	
	$query_cliente_cod="select fatura_id from setor_cliente where razao_social='$razao_social' and fatura_id='$fatura_id' and cliente_id=$cliente_id and filial_id=$filial_id";
	$result_cliente_cod =pg_query($query_cliente_cod) or die ("Erro na query $query_cliente_cod".pg_last_error($connect));
	$row_cliente_cod=pg_fetch_array($result_cliente_cod);
	$cod_cliente=$row_cliente_cod[cliente_id];
	$valore='gravar';
	
	$valor="buscar";
}



?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</header>

<body bgcolor="#006633">
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
            <td width="303" class="fontebranca12">razao_social</td>
            <td width="322">fatura_id</td>
          </tr>
		            <tr>
            
            <td width="303">
			
            </td>
		            </tr>
		            <tr>
		              <td class="fontebranca12"><input name="cliente_id" type="text" id="cliente_id2" size="30"></td>
		              <td><input name="filial_id" type="text" id="filial_id4" size="30"></td>
		              <td><input name="razao_social" type="text" id="cobranca6" size="30"></td>
		              <td><input name="fatura_id" type="text" id="fatura_id" size="30"></td>
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
            <td><input type="image" name="apagar" src="img/cadastro_cliente_verde_r22_c5.gif" width="52" height="37" onClick="valore('apagar');" /></td>
            <td><input name="btn_incluir" type="submit" id="btn_incluir2" value="gerar"></td>
            <td>&nbsp;            </td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

