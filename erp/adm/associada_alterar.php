<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";

$fantasy = "SESMT";

if($_GET){
$associada_id  = $_GET["associada_id"];
}
else{
$associada_id  = $_POST["associada_id"];
}

if($associada_id!="" and $_POST[btn_excluir] == "Excluir"){
	$query = "SELECT * FROM associada WHERE associada_id=$associada_id";
	$result = pg_query($connect, $query) 
		or die ("Não foi possivel realizar a consulta!" . pg_last_error($connect));
	
	if(pg_num_rows($result) > 0) {
		$sql = "DELETE FROM associada WHERE associada_id=$associada_id";
		
	$resultado = pg_query($sql) or die ("Não foi possível realizar a exclusão dos dados.");
	header("Location: associada_adm.php");

	}
}

if($associada_id!="" and $_POST[btn_alterar] == "Alterar" ){

	$nome = $_POST["nome"];
	$cnpj_franquia = $_POST["cnpj_franquia"];
	$insc_munic = $_POST["insc_munic"];
	$email_franquia = $_POST["email_franquia"];
	$telefone = $_POST["telefone"];
	$fax = $_POST["fax"];
	$endereco = $_POST["endereco"];
	$bairro = $_POST["bairro"];
	$cidade = $_POST["cidade"];
	$uf = $_POST["uf"];
	$cep = $_POST["cep"];
	$responsavel = $_POST["responsavel"];
	$rg_resp = $_POST["rg_resp"];
	$cpf_resp = $_POST["cpf_resp"];
	$tel_resp = $_POST["tel_resp"];
	$cel_resp = $_POST["cel_resp"];
	$nextel_resp = $_POST["nextel_resp"];
	$id_resp = $_POST["id_resp"];
	$email_resp = $_POST["email_resp"];
	$skype_resp = $_POST["skype_resp"];
	$cep_resp = $_POST["cep_resp"];
	$end_resp = $_POST["end_resp"];
	$bairro_resp = $_POST["bairro_resp"];
	$uf_resp = $_POST["uf_resp"];
	$cidade_resp = $_POST["cidade_resp"];
	
	$query_clinica = "UPDATE associada SET 
					 nome = '$nome',
					 cnpj_franquia = '$cnpj_franquia',
					 insc_munic = '$insc_munic',
					 email_franquia = '$email_franquia',
					 telefone = '$telefone',
					 fax = '$fax',
					 endereco = '$endereco',
					 bairro = '$bairro',
					 cidade = '$cidade',
					 uf = '$uf',
					 cep = '$cep',
					 responsavel = '$responsavel',
					 rg_resp = '$rg_resp',
					 cpf_resp = '$cpf_resp',
					 tel_resp = '$tel_resp',
					 cel_resp = '$cel_resp', 
					 nextel_resp = '$nextel_resp',
					 id_resp = '$id_resp',
					 email_resp = '$email_resp',
					 skype_resp = '$skype_resp',
					 cep_resp = '$cep_resp',
					 end_resp = '$end_resp',
					 bairro_resp = '$bairro_resp',
					 uf_resp = '$uf_resp',
					 cidade_resp = '$cidade_resp'
					 WHERE associada_id = $associada_id";
	
	$result_clinica = pg_query($connect, $query_clinica) 
			or die ("Erro na query: $query_clinica ==> ".pg_last_error($connect));
}

if($associada_id!=""){
	$query_incluir="SELECT nome, nome_fantasia, cnpj_franquia, insc_munic, email_franquia,
					telefone, fax, endereco, bairro, cidade, uf, cep, responsavel, rg_resp, cpf_resp, tel_resp,
					cel_resp, nextel_resp, id_resp, email_resp, skype_resp, cep_resp, end_resp, bairro_resp,
					uf_resp, cidade_resp
					FROM associada
					WHERE associada_id = $associada_id";
					
	$result = pg_query($query_incluir) or die 
		("Erro na query:$query_incluir".pg_last_error($connect));
	
	$row = pg_fetch_array($result);
}

?>
<html>
<head>
<title>Sistema SESMT - Cadastro de Associada</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633">

<form action="associada_alterar.php" method="post" enctype="multipart/form-data" name="form1">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center" class="fontebranca22bold">Painel de Controle do Sistema</td>
	</tr>
	<tr>
		<td align="center" bgcolor="#FFFFFF" class="fontepreta14bold">Franqueada SESMT </td>
	</tr>
