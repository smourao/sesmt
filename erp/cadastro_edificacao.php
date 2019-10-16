<?php
include "sessao.php";
include ('./config/connect.php');
include ('./config/config.php');
include ('./config/funcoes.php');

if($valor=='gravar'){

$query_grava="update setor_cliente SET tipo_edificacao=".$descricao.", tipo_ventilacao_natural=".$descricao.", tipo_ventilacao_artificial=".$descricao.", tipo_iluminacao_natural=".$descricao.", tipo_iluminacao_artificial=".$descricao.", numero_pavimento=".$numero_pavimento.", altura='$altura', frente='$frente', comprimento='$comprimento', caracteristica_piso=".$caracteristica_piso.", caracteristica_parede=".$caracteristica_parede.", caracteristica_cobertura=".$caracteristica_cobertura." where setor_id=".$setor_id.""; 
$result_grava=pg_query($query_grava) or die ("Erro ao gravar dados: $query_grava".pg_last_error($connect));

}

$query="select * from setor_cliente where setor_id=".$setor_id."";
$result=pg_query($query)or die ("Erro na query: $query".pg_last_error($connect));
$row_setor=pg_fetch_array($result);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Sistema SESMT - Cadastro de Edificação::</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css" />
<script>
var botoes;
function valore(botoes){
	document.cadastro.valor.value=botoes;
	}

