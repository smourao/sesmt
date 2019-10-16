<?php
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"

	case "administrador":
		$leitura = "";
	break;

	case "funcionario":
		$leitura = "readonly=true";
	break;
}

?>
<html>
<head>
<title>Cadastro de ATIVIDADE</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
.style5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 14px;
}
.style6 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 18px;
}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
&nbsp;<p>
<center><h2 class="style6"> SESMT - Segurança do Trabalho </h2>
</center>
<p>&nbsp;</p>
<?
$id      = $_REQUEST[id];
$excluir = $_POST["btn_excluir"];

if (empty($excluir)){ // se excluir for vazio, verifica o update
	$update  = $_REQUEST[update];
}

if (!empty($excluir)){ // se excluir não for vazio

	$cod_prod = $_POST["cod_prod"];

	$query_excluir = "delete from produto where cod_prod = ".$cod_prod;

	$result = pg_query($query_excluir) // executa a atualização
		or die ("Erro na exclusão da tabela ''Produto''. ==> " . pg_last_error($connect));

	echo '<script> alert("PRODUTO Excluido com sucesso!");</script>';

}
else if (!empty($update)){ // se update for ativado.
    if(!empty($_POST[preco_prod])){
        $_POST['preco_prod'] = str_replace(".", "", $_POST['preco_prod']);
        $_POST['preco_prod'] = str_replace(",", ".", $_POST['preco_prod']);
    }
	$cod_prod            = $_POST["cod_prod"];
	$cod_atividade       = $_POST["cod_atividade"];
	$desc_resumida_prod  = $_POST["desc_resumida_prod"];
	$desc_detalhada_prod = $_POST["desc_detalhada_prod"];
	$preco_prod          = $_POST["preco_prod"];

        //$preco_prod = str_replace(".", "", $preco_prod);
        //$preco_prod = str_replace(",", ".", $preco_prod);

	$query_update = "update produto set
	      cod_prod = ".$cod_prod."
	    , cod_atividade = '".$cod_atividade."'
		, desc_resumida_prod = '".$desc_resumida_prod."'
		, desc_detalhada_prod = '".$desc_detalhada_prod."'
		, preco_prod = '".$preco_prod."'
		where cod_prod = ".$id;

	$result = pg_query($query_update) // executa a atualização
		or die ("Erro na atualização na tabela ''Atividade''. ==> " . pg_last_error($connect));

	echo '<script> alert("PRODUTO Atualizado com sucesso!");</script>';

	$id = ""; $update = "";
}

