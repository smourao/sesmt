<?php
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
?>
<html>
<head>
<title>Cadastro de ATIVIDADE</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho</h2></center>
<p>&nbsp;</p>
<?
$id      = $_REQUEST[id];
$excluir = $_POST["btn_excluir"];

if (empty($excluir)){
	$update  = $_REQUEST[update];
}

if (!empty($excluir)){ // se excluir for ativado.

	$cod_atividade  = $_POST["cod_atividade"]; 
	$desc_atividade = $_POST["dsc_atividade"];
	
	$query_excluir = "delete from atividade where cod_atividade = ".$cod_atividade;

	$result = pg_query($query_excluir) // executa a atualização
		or die ("Erro na exclusão da tabela ''Atividade''. ==> " . pg_last_error($connect));
		
	echo '<script> alert("ATIVIDADE Excluida com Sucesso!");</script>';
	
//	$excluir = ""; $id = ""; $update = "";

}
else if (!empty($update)){ // se update for ativado.

	$cod_atividade  = $_POST["cod_atividade"]; 
	$desc_atividade = $_POST["dsc_atividade"];
	
	$query_update = "update atividade set cod_atividade = ".$cod_atividade.", dsc_atividade = '".$desc_atividade."' 
		where cod_atividade = ".$id;
	
	$result = pg_query($query_update) // executa a atualização
		or die ("Erro na atualização na tabela ''Atividade''. ==> " . pg_last_error($connect));
		
	echo '<script> alert("ATIVIDADE Atualizada com Sucesso!");</script>';
	
	$id = ""; $update = "";
}

if ( $id=="" && $update!="sim"){ // se id for vazio

	$cod_atividade  = $_POST["cod_atividade"]; 
	$desc_atividade = $_POST["dsc_atividade"];
	
	if ( (!empty($cod_atividade)) AND (!empty($desc_atividade)) ) // !empty = não vazio
	{
	
		$query_busca="SELECT cod_atividade FROM atividade WHERE cod_atividade=".$cod_atividade; //query que verifica se código já esta cadastrado
	
		$result_busca = pg_query($query_busca) //executa query
			or die ("Erro na busca da tabela atividade. ==> " . pg_last_error($connect)); //mostra erro
	
		$row_busca = pg_fetch_array($result_busca); // recebe o resultado da query (linhas)
		
		if ($teste_busca = pg_num_rows($result_busca) < 1) { // se não teve mais de uma linha
		
			$query_atividade = "insert into atividade (cod_atividade, dsc_atividade) values (".$cod_atividade.",'".$desc_atividade."')";
	
			$result_atividade = pg_query($query_atividade)or die("Erro na query: $query_atividade".pg_last_error($connect));
			
			echo '<script> alert("ATIVIDADE Cadastrada com Sucesso!");</script>';
			
		}
	}
?>
<form name="frm_ATIVIDADE" action="cad_atividade.php" method="post">
	<table align="center" width="400" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
		<tr>
			<th colspan="2" bgcolor="#009966"><br><h3>Cadastro de Atividade:</h3><br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<?
			$query_max = "SELECT max(cod_atividade) as cod_atividade FROM atividade";
			
			$result_max = pg_query($query_max) //executa a query
				or die ("Erro na busca da tabela ATIVIDADE. ==> " . pg_last_error($connect)); //mostra o erro.
				
			$row_max = pg_fetch_array($result_max); //recebe o resultado da query. (linhas)
		?>
		<tr>
			<td width="180" align="right"><strong>Código:&nbsp;</strong></td>
			<td width="220">&nbsp;<input type="text" name="cod_atividade" size="5" value="<?=($row_max[cod_atividade] + 1)?>" readonly="true"> </td>
		</tr>
		<tr>
			<td width="180" align="right"><strong>Descrição:&nbsp;</strong></td>
			<td>&nbsp;<input type="text" name="dsc_atividade" size="30" style="background:#FFFFCC"></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2" bgcolor="#009966">
				<br>
			<input type="submit" value="Enviar" name="btn_enviar" style="width:100;">
			&nbsp;&nbsp;&nbsp;
			<input type="reset" value="Limpar" style="width:100;"> 
			&nbsp;&nbsp;&nbsp;
			<input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','lista_atividade.php'); return document.MM_returnValue" value="&lt;&lt; Voltar" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		
	</table>
</form>
<?
}
else { // se id estiver com valor

	$query_atividade="select cod_atividade, dsc_atividade from atividade where cod_atividade = ".$id ;
	
	$result_atividade = pg_query($connect, $query_atividade) 
		or die ("Erro na query: $query_atividade ==> " . pg_last_error($connect) );

    $row = pg_fetch_array($result_atividade);

?>
<form name="frm_ATIVIDADE" action="cad_atividade.php?update=sim&id=<?=$id?>" method="post">
	<table align="center" width="400" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
		<tr>
			<th colspan="2" bgcolor="#009966"><br><h3>Cadastro de Atividade:</h3><br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td width="180" align="right"><strong>Código:</strong></td>
			<td width="220">&nbsp;<input type="text" name="cod_atividade" size="5" value="<?=$row[cod_atividade]?>" readonly="true"></td>
		</tr>
		<tr>
			<td align="right"><strong>Descrição:</strong></td>
			<td>&nbsp;<input type="text" name="dsc_atividade" size="30" value="<?=$row[dsc_atividade]?>" style="background:#FFFFCC"></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
			<th colspan="2" bgcolor="009966">
			<br>
			<input type="submit" value="Alterar" name="btn_enviar" style="width:100;">
			&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Excluir" name="btn_excluir" style="width:100;"> 
			&nbsp;&nbsp;&nbsp;
			<input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','lista_atividade.php'); return document.MM_returnValue" value="&lt;&lt; Voltar" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		
	</table>
</form>
<p>
<?
}
pg_close($connect);
?>
</p>
<p>&nbsp;</p>
</body>
</html>