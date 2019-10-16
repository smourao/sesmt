<?php 
include "../sessao.php";
include "../config/connect.php";

$data = date("Y/m/d");

if($_GET){
$cod_clinica  = $_GET["cod_clinica"];
}
else{
$cod_clinica  = $_POST["cod_clinica"];
}

if(!empty($cod_clinica) and $_POST[btn_excluir] == "Excluir"){
	$query = "SELECT * FROM clinicas WHERE cod_clinica=$cod_clinica";
	$result = pg_query($connect, $query) 
		or die ("Não foi possivel realizar a consulta!" . pg_last_error($connect));
	
	if(pg_num_rows($result) > 0) {
		$sql = "DELETE FROM clinicas WHERE cod_clinica=$cod_clinica";
		
	$resultado = pg_query($sql) or die ("Não foi possível realizar a exclusão dos dados.");
	header("location: ../medico/lista_clinicas.php");
	}
}

if(!empty($cod_clinica) and $_POST[btn_alterar] == "Alterar" ){

	$razao_social_clinica = $_POST["razao_social_clinica"];
	$nome_fantasia_clinica = $_POST["nome_fantasia_clinica"];
	$inscricao_clinica = $_POST["inscricao_clinica"];
	$cnpj_clinica = $_POST["cnpj_clinica"];
	$endereco_clinica = $_POST["endereco_clinica"];
	$num_end = $_POST["num_end"];
	$bairro_clinica = $_POST["bairro_clinica"];
	$cidade = $_POST["cidade"];
	$estado = $_POST["estado"];
	$tel_clinica = $_POST["tel_clinica"];
	$fax_clinica = $_POST["fax_clinica"];
	$email_clinica = $_POST["email_corporativo_clinica"];
	$cep_clinica = $_POST["cep_clinica"];
	$referencia_clinica = $_POST["referencia_clinica"];
	$contato_clinica = $_POST["contato_clinica"];
	$id_nextel_contato = $_POST["id_nextel_contato"];
	$tel_contato = $_POST["tel_contato"];
	$nextel_contato = $_POST["nextel_contato"];
	$email_contato = $_POST["email_contato"];
	$cod_func_alt = $_POST["usuario_id"];
	$data_ultima_alt = $_POST["data"];
	$cargo_responsavel = $_POST["cargo_responsavel"];
	$cargo_intermediario = $_POST["cargo_intermediario"];
	$ramal_responsavel = $_POST["ramal_responsavel"];
	$ramal_intermediario = $_POST["ramal_intermediario"];
	$fax_responsavel = $_POST["fax_responsavel"];
	$fax_intermediario = $_POST["fax_intermediario"];
	$contato_intermediario = $_POST["contato_intermediario"];
	$email_intermediario = $_POST["email_intermediario"];
	$tel_intermediario = $_POST["tel_intermediario"];
	$nextel_intermediario = $_POST["nextel_intermediario"];
	$id_nextel_intermediario = $_POST["id_nextel_intermediario"];
	$status = $_POST["status"];
	
	$query_clinica = "UPDATE clinicas SET 
					 razao_social_clinica = '$razao_social_clinica',
					 nome_fantasia_clinica = '$nome_fantasia_clinica',
					 inscricao_clinica = '$inscricao_clinica',
					 cnpj_clinica = '$cnpj_clinica',
					 endereco_clinica = '$endereco_clinica',
					 num_end = '$num_end',
					 bairro_clinica = '$bairro_clinica',
					 cidade = '$cidade',
					 estado = '$estado',
					 tel_clinica = '$tel_clinica',
					 fax_clinica = '$fax_clinica',
					 email_clinica = '$email_corporativo_clinica',
					 cep_clinica = '$cep_clinica',
					 referencia_clinica = '$referencia_clinica',
					 contato_clinica = '$contato_clinica',
					 id_nextel_contato = '$id_nextel_contato',
					 tel_contato = '$tel_contato',
					 nextel_contato = '$nextel_contato', 
					 email_contato = '$email_contato',
					 cod_func_alt = $usuario_id,
					 data_ultima_alt = '$data',
					 cargo_responsavel = '$cargo_responsavel',
					 cargo_intermediario = '$cargo_intermediario',
					 ramal_responsavel = '$ramal_responsavel',
					 ramal_intermediario = '$ramal_intermediario',
					 fax_responsavel = '$fax_responsavel',
					 fax_intermediario = '$fax_intermediario',
					 contato_intermediario = '$contato_intermediario',
					 email_intermediario = '$email_intermediario',
					 tel_intermediario = '$tel_intermediario',
					 nextel_intermediario = '$nextel_intermediario',
					 id_nextel_intermediario = '$id_nextel_intermediario',
					 status = '$status'
					 WHERE cod_clinica = $cod_clinica";
	
	$result_clinica = pg_query($connect, $query_clinica) 
			or die ("Erro na query: $query_clinica ==> ".pg_last_error($connect));
	
	if($result_clinica){
		echo "<script>alert('Dados Alterados com Sucesso!');</script>";
	}else{
		echo "<script>alert('Dados da Clínica Incorreto!');</script>";
	}
}

