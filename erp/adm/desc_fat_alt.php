<?php

include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$id = $_GET["id"];
}
else{
	$id = $_POST["id"];
}

if ( $_POST[btn_excluir] == "Excluir" ){ // se excluir for ativado.
	$query_excluir = "delete from desc_fatura where id = $id" ;

	$result = pg_query($query_excluir) // executa a atualização
		or die ("Erro na exclusão da tabela. ==> " . pg_last_error($connect));

	echo '<script> alert("Descrição Excluida com Sucesso!");</script>';

	header("location: lista_desc.php?excluido=".$_POST[descricao]);
}
else if ( $_POST[btn_enviar] == "Gravar" )
{
	$sql_update = "update desc_fatura set
					descricao = '".addslashes($descricao)."'
				   where id = $id";

	$result_update = pg_query($connect, $sql_update)
		or die ("Erro na query: $sql_update==> " . pg_last_error($connect) );

	if ($result_update){ echo "<script>alert('Descrição atualizada com sucesso!');</script>";}
}

	$query_epi = "select id, descricao from desc_fatura where id = $id";

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
<form name="frm_epi" action="desc_fat_alt.php" method="post">
	<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<th colspan="2" bgcolor="#009966"><br><h3>Alterar Descrição das Faturas</h3><br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right"><strong>Código:&nbsp;&nbsp;&nbsp;</strong></td>
			<td >&nbsp;&nbsp;<input type="text" name="id" size="5" value="<?php echo $row[id]?>" readonly="true"></td>
		</tr>
		<tr>
			<td align="right"><strong>Descrição:&nbsp;&nbsp;&nbsp;</strong></td>
			<td>&nbsp;&nbsp;<textarea name="descricao" rows="5" cols="40" style="background:#FFFFCC"><?php echo $row[descricao]?></textarea></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2" bgcolor="#009966">
			<br>
				<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_desc.php');return document.MM_returnValue;" style="width:100;">
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