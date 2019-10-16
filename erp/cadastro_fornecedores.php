<?php
// Data no passado
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

// Sempre modificado
header("Last-Modified: " . gmdate("D, d M Y H:i ") . " GMT");

// HTTP/1.1
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);

// HTTP/1.0
header("Pragma: no-cache");

include "sessao.php";
include "./config/connect.php";

switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"

	case "administrador":
		$leitura = "";
	break;

	case "funcionario":
		$leitura = "readonly=true";
	break;
}

if($valor=="gravar"){

	if($cod_fornecedor!=''){

		$query_fornecedor_cod="select fornecedor_id from fornecedores where fornecedor_id=$cod_fornecedor";
		$result_fornecedor_cod=pg_query($query_fornecedor_cod) or die ("Erro na query $query_fornecedor_cod".pg_last_error($connect));
		$row_fornecedor_cod=pg_fetch_array($result_fornecedor_cod);
		echo "<script>alert('".$valor."');</script>";
		$teste_fornecedor_cod=pg_num_rows($result_fornecedor_cod);
		
	}else{
		$teste_fornecedor_cod='erro';
	}
	if ($teste_fornecedor_cod < 1 || $teste_fornecedor_cod=="erro") {
	
		$query_fornecedor="insert into fornecedores
		(razao_social, nome_fantasia, cnpj, insc_estadual, insc_municipal, nome_responsavel, endereco, bairro, cidade, estado, cep, msn, skype, email, ddd1, telefone1, ddd2, telefone2, ddd_fax, fax, ddd_cel, celular, id_nextel, segmento ) values
		('$razao_social', '$nome_fantasia', '$cnpj', '$insc_estadual', '$insc_municipal', '$nome_responsavel', '$endereco', '$bairro', '$cidade', '$estado', '$cep', '$msn', '$skype', '$email','$ddd1', '$telefone1', '$ddd2', '$telefone2', '$ddd_fax', '$fax', '$ddd_cel', '$celular', '$id_nextel', '$segmento')";
		$result_fornecedor=pg_query($query_fornecedor)or die("Erro na query: $query_fornecedor".pg_last_error($connect));
	
		echo '<script> alert("Fornecedor Cadastrado com Sucesso!");</script>';
		
		$query_fornecedor_cod="select fornecedor_id from fornecedores where razao_social='$razao_social' and nome_fantasia='$nome_fantasia'";
		$result_fornecedor_cod=pg_query($query_fornecedor_cod) or die ("Erro na query $query_fornecedor_cod".pg_last_error($connect));
		$row_fornecedor_cod=pg_fetch_array($result_fornecedor_cod);
		
		$cod_fornecedor=$row_fornecedor_cod['fornecedor_id'];
		
	}else {
		
		$query_fornecedor = "update fornecedores SET 
		razao_social='$razao_social', nome_fantasia='$nome_fantasia', cnpj='$cnpj', insc_estadual='$insc_estadual', insc_municipal='$insc_municipal', nome_responsavel='$nome_responsavel', endereco='$endereco', bairro='$bairro', cidade='$cidade', estado='$estado', cep='$cep', msn='$msn', skype='$skype', email='$email', ddd1='$ddd1', telefone1='$telefone1', ddd2='$ddd2', telefone2='$telefone2', ddd_fax='$ddd_fax', fax='$fax', ddd_cel='$ddd_cel', celular='$celular', id_nextel='$id_nextel', segmento='$segmento' where fornecedor_id=".$cod_fornecedor."";
		$result_fornecedor=pg_query($query_fornecedor)or die("Erro na query: $query_fornecedor".pg_last_error($connect));
		
		echo '<script> alert("Fornecedor Alterado com Sucesso!");</script>';
	}
}

if($valor=="apagar"){
	
	$query_fornecedor_cod="select fornecedor_id from fornecedores where fornecedor_id=".$cod_fornecedor."";
	$result_fornecedor_cod =pg_query($query_fornecedor_cod) or die ("Erro na query $query_fornecedor_cod".pg_last_error($connect));
	//$row_fornecedor_cod=pg_fetch_array($result_fornecedor_cod);
	if ($teste_fornecedor_cod=pg_num_rows($result_fornecedor_cod) >= 1) {
	
		$query_fornecedor_del="delete from fornecedores where fornecedor_id=".$cod_fornecedor."";
		pg_query($query_fornecedor_del)or die("Erro na query: $query_fornecedor_del".pg_last_error($connect));
	
		}
}

