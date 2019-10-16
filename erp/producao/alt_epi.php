<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$epi = $_GET["epi"];
}
else{
	$epi = $_POST["cod_epi"];
}

if ( $_POST[btn_excluir] == "Excluir" ){ // se excluir for ativado.

	$query_excluir = "delete from epi where cod_epi = $epi" ;

	$result = pg_query($query_excluir) // executa a atualização
		or die ("Erro na exclusão da tabela \"EPI\". ==> " . pg_last_error($connect));
		
	echo '<script> alert("EPI Excluido com Sucesso!");</script>';

	header("location: lista_epi.php?excluido=".$_POST[dsc_epi]);

}
else if ( $_POST[btn_enviar] == "Gravar" )
{
	$sql_update = "update epi set 
					dsc_epi = '$dsc_epi' 
				   where cod_epi = $epi";

	$result_update = pg_query($connect, $sql_update) 
		or die ("Erro na query: $sql_update==> " . pg_last_error($connect) );

	if ($result_update){ echo "<script>alert('EPI atualizado com sucesso!');</script>";}
}

	$query_epi = "select cod_epi, dsc_epi from epi where cod_epi = $epi";
	
	$result_epi= pg_query($connect, $query_epi) 
		or die ("Erro na query: $query_epi==> " . pg_last_error($connect) );

    $row = pg_fetch_array($result_epi);

?>
<html>
<head>
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_epi" action="alt_epi.php" method="post">
	<table align="center" width="800" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<th colspan="2" bgcolor="#009966"><br><h3>EPI - Equipamento de Proteção Individual</h3><br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right"><strong>Código:&nbsp;&nbsp;&nbsp;</strong></td>
			<td >&nbsp;&nbsp;<input type="text" name="cod_epi" size="5" value="<?php echo $row[cod_epi]?>" readonly="true"></td>
		</tr>
		<tr>
			<td align="right"><strong>Descrição:&nbsp;&nbsp;&nbsp;</strong></td>
			<td>&nbsp;&nbsp;<textarea name="dsc_epi" rows="5" cols="50" style="background:#FFFFCC"><?php echo $row[dsc_epi]?></textarea></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2" bgcolor="#009966">
			<br>
				<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_epi.php');return document.MM_returnValue;" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="submit" value="Gravar" name="btn_enviar" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="submit" value="Excluir" name="btn_excluir" style="width:100;">
				<!-- &nbsp;&nbsp;&nbsp;
				<input name="btn_epi_epi" type="button" id="btn_novo" onClick="MM_goToURL('parent',''); return document.MM_returnValue" value="Avançar >>" style="width:100;"> -->
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