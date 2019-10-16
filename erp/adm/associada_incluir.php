<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";

$fantasy = "SESMT";
$number = rand(1000,9999);
ob_start();
if($nome!=""){
	$query_incluir="INSERT into associada (random, nome, nome_fantasia, cnpj_franquia, insc_munic, email_franquia,
					telefone, fax, endereco, bairro, cidade, uf, cep, responsavel, rg_resp, cpf_resp, tel_resp,
					cel_resp, nextel_resp, id_resp, email_resp, skype_resp, cep_resp, end_resp, bairro_resp,
					uf_resp, cidade_resp)
					values
					($number, '$nome', '$fantasy', '$cnpj_franquia', '$insc_munic', '$email_franquia', '$telefone', '$fax',
					'$endereco', '$bairro', '$cidade', '$uf', '$cep', '$responsavel', '$rg_resp', '$cpf_resp',
					'$tel_resp', '$cel_resp', '$nextel_resp', '$id_resp', '$email_resp', '$skype_resp', '$cep_resp',
					'$end_resp', '$bairro_resp', '$uf_resp', '$cidade_resp')";
					
	pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));
	
	echo"<script>alert('Associada Incluído com Sucesso!');</script>";
	header("location: associada_adm.php");
}

?>
<html>
<head>
<title>Sistema SESMT - Cadastro de Associada</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633">

<form action="associada_incluir.php" method="post" enctype="multipart/form-data" name="form1">
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
		<td class="fontepreta12"><input name="nome" type="text" id="nome" size="65"></td>
		<td class="fontepreta12"><?php echo $fantasy; ?></td>
		<td class="fontepreta12"><input name="cnpj_franquia" type="text" id="cnpj_franquia" size="20"></td>
		<td class="fontepreta12"><input name="insc_munic" type="text" id="insc_munic" size="10"></td>
	</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="fontebranca12">CEP</td>
		<td class="fontebranca12">Endereço</td>
		<td class="fontebranca12">Bairro</td>
	</tr>
	<tr>
		<td><input name="cep" type="text" id="cep" size="12"></td>
		<td><input name="endereco" type="text" id="endereco" size="60"></td>
		<td><input name="bairro" type="text" id="bairro" size="30"></td>
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
		<td><input name="cidade" type="text" id="cidade" size="30"></td>
		<td><input name="uf" type="text" id="uf" size="15"></td>
		<td><input name="telefone" type="text" id="telefone" size="15"></td>
		<td><input name="fax" type="text" id="fax" size="15"></td>
		<td><input name="email_franquia" type="text" id="email_franquia" size="20"></td>
	</tr>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="fontebranca12">Responsável</td>
		<td class="fontebranca12">RG</td>
		<td class="fontebranca12">CPF</td>
	</tr>
	<tr>
		<td><input name="responsavel" type="text" id="responsavel" size="40"></td>
		<td><input name="rg_resp" type="text" id="rg_resp" size="15"></td>
		<td><input name="cpf_resp" type="text" id="cpf_resp" size="15"></td>
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
		<td><input name="cep_resp" type="text" id="cep_resp" size="10"></td>
		<td><input name="end_resp" type="text" id="end_resp" size="25"></td>
		<td><input name="bairro_resp" type="text" id="bairro_resp" size="15"></td>
		<td><input name="cidade_resp" type="text" id="cidade_resp" size="15"></td>
		<td><input name="uf_resp" type="text" id="uf_resp" size="10"></td>
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
		<td><input name="tel_resp" type="text" id="tel_resp" size="15"></td>
		<td><input name="cel_resp" type="text" id="cel_resp" size="15"></td>
		<td><input name="nextel_resp" type="text" id="nextel_resp" size="15"></td>
		<td><input name="id_resp" type="text" id="id_resp" size="10"></td>
		<td><input name="email_resp" type="text" id="email_resp" size="20"></td>
		<td><input name="skype_resp" type="text" id="skype_resp" size="10"></td>	
	</tr>
</table><br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<th><input type="submit" name="btn_gravar" value="Gravar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','associada_adm.php'); return document.MM_returnValue" &nbsp;&nbsp; value="&lt;&lt; Voltar"></th>
	</tr>
</table>
</form>
</body>
</html>