<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$medicamento = $_GET["medicamento"];
}
else{
	$medicamento = $_POST["cod_medi"];
}

if ( $_POST[btn_excluir] == "Excluir" ){ // se excluir for ativado.

	$query_excluir = "delete from medicamento where cod_medi = $medicamento" ;

	$result = pg_query($query_excluir) // executa a atualização
		or die ("Erro na exclusão da tabela \"medicamento\". ==> " . pg_last_error($connect));
		
	echo '<script> alert("medicamento Excluido com Sucesso!");</script>';

	header("location: lista_medicamento.php?excluido=".$_POST[dsc_medi]);

}
else if ( $_POST[btn_enviar] == "Gravar" )
{
	$sql_update = "update medicamento set 
					dsc_medi = '$dsc_medi' 
				   where cod_medi = $medicamento";

	$result_update = pg_query($connect, $sql_update) 
		or die ("Erro na query: $sql_update==> " . pg_last_error($connect) );

	if ($result_update){ echo "<script>alert('Medicamento atualizado com sucesso!');</script>";}
}

	$query_medicamento = "select cod_medi, dsc_medi from medicamento where cod_medi = $medicamento";
	
	$result_medicamento= pg_query($connect, $query_medicamento) 
		or die ("Erro na query: $query_medicamento==> " . pg_last_error($connect) );

    $row = pg_fetch_array($result_medicamento);

?>
<html>
<head>
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_medicamento" action="alt_medicamento.php" method="post">
	<table align="center" width="800" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<th colspan="2" bgcolor="#009966"><br><h3>MEDICAMENTO</h3>
			<br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right"><strong>Código:&nbsp;&nbsp;&nbsp;</strong></td>
			<td >&nbsp;&nbsp;<input type="text" name="cod_medi" size="5" value="<?php echo $row[cod_medi]?>" readonly="true"></td>
		</tr>
		<tr>
			<td align="right"><strong>Descrição:&nbsp;&nbsp;&nbsp;</strong></td>
			<td>&nbsp;&nbsp;<textarea name="dsc_medi" rows="5" cols="50" style="background:#FFFFCC"><?php echo $row[dsc_medi]?></textarea></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2" bgcolor="#009966">
			<br>
				<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_medicamento.php');return document.MM_returnValue;" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="submit" value="Gravar" name="btn_enviar" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="submit" value="Excluir" name="btn_excluir" style="width:100;">
				<!-- &nbsp;&nbsp;&nbsp;
				<input name="btn_medicamento_medicamento" type="button" id="btn_novo" onClick="MM_goToURL('parent',''); return document.MM_returnValue" value="Avançar >>" style="width:100;"> -->
				<br>
				&nbsp;
			</th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  </table>
</form>
</body>
</html>