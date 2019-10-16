<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";
ob_start();
if($grupo_cipa!=""){
$query_alterar="update cnae_novo SET cnae_novo='$cnae_novo', descricao='$descricao', grau_risco='$grau_risco', grupo_cipa='$grupo_cipa' where cnae_id=".$cnae_id."";
pg_query($query_alterar) or die ("Erro na query:$query_alterar".pg_last_error($connect));

$query="select * from cnae_novo where cnae_id=".$cnae_id."";
$result=pg_query($query) or die ("Erro na query:$query".pg_last_error($connect));
$row=pg_fetch_array($result);
echo"<script>alert('CNAE_Novo Alterado com Sucesso!');</script>";
//header("location: cnae_atual_adm.php");
}
if($grupo_cipa==""){
$query="select * from cnae_novo where cnae_id=".$cnae_id[0]."";
$result=pg_query($query) or die ("Erro na query:$query".pg_last_error($connect));
$row=pg_fetch_array($result);
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
<title>Alterar CNAE</title><body bgcolor="#006633">
<form name="form1" method="post" action="cnae_novo_alterar.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">CNAE ATUAL</font> - Alterar </div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="97" height="25" bgcolor="#008C46" class="fontebranca12">CNAE</td>
            <td width="303" bgcolor="#008C46" class="fontebranca12"><?=$row[cnae]?>
            <input name="cnae_id" type="hidden" id="cnae_id" value="<?=$row[cnae_id]?>"></td>
          </tr>
		  <tr>
            <td width="97" height="25" class="fontebranca12">CNAE_NOVO</td>
            <td width="303"><input name="cnae_novo" type="text" id="cnae_novo" value="<?=$row[cnae_novo]?>" size="30"></td>
          </tr>
		  <?php /*?><tr>
		  	<td width="97" class="fontebranca12">CNAE_NOVO</td>
			<td width="303"> <input name="cnae_novo" type="hidden" id="cnae_novo" 
			value=<?=$row[cnae_novo]?>></td>
		  </tr><?php */?>
		            <tr>
            <td width="97" class="fontebranca12">Grau de Risco </td>
            <td width="303">
			<select name="grau_risco">
              <option value="1"<?php if($row[grau_risco]==1){echo "selected";}?>>1</option>
			  <option value="2"<?php if($row[grau_risco]==2){echo "selected";}?>>2</option>
			  <option value="3"<?php if($row[grau_risco]==3){echo "selected";}?>>3</option>
			  <option value="4"<?php if($row[grau_risco]==4){echo "selected";}?>>4</option>
            </select>            </td>
		            </tr>
		            <tr>
            <td width="97" class="fontebranca12">Grupo</td>
            <td width="303"><input name="grupo_cipa" type="text" id="grupo_cipa" 
							value="<?=$row[grupo_cipa]?>" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Descri&ccedil;&atilde;o</td>
            <td><textarea name="descricao" cols="40" rows="5" class="camposform" 
			id="descricao"><?=$row[descricao]?>
            </textarea></td>
          </tr>

          <tr>
            <td>&nbsp;</td>
            <td><input name="btn_gravar" type="submit" id="btn_gravar" value="Gravar">
            <input name="btn1" type="submit" id="btn1" onClick="MM_goToURL('parent','cnae_novo_adm.php');return document.MM_returnValue" value="Sair"></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>

<html>