</script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form id="form1" name="form1" method="post" action="">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2" class="fontebranca10"><div align="center" class="fontebranca22bold">CADASTRO DE EDIFICA&Ccedil;&Atilde;O </div></td>
    </tr>
    <tr>
      <td class="fontebranca10">&nbsp;</td>
      <td class="fontebranca10">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" class="fontebranca10">TIPO DE EDIFICA&Ccedil;&Atilde;O </td>
      <td height="25" class="fontebranca10">TIPO DE ILUMINA&Ccedil;&Atilde;O NATURAL </td>
    </tr>
    <tr>
      <td height="25" class="fontebranca10">
	  <?php
	  $tipo="descricao";
	  ?>
	  <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
      <?php
	  ${"query_".$tipo}="select * from tipo_edificacao";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
		  if($row_setor[''.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
	  
	   <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>><?=${"row_".$tipo}[''.$tipo.'']?></option>
	  <?
	  }  
	  
	  ?>
	  </select>      </td>
            <td height="25" class="fontebranca10"><?php
	   $tipo="descricao";
	  ?>
        <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
          <?php
	  ${"query_".$tipo}="select * from tipo_iluminacao_natural";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
		  if($row_setor[''.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
          <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>>
            <?=${"row_".$tipo}[''.$tipo.'']?>
          </option>
          <?
	  }  
	  
	  ?>
        </select></td>
    </tr>
	<tr>
      <td height="25" class="fontebranca10">&nbsp;</td>
      <td height="25" class="fontebranca10">&nbsp;</td>
    </tr>
	<tr>
	  
      <td height="25" class="fontebranca10">TIPO DE VENTILA&Ccedil;&Atilde;O NATURAL </td>
      <td height="25" class="fontebranca10">TIPO DE VENTILA&Ccedil;&Atilde;O ARTIFICIAL </td>
	</tr>
	<tr>
	  <td height="25" class="fontebranca10"><?php
	  $tipo="descricao";
	  ?>
        <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
          <?php
	  ${"query_".$tipo}="select * from tipo_ventilacao_natural";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
	  if($row_setor[''.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
          <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>> <?=${"row_".$tipo}[''.$tipo.'']?> </option>
      <?
	  }  
	  
	  ?>
        </select></td>
      <td height="25" class="fontebranca10"><?php
	 $tipo="descricao";
	  ?>
        <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
          <?php
	  ${"query_".$tipo}="select * from tipo_ventilacao_artificial";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
	  if($row_setor[''.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
          <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>>
            <?=${"row_".$tipo}[''.$tipo.'']?>
          </option>
          <?
	  }  
	  
	  ?>
        </select></td>
	</tr>
    <tr>
      <td height="25" class="fontebranca10"><table width="174" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="84">NUMERO PAV. </td>
            <td width="78">ALTURA</td>
          </tr>
          <tr>
            <td><input name="numero_pavimento" type="text" id="numero_pavimento" value="<?=$row_setor['numero_pavimento']?>" size="5" /></td>
            <td><input name="altura" type="text" id="altura" value="<?=$row_setor['altura']?>" size="5" /></td>
          </tr>
      </table></td>
      <td height="25" class="fontebranca10"><table width="162" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="81">FRENTE</td>
            <td width="81">COMPRIMENTO</td>
          </tr>
          <tr>
            <td><input name="frente" type="text" id="frente" value="<?=$row_setor['frente']?>" size="5" /></td>
            <td><input name="comprimento" type="text" id="comprimento" value="<?=$row_setor['comprimento']?>" size="5" /></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td height="25" class="fontebranca10">&nbsp;</td>
      <td height="25" class="fontebranca10">&nbsp;</td>
    </tr>
    <tr>
      <td height="25" class="fontebranca10">CARCATERISTICA DO PISO </td>
      <td height="25" class="fontebranca10">CARACTERISTICA DA PAREDE</td>
    </tr>
    <tr>
      <td height="25" class="fontebranca10"><?php
	  $tipo="caracteristica_piso";
	  ?>
        <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
          <?php
	  ${"query_".$tipo}="select * from $tipo";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
	  if($row_setor[''.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
          <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>>
            <?=${"row_".$tipo}[''.$tipo.'']?>
          </option>
          <?
	  }  
	  
	  ?>
        </select></td>
      <td height="25" class="fontebranca10"><?php
	   $tipo="caracteristica_parede";
	   
	  ?>
        <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
          <?php
	  ${"query_".$tipo}="select * from $tipo";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
	  if($row_setor[''.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
          <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>>
          <?=${"row_".$tipo}[''.$tipo.'']?>
          <?php $row_setor[''.$tipo.''];?>
          </option>
          <?
	  }  
	  
	  ?>
                </select></td>
    </tr>
	 <tr>
      <td height="25" class="fontebranca10">CARACTERISTICA DE COBERTURA</td>
      <td height="25" class="fontebranca10">TIPO DE ILUMINA&Ccedil;&Atilde;O ARTIFICIAL </td>
    </tr>
    <tr>
      <td height="25" class="fontebranca10"><?php
	   $tipo="caracteristica_cobertura";
	  ?>
        <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
          <?php
	  ${"query_".$tipo}="select * from $tipo";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
		  if($row_setor[''.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
          <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>>
          <?=${"row_".$tipo}[''.$tipo.'']?>
          </option>
          <?
	  }  
	  
	  ?>
                </select></td>
      <td height="25" class="fontebranca10"><?php
	  $tipo="descricao";
		  ?>
        <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
          <?php
	  ${"query_".$tipo}="select * from tipo_iluminacao_artificial";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
	  if($row_setor[''.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
          <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>>
            <?=${"row_".$tipo}[''.$tipo.'']?>
          </option>
          <?
	  }  
	  
	  ?>
      </select></td>
    </tr>
    <tr>
      <td class="fontebranca10">&nbsp;</td>
      <td class="fontebranca10">&nbsp;</td>
    </tr>
    <tr>
          <td width="25">&nbsp;</td>
          <td width="25">&nbsp;</td>

        </tr>
		
        <tr>
			<div align="center">
          <td colspan="2" align="center" class="fontebranca10">
            <input name="gravar" type="image" id="gravar" value="gravar" src="img/icones_gravar.gif" width="52" height="52" onclick="valore('gravar');" hspace="1" />&nbsp;&nbsp;&nbsp;
            <a href="cadastro_setor.php?valor=bucar&cod_cliente=<?=$row[cliente_id]?>"><img name="cadastro_cliente_verde_r21_c18" src="img/cadastro_cliente_verde_r21_c18.gif" width="41" height="56" border="0" id="cadastro_cliente_verde_r21_c18"/></a></td>
		</div>
        </tr>
      </table>
        <input name="setor_id" type="hidden" id="setor_id" value="<?=$row_setor[setor_id]?>" /><input name="valor" type="hidden" id="valor" value="gravar"></td>
      
   
</form>
</body>
</html>
