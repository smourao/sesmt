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

include "../sessao.php";
include "../config/connect.php";
include "../config/funcoes.php";

switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"

	case "administrador":
		$leitura = "";
	break;

	case "funcionario":
		$leitura = "readonly=true";
	break;
}

$data = date("Y/m/d");

if($_GET){
$cod_clinica  = $_GET["cod_clinica"];
}
else{
$cod_clinica  = $_POST["cod_clinica"];
}

if(!empty($cod_clinica)){
	$query_clinica = "SELECT cod_clinica, razao_social_clinica, nome_fantasia_clinica, inscricao_clinica, cnpj_clinica,
					 endereco_clinica, num_end, bairro_clinica, tel_clinica, fax_clinica, email_clinica, cep_clinica,
					 referencia_clinica, cidade, estado, contato_clinica, id_nextel_contato, tel_contato, nextel_contato, email_contato,
					 cod_func_criacao, data_criacao, cod_func_alt, data_ultima_alt, cargo_responsavel, cargo_intermediario,
					 ramal_responsavel, ramal_intermediario, fax_responsavel, fax_intermediario, contato_intermediario,
					 email_intermediario, tel_intermediario, nextel_intermediario, id_nextel_intermediario, status
					 FROM clinicas 
					 WHERE cod_clinica = $cod_clinica";
	
	$result_clinica = pg_query($connect, $query_clinica) 
			or die ("Erro na query: $query_clinica ==> ".pg_last_error($connect));

	$row_clinica = pg_fetch_array($result_clinica);
}

if (!empty($cod_clinica) and $_POST[btn_gravar]=="Gravar"){
	$query_insert = "INSERT INTO clinicas
					 (cod_clinica, razao_social_clinica, nome_fantasia_clinica, inscricao_clinica, cnpj_clinica,
					 endereco_clinica, num_end, bairro_clinica, tel_clinica, fax_clinica, email_clinica, cep_clinica,
					 referencia_clinica, cidade, estado, contato_clinica, id_nextel_contato, tel_contato, nextel_contato, email_contato,
					 cod_func_criacao, data_criacao, cod_func_alt, data_ultima_alt, cargo_responsavel, cargo_intermediario,
					 ramal_responsavel, ramal_intermediario, fax_responsavel, fax_intermediario, contato_intermediario,
					 email_intermediario, tel_intermediario, nextel_intermediario, id_nextel_intermediario, status)
					 VALUES
					 ($cod_clinica, '$razao_social_clinica', '$nome_fantasia_clinica', '$inscricao_clinica', '$cnpj_clinica',
					 '$endereco_clinica', '$num_end', '$bairro_clinica', '$tel_clinica', '$fax_clinica', '$email_clinica', '$cep_clinica',
					 '$referencia_clinica', '$cidade', '$estado', '$contato_clinica', '$id_nextel_contato', '$tel_contato', '$nextel_contato',
					 '$email_contato', '$usuario_id', '$data', '$usuario_id', '$data', '$cargo_responsavel', '$cargo_intermediario',
					 '$ramal_responsavel', '$ramal_intermediario', '$fax_responsavel', '$fax_intermediario', '$contato_intermediario',
					 '$email_intermediario', '$tel_intermediario', '$nextel_intermediario', '$id_nextel_intermediario', '$status')";
					 
	$result_insert = pg_query($connect, $query_insert) or die
		("Erro no INSERT ==> $query_insert".pg_last_error($connect));
	
	if($result_insert){
		header("location: http://www.sesmt-rio.com/erp/medico/cad_preco_exame.php?cod_clinica=$cod_clinica");
		echo '<script> alert("Os dados foram cadastradas com sucesso!");</script>';
	}
}	

function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="cache-control"   content="no-cache" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content = "-1" />
<title>::Sistema SESMT - Cadastro de Clínicas::</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">

td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
</style>
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="../ajax.js"></script>
</head>

