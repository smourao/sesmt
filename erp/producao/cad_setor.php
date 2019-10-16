<?php
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

// Captura os valores do formulário
if($_POST){
	$cod_setor  = $_POST["cod_setor"];
}else{
	$cod_setor  = $_GET["setor"];
}
$desc_setor = $_POST["desc_setor"];
$nome_setor = $_POST["nome_setor"];

/******************* PARTE DE INSERIR ***************************/
if ( !empty($cod_setor) and $_POST[btn_enviar]=="Gravar" and !empty($_POST["nome_setor"]) ) // quando clicar em gravar
{
	$query_busca="SELECT cod_setor, desc_setor, nome_setor FROM setor
				  WHERE upper(nome_setor) = '" . strtoupper($nome_setor) . "' or desc_setor = '" . strtoupper($desc_setor) . "'"; //query que verifica se já esta cadastrado

	$result_busca = pg_query($query_busca) //executa query
		or die ("Erro na busca da tabela SETOR. ==> " . pg_last_error($connect)); //mostra erro

	$row_busca = pg_fetch_array($result_busca); // recebe o resultado da query (linhas)

	if ($teste_busca = pg_num_rows($result_busca) == 0) { // se não encontrou resultado, pode gravar
		$query_setor = "insert into setor (cod_setor, desc_setor, nome_setor) values ($cod_setor, '$desc_setor','$nome_setor')";

		$result_setor = pg_query($query_setor)or die("Erro na query: $query_setor " . pg_last_error($connect) );

		if ($result_setor){
			echo '<script> alert("Setor cadastrado com sucesso!");</script>';
		}
	}
	else{ // se foi encontrado o nome ou a descrição
		echo "<script>alert('O setor \"$nome_setor\" já está cadastrado.');</script>";
	}
}/******************* PARTE DE ATUALIZAR ***************************/
else if ($_POST[btn_enviar]=="Atualizar") // quando for atualização
{
	$sql_atualizar = "UPDATE setor SET desc_setor='$desc_setor' , nome_setor='$nome_setor' WHERE cod_setor = $cod_setor";

	$result_atualiza = pg_query($connect, $sql_atualizar);
	
	if($result_atualiza){
		echo "<script>alert('O setor atualizado com sucesso.');</script>";
	}
	else{
		echo "<script>alert('O setor não foi atualizado.');</script>";
	}
}
else if ( $_POST[btn_enviar]=="Gravar" and empty($_POST["nome_setor"]) and empty($_POST["desc_setor"]) ){
	echo "<script>alert('Preencha corretamente os campos!');</script>";
}
/******************* PARTE DE BUSCAR OS DADOS PARA PREENCHER A TELA ***************************/
// buscar os dados do setor selecionado na listagem
if( !empty($_GET[setor]) )
{
	$sql_update="SELECT cod_setor, desc_setor, nome_setor FROM setor
				  WHERE cod_setor = $setor"; //query que verifica se código já esta cadastrado

	$result_update = pg_query($sql_update) //executa query
		or die ("Erro na busca da tabela SETOR. ==> " . pg_last_error($connect)); //mostra erro

	$row_update = pg_fetch_array($result_update); // recebe o resultado da query (linhas)

	$setor = $row_update[cod_setor];
}
else{
	$query_max = "SELECT max(cod_setor)+1 as cod_setor FROM setor";
	
	$result_max = pg_query($query_max) //executa a query
		or die ("Erro na busca da tabela SETOR. ==> " . pg_last_error($connect)); //mostra o erro.
		
	$row_max = pg_fetch_array($result_max); //recebe o resultado da query. (linhas)
	
	$setor = $row_max[cod_setor];
}
?>
<html>
<head>
<title>::SESMT:: Cadastro de Setor</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho</h2></center>
<p>&nbsp;</p>

<form name="frm_ATIVIDADE" action="" method="post">
	<table align="center" width="500" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
		<tr>
			<th colspan="2" bgcolor="#009966"><br>
			<h3>Cadastro de Setor:</h3>
			<br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td width="180" align="right"><strong>Código:&nbsp;</strong></td>
			<td width="220">&nbsp;<input type="text" name="cod_setor" size="5" value="<?php echo $setor; ?>" readonly="true"> </td>
		</tr>
		<tr>
			<td width="180" align="right"><strong>Nome:&nbsp;</strong></td>
			<td>&nbsp;<input type="text" name="nome_setor" size="30" style="background:#FFFFCC" value="<?php echo $row_update[nome_setor] ?>"></td>
		</tr>
		<tr>
			<td width="180" align="right"><strong>Descrição:&nbsp;</strong></td>
			<td>&nbsp;<input type="text" name="desc_setor" size="30" style="background:#FFFFCC" value="<?php echo $row_update[desc_setor] ?>"></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2" bgcolor="#009966">
				<br>
			<input name="btn_voltar" type="button" id="btn_voltar" onClick="location.href='lista_setor.php';" value="&lt;&lt; Voltar" style="width:100;">
			&nbsp;&nbsp;&nbsp;
			<input type="submit" value="<?php if($_GET){echo "Atualizar";} else {echo "Gravar";}?>" name="btn_enviar" style="width:100;">
			&nbsp;&nbsp;&nbsp;
			<input type="reset" value="Limpar" style="width:100;">
			&nbsp;&nbsp;&nbsp;
			<input name="btn_avancar" type="button" id="btn_avancar" onClick="location.href='setor_epi.php?setor=<?PHP echo $_GET[setor];?>';" value="Avançar >>" style="width:100;">

			<br>&nbsp;
			</th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
</form>
<?
	pg_close($connect);
?>
</p>
<p>&nbsp;</p>
</body>
</html>
