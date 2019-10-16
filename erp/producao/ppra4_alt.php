<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$cliente = $_GET["cliente"];
	$setor = $_GET["setor"];
	$mobilia = $_GET["mobilia"];
}
else{
	$cliente = $_POST["cliente"];
	$setor = $_POST["setor"];
}

if( $_POST["btn_excluir"] == "Excluir" ){
	if( isset($_POST["mobilia_fora"]) ){ // verifica se tem produtos selecionados
		foreach($_POST["mobilia_fora"] as $mobilia_fora){ // recebe a lista de produtos
			// monta o insert no banco
			$excluir = $excluir . "delete from mobilia 
								   where cod_cliente = $cliente 
								   and cod_setor = $setor 
								   and cod_mobilia = $mobilia_fora;";
		}
		$result_excluir = pg_query($connect, $excluir)
			or die ("Erro na query: $excluir ==> " . pg_last_error($connect) );

		if ($result_excluir){ // se os inserts foram corretos
			echo '<script> alert("Mobilias excluidas com sucesso!");</script>';
		}
	}
}


/* IDENTIFICA SE O USUÁRIO QUE CONTINUAR INSERINDO DADOS OU PARAR */
$continuar = $_POST["btn_mais"]; // CONTINUA
$concluir = $_POST["btn_concluir"]; // PÁRA

if($continuar == "Gravar"){ //CONTINUA

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
		echo "<script>alert('Mobilia cadastrada com sucesso!');</script>";
		$sql = "";
		$cod_agente_risco = "";
		$descricao_risco = "";
		$fonte_geradora = "";
		$medida_predentiva_existente = "";
		$sugestao = "";
	}
}
else if($continuar == "Alterar"){ //ALTERA

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

	$sql = "UPDATE mobilia
			   SET descricao_mobilia = '$descricao_mobilia'
			   		, ruido = $ruido
					, iluminancia = $iluminancia
			 WHERE cod_mobilia = $cod_mobilia
			 and cod_cliente = $cliente
			 and cod_setor = $setor ;";

	$result = pg_query($connect, $sql) 
		or die ("Erro na query: $sql ==> " . pg_last_error($connect) );

	if($result){
		echo "<script>alert('Mobilia Alterada com sucesso!');</script>";
		$sql = "";
		$cod_agente_risco = "";
		$descricao_risco = "";
		$fonte_geradora = "";
		$medida_predentiva_existente = "";
		$sugestao = "";
	}
}

if($concluir == "Concluir"){
	header("location: http://$dominio/erp/producao/ppra5.php?cliente=$cliente&setor=$setor");
}

if( !empty($cliente) and !empty($setor) ){

	$query_cli = "SELECT upper(razao_social_cliente) as razao_social_cliente, bairro_cliente, telefone_cliente, email, endereco_cliente
				  FROM clientes where cod_cliente = $cliente";
	$result_cli = pg_query($connect, $query_cli) 
	or die ("Erro na query: $query_cli ==> " . pg_last_error($connect) );

	$query_set = "SELECT cod_setor, desc_setor, nome_setor
				  FROM setor where cod_setor = $setor";
	$result_set = pg_query($connect, $query_set) 
	or die ("Erro na query: $query_set ==> " . pg_last_error($connect) );
}

?>
<html>
<head>
<title>PPRA - parte IV</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px;}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra3" method="post" action="ppra4_alt.php">
<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<th colspan="2" bgcolor="#009966" >
			<br>
			CADASTRO DE MOB&Iacute;LIA
			<br>&nbsp;		</th>
	</tr>
<?php
if($result_cli){

	$row_cli = pg_fetch_array($result_cli);

	echo "<tr>
			<td colspan=2 bgcolor=#FFFFFF>
				<br><font color=black>
				&nbsp;&nbsp;&nbsp; Nome do Cliente: <b>$row_cli[razao_social_cliente]</b> <br>
				&nbsp;&nbsp;&nbsp; Endereço: <b>$row_cli[endereco_cliente]</b> <br>
				&nbsp;&nbsp;&nbsp; Bairro: <b>$row_cli[bairro_cliente]</b> <br>
				&nbsp;&nbsp;&nbsp; Telefone: <b>$row_cli[telefone_cliente]</b> <br>
				&nbsp;&nbsp;&nbsp; E-mail: <b>$row_cli[email]</b> <br>&nbsp;
			</td>
		</tr>";
}
if($result_set){

	$row_set = pg_fetch_array($result_set);
	
	echo "<tr>
			<td colspan=2 bgcolor=#FFFFFF>
				<font color=black>
				&nbsp;&nbsp;&nbsp; Nome do Setor: <b>$row_set[nome_setor]</b> <br>
				&nbsp;&nbsp;&nbsp; Descrição do Setor: <b>$row_set[desc_setor]</b> <br>&nbsp;
			</td>
		</tr>";
}

