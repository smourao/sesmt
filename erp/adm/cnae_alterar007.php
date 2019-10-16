<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($cliente_id!=""){
$query_alterar="update fatura2 SET nome='$nome', filial_Id='$filial_id', fatura_id='$fatura_id' where cliente_id=".$cliente_id."";
pg_query($query_alterar) or die ("Erro na query:$query_alterar".pg_last_error($connect));

$query="select * from fatura2 where cliente_id=".$cliente_id."";
$result=pg_query($query) or die ("Erro na query:$query".pg_last_error($connect));
$row=pg_fetch_array($result);
echo"<script>alert('cliente  Alteradp com Sucesso!');</script>";
//header("location: cnae_alterar007.php");
}
if($cliente_id==""){
$query="select * from fatura2 where cliente_id=".$cliente_id."";
$result=pg_query($query) or die ("Erro na query:$query".pg_last_error($connect));
$row=pg_fetch_array($result);
}


?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</header>

<body bgcolor="#006633">
<form name="form1" method="post" action="cnae_alterar.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">CNAE</font> - Alterar </div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="97" height="25" bgcolor="#008C46" class="fontebranca12">CNAE</td>
            <td width="303" bgcolor="#008C46" class="fontebranca12"><?=$row[fatura_2]?>
            <input name="fatura_id" type="hidden" id="fatura_id" value="<?=$row[fatura_id]?>"></td>
          </tr>
		            <tr>
		              <td class="fontebranca12">&nbsp;</td>
		              <td>&nbsp;</td>
          </tr>
		            <tr>
            <td width="97" class="fontebranca12">nome</td>
            <td width="303"><input name="nome" type="text" id="nome" value="<?=$row[nome]?>" size="30">
            </td>
		            </tr>
		            <tr>
            <td width="97" class="fontebranca12">Grupo</td>
            <td width="303"><input name="cliente_id" type="text" id="cliente_id" value="<?=$row[cliente_id]?>" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">filial</td>
            <td><input name="filial_id" type="text" id="filial_id" value="<?=$row[filial_id]?>" size="30"></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td><input name="btn_gravar" type="submit" id="btn_gravar" value="Gravar">
            <input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','cnae_adm.php');return document.MM_returnValue" value="Sair"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