if(!empty($cod_clinica)){
	$query_cli     = "SELECT *
					 FROM clinicas
					 WHERE cod_clinica = $cod_clinica";
	
	$result_cli = pg_query($connect, $query_cli) 
			or die ("Erro na query: $query_cli ==> ".pg_last_error($connect));
	$row_cli = pg_fetch_array($result_cli);

}

function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>::Sistema SESMT - Cadastro de Clínicas::</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">

td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
</style>
<script language="javascript" src="../scripts.js"></script>

</head>

<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form action="cadastro_clinicas_alt.php" name="form_clinicas" method="post">
    <table width="90%" border="0" cellpadding="0" align="center">
	<tr>
      <td class="fontebranca22bold"><div align="center">Cadastro de Clínicas </div></td>
    </tr>
	</table>
	<table width="90%" border="0" align="center" cellpadding="0">
      <tr>
	    <td class="fontebranca10">Código </td>
        <td class="fontebranca10">Razão Social </td>
		<td class="fontebranca10">Nome fantasia </td>
      </tr>
	  <?php
	  	if(empty($cod_clinica)){
			$query_max = "SELECT max(cod_clinica) as cod_clinica FROM clinicas";
		
			$result_max = pg_query($query_max) //executa query
				or die ("Erro na busca da tabela clinicas. ==> " . pg_last_error($connect)); //mostra erro
		
			$row_max = pg_fetch_array($result_max); // recebe o resultado da query (linhas)
			
			$cod_clinica = $row_max[cod_clinica] + 1;
		}
		else if(!empty($cod_clinica)){
			$cod_clinica = $cod_clinica;
		} 
		?>
      <tr>
	    <td class="fontebranca10"><input name="cod_clinica" value="<?php if(empty($cod_clinica)){coloca_zeros($row_max[cod_clinica]);} else {echo coloca_zeros($cod_clinica);}?>" readonly="true" type="text" size="7"></td>
        <td class="fontebranca10"><input name="razao_social_clinica" type="text" value="<?php echo $row_cli[razao_social_clinica];?>" size="70"></td>
		<td class="fontebranca10"><input name="nome_fantasia_clinica" type="text" value="<?php echo $row_cli[nome_fantasia_clinica]?>" size="30"></td>
      </tr>
    </table>
	<table width="90%" border="0" cellpadding="0" align="center"> 
    <tr>
      <td class="fontebranca10">CEP</td>
      <td class="fontebranca10">Endereço</td>
	  <td class="fontebranca10">Nº</td>
      <td class="fontebranca10">Bairro</td>
      <td class="fontebranca10">Cidade</td>
	  <td class="fontebranca10">Estado</td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="cep_clinica" type="text" value="<?php echo $row_cli[cep_clinica]?>" id="cep_clinica" size="9"></td>    
      <td class="fontebranca10"><input name="endereco_clinica" type="text" id="endereco_clinica" value="<?php echo $row_cli[endereco_clinica]?>" size="35"></td>
	  <td class="fontebranca10"><input name="num_end" type="text" id="num_end" value="<?php echo $row_cli[num_end]?>" size="2"></td>
      <td class="fontebranca10"><input name="bairro_clinica" type="text" id="bairro_clinica" value="<?php echo $row_cli[bairro_clinica]?>" size="17"></td>
      <td class="fontebranca10"><input name="cidade" type="text" id="cidade" value="<?php echo $row_cli[cidade]?>" size="13"></td>
	  <td class="fontebranca10"><input name="estado" type="text" id="estado" value="<?php echo $row_cli[estado]?>" size="15"></td>
	</tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Telefone</td>
      <td class="fontebranca10">FAX</td>
      <td class="fontebranca10">E-mail Corporativo</td>
      <td class="fontebranca10">CNPJ</td>
      <td class="fontebranca10">Insc. Est./Mun. </td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="tel_clinica" type="text" value="<?php echo $row_cli[tel_clinica]?>" size="12"></td>
	  <td class="fontebranca10"><input name="fax_clinica" type="text" value="<?php echo $row_cli[fax_clinica]?>" size="12"></td>
      <td class="fontebranca10"><input name="email_corporativo_clinica" type="text" value="<?php echo $row_cli[email_clinica]?>" size="40"></td>
      <td class="fontebranca10"><input name="cnpj_clinica" type="text" value="<?php echo $row_cli[cnpj_clinica]?>" size="17" ></td>
      <td class="fontebranca10"><input name="inscricao_clinica" type="text" value="<?php echo $row_cli[inscricao_clinica]?>" size="15" ></td>
	</tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Ponto de Referência</td>
	  <td class="fontebranca10">Responsável Por Cadastro</td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="referencia_clinica" type="text" value="<?php echo $row_cli[referencia_clinica]?>" size="70"></td>
	  <?php
	  	$query_log = "SELECT c.cod_func_alt, u.usuario_id, f.funcionario_id, f.nome, c.cod_clinica
					  FROM usuario u, funcionario f, clinicas c
					  WHERE c.cod_func_alt = u.usuario_id
					  AND f.funcionario_id = u.funcionario_id
					  AND c.cod_clinica = $cod_clinica";
		$result_log = pg_query($connect, $query_log) or die
			("Erro na Busca: ==> $query_log".pg_last_error($connect));
		$row_log = pg_fetch_array($result_log);
	  ?>
	  <td class="fontebranca10"><input type="text" value="<?php echo $row_log[nome] ?>" size="30"></td>
    </tr>
    </table>
	<table width="90%" border="0" cellpadding="0" align="center">
	<tr>
		<td class="fontebranca10">Responsável</td>
		<td class="fontebranca10">Cargo</td>
		<td class="fontebranca10">E-mail</td>
	</tr>
	<tr>
		<td class="fontebranca10"><input name="contato_clinica" type="text" value="<?php echo $row_cli[contato_clinica]?>" size="30"></td>
		<td class="fontebranca10"><input name="cargo_responsavel" type="text" value="<?php echo $row_cli[cargo_responsavel]?>" size="20"></td>
		<td class="fontebranca10"><input name="email_contato" type="text" value="<?php echo $row_cli[email_contato]?>" size="40"></td>
	</tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
	<tr>
		<td class="fontebranca10">Telefone Responsável</td>
		<td class="fontebranca10">Ramal</td>
		<td class="fontebranca10">Fax</td>
		<td class="fontebranca10">Nextel</td>
		<td class="fontebranca10">ID</td>
	</tr>
	<tr>
		<td class="fontebranca10"><input name="tel_contato" type="text" value="<?php echo $row_cli[tel_contato]?>" size="12"></td>
		<td class="fontebranca10"><input name="ramal_responsavel" type="text" value="<?php echo $row_cli[ramal_responsavel]?>" size="12"></td>
		<td class="fontebranca10"><input name="fax_responsavel" type="text" value="<?php echo $row_cli[fax_responsavel]?>" size="12"></td>
		<td class="fontebranca10"><input name="nextel_contato" type="text" value="<?php echo $row_cli[nextel_contato]?>" size="12"></td>
		<td class="fontebranca10"><input name="id_nextel_contato" type="text" value="<?php echo $row_cli[id_nextel_contato]?>" size="8"></td>
	</tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
	<tr>
		<td class="fontebranca10">Contato Intermediário</td>
		<td class="fontebranca10">Cargo</td>
		<td class="fontebranca10">E-mail</td>
	</tr>
	<tr>
		<td class="fontebranca10"><input name="contato_intermediario" type="text" value="<?php echo $row_cli[contato_intermediario]?>" size="30"></td>
		<td class="fontebranca10"><input name="cargo_intermediario" type="text" value="<?php echo $row_cli[cargo_intermediario]?>" size="20"></td>
		<td class="fontebranca10"><input name="email_intermediario" type="text" value="<?php echo $row_cli[email_intermediario]?>" size="40"></td>
	</tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
	<tr>
		<td class="fontebranca10">Telefone</td>
		<td class="fontebranca10">Ramal</td>
		<td class="fontebranca10">Fax</td>
		<td class="fontebranca10">Nextel</td>
		<td class="fontebranca10">ID</td>
