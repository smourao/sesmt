<?php
include "../sessao.php";
include ('./config/connect.php');
include ('./config/config.php');
include ('./config/funcoes.php');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Sistema SESMT - Cadastro de Equipamentos::</title>
<style type="text/css">




td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
</style>
<link href="css_js/css.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form id="form1" name="form1" method="post" action="">
  <table width="676" border="0" align="center" cellpadding="0" cellspacing="0">
    <!-- fwtable fwsrc="sistema_cadastro_equip_incendio.png" fwbase="cadastro_equip_incendio.png" fwstyle="Dreamweaver" fwdocid = "1175098993" fwnested="0" -->
    <tr>
      <td><img src="img/spacer.gif" width="18" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="73" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="19" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="36" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="38" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="15" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="53" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="47" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="61" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="32" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="60" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="61" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="7" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="24" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="51" height="1" border="0" alt="" /></td>
      <td class="fontebranca10"><img src="img/spacer.gif" width="81" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="1" height="1" border="0" alt="" /></td>
    </tr>
    <tr>
      <td rowspan="12">&nbsp;</td>
      <td colspan="15" class="fontebranca22bold"><div align="center">Cadastro de Equipamento Contra Inc&ecirc;ndio </div></td>
      <td><img src="img/spacer.gif" width="1" height="58" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="2" class="fontebranca10">Cod Cliente </td>
      <td colspan="2" class="fontebranca10">Cod Filial </td>
      <td colspan="4" class="fontebranca10">Localiza&ccedil;&atilde;o</td>
      <td colspan="2" class="fontebranca10">Extintor</td>
      <td colspan="3" class="fontebranca10">Capacidade</td>
      <td colspan="2" class="fontebranca10">Data da Recarga </td>
      <td><img src="img/spacer.gif" width="1" height="14" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="2" class="fontebranca10"><input name="textfield" type="text" size="5"></td>
      <td colspan="2" class="fontebranca10"><input name="textfield2" type="text" size="5"></td>
      <td colspan="4" class="fontebranca10"><input name="textfield3" type="text" size="15"></td>
      <td colspan="2" class="fontebranca10"><input name="textfield4" type="text" size="10"></td>
      <td colspan="3" class="fontebranca10"><input name="textfield5" type="text" size="5"></td>
      <td colspan="2" class="fontebranca10"><input name="textfield6" type="text" size="10"></td>
      <td><img src="img/spacer.gif" width="1" height="31" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="2" class="fontebranca10">N&ordm; do Cilindro </td>
      <td colspan="3" class="fontebranca10">Venc ABNT </td>
      <td colspan="2" class="fontebranca10">Prox. Carga </td>
      <td colspan="2" class="fontebranca10">Placa de Sinaliza&ccedil;&atilde;o </td>
      <td colspan="3" class="fontebranca10">Demarca&ccedil;&atilde;o do Solo </td>
      <td colspan="3" class="fontebranca10">Tipo de Instala&ccedil;&atilde;o </td>
      <td><img src="img/spacer.gif" width="1" height="12" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="2" class="fontebranca10"><input name="textfield8" type="text" size="8"></td>
      <td colspan="3" class="fontebranca10"><input name="textfield7" type="text" size="8"></td>
      <td colspan="2" class="fontebranca10"><input name="textfield22" type="text" size="10"></td>
      <td colspan="2" class="fontebranca10"><?php
	  $tipo="placa_sinalizacao";
	  ?>
        <select name="select2" class="camposform" id="select2">
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
      <td colspan="3" class="fontebranca10"><span class="fontebranca10">
 <?php
	  $tipo="tipo_edificacao";
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
	  
	   <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>><?=${"row_".$tipo}[''.$tipo.'']?></option>
	  <?
	  }  
	  ?>
	  </select>
      </span></td>
      <td colspan="3" class="fontebranca10"><?php
	  $tipo="tipo_instalacao";
	  ?>
        <select name="select" class="camposform" id="select">
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
      <td><img src="img/spacer.gif" width="1" height="34" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="7" class="fontebranca10">Empresa Prestadora dos Servi&ccedil;os </td>
      <td colspan="8" rowspan="2" class="fontebranca10">&nbsp;</td>
      <td><img src="img/spacer.gif" width="1" height="11" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="7" class="fontebranca10"><input name="textfield82" type="text" size="30"></td>
      <td><img src="img/spacer.gif" width="1" height="31" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="3" class="fontebranca10">Tipo de Hidrante </td>
      <td colspan="3" class="fontebranca10">Di&acirc;metro da Man </td>
      <td colspan="2" class="fontebranca10"> Qtd. Mangueira </td>
      <td colspan="2" class="fontebranca10">Esquicho</td>
      <td class="fontebranca10">C. Stors </td>
      <td colspan="3" class="fontebranca10">Pl. Ident </td>
      <td class="fontebranca10">Demarca&ccedil;&atilde;o</td>
      <td><img src="img/spacer.gif" width="1" height="13" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="3" class="fontebranca10"><?php
	  $tipo="tipo_hidrante";
	  ?>
        <select name="select3" class="camposform" id="select3">
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
      <td colspan="3" class="fontebranca10"><?php
	  $tipo="diametro_mangueira";
	  ?>
        <select name="select4" class="camposform" id="select4">
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
      <td colspan="2" class="fontebranca10"><input name="textfield72" type="text" size="5"></td>
      <td colspan="2" class="fontebranca10"><input name="textfield722" type="text" size="5"></td>
      <td class="fontebranca10"><input name="checkbox" type="checkbox" class="camposform" value="checkbox"></td>
      <td colspan="3" class="fontebranca10"><input type="checkbox" name="checkbox2" value="checkbox"></td>
      <td class="fontebranca10"><input type="checkbox" name="checkbox3" value="checkbox"></td>
      <td><img src="img/spacer.gif" width="1" height="31" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10">P. Contr. Fogo </td>
      <td colspan="3" class="fontebranca10">Para Raio </td>
      <td colspan="5" class="fontebranca10">Sistema Fixo Contra Inc&ecirc;ndio </td>
      <td colspan="6" class="fontebranca10">Alarme contra Inc&ecirc;ndio </td>
      <td><img src="img/spacer.gif" width="1" height="12" border="0" alt="" /></td>
    </tr>
    <tr>
      <td class="fontebranca10"><span class="fontebranca10">
        <select name="select5" class="camposform" id="select5">
          <option>Sim</option>
          <option>N&atilde;o</option>
        </select>
      </span></td>
      <td colspan="3" class="fontebranca10"><?php
	  $tipo="tipo_para_raio";
	  ?>
        <select name="select6" class="camposform" id="select6">
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
      <td colspan="5" class="fontebranca10"><span class="fontebranca10">
        <select name="select7" class="camposform" id="select7">
          <option>Tipo Exemplo</option>
        </select>
      </span></td>
      <td colspan="6" class="fontebranca10"><?php
	  $tipo="alarme_contra_incendio";
	  ?>
        <select name="select8" class="camposform" id="select8">
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
      <td><img src="img/spacer.gif" width="1" height="30" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="15" class="fontebranca10"><table width="519" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="25" height="12">&nbsp;</td>
          <td width="25">&nbsp;</td>
          <td width="26">&nbsp;</td>
          <td width="24">&nbsp;</td>
          <td width="25">&nbsp;</td>
          <td width="25" rowspan="2"><img name="cadastro_cliente_verde_r21_c18" src="img/cadastro_cliente_verde_r21_c18.gif" width="41" height="58" border="0" id="cadastro_cliente_verde_r21_c18" alt="" /></td>
          <td width="25">&nbsp;</td>
          <td width="25">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><img name="cadastro_cliente_verde_r22_c3" src="img/cadastro_cliente_verde_r22_c3.gif" width="53" height="37" border="0" id="cadastro_cliente_verde_r22_c3" alt="" /></td>
          <td><img name="cadastro_cliente_verde_r22_c5" src="img/cadastro_cliente_verde_r22_c5.gif" width="52" height="37" border="0" id="cadastro_cliente_verde_r22_c5" alt="" /></td>
          <td><img name="cadastro_cliente_verde_r22_c9" src="img/cadastro_cliente_verde_r22_c9.gif" width="53" height="38" border="0" id="cadastro_cliente_verde_r22_c9" alt="" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
      <td><img src="img/spacer.gif" width="1" height="50" border="0" alt="" /></td>
    </tr>
  </table>
</form>
</body>
</html>
