<?php 
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";

if($_GET){
	$cliente_id = $_GET["cliente_id"];
}else{
	$cliente_id = $_POST["cliente_id"];
}

if(!empty($cliente_id)){
	$query_cli = "SELECT cc.cliente_id, o.cod_orcamento
				  FROM cliente_comercial cc, orcamento o
				  WHERE cc.cliente_id = $cliente_id
				  AND cc.cliente_id = o.cod_cliente";
	
	$result_cli = pg_query($connect, $query_cli) 
			or die ("Erro na query: $query_func ==> ".pg_last_error($connect));

	$row_cli = pg_fetch_array($result_cli);
}

if($cliente_id == "$row_cli[cliente_id]" and $_POST[btn_gravar] == "Gravar") {
	$query_busca = "SELECT cc.cliente_id, o.cod_orcamento
				    FROM cliente_comercial cc, orcamento o, orcamento_produto op
				    WHERE cc.cliente_id = $cliente_id
				    AND cc.cliente_id = o.cod_cliente
				    AND o.cod_orcamento = op.cod_orcamento";
	
	$result_busca = pg_query($connect, $query_busca) 
		or die ("Erro na query: $query_busca ==>".pg_last_error($connect));
	
		if($result_busca){
		$query_insert = "INSERT INTO orcamento_produto(cod_orcamento, cod_produto, quantidade, preco_unitario, preco_total)
						 VALUES ($cod_orcamento, $cod_produto, $qtd, $preco_unitario, ($qtd * $preco_unitario))";
	
		$result_insert = pg_query($connect, $query_insert) 
			or die ("Erro na query: $query_insert ==>".pg_last_error($connect));
			
			if ($result_insert) { // se os inserts foram corretos
					echo '<script> alert("Os dados foram cadastradas com sucesso!");</script>';
			}
		}	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gerar ASO</title>
<script language="javascript" src="./scripts.js"></script>
<link href="./css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">

td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style1 {font-size: 14px}
.style2 {font-size: 12px}
.style3 {font-family: Arial, Helvetica, sans-serif}
.style4 {font-size: 12}
</style>

</head>
<body bgcolor="#006633">&nbsp;
<form action="cipa_orcamento.php" name="frm_cipa" method="post">
<div align="center" class="fontebranca22bold">
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
	<td bgcolor="#009966" colspan="2"><center><h2 class="style3">Cadastrar Cipeiros no Orçamento</h2></center></td>
	</tr>
	<tr>
			<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td width="20%" class="fontebranca10 style2" align="left">Cod. Cliente</td>
		<td width="80%" class="fontebranca12" align="left">&nbsp;<?php echo $row_cli[cliente_id]; ?></td>
	</tr>
	<tr>
		<td class="fontebranca10 style2" align="left">Cod. Orçamento</td>
		<td class="fontebranca12" align="left">&nbsp;<?php echo $row_cli[cod_orcamento]; ?></td>
	</tr>
	<tr>
		<td class="fontebranca10 style2" align="left">Quantidade</td>
		<td class="fontebranca12 style2" align="left">&nbsp;<input type="text" name="qtd" size="5" /></td>
	</tr>
	<tr>
		<td class="fontebranca10 style2" align="left">Produto</td>
		<td class="fontebranca12" align="left">&nbsp;<select name="cod_prod">
		<?
			$query_produto = "select cod_prod, desc_resumida_prod from produto where cod_prod in ('840', '897') ";
			
			$result_produto = pg_query($connect, $query_produto) 
				or die ("Erro na query: $query_produto ==> " . pg_last_error($connect) );
		
			while($row_produto = pg_fetch_array($result_produto)){
	
		?>
			<option value="<?=$row_produto[cod_prod]?>"><?=$row_produto[desc_resumida_prod]?></option>
		<?
			}
		?>
			</select>
		</td>
	</tr>
	<tr>
		<td width="15%" class="fontebranca10 style2" align="left">Preço Unitário</td>
		<td class="fontebranca12" align="left">&nbsp;R$
		<?php
			$query_prod = "select cod_prod, preco_prod from produto where cod_prod = 840";
			$result_prod = pg_query($connect, $query_prod) 
				or die ("Erro na query: $query_prod ==> " . pg_last_error($connect) );
			$row_prod = pg_fetch_array($result_prod);
			echo $row_prod[preco_prod];
		?>
		</td>
	</tr>
	<tr>
			<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td align="center" colspan="2"><input type="submit" name="btn_gravar" value="Gravar" /></td>
		<input type="hidden" name="cliente_id" value="<?php echo $cliente_id; ?>" />
	</tr>
</table></div>
</form>
</body>
</html>
