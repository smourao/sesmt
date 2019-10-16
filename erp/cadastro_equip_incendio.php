<?php
include "sessao.php";
include ('./config/connect.php');
include ('./config/config.php');
include ('./config/funcoes.php');


if($valor==1){
$query_insert="update setor_cliente SET
incendio_localizacao = '$localizacao', incendio_extintor= '$extintor', incendio_capacidade= '$capacidade', incendio_data_recarga= '$data_recarga', incendio_numero_cilindro= '$numero_cilindro', 
incendio_vencimento_abnt= '$vencimento_abnt', incendio_proxima_recarga= '$proxima_recarga', incendio_placa_sinalizacao= '$placa_sinalizacao', incendio_demarcacao_solo= '$demarcacao_soloo', 
incendio_tipo_instalacao= '$tipo_instalacao', incendio_empresa_prestador= '$empresa_prestador', incendio_tipo_hidrante= '$tipo_hidrante', 
incendio_diametro_mangueira= '$diametro_mangueira', incendio_quantidade_mangueira= '$quantidade_mangueira', incendio_esguicho= '$esguicho', 
incendio_chave_stors= '$chave_stors', incendio_pl_ident= '$pl_ident', incendio_demarcacao= '$demarcacao', incendio_porta_cont_fogo= '$porta_cont_fogo', 
incendio_para_raio= '$para_raio', incendio_sistema_fixo_contra_incendio= '$sistema_fixo_contra_incendio', incendio_alarme_contra= '$alarme_contra'
where cod_setor=".$setor_id." and cliente_id=".$cod_cliente." and filial_id=".$filial_id."";
}