if ( $id=="" && $update!="sim"){ // se id for vazio

    if(!empty($_POST[preco_prod])){
        $_POST['preco_prod'] = str_replace(".", "", $_POST['preco_prod']);
        $_POST['preco_prod'] = str_replace(",", ".", $_POST['preco_prod']);
    }
    	$cod_prod            = $_POST["cod_prod"];
	$cod_atividade       = $_POST["cod_atividade"];
	$desc_resumida_prod  = $_POST["desc_resumida_prod"];
	$desc_detalhada_prod = $_POST["desc_detalhada_prod"];
	$preco_prod          = $_POST["preco_prod"];

	if ( (!empty($cod_atividade)) AND (!empty($cod_prod)) ) // !empty = não vazio
	{

		$query_busca="SELECT cod_prod FROM produto WHERE cod_prod = ".$cod_prod; //query que verifica se código já esta cadastrado

		$result_busca = pg_query($query_busca) //executa query
			or die ("Erro na busca da tabela PRODUTO. ==> " . pg_last_error($connect). $query_busca); //mostra erro

		$row_busca = pg_fetch_array($result_busca); // recebe o resultado da query (linhas)

		if ($teste_busca = pg_num_rows($result_busca) < 1) { // se não teve mais de uma linha

        //$preco_prod = str_replace(".", "", $preco_prod);
        //$preco_prod = str_replace(",", ".", $preco_prod);

			$query_atividade = "insert into produto
		(cod_prod, desc_detalhada_prod , desc_resumida_prod, preco_prod, cod_atividade)
		values (".$cod_prod.", '".$desc_detalhada_prod."', '".$desc_resumida_prod."',
				'".$preco_prod."', '".$cod_atividade."')";

			$result_atividade = pg_query($query_atividade)or die("Erro na query: $query_atividade".pg_last_error($connect));

			echo '<script> alert("PRODUTO Cadastrado com sucesso!");</script>';

		}
	}

?>
<form name="frm_produto" action="cad_produto.php" method="post">
	<table align="center" width="400" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<th colspan="2" bgcolor="#009966"><br><h3 class="style5">Cadastro de Produto</h3><br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<?
			$query_max = "SELECT max(cod_prod) as cod_prod FROM produto";
			$result_max = pg_query($query_max) or die
					("Erro na busca da tabela produto!" . pg_last_error($connect));
			$row_max = pg_fetch_array($result_max);
		?>
		<tr>
			<td width="180" align="right"><strong><span class="style4">Código:</span>&nbsp;</strong></td>
			<td width="220">&nbsp;<input type="text" name="cod_prod" <?php echo($leitura)?> size="5" value="<?=($row_max[cod_prod] + 1)?>" readonly="true"></td>
		</tr>
		<tr>
			<td align="right"><span class="style4">Descrição&nbsp; Detalhada:&nbsp;</span></td>
			<td>&nbsp;<span class="style1"><input type="text" name="desc_detalhada_prod" <?php echo($leitura)?> size="30" style="background:#FFFFCC"></span></td>
		</tr>
		<tr>
			<td align="right"><span class="style4">Descrição&nbsp; Resumida:&nbsp;</span></td>
			<td>&nbsp;<span class="style1"><input type="text" name="desc_resumida_prod" <?php echo($leitura)?> size="30" style="background:#FFFFCC"></span></td>
		</tr>
		<tr>
			<td align="right"><span class="style4">Preço&nbsp; Unitário:&nbsp;</span></td>
			<td>&nbsp;<span class="style1"><input type="text"  onkeypress="return FormataReais(this, '.', ',', event);" name="preco_prod" <?php echo($leitura)?> size="15" style="background:#FFFFCC"></span></td>
		</tr>
		<tr>
			<td align="right"><span class="style4">Código da&nbsp; Atividade:&nbsp;</span></td>
			<td>&nbsp;
				<select name="cod_atividade">
<?

// aqui fazemos uma consulta para buscar as atividades

	$query_atividade = "select cod_atividade, dsc_atividade from atividade order by dsc_atividade";

	$result_atividade = pg_query($connect, $query_atividade)
		or die ("Erro na query: $query_atividade ==> " . pg_last_error($connect) );

    while($row_ativ = pg_fetch_array($result_atividade)){

?>
					<option value="<?=$row_ativ[cod_atividade]?>"><?=$row_ativ[dsc_atividade]?></option>
<?
	}
?>
				</select>			</td>
		</tr>
		<tr>
			<td colspan="2" >&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2" bgcolor="#009966">
			<br>
			<? if ($grupo=="administrador"){?>
				<input type="submit" value="Enviar" name="btn_enviar" style="width:100;">
			<? } else { echo "&nbsp;";}?>
				&nbsp;&nbsp;&nbsp;
			<? if ($grupo=="administrador"){?>
				<input type="reset" value="Limpar" name="btn_limpar" style="width:100;">
			<? } else { echo "&nbsp;";}?>
				&nbsp;&nbsp;&nbsp;
				<input type="button" name="voltar" value="&lt;&lt;Voltar" onClick="MM_goToURL('parent','lista_produto.php'); return document.MM_returnValue" style="width:100;">
			<br>&nbsp;			</th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
	</table>
</form>
<?
}
else
{ // se id estiver com valor

	$query_produto = "select
	                      cod_prod
						, desc_detalhada_prod
						, desc_resumida_prod
						, preco_prod
						, cod_atividade
					  from produto where cod_prod = ".$id ;

	$result_produto = pg_query($connect, $query_produto)
		or die ("Erro na query: $query_atividade ==> " . pg_last_error($connect) );

    $row = pg_fetch_array($result_produto);

?>
<form name="frm_produto" action="cad_produto.php?update=sim&id=<?=$id?>" method="post">
	<table align="center" width="400" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<th colspan="2" bgcolor="#009966"><br><h3 class="style5">Cadastro de Produto</h3><br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td width="180" align="right"><span class="style1"><strong>Código:</strong>&nbsp;</span></td>
			<td width="220">&nbsp;<span class="style1"><input type="text" name="cod_prod" <?php echo($leitura)?> size="5" value="<?=$row[cod_prod]?>" readonly="true"></span></td>
		</tr>
	<tr>
			<td align="right"><span class="style1"><strong>Descrição&nbsp; Detalhada:&nbsp;</strong></span></td>
			<td>&nbsp;<span class="style1"><input type="text" name="desc_detalhada_prod" <?php echo($leitura)?> size="30" value="<?=$row[desc_detalhada_prod]?>"
			style="background:#FFFFCC"></span></td>
		</tr>
		<tr>
			<td align="right"><span class="style1"><strong>Descrição&nbsp; Resumida:&nbsp;</strong></span></td>
			<td>&nbsp;<span class="style1"><input type="text" name="desc_resumida_prod" <?php echo($leitura)?> size="30" value="<?=$row[desc_resumida_prod]?>"
			style="background:#FFFFCC"></span></td>
		</tr>
		<tr>
			<td align="right"><span class="style1"><strong>Preço&nbsp; Unitário:&nbsp;</strong></span></td>
			<td>&nbsp;<span class="style1"><input type="text" onkeypress="return FormataReais(this, '.', ',', event);" name="preco_prod" <?php echo($leitura)?> size="15" value="<?php echo number_format($row[preco_prod], 2, ',','.');?>" style="background:#FFFFCC"></span></td>
		</tr>
		<tr>
			<td align="right"><span class="style1"><strong>Código da&nbsp; Atividade:&nbsp;</strong></span></td>
			<td>&nbsp;
				<select name="cod_atividade">
<?

// aqui fazemos uma consulta para buscar as atividades

	$query_atividade = "select cod_atividade, dsc_atividade from atividade order by dsc_atividade";

	$result_atividade = pg_query($connect, $query_atividade)
		or die ("Erro na query: $query_atividade ==> " . pg_last_error($connect) );

    while($row_ativ = pg_fetch_array($result_atividade)){

?>
					<option value="<?=$row_ativ[cod_atividade]?>"><?=$row_ativ[dsc_atividade]?></option>
<?
	}
?>
				</select>			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2" bgcolor="#009966">
			<br>
			<? if ($grupo=="administrador"){?>
				<input type="submit" value="Alterar" name="btn_enviar" style="width:100;">
			<? } else { echo "&nbsp;";}?>
				&nbsp;&nbsp;&nbsp;
			<? if ($grupo=="administrador"){?>
				<input type="submit" value="Excluir" name="btn_excluir" style="width:100;">
			<? } else { echo "&nbsp;";}?>
				&nbsp;&nbsp;&nbsp;
				<input type="button" value="&lt;&lt;Voltar" name="btn_voltar" onClick="MM_goToURL('parent','lista_produto.php');
				return document.MM_returnValue" style="width:100;">
			<br>&nbsp;			</th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  </table>
</form>
<?
}
pg_close($connect);
?>
<p>
<p>&nbsp;</p>
</body>
</html>
