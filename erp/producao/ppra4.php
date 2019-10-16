<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$cliente = $_GET["cliente"];
	$setor = $_GET["setor"];
}
else{
	$cliente = $_POST["cliente"];
	$setor = $_POST["setor"];
}

/* IDENTIFICA SE O USUÁRIO QUE CONTINUAR INSERINDO DADOS OU PARAR */
$continuar = $_POST["btn_mais"]; // CONTINUA
$concluir = $_POST["btn_concluir"]; // PÁRA

if( !empty($cliente) & !empty($setor) ){

	$query_cli = "SELECT upper(razao_social_cliente) as razao_social_cliente, bairro_cliente, telefone_cliente, email, endereco_cliente
				  FROM clientes where cod_cliente = $cliente";
	$result_cli = pg_query($connect, $query_cli) 
	or die ("Erro na query: $query_cli ==> " . pg_last_error($connect) );

	$query_set = "SELECT cod_setor, desc_setor, nome_setor
				  FROM setor where cod_setor = $setor";
	$result_set = pg_query($connect, $query_set) 
	or die ("Erro na query: $query_set ==> " . pg_last_error($connect) );
}

if($continuar == "Mais"){ //CONTINUA

	$cod_mobilia = $_POST["cod_mobilia"];
	$descricao_mobilia = $_POST["descricao_risco"];

	if( !empty($_POST["ruido"]) ){
		$ruido = $_POST["ruido"];
	}
	else {
		$ruido = 0;
	}

	if ( !empty($_POST["iluminancia"]) ){
		$iluminancia = $_POST["iluminancia"];
	} else {$iluminancia = 0;}

	$descricao_mobilia = $_POST["descricao_mobilia"];

	$sql = "INSERT INTO mobilia(
            cod_mobilia
			, cod_cliente
			, cod_setor
			, descricao_mobilia
			, ruido
			, iluminancia)
    VALUES ($cod_mobilia
			, $cliente
			, $setor
			, '$descricao_mobilia'
			, $ruido
			, $iluminancia)";

	$result = pg_query($connect, $sql) 
		or die ("Erro na query: $sql ==> " . pg_last_error($connect) );

	if($result){
		echo "<script>alert('Risco do Setor cadastrado com sucesso!');</script>";
		$sql = "";
		$cod_agente_risco = "";
		$descricao_risco = "";
		$fonte_geradora = "";
		$medida_predentiva_existente = "";
	}
}

if($concluir == "Avançar"){
	header("location: http://www.sesmt-rio.com/erp/producao/ppra5.php?cliente=$cliente&setor=$setor");
}

?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra3" method="post" action="ppra4.php">
<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<th colspan="2" bgcolor="#009966" ><br>
			<h3 class="style1">Cadastro de Mob&iacute;lia:</h3>
			<br>
		</th>
	</tr>
<?php
if($result_cli){

	$row_cli = pg_fetch_array($result_cli);

	echo "<tr>
			<td colspan=2 bgcolor=#FFFFFF>
				<br><font color=black><center><b>CLIENTE:</b></center>
				&nbsp;&nbsp;&nbsp; Nome do Cliente: <b>$row_cli[razao_social_cliente]</b> <br>
				&nbsp;&nbsp;&nbsp; Endereço: <b>$row_cli[endereco_cliente]</b> <br>
				&nbsp;&nbsp;&nbsp; Bairro: <b>$row_cli[bairro_cliente]</b> <br>
				&nbsp;&nbsp;&nbsp; Telefone: <b>$row_cli[telefone_cliente]</b> <br>
				&nbsp;&nbsp;&nbsp; E-mail: <b>$row_cli[email]</b> &nbsp;
			</td>
		</tr>";
}
if($result_set){

	$row_set = pg_fetch_array($result_set);
	
	echo "<tr>
			<td colspan=2 bgcolor=#FFFFFF>
				<font color=black><center><b>SETOR:</b></center>
				&nbsp;&nbsp;&nbsp; Nome do Setor: <b>$row_set[nome_setor]</b> <br>
				&nbsp;&nbsp;&nbsp; Descrição do Setor: <b>$row_set[desc_setor]</b> <br>
			</td>
		</tr>";
}
/********************* LISTAR AS MOBÍLIAS JÁ CADASTRADAS PARA ESTE SETOR NESTE CLIENTE *********************/
if( !empty($cliente) and !empty($setor) ){

	$sql_dados = "SELECT descricao_mobilia
					, ruido
					, iluminancia
				  FROM mobilia
				  where cod_cliente = $cliente
				  and cod_setor = $setor";

	$result_dados = pg_query($connect, $sql_dados) 
	or die ("Erro na query: $sql_dados <p> " . pg_last_error($connect) );
	
	while($row_dados = pg_fetch_array($result_dados)){
		echo "<tr>
				<td colspan=2><br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Descrição da Mobília:</b> $row_dados[descricao_mobilia] <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Nível do Ruído:</b> $row_dados[ruido] <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Nível de Iluminância:</b> $row_dados[iluminancia] <br> &nbsp;
				</td>
			  </tr>";
	}
}
/********************* FIM LISTAR AS MOBÍLIAS *********************/
?>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
<?php

	$sql_busca = "select cod_mobilia from mobilia where cod_cliente = $cliente and cod_setor = $setor";

	$result_busca = pg_query($connect, $sql_busca) 
		or die ("Erro na query: $query_busca ==> " . pg_last_error($connect) );
/* CASO JÁ TENHA REGISTRO PARA ESTE SETOR NESTE CLIENTE, NÃO INCLUI NA LISTA */
	if (pg_num_rows($result_busca)<>0)
	{
		$sql_mob = "select max(cod_mobilia)+1 as cod_mobilia from mobilia where cod_cliente = $cliente and cod_setor = $setor";
		$result_mob = pg_query($connect, $sql_mob) 
			or die ("Erro na query: $sql_mob ==> " . pg_last_error($connect) );
		$row_mob = pg_fetch_array($result_mob);
		$mobilia = $row_mob[cod_mobilia];
	}
	else
	{
		$mobilia = 1;
	}
?>
	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style1">Código da Mobília:</span></b><br>
	  &nbsp;</td>
		<td>
			&nbsp;&nbsp;&nbsp;	<input type="text" name="cod_mobilia" size="5" readonly="true" value="<?php echo $mobilia;?>" />
		</td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style1">Descrição da Mobília:</span></b><br>
	  &nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;	<input type="text" name="descricao_mobilia" size="50"/></td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;<span class="style1">&nbsp;Ruído:</span></b><br>
	  &nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;	<input type="text" name="ruido" size="5"/></td>
	</tr>
	<tr>
		<td><b><br>&nbsp;&nbsp;&nbsp;<span class="style1">Iluminância:</span></b><br>
	  &nbsp;</td>
		<td>&nbsp;&nbsp;&nbsp;	<input type="text" name="iluminancia" size="5"/></td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<br>&nbsp;
			<input type="submit" name="btn_mais" value="Mais" style="width:100px;" title="Clique aqui para cadastrar mais">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_concluir" value="Avançar" style="width:100px;" title="Clique aqui para encerrar">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="btn_limpar" value="Limpar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	        <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','../tela_principal.php');return document.MM_returnValue" style="width:100;">
			<br>&nbsp;
			<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
			<input type="hidden" name="setor" value="<?php echo $setor; ?>">
		</td>
	</tr>
</table>
</form>
</body>
</html>