$query_setor="select * from setor_cliente where cod_setor=".$setor_id." and cliente_id=".$cliente_id." and filial_id=".$filial_id."";
$result_setor=pg_query($query_setor)or die("Erro na query $query_setor".pg_last_error($connect));
$row_setor=pg_fetch_array($result_setor);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Sistema SESMT - Cadastro de Equipamentos de Incêndio::</title>
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
      <td colspan="2" class="fontebranca10"><input name="cliente_id" type="text" id="cod_cliente" value="<?=$cliente_id.$row_setor[cliente_id]?>" size="5"></td>
      <td colspan="2" class="fontebranca10"><input name="filial_id" type="text" id="cod_filial" value="<?=$filial_id.$row_setor[filial_id]?>" size="5"></td>
      <td colspan="4" class="fontebranca10"><input name="localicazao" type="text" id="localicazao" value="<?=$row_setor[incendio_localizacao]?>" size="15"></td>
      <td colspan="2" class="fontebranca10"><input name="extintor" type="text" id="extintor" value="<?=$row_setor[incendio_extintor]?>" size="10"></td>
      <td colspan="3" class="fontebranca10"><input name="capcacidade" type="text" id="capcacidade" value="<?=$row_setor[incendio_capacidade]?>" size="5"></td>
      <td colspan="2" class="fontebranca10"><input name="data_recarga" type="text" id="data_recarga" value="<?=$row_setor[incendio_data_recarga]?>" size="10"></td>
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
      <td colspan="2" class="fontebranca10"><input name="numero_cilindro" type="text" id="numero_cilindro" value="<?=$row_setor[incendio_numero_cilindro]?>" size="8"></td>
      <td colspan="3" class="fontebranca10"><input name="vencimento_abnt" type="text" id="vencimento_abnt" value="<?=$row_setor[incendio_vencimento_abnt]?>" size="8"></td>
      <td colspan="2" class="fontebranca10"><input name="proxima_carga" type="text" id="proxima_carga" value="<?=$row_setor[incendio_proxima_carga]?>" size="10"></td>
      <td colspan="2" class="fontebranca10"><?php
	  $tipo="placa_sinalizacao";
	  ?>
        <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
          <?php
	  ${"query_".$tipo}="select * from $tipo";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
		  if($row_setor['incendio_'.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
          <option value="<?=${"row_".$tipo}[''.$tipo.'_id']?>" <?=$selected?>>
            <?=${"row_".$tipo}['incendio_'.$tipo.'']?>
          </option>
          <?
	  }  
	  ?>
        </select></td>
      <td colspan="3" class="fontebranca10"><span class="fontebranca10">
 <?php
	  $tipo="demarcacao_solo";
	  ?>
	  <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
      <?php
	  ${"query_".$tipo}="select * from $tipo";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
		  if($row_setor['incendio_'.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
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
		  if($row_setor['incendio_'.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
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
      <td colspan="7" class="fontebranca10"><input name="empresa_prestadora" type="text" id="empresa_prestadora" value="<?=$row_setor[incendio_empresa_prestadora]?>" size="30"></td>
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
		  if($row_setor['incendio_'.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
	  $selected="selected";
	  }else{
	  $selected="";
	  }
	  ?>
          <option value="<?=${"row_".$tipo}['incendio_'.$tipo.'_id']?>" <?=$selected?>>
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
		  if($row_setor['incendio_'.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
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
      <td colspan="2" class="fontebranca10"><input name="qtd_mangueira" type="text" id="qtd_mangueira" value="<?=$row_setor[incendio_quantidade_mangueira]?>" size="5"></td>
      <td colspan="2" class="fontebranca10"><input name="esguicho" type="text" id="esguicho" value="<?=$row_setor[incendio_esguicho]?>" size="5"></td>
      <td class="fontebranca10"><input name="chave_stors" type="checkbox" class="camposform" id="chave_stors" value="checkbox"></td>
      <td colspan="3" class="fontebranca10"><input name="pl_ident" type="checkbox" id="pl_ident" value="checkbox"></td>
      <td class="fontebranca10"><input name="demarcacao" type="checkbox" id="demarcacao" value="checkbox"></td>
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
        <select name="p_contr_fogo" class="camposform" id="p_contr_fogo">
          <option>Sim</option>
          <option>N&atilde;o</option>
        </select>
      </span></td>
      <td colspan="3" class="fontebranca10"><?php
	  $tipo="tipo_para_raio";
	  ?>
        <select name="para_raio" class="camposform" id="para_raio">
          <?php
	  ${"query_".$tipo}="select * from $tipo";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
		  if($row_setor['incendio_'.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
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
        <?php
	  $tipo="tipo_sistema_fixo_contra_incendio";
	  ?>
        <select name="<?=$tipo?>" class="camposform" id="<?=$tipo?>">
          <?php
	  ${"query_".$tipo}="select * from $tipo";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
		  if($row_setor['incendio_'.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
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
        </select>
      </span></td>
      <td colspan="6" class="fontebranca10"><?php
	  $tipo="alarme_contra_incendio";
	  ?>
        <select name="<?=$tipo?>" class="camposform" id="select8">
          <?php
	  ${"query_".$tipo}="select * from $tipo";
	  ${"result_".$tipo}=pg_query(${"query_".$tipo})or die ("Erro na query: ".${'query_'.$tipo}." ".pg_last_error($connect));
	  while (${"row_".$tipo}=pg_fetch_array(${"result_".$tipo})){
		  if($row_setor['incendio_'.$tipo.'']==${"row_".$tipo}[''.$tipo.'_id']){
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
          <td width="25"><input name="cliente_id" type="hidden" id="cliente_id" value="<?=$cliente_id.$row_setor[cliente_id]?>">
            <input name="cod_setor" type="hidden" id="cod_setor" value="<?=$setor_id.$row_setor[cod_setor]?>">
            <input name="filial_id" type="hidden" id="filial_id" value="<?=$filial_id.$row_setor[filial_id]?>"></td>
          <td width="26"><input name="valor" type="hidden" id="valor" value="1" /></td>
          <td width="24">&nbsp;</td>
          <td width="25">&nbsp;</td>
          <td width="25" rowspan="2"><a href="cadastro_setor.php"><img name="cadastro_cliente_verde_r21_c18" src="img/cadastro_cliente_verde_r21_c18.gif" width="41" height="58" border="0" id="cadastro_cliente_verde_r21_c18" alt="" /></a></td>
          <td width="25">&nbsp;</td>
          <td width="25">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="gravar" type="image" id="gravar" value="gravar" src="img/icones_gravar.gif" width="52" height="37" onClick="valore('gravar');" hspace="1"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
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
