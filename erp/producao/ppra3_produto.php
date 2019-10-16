<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$cliente  = $_GET["cliente"];
	$setor    = $_GET["setor"];
	$status   = $_GET["status"];
	$pesquisa = $_GET["pesquisa"];
	$tipo     = $_GET["tipo"];
}
else{
	$cliente  = $_POST["cliente"];
	$setor    = $_POST["setor"];
	$status   = $_POST["status"];
	$pesquisa = $_POST["pesquisa"];
	$tipo     = $_POST["tipo"];
}

if ( empty($cliente) or empty($setor) ){
	header("location: lista_ppra.php");
}

/*Parte que trata as sugestões que serão excluidas*/
if(!empty($_GET[produto]))
{
	$produto = $_GET[produto];

	$query_excluir = $query_excluir . "delete from sugestao_setor 
										where cod_cliente   = $cliente 
											and cod_setor   = $setor 
											and cod_produto = $produto
											and cod_status  = $status;";

	$result_excluir = pg_query($connect, $query_excluir)
		or die ("Erro na query: $query_excluir ==> " . pg_last_error($connect) );

	if ($result_excluir) {
		echo '<script> alert("A Sugestão foi excluída com sucesso!");</script>';
	}
} 
/************ Fim da exclusão *************/


if($_POST["btn_alterar"] == "Gravar"){

	if(isset($_POST["produto"])) // verifica se tem produtos selecionados
	{
		foreach($_POST["produto"] as $produto) // recebe a lista de produtos
		{
			$sql_verifica = "select * from sugestao_setor where cod_cliente = $cliente and cod_setor = $setor and cod_produto = $produto and cod_status=$status";
			
			$result_verifica = pg_query($connect, $sql_verifica)
				or die ("Erro na query: $sql_verifica ==> " . pg_last_error($connect) );

			if ( pg_num_rows($result_verifica)==0 ){
				// monta o insert no banco
				$query_sugestao = $query_sugestao . "INSERT INTO sugestao_setor(cod_cliente, cod_setor, cod_produto, data, cod_status, tipo_sugestao) VALUES ($cliente, $setor, $produto, '" . date("Y-m-d") . "', $status, '$tipo');";
			}
			else{
				$sql_jatem = "select desc_detalhada_prod from produto where cod_produto = $produto";
				$result_jatem = pg_query($connection, $sql_jatem);
				$row_jatem = pg_fetch_array($result_jatem);
			 	echo '<script> alert("A sugestão $row_jatem[desc_detalhada_prod] já está cadastrada!");</script>';
			}
		}

		$result_sugestao = pg_query($connect, $query_sugestao)
			or die ("Erro na query: $query_sugestao ==> " . pg_last_error($connect) );

		if ($result_sugestao) { // se os inserts foram corretos
			echo '<script> alert("As Sugestões foram cadastradas com sucesso!");</script>';
		}
	}
}


if(!empty($cliente)){
/******************** DADOS DO CLIENTE **********************/
	$query_cli = "SELECT razao_social_cliente
					, bairro_cliente
					, telefone_cliente
					, email
					, endereco_cliente
				  FROM clientes 
				  where cod_cliente = $cliente";
	
	$result_cli = pg_query($connect, $query_cli) 
		or die ("Erro na query: $query_cli ==> " . pg_last_error($connect) );
}
/******************** DADOS DO CLIENTE **********************/

if(!empty($setor)){
/*************** DADOS DO SETOR ****************/
	$query_set = "SELECT cod_setor, desc_setor, nome_setor
				  FROM setor where cod_setor = $setor";
	$result_set = pg_query($connect, $query_set) 
		or die ("Erro na query: $query_set ==> " . pg_last_error($connect) );
}
/*************** DADOS DO SETOR DO CLIENTE ****************/

?>
<html>
<head>
<title>:: SESMT :: Medidas Coletivas </title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra3" method="post" action="ppra3_produto.php">
<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
		<th bgcolor="#009966" colspan=2>
			<br>
			CADASTRO DE MEDIDAS COLETIVAS
			<br> &nbsp;
		</th>
    </tr>
	<?php
	if($result_cli){

		$row_cli = pg_fetch_array($result_cli);
		echo "<tr>
				<td bgcolor=#FFFFFF colspan=2>
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
				<td bgcolor=#FFFFFF colspan=2>
					<font color=black>
					&nbsp;&nbsp;&nbsp; Nome do Setor: <b>$row_set[nome_setor]</b> <br>
					&nbsp;&nbsp;&nbsp; Descrição do Setor: <b>$row_set[desc_setor]</b> <br>&nbsp;
				</td>
			</tr>";
	}
	?>
	<tr>
		<td colspan=2>&nbsp;</td>
	</tr>
	<tr>
		<th align="center" colspan="2">
			<br>
			<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','ppra3_sugestao.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_alterar" value="Gravar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="btn_limpar" value="Limpar" style="width:100px;">
			<br> &nbsp;
			<input type="hidden" name="cliente" value="<?php echo $cliente ?>">
			<input type="hidden" name="setor" value="<?php echo $setor ?>">
		</th>
	</tr>
	<tr>
		<th colspan=2><br> MEDIDAS PREVENTIVAS COLETIVAS: <br> &nbsp; </th>
	</tr>
