<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$exame = $_GET["exame"];
}
else{
	$exame = $_POST["cod_exame"];
}

if ( $_POST[btn_excluir] == "Excluir" ){ // se excluir for ativado.

	$query_excluir = "delete from exame where cod_exame = $exame" ;

	$result = pg_query($query_excluir) // executa a atualização
		or die ("Erro na exclusão da tabela \"EXAME\". ==> " . pg_last_error($connect));
		
	echo "<script> alert('Exame excluido com sucesso!');</script>";

	header("location: lista_exame.php?excluido=$_POST[especialidade]");

}
else if ( $_POST[btn_enviar] == "Gravar" )
{
	$sql_update = "update exame set 
					especialidade = '$especialidade' 
					, dsc_exame = '$dsc_exame' 
				   where cod_exame = $exame ";

	$result_update = pg_query($connect, $sql_update) 
		or die ("Erro na query: $sql_update==> " . pg_last_error($connect) );
	if ($result_update){ echo "<script>alert('Exame atualizado com sucesso!');</script>"; }
}

	$query_exame = "select cod_exame, especialidade, dsc_exame 
					 from exame where cod_exame = $exame";
	
	$result_exame= pg_query($connect, $query_exame) 
		or die ("Erro na query: $query_exame==> " . pg_last_error($connect) );

    $row = pg_fetch_array($result_exame);

?>
<html>
<head>
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_exame" action="alt_exame.php" method="post">
	<table align="center" width="800" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<th colspan="2" bgcolor="#009966"><br>
			<h3>EXAME:</h3>
			<br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right"><strong>Código:&nbsp;&nbsp;&nbsp;</strong></td>
			<td >&nbsp;&nbsp;<input type="text" name="cod_exame" size="5" value="<?php echo $row[cod_exame];?>" readonly="true"></td>
		</tr>
		<tr>
			<td align="right"><strong>Nome:&nbsp;&nbsp;&nbsp;</strong></td>
			<td>&nbsp;&nbsp;<input type="text" name="especialidade" size="30" value="<?php echo $row[especialidade];?>" style="background:#FFFFCC"></td>
		</tr>
		<tr>
			<td align="right"><strong>Descrição:&nbsp;&nbsp;&nbsp;</strong></td>
			<td>&nbsp;&nbsp;<textarea name="dsc_exame" rows="5" cols="50" style="background:#FFFFCC"><?php echo $row[dsc_exame];?></textarea></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2" bgcolor="#009966">
			<br>
				<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_exame.php');return document.MM_returnValue;" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="submit" value="Gravar" name="btn_enviar" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="submit" value="Excluir" name="btn_excluir" style="width:100;">
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