</table><br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="fontebranca12">Razão Social</td>
		<td class="fontebranca12">Nome Fantasia</td>
		<td class="fontebranca12">CNPJ</td>
		<td class="fontebranca12">Insc. Munic.</td>
	</tr>
	<tr>
		<td class="fontepreta12"><input name="nome" type="text" id="nome" value="<?php echo $row[nome]?>" size="65"></td>
		<td class="fontepreta12"><?php echo $fantasy; ?></td>
		<td class="fontepreta12"><input name="cnpj_franquia" type="text" id="cnpj_franquia" value="<?php echo $row[cnpj_franquia]?>" size="20"></td>
		<td class="fontepreta12"><input name="insc_munic" type="text" id="insc_munic" value="<?php echo $row[insc_munic]?>" size="10"></td>
	</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="fontebranca12">CEP</td>
		<td class="fontebranca12">Endereço</td>
		<td class="fontebranca12">Bairro</td>
	</tr>
	<tr>
		<td><input name="cep" type="text" id="cep" value="<?php echo $row[cep]?>" size="12"></td>
		<td><input name="endereco" type="text" id="endereco" value="<?php echo $row[endereco]?>" size="60"></td>
		<td><input name="bairro" type="text" id="bairro" value="<?php echo $row[bairro]?>" size="30"></td>
	</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="fontebranca12">Cidade</td>
		<td class="fontebranca12">Estado</td>
		<td class="fontebranca12">Telefone</td>
		<td class="fontebranca12">FAX</td>
		<td class="fontebranca12">E-mail</td>
	</tr>
	<tr>
		<td><input name="cidade" type="text" id="cidade" value="<?php echo $row[cidade]?>" size="30"></td>
		<td><input name="uf" type="text" id="uf" value="<?php echo $row[uf]?>" size="15"></td>
		<td><input name="telefone" type="text" id="telefone" value="<?php echo $row[telefone]?>" size="15"></td>
		<td><input name="fax" type="text" id="fax" value="<?php echo $row[fax]?>" size="15"></td>
		<td><input name="email_franquia" type="text" id="email_franquia" value="<?php echo $row[email_franquia]?>" size="20"></td>
	</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="fontebranca12">Responsável</td>
		<td class="fontebranca12">RG</td>
		<td class="fontebranca12">CPF</td>
	</tr>
	<tr>
		<td><input name="responsavel" type="text" id="responsavel" value="<?php echo $row[responsavel]?>" size="40"></td>
		<td><input name="rg_resp" type="text" id="rg_resp" value="<?php echo $row[rg_resp]?>" size="15"></td>
		<td><input name="cpf_resp" type="text" id="cpf_resp" value="<?php echo $row[cpf_resp]?>" size="15"></td>
	</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="fontebranca12">CEP</td>
		<td class="fontebranca12">Endereço</td>
		<td class="fontebranca12">Bairro</td>
		<td class="fontebranca12">Cidade</td>
		<td class="fontebranca12">Estado</td>	
	</tr>
	<tr>
		<td><input name="cep_resp" type="text" id="cep_resp" value="<?php echo $row[cep_resp]?>" size="10"></td>
		<td><input name="end_resp" type="text" id="end_resp" value="<?php echo $row[end_resp]?>" size="25"></td>
		<td><input name="bairro_resp" type="text" id="bairro_resp" value="<?php echo $row[bairro_resp]?>" size="15"></td>
		<td><input name="cidade_resp" type="text" id="cidade_resp" value="<?php echo $row[cidade_resp]?>" size="15"></td>
		<td><input name="uf_resp" type="text" id="uf_resp" value="<?php echo $row[uf_resp]?>" size="10"></td>
	</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="fontebranca12">Telefone</td>
		<td class="fontebranca12">Celular</td>
		<td class="fontebranca12">Nextel</td>
		<td class="fontebranca12">ID</td>
		<td class="fontebranca12">E-mail</td>
		<td class="fontebranca12">Skype</td>	
	</tr>
	<tr>
		<td><input name="tel_resp" type="text" id="tel_resp" value="<?php echo $row[tel_resp]?>" size="15"></td>
		<td><input name="cel_resp" type="text" id="cel_resp" value="<?php echo $row[cel_resp]?>" size="15"></td>
		<td><input name="nextel_resp" type="text" id="nextel_resp" value="<?php echo $row[nextel_resp]?>" size="15"></td>
		<td><input name="id_resp" type="text" id="id_resp" value="<?php echo $row[id_resp]?>" size="10"></td>
		<td><input name="email_resp" type="text" id="email_resp" value="<?php echo $row[email_resp]?>" size="20"></td>
		<td><input name="skype_resp" type="text" id="skype_resp" value="<?php echo $row[skype_resp]?>" size="10"></td>	
	</tr>
</table><br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<th>
			<input type="submit" name="btn_excluir" value="Excluir" onClick="aviso_fra(['associada_id']); return false;" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_alterar" value="Alterar" onClick="aviso_fran(['associada_id']); return false;" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','../adm/associada_adm.php');return document.MM_returnValue" style="width:100;">
			<input type="hidden" name="associada_id" value="<?php echo $associada_id; ?>">
		</th>
	</tr>
</table>
</form>
</body>
</html>