<?php if ($grupo=="administrador"){?>
		<td class="fontebranca10">Status</td>
<?php } else { echo "&nbsp;";}?>
	</tr>
	<tr>
		<td class="fontebranca10"><input name="tel_intermediario" type="text" value="<?php echo $row_cli[tel_intermediario]?>" size="12"></td>
		<td class="fontebranca10"><input name="ramal_intermediario" type="text" value="<?php echo $row_cli[ramal_intermediario]?>" size="12"></td>
		<td class="fontebranca10"><input name="fax_intermediario" type="text" value="<?php echo $row_cli[fax_intermediario]?>" size="12"></td>
		<td class="fontebranca10"><input name="nextel_intermediario" type="text" value="<?php echo $row_cli[nextel_intermediario]?>" size="12"></td>
		<td class="fontebranca10"><input name="id_nextel_intermediario" type="text" value="<?php echo $row_cli[id_nextel_intermediario]?>" size="8"></td>
<?php if ($grupo=="administrador"){?>
		<td ><select name="status" id="status">
        <option value="ativo" <?php if($row_cli[status]=="ativo"){echo "selected";} ?>>ativo</option>
        <option value="inativo" <?php if($row_cli[status]=="inativo"){echo "selected";} ?>>inativo</option>
      		</select>
	  	</td>
<?php } else { echo "&nbsp;";}?>
	</tr>
	</table>
	<br><table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
	  <td align="center">
<?php if ($grupo=="administrador"){?>
	  <input type="submit" name="btn_excluir" value="Excluir" onClick="aviso_cli(['cod_clinica']); return false;" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
<?php } else { echo "&nbsp;";}?>
	  <input type="submit" name="btn_alterar" value="Alterar" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','../medico/lista_clinicas.php');return document.MM_returnValue" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="button"  name="btn_avancar" value="Mais Exames" onClick="MM_goToURL('parent','../medico/cad_preco_exame.php?cod_clinica=<?php echo $cod_clinica; ?>');return document.MM_returnValue" style="width:100;">
	  <input type="hidden" name="cod_clinica" value="<?php echo $cod_clinica; ?>" />
	  </td>
	</tr>
	</table>
</form>
</body>
</html>