if($valor=="gravar" || $cod_fornecedor!=""){

		$query="select * from fornecedores where fornecedor_id=".$cod_fornecedor."";
		$result=pg_query($query) or die ("Erro na query $query".pg_last_error($connect));
		$row=pg_fetch_array($result);
		$cod_fornecedor=$row['fornecedor_id'];

}
/*if($valor=="duplicar"){
	
	$query_dp="select * from fornecedores where fornecedor_id=".$cod_fornecedor."";
	$result_dp=pg_query($query_dp) or die ("Erro na query $query_dp".pg_last_error($connect));
	$row_dp=pg_fetch_array($result_dp);
	$cod_fornecedor=$row_dp['fornecedor_id'];
}
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="cache-control"   content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content = "-1" />

<title>Sistema SESMT - Cadastro de Fornecedores</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
td img {display: block;}
</style>
<script>
var botoes;
function valore(botoes){
	document.cadastro.valor.value=botoes;
	}

</script>
<script language="javascript" src="ajax.js"></script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#006633" >
<form id="cadastro" name="cadastro" method="post" action="cadastro_fornecedores.php">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><div align="center" class="fontebranca22bold">Cadastro de Fornecedores </div></td>
    </tr>
  </table><br />
    <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
    	<tr>
        	<td class="fontebranca10">Produto/Serviço</td>
			<td class="fontebranca10">Razão Social</td>
			<td class="fontebranca10">Nome Fantasia</td>
		</tr>
		<tr>
        	<td class="fontebranca10"><input name="segmento" <?php echo($leitura)?> type="text" id="razao_social" value="<?php echo $row['segmento']?>" size="40" /></td>
			<td class="fontebranca10"><input name="razao_social" <?php echo($leitura)?> type="text" id="razao_social" value="<?php echo $row['razao_social']?>" size="40" /></td>
			<td class="fontebranca10"><input name="nome_fantasia" <?php echo($leitura)?> type="text" id="nome_fantasia" value="<?php echo $row['nome_fantasia']?>" size="40" /></td>
        </tr>
	</table>
	<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
	    <tr>
        	<td class="fontebranca10">CNPJ</td>
			<td class="fontebranca10">Insc. Estadual</td>
			<td class="fontebranca10">Insc. Municipal</td>
			<td class="fontebranca10">Nome Responsável</td>
		</tr>
		<tr>
            <td class="fontebranca10"><input name="cnpj" <?php echo($leitura)?> type="text" id="cnpj" value="<?php echo $row['cnpj']?>" size="15" /></td>
            <td class="fontebranca10"><input name="insc_estadual" <?php echo($leitura)?> type="text" id="insc_estadual" value="<?php echo $row['insc_estadual']?>" size="15" /></td>
            <td class="fontebranca10"><input name="insc_municipal" <?php echo($leitura)?> type="text" id="insc_municipal" value="<?php echo $row['insc_municipal']?>" size="15" /></td>
            <td class="fontebranca10"><input name="nome_responsavel" <?php echo($leitura)?> type="text" id="nome_responsavel" value="<?php echo $row['nome_responsavel']?>" size="40" /></td>
        </tr>
	</table>
	<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
			<td class="fontebranca10">CEP</td>
            <td class="fontebranca10">Endereço</td>
		    <td class="fontebranca10">Bairro</td>
		    <td class="fontebranca10">Municipio</td>
		    <td class="fontebranca10">Estado</td>
		</tr>
		<tr>
			<td class="fontebranca10"><input name="cep" <?php echo($leitura)?> type="text" id="cep" value="<?php echo $row['cep']?>" size="10" onchange="showDataFornecedor();" /></td>
            <td class="fontebranca10"><input name="endereco" <?php echo($leitura)?> type="text" id="endereco" value="<?php echo $row['endereco']?>" size="40" /></td>
            <td class="fontebranca10"><input name="bairro" <?php echo($leitura)?> type="text" id="bairro" value="<?php echo $row['bairro']?>" size="15" /></td>
            <td class="fontebranca10"><input name="cidade" <?php echo($leitura)?> type="text" id="cidade" value="<?php echo $row['cidade']?>" size="20" /></td>
            <td class="fontebranca10"><input name="estado" <?php echo($leitura)?> type="text" id="estado" value="<?php echo $row['estado']?>" size="15" /></td>
        </tr>
	</table>
    <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td class="fontebranca10">MSN</td>
			<td class="fontebranca10">Skipe</td>
			<td class="fontebranca10">E-mail</td>
			<td class="fontebranca10">DDD</td>
			<td class="fontebranca10">Telefone</td>          
        </tr>
        <tr>
			<td class="fontebranca10"><input name="msn" <?php echo($leitura)?> type="text" id="msn" value="<?php echo $row['msn']?>" size="25" /></td>
            <td class="fontebranca10"><input name="skype" <?php echo($leitura)?> type="text" id="skype" value="<?php echo $row['skype']?>" size="12" /></td>
            <td class="fontebranca10"><input name="email" <?php echo($leitura)?> type="text" id="email" value="<?php echo $row['email']?>" size="25" /></td>
            <td class="fontebranca10"><input name="ddd1" <?php echo($leitura)?> type="text" id="ddd1" value="<?php echo $row['ddd1']?>" size="5" /></td>
            <td class="fontebranca10"><input name="telefone1" <?php echo($leitura)?> type="text" id="telefone1" value="<?php echo $row['telefone1']?>" size="15" /></td>
        </tr>
	</table>
	<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td class="fontebranca10">DDD</td>
			<td class="fontebranca10">Telefone</td>
			<td class="fontebranca10">DDD - FAX</td>
			<td class="fontebranca10">FAX</td>
			<td class="fontebranca10">DDD - Celular</td>
			<td class="fontebranca10">Celular</td>
			<td class="fontebranca10">ID - Nextel</td>
		</tr>
		<tr>
			<td class="fontebranca10"><input name="ddd2" <?php echo($leitura)?> type="text" id="ddd2" value="<?php echo $row['ddd2']?>" size="5" /></td>
            <td class="fontebranca10"><input name="telefone2" <?php echo($leitura)?> type="text" id="telefone2" value="<?php echo $row['telefone2']?>" size="15" /></td>
            <td class="fontebranca10"><input name="ddd_fax" <?php echo($leitura)?> type="text" id="ddd_fax" value="<?php echo $row['ddd_fax']?>" size="5" /></td>
            <td class="fontebranca10"><input name="fax" <?php echo($leitura)?> type="text" id="fax" value="<?php echo $row['fax']?>" size="15" /></td>
            <td class="fontebranca10"><input name="ddd_cel" <?php echo($leitura)?> type="text" id="ddd_cel" value="<?php echo $row['ddd_cel']?>" size="5" /></td>
            <td class="fontebranca10"><input name="celular" <?php echo($leitura)?> type="text" id="celular" value="<?php echo $row['celular']?>" size="15" /></td>
        	<td class="fontebranca10"><input name="id_nextel" <?php echo($leitura)?> type="text" id="id_nextel" value="<?php echo $row['id_nextel']?>" size="12" /></td>
            <td><input name="valor" type="hidden" id="valor" />
            <input name="cod_fornecedor" type="hidden" id="cod_fornecedor" value="<?php echo $cod_fornecedor?>" /></td>
		</tr>
	</table><br />
	<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
		  <td>&nbsp;</td>
          <? if ($grupo=="administrador"){?>
		  <td><a href="cadastro_fornecedores.php"><img src="img/cadastro_cliente_verde_r22_c3.gif" width="53" height="37" border="0"></a></td>
		  <!--<td><input name="duplicar" type="image" id="duplicar" value="duplicar" src="img/cadastro_cliente_verde_r22_c9.gif" width="52" height="37" onclick="valore('duplicar');" /></td>-->
          <td><input name="gravar" type="image" id="gravar" value="gravar" src="img/icones_gravar.gif" width="52" height="37" onclick="valore('gravar');" /></td>
          <td><input type="image" name="apagar" src="img/cadastro_cliente_verde_r22_c5.gif" width="52" height="37" onclick="valore('apagar');" /></td>
          <? } else { echo "&nbsp;";}?>
		  <td><a href="listagem_fornecedores.php"><img src="img/cadastro_cliente_verde_r21_c18.gif" alt="" name="cadastro_cliente_verde_r21_c18" width="41" height="58" border="0" id="cadastro_cliente_verde_r21_c18" /></a></td>
          </tr>
      </table>
</form>
</body>
</html>
