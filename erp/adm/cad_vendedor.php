<?php
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
?>
<html>
<head>
<title>Cadastro de Vendedor</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="scripts.js">
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

	$cod_vendedor  = $_POST["cod_vendedor"]; 
	$nome_vendedor = $_POST["nome_vendedor"];
	
	$query_excluir = "delete from vendedor where cod_vendedor = ".$cod_vendedor;

	$result = pg_query($query_excluir) // executa a atualização
		or die ("Erro na exclusão da tabela ''Vendedor''. ==> " . pg_last_error($connect));
		
	echo '<script> alert("Vendedor Excluido com Sucesso!");</script>';
	
//	$excluir = ""; $id = ""; $update = "";

}
else if (!empty($update)){ // se update for ativado.

	$cod_vendedor  = $_POST["cod_vendedor"]; 
	$nome_vendedor = $_POST["nome_vendedor"];
	
	$query_update = "update vendedor set cod_vendedor = ".$cod_vendedor.", nome_vendedor = '".$nome_vendedor."' 
		where cod_vendedor = ".$id;
	
	$result = pg_query($query_update) // executa a atualização
		or die ("Erro na atualização na tabela ''Vendedor''. ==> " . pg_last_error($connect));
		
	echo '<script> alert("Vendedor Atualizado com Sucesso!");</script>';
	
	$id = ""; $update = "";
}

if ( $id=="" && $update!="sim"){ // se id for vazio

	$cod_vendedor  = $_POST["cod_vendeodr"]; 
	$nome_vendedor = $_POST["nome_vendedor"];
	
	if ( (!empty($cod_vendedor)) AND (!empty($nome_vendedor)) ) // !empty = não vazio
	{
	
		$query_busca="SELECT cod_vendedor FROM vendedor WHERE cod_vendedor=".$cod_vendedor; //query que verifica se código já esta cadastrado
	
		$result_busca = pg_query($query_busca) //executa query
			or die ("Erro na busca da tabela vendedor. ==> " . pg_last_error($connect)); //mostra erro
	
		$row_busca = pg_fetch_array($result_busca); // recebe o resultado da query (linhas)
		
		if ($teste_busca = pg_num_rows($result_busca) < 1) { // se não teve mais de uma linha
		
			$query_vendedor = "insert into vendedor (cod_vendedor, nome_vendedor) values (".$cod_vendedor.",'".$nome_vendedor."')";
	
			$result_vendedor = pg_query($query_vendedor)or die("Erro na query: $query_vendedor".pg_last_error($connect));
			
			echo '<script> alert("Vendedor Cadastrado com Sucesso!");</script>';
			
		}
	}
?>
<form name="frm_vendedor" action="cad_vendedor.php" method="post">
	<table align="center" width="400" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
		<tr>
			<th colspan="2" bgcolor="#009966"><br>
			<h3>Cadastro de Vendedor</h3>
			<br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<?
			$query_max = "SELECT max(cod_vendedor) as cod_vendedor FROM vendedor";
			
			$result_max = pg_query($query_max) //executa a query
				or die ("Erro na busca da tabela Vendedor. ==> " . pg_last_error($connect)); //mostra o erro.
				
			$row_max = pg_fetch_array($result_max); //recebe o resultado da query. (linhas)
		?>
		<tr>
			<td width="180" align="right"><strong>Código:&nbsp;</strong></td>
			<td width="220">&nbsp;<input type="text" name="cod_vendedor" size="5" value="<?=($row_max[cod_vendedor] + 1)?>" readonly="true"> </td>
		</tr>
		<tr>
			<td width="180" align="right"><strong>Nome:&nbsp;</strong></td>
			<td>&nbsp;<input type="text" name="nome_vendedor" size="30" style="background:#FFFFCC"></td>
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
			<input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','../lista_vendedor.php'); return document.MM_returnValue" value="&lt;&lt; Voltar" style="width:100;">
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

	$query_vendedor="select cod_vendedor, nome_vendedor from vendedor where cod_vendedor = ".$id ;
	
	$result_vendedor = pg_query($connect, $query_vendedor) 
		or die ("Erro na query: $query_vendedor ==> " . pg_last_error($connect) );

    $row = pg_fetch_array($result_vendedor);

?>
<form name="frm_vendedor" action="cad_vendedor.php?update=sim&id=<?=$id?>" method="post">
	<table align="center" width="400" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
		<tr>
			<th colspan="2" bgcolor="#009966"><br><h3>Cadastro de Vendedor</h3><br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td width="180" align="right"><strong>Código:</strong></td>
			<td width="220">&nbsp;<input type="text" name="cod_vendedor" size="5" value="<?=$row[cod_vendedor]?>" readonly="true"></td>
		</tr>
		<tr>
			<td align="right"><strong>Nome:</strong></td>
			<td>&nbsp;<input type="text" name="nome_vendedor" size="30" value="<?=$row[nome_vendedor]?>" style="background:#FFFFCC"></td>
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
			<input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','lista_vendedor.php'); return document.MM_returnValue" value="&lt;&lt; Voltar" style="width:100;">
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