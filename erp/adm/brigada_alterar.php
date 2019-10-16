<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($atualizar==1){
$query_atualizar="update brigadistas set classe='$classe', sub_classe='$sub_classe', descricao='$descricao', ate_10=".$ate_10.", mais_10=".$mais_10." where brigadista_id=".$brigadista_id2."";
pg_query($query_atualizar) or die ("Erro na query:$query_atualizar".pg_last_error($connect));

$query="select * from brigadistas where brigadista_id=".$brigadista_id2."";
$result=pg_query($query)or die("Erro na consulta: $query".pg_last_error($connect));
$row=pg_fetch_array($result);

echo"<script>alert('Classe de Brigada alterada com Sucesso!');</script>";
}else{

$query="select * from brigadistas where brigadista_id=".$brigadista_id[0]."";
$result=pg_query($query)or die("Erro na consulta: $query".pg_last_error($connect));
$row=pg_fetch_array($result); }

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
<title>Alterar Brigada de Inc&ecirc;ndio</title><body bgcolor="#006633">
<form name="form1" method="post" action="brigada_alterar.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Brigada</font> - Alterar </div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="97" class="fontebranca12">Classe</td>
            <td width="303"><input name="classe" type="text" id="classe" value="<?=$row[classe]?>" size="30"></td>
          </tr>
		            <tr>
            <td width="97" class="fontebranca12">Sub_classe</td>
            <td width="303"><input name="sub_classe" type="text" id="sub_classe" value="<?=$row[sub_classe]?>" size="30">
              <input name="atualizar" type="hidden" id="atualizar" value="1">
              <input name="brigadista_id2" type="hidden" id="brigadista_id2" value="<?=$row[brigadista_id]?>"></td>
		            </tr>
		            <tr>
            <td width="97" class="fontebranca12">Descricao</td>
            <td width="303"><textarea name="descricao" cols="35" rows="4" id="descricao"><?=$row[descricao]?>
            </textarea></td>
          </tr>
          <tr>
            <td class="fontebranca12">At&eacute; 10 </td>
            <td><input name="ate_10" type="text" class="camposform" id="ate_10" value="<?=$row[ate_10]?>" size="10">
            <span class="fontebranca12">            Somente N&uacute;meros </span></td>
          </tr>
		            <tr>
            <td class="fontebranca12">Acima de  10 </td>
            <td><input name="mais_10" type="text" class="camposform" id="mais_10" value="<?=$row[mais_10]?>" size="10">
              <span class="fontebranca12">Somente N&uacute;meros </span></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td><input name="btn_incluir" type="submit" id="btn_incluir" value="Alterar">
            <input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','brigada_adm.php');return document.MM_returnValue" value="Sair"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