<?php

$sql_sugestao = "SELECT c.cod_cliente
					, c.razao_social_cliente
					, ss.cod_setor
					, s.nome_setor
					, ss.cod_produto
					, p.desc_detalhada_prod
					, p.preco_prod
					, ss.cod_status
					, st.dsc_status
					, ss.tipo_sugestao
				 FROM sugestao_setor ss, setor s, clientes c, produto p, status st
				 where ss.cod_cliente = c.cod_cliente
				 and ss.cod_setor     = s.cod_setor
				 and ss.cod_produto   = p.cod_prod
				 and ss.cod_cliente   = $cliente
				 and ss.cod_setor     = $setor
				 and ss.cod_status    = st.cod_status";

$result_sugestao = pg_query($connect, $sql_sugestao) 
	or die ("Erro na query: $sql_sugestao ==> ".pg_last_error($connect));

if(pg_num_rows($result_sugestao)>0){
	echo "	<tr>";
	echo "		<th colspan=2 bgcolor=\"#FFFFFF\"><font color=black>Sugestões já cadastradas:</font></th>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<td colspan=2>";
	echo "			<table border=1>";
	echo "				<tr>";
	echo "					<th width=100>&nbsp;</th>";
	echo "					<th width=600>Produto:<br>&nbsp;</th>";
	echo "				</tr>";
	while($row_sugestao = pg_fetch_array($result_sugestao))
	{
		echo "				<tr>";
		echo "					<th class=linksistema><a href=\"http://$dominio/erp/producao/ppra3_produto.php?produto=$row_sugestao[cod_produto]&cliente=$cliente&setor=$setor&status=$status\"><u>Excluir</u></a></th>";
		echo "					<td>&nbsp;&nbsp;&nbsp;&nbsp; $row_sugestao[desc_detalhada_prod] </td>";
		echo "				</tr>";
		$fora = $fora . ", $row_sugestao[cod_produto]";
/***************************/
	}
	echo "			</table>";
	echo "		</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<th colspan=2>&nbsp;</th>";
	echo "	</tr>";
}

/******************** DADOS DO PRODUTO **********************/
?>
	<tr>
		<th colspan=2 bgcolor="#FFFFFF"><br><font color=black>SELECIONE AS NOVAS MEDIDAS:<br>&nbsp;</font></th>
	</tr>
	<tr>
		<th colspan=2>&nbsp;</th>
	</tr>

<?php
if ( !empty($pesquisa) and !empty($cliente) and !empty($setor) and !empty($status) )
{
		$query_produto = "SELECT cod_prod, desc_detalhada_prod, preco_prod
						  FROM produto 
						  where lower(desc_detalhada_prod) like '%" . strtolower( addslashes($pesquisa) ) . "%'";

// não trás os produtos já cadastrados
	if (pg_num_rows($result_sugestao)>0){
		$query_produto = $query_produto . " and cod_prod not in (". substr($fora,1,100) .")";
	}
	
	$result_produto = pg_query($connect, $query_produto) 
		or die ("Erro na query: $query_produto ==> ".pg_last_error($connect));


	while($row_produto = pg_fetch_array($result_produto))
	{
	
		echo "	<tr>";
		echo "		<td colspan=2>";
		echo "			&nbsp;&nbsp;&nbsp; ";
		echo "			<input type=\"checkbox\" name=\"produto[]\" value=\"$row_produto[cod_prod]\">&nbsp;&nbsp; $row_produto[desc_detalhada_prod] <br>&nbsp;";
		echo "		</td>";
		echo "	</tr>";
	
	}
/******************** FIM DADOS DO PRODUTO **********************/
?>
	<tr>
		<td colspan=2>&nbsp;</td>
	</tr>
	<tr>
		<th align="center" colspan="2">
			<br>
			<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','ppra3_sugestao.php?cliente=<?php echo $cliente; ?>&setor=<?php echo $setor; ?>');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_alterar" value="Gravar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="btn_limpar" value="Limpar" style="width:100px;">
			<br> &nbsp;
		</th>
	</tr>
<?php
}
?>
</table>
<input type="hidden" name="cliente"  value="<?php echo $cliente; ?>"  >
<input type="hidden" name="setor"    value="<?php echo $setor; ?>"    >
<input type="hidden" name="pesquisa" value="<?php echo $pesquisa; ?>" >
<input type="hidden" name="status"   value="<?php echo $status; ?>"   >
<input type="hidden" name="tipo"     value="<?php echo $tipo; ?>"     >
</form>
</body>
</html>