<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form action="cadastro_clinicas.php" name="form_clinicas" method="post">
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
        <td class="fontebranca10"><input name="razao_social_clinica" type="text" value="<?php echo $row_clinica[razao_social_clinica]?>" size="70"></td>
		<td class="fontebranca10"><input name="nome_fantasia_clinica" type="text" value="<?php echo $row_clinica[nome_fantasia_clinica]?>" size="30"></td>
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
      <td class="fontebranca10"><input name="cep_clinica" type="text" value="<?php echo $row_clinica[cep_clinica]?>" id="cep_clinica" size="9" onChange="showData();" ></td>    
      <td class="fontebranca10"><input name="endereco_clinica" type="text" id="endereco_clinica" value="<?php echo $row_clinica[endereco_clinica]?>" size="35"></td>
	  <td class="fontebranca10"><input name="num_end" type="text" id="num_end" value="<?php echo $row_clinica[num_end]?>" size="2"></td>
      <td class="fontebranca10"><input name="bairro_clinica" type="text" id="bairro_clinica" value="<?php echo $row_clinica[bairro_clinica]?>" size="17"></td>
      <td class="fontebranca10"><input name="cidade" type="text" id="cidade" value="<?php echo $row_clinica[cidade]?>" size="13"></td>
	  <td class="fontebranca10"><input name="estado" type="text" id="estado" value="<?php echo $row_clinica[estado]?>" size="15"></td>
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
      <td class="fontebranca10"><input name="tel_clinica" type="text" value="<?php echo $row_clinica[tel_clinica]?>" size="12"></td>
	  <td class="fontebranca10"><input name="fax_clinica" type="text" value="<?php echo $row_clinica[fax_clinica]?>" size="12"></td>
      <td class="fontebranca10"><input name="email_clinica" type="text" value="<?php echo $row_clinica[email_clinica]?>" size="40"></td>
      <td class="fontebranca10"><input name="cnpj_clinica" type="text" value="<?php echo $row_clinica[cnpj_clinica]?>" size="17" ></td>
      <td class="fontebranca10"><input name="inscricao_clinica" type="text" value="<?php echo $row_clinica[inscricao_clinica]?>" size="15" ></td>
	</tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
    <tr>
      <td class="fontebranca10">Ponto de Referência</td>
	  <td class="fontebranca10">Responsável Por Cadastro</td>
    </tr>
    <tr>
      <td class="fontebranca10"><input name="referencia_clinica" type="text" value="<?php echo $row_clinica[referencia_clinica]?>" size="70"></td>
	  <?php
	  	$query_log = "SELECT c.cod_func_criacao, u.usuario_id, f.funcionario_id, f.nome
					  FROM usuario u, funcionario f, clinicas c, log l
					  WHERE c.cod_func_criacao = u.usuario_id
					  AND f.funcionario_id = u.funcionario_id
					  AND u.usuario_id = l.usuario_id
					  AND l.usuario_id = $usuario_id";
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
		<td class="fontebranca10"><input name="contato_clinica" type="text" value="<?php echo $row_clinica[contato_clinica]?>" size="30"></td>
		<td class="fontebranca10"><input name="cargo_responsavel" type="text" value="<?php echo $row_clinica[cargo_responsavel]?>" size="20"></td>
		<td class="fontebranca10"><input name="email_contato" type="text" value="<?php echo $row_clinica[email_contato]?>" size="40"></td>
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
		<td class="fontebranca10"><input name="tel_contato" type="text" value="<?php echo $row_clinica[tel_contato]?>" size="12"></td>
		<td class="fontebranca10"><input name="ramal_responsavel" type="text" value="<?php echo $row_clinica[ramal_responsavel]?>" size="12"></td>
		<td class="fontebranca10"><input name="fax_responsavel" type="text" value="<?php echo $row_clinica[fax_responsavel]?>" size="12"></td>
		<td class="fontebranca10"><input name="nextel_contato" type="text" value="<?php echo $row_clinica[nextel_contato]?>" size="12"></td>
		<td class="fontebranca10"><input name="id_nextel_contato" type="text" value="<?php echo $row_clinica[id_nextel_contato]?>" size="8"></td>
	</tr>
	</table>
	<table width="90%" border="0" cellpadding="0" align="center">
	<tr>
		<td class="fontebranca10">Contato Intermediário</td>
		<td class="fontebranca10">Cargo</td>
		<td class="fontebranca10">E-mail</td>
	</tr>
	<tr>
		<td class="fontebranca10"><input name="contato_intermediario" type="text" value="<?php echo $row_clinica[contato_intermediario]?>" size="30"></td>
		<td class="fontebranca10"><input name="cargo_intermediario" type="text" value="<?php echo $row_clinica[cargo_intermediario]?>" size="20"></td>
		<td class="fontebranca10"><input name="email_intermediario" type="text" value="<?php echo $row_clinica[email_intermediario]?>" size="40"></td>
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
		<td class="fontebranca10"><input name="tel_intermediario" type="text" value="<?php echo $row_clinica[tel_intermediario]?>" size="12"></td>
		<td class="fontebranca10"><input name="ramal_intermediario" type="text" value="<?php echo $row_clinica[ramal_intermediario]?>" size="12"></td>
		<td class="fontebranca10"><input name="fax_intermediario" type="text" value="<?php echo $row_clinica[fax_intermediario]?>" size="12"></td>
		<td class="fontebranca10"><input name="nextel_intermediario" type="text" value="<?php echo $row_clinica[nextel_intermediario]?>" size="12"></td>
		<td class="fontebranca10"><input name="id_nextel_intermediario" type="text" value="<?php echo $row_clinica[id_nextel_intermediario]?>" size="8"></td>
<?php if ($grupo=="administrador"){?>
		<td ><select name="status" id="status">
        <option value="ativo" <?php if($row_clinica[status]=="ativo"){echo "selected";} ?>>ativo</option>
        <option value="inativo" <?php if($row_clinica[status]=="inativo"){echo "selected";} ?>>inativo</option>
      		 </select>
		</td>
<?php } else { echo "&nbsp;";}?>
	</tr>
	</table>
	<br><table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
	  <td align="center">
	  <input type="button"  name="continuar" value="Cancelar" onClick="MM_goToURL('parent','../medico/lista_clinicas.php');return document.MM_returnValue" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="submit" name="btn_gravar" value="Gravar" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','../medico/lista_clinicas.php');return document.MM_returnValue" style="width:100;">
	  </td>
	</tr>
	</table>
</form>
</body>
</html>