echo "	<tr>
			<td colspan=2>&nbsp;</td>
		</tr>";
/********************* LISTAR AS MOBÍLIAS JÁ CADASTRADAS PARA ESTE SETOR NESTE CLIENTE *********************/
if( !empty($cliente) and !empty($setor) ){

	$sql_dados = "SELECT cod_mobilia
					, descricao_mobilia
					, ruido
					, iluminancia
				  FROM mobilia
				  where cod_cliente = $cliente
				  and cod_setor = $setor";
	if ( !empty($_GET[mobilia]) ){
		$sql_dados = $sql_dados . "and cod_mobilia not in ( $_GET[mobilia] ) ";
	}

	$result_dados = pg_query($connect, $sql_dados) 
	or die ("Erro na query: $sql_dados <p> " . pg_last_error($connect) );
	
	if( pg_num_rows($result_dados)>0 ){
		echo "	<tr>";
		echo "			<th colspan=2 bgcolor=\"#FFFFFF\"> <br> <font color=\"#000000\">Dados já cadastrados:</font></br> &nbsp;</th>";
		echo "	</tr>";
	}

	while($row_dados = pg_fetch_array($result_dados)){
		echo "<tr>
				<th><input type=\"checkbox\" name=\"mobilia_fora[]\" value=\"$row_dados[cod_mobilia]\">&nbsp;Excluir</th>
				<td class=style1><br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Descrição da Mobília: <b>$row_dados[descricao_mobilia]</b> <br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nível do Ruído: <b>$row_dados[ruido]</b><br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nível de Iluminância: <b>$row_dados[iluminancia] </b><br> &nbsp;
				</td>
			  </tr>";
	}
}
/********************* FIM LISTAR AS MOBÍLIAS *********************/
?>
	<tr>
		<th colspan="2" bgcolor="#FFFFFF"><br>
		  <span class="style1"><font color="#000000">Novo Registro</font></span><br>
		  &nbsp;</th>
	</tr>
<?php
if ( empty($_GET["mobilia"]) ){
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
}
else{
		$sql_mob = "SELECT cod_mobilia, cod_cliente, cod_setor, descricao_mobilia, ruido, iluminancia 
					  FROM mobilia 
					  where cod_cliente = $cliente 
					  and cod_setor = $setor
					  and cod_mobilia = $_GET[mobilia]";
		$result_mob = pg_query($connect, $sql_mob) 
			or die ("Erro na query: $sql_mob ==> " . pg_last_error($connect) );
		$row_mob = pg_fetch_array($result_mob);
		$mobilia = $row_mob[cod_mobilia];
}
?>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;&nbsp;<span class="style1">Código da Mobília: &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td>
			&nbsp;&nbsp;&nbsp;	<input type="text" name="cod_mobilia" size="5" readonly="true" value="<?php echo $mobilia;?>" />		</td>
	</tr>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;<span class="style1">&nbsp;Descrição da Mobília:  &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td>&nbsp;&nbsp;&nbsp;	<input type="text" name="descricao_mobilia" size="50" value="<?php echo $row_mob[descricao_mobilia];?>"/></td>
	</tr>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;&nbsp;<span class="style1">Ruído:  &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td>&nbsp;&nbsp;&nbsp;	<input type="text" name="ruido" size="5"value="<?php echo $row_mob[ruido];?>"/></td>
	</tr>
	<tr>
		<td><div align="right"><b><br>
		  &nbsp;&nbsp;&nbsp;<span class="style1">Iluminância:  &nbsp;</span></b><br>
	  &nbsp;</div></td>
		<td>&nbsp;&nbsp;&nbsp;	<input type="text" name="iluminancia" value="<?php echo $row_mob[iluminancia];?>" size="5"/></td>
	</tr>
<?php
	if(pg_num_rows($result_dados)>0){
		echo "<tr>";
		echo "			<th colspan=2><br><input type=\"submit\" name=\"btn_excluir\" value=\"Excluir\" title=\"Excluir itens selecionados\" style=\"width:100px;\"> <br>&nbsp;</th>";
		echo "	</tr>";
	}
?>
	<tr>
		<td align="center" colspan="2">
			<br>&nbsp;
	        <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','ppra3_sugestao.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>&update=sim');return document.MM_returnValue" style="width:100;">
	        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_mais" value="Gravar" style="width:100px;" title="Clique aqui para cadastrar mais">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_concluir" value="Concluir" style="width:100px;" title="Clique aqui para avançar" onClick="MM_goToURL('parent','ppra5.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>&update=sim');return document.MM_returnValue">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="btn_limpar" value="Limpar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
			&nbsp;
			<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
			<input type="hidden" name="setor" value="<?php echo $setor; ?>">		</td>
	</tr>
</table>
</form>
<?php pg_close($connect); ?>
</body>
</html>