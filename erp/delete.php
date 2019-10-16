<?php
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";

if($valor=="continuar"){

header('location: '.$menu.'?setor_id='.$cod_setor.'&cliente_id='.$cod_cliente.'&filial_id='.$filial_id.'');
}

if($valor=="buscar"){

	$query_cliente_cod="select cliente_id from cliente where cliente_id=".$cod_cliente."";
	$result_cliente_cod =pg_query($query_cliente_cod) or die ("Erro na query $query_cliente_cod".pg_last_error($connect));
	$row_cliente_cod=pg_fetch_array($result_cliente_cod);
	if ($teste_cliente_cod=pg_num_rows($result_cliente_cod) < 1) {
	
		
		echo '<script> alert("Cliente não Cadastrado!");</script>';
	
	}else {
		
		$query_cliente_filial="select cnpj, filial_id from cliente where cliente_id=".$cod_cliente."";
		$result_cliente_filial=pg_query($query_cliente_filial) or die ("Erro na query $query_cliente_filial".pg_last_error($connect));
		if($filial_id!=""){
		$query_setor="select * from setor where cliente_id=".$cod_cliente." and filial_id=".$filial_id."";
		$result_setor=pg_query($query_setor) or die("Erro na query:$query_setor".pg_last_error($connect));
		if($numero=pg_num_rows($result_setor)>=1){
		$valore="busca";
		}
		}
	
	}
	

}

	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema SESMT - Tela Deletar</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
td img {display: block;}
</style>

<script>
<!--
var botoes;
function valore(botoes){
	document.cadastro.valor.value=botoes;
	}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body bgcolor="#006633" >
<form action="cadastro_setor.php" method="post" enctype="multipart/form-data" name="cadastro" target="_self" id="cadastro">
  <table width="527" border="0" align="center" cellpadding="0" cellspacing="0">
    <!-- fwtable fwsrc="cadastro_setor.png" fwbase="cadastro_setor.png" fwstyle="Dreamweaver" fwdocid = "1518084642" fwnested="0" -->
    <tr>
      <td><img src="img/spacer.gif" width="19" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="39" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="33" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="24" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="26" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="30" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="68" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="6" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="12" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="19" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="48" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="33" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="28" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="49" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="93" height="1" border="0" alt="" /></td>
      <td><img src="img/spacer.gif" width="1" height="1" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="15"><div align="center" class="fontebranca22bold">Cadastro de Setor </div></td>
      <td><img src="img/spacer.gif" width="1" height="49" border="0" alt="" /></td>
    </tr>
    <tr>
      <td rowspan="10">&nbsp;</td>
      <td colspan="14" valign="top"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="25" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="3" class="fontebranca10">Cod. Cliente </td>
      <td rowspan="2" class="fontebranca10">&nbsp;</td>
      <td colspan="2" class="fontebranca10">Cod. Filial </td>
      <td colspan="2" rowspan="2" class="fontebranca10"><img name="cadastro_setor_r3_c8" src="img/cadastro_setor_r3_c8.png" width="18" height="54" border="0" id="cadastro_setor_r3_c8" alt="" /></td>
      <td colspan="3" class="fontebranca10">Cod. Setor </td>
      <td rowspan="2" class="fontebranca10"><img name="cadastro_setor_r3_c13" src="img/cadastro_setor_r3_c13.png" width="28" height="54" border="0" id="cadastro_setor_r3_c13" alt="" /></td>
      <td colspan="2" class="fontebranca10">Nome Setor </td>
      <td><img src="img/spacer.gif" width="1" height="17" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="3" class="fontebranca10"><input name="cod_cliente" type="text" id="cod_cliente2" size="8" value="<?=$row_cliente_cod[cliente_id]?>" /></td>
      <td colspan="2" class="fontebranca10"><input name="filial_id" type="text" id="filial_id2" value="<?=$row_cliente_cod[filial_id]?>" size="10" /></td>
      <td colspan="3" class="fontebranca10"><?php if ($valore=='novo' || $valore==''){
	  
	  ?>

	  <input name="cod_setor" type="text" id="cod_setor" size="10" />
	 <?php }else{
	 
	 ?> 
	 	<select name="cod_setor">
		<?php
			$query_setor="select * from setor where cliente_id=".$cod_cliente." and filial_id=".$filial_id."";
			$result_setor=pg_query($query_setor) or die("Erro na query:$query_setor".pg_last_error($connect));
			while($row_setor=pg_fetch_array($result_setor)){
		?>
			
			<option value="<?=$row_setor[cod_setor]?>"><?=$row_setor[cod_setor]?></option>
			<?php
			}
			?>
        </select>
	 
	 	<?php
		 }
	 	?>	  </td>
      <td colspan="2" class="fontebranca10"><input name="nome_setor" type="text" id="nome_setor" size="20" /></td>
      <td><img src="img/spacer.gif" width="1" height="37" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="14" valign="top" class="fontebranca10"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="32" border="0" alt="" /></td>
    </tr>
    <tr>
      <td rowspan="4" valign="top" class="fontebranca10"><p style="margin:0px"></p></td>
      <td colspan="8" class="fontebranca10">Alterar Cadastrar </td>
      <td colspan="4" class="fontebranca10"><input name="valor" type="hidden" id="valor" /></td>
      <td rowspan="6" valign="top"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="17" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="8" rowspan="2" class="fontebranca10"><select name="menu" id="menu">
        <option value="cadastro_edificacao.php">Edifica&ccedil;&atilde;o</option>
          <option value="cadastro_equip_incendio.php">Equip Inc&ecirc;ndio</option>
          <option value="cadastro_funcionarios.php">Funcion&aacute;rios</option>
      </select>
          <input name="btn_continuar" type="submit" id="btn_continuar" value="Continuar" onclick="valore('continuar');"/></td>
      <td height="31" colspan="4" class="fontebranca10">&nbsp;</td>
      <td><img src="img/spacer.gif" width="1" height="20" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="4" rowspan="2" valign="top" class="fontebranca10"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="6" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="8" valign="top" class="fontebranca10"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="82" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="3"><input name="btn_buscar" type="image" id="btn_buscar" onclick="valore('buscar');" src="img/botao_pesquisar.jpg" width="53" height="38" /></td>
      <td><input type="image" name="cadastro_cliente_verde_r22_c3" src="img/cadastro_cliente_verde_r22_c3.gif" width="53" height="37" border="0" id="cadastro_cliente_verde_r22_c3" alt="" onclick="valore('novo');"/></td>
      <td><input name="gravar" type="image" id="gravar" value="gravar" src="img/icones_gravar.gif" width="52" height="37" onClick="valore('gravar');" hspace="1"></td>
      <td colspan="3" align="center"><input type="image" name="cadastro_cliente_verde_r22_c5" src="img/cadastro_cliente_verde_r22_c5.gif" width="52" height="37" border="0" id="cadastro_cliente_verde_r22_c5" alt="" onclick="valore('apagar');"/></td>
      <td rowspan="2" colspan="2"><a href="tela_principal.php"><img name="cadastro_cliente_verde_r21_c18" src="img/cadastro_cliente_verde_r21_c18.gif" width="41" height="58" border="0" id="cadastro_cliente_verde_r21_c18" alt=""/></a></td>
      <td rowspan="2" valign="top"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="54" border="0" alt="" /></td>
    </tr>
    <tr>
      <td colspan="10" valign="top"><p style="margin:0px"></p></td>
      <td><img src="img/spacer.gif" width="1" height="23" border="0" alt="" /></td>
    </tr>
  </table>
</form>
</body>
</html>
