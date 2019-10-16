<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if(!empty($_POST[cnae]) and $_POST[btn_enviar]=="Buscar" ){

	$sql = "select cnae, cnae_id, descricao, grupo_cipa, grau_risco from cnae where cnae = '$_POST[cnae]'";
	$result = pg_query($connect, $sql)
		or die ("Erro na query: $sql ==> " . pg_last_error($connect) );
	$row = pg_fetch_array($result);

}

?>
<html>
<body>
<form action="cnae.php" method="post">

<table align="center" width="500">
	<tr>
		<td>CNAE:</td>
		<td><input type="text" name="cnae" value="<?php echo $row[cnae];?>" ></td>
	</tr>
	<tr>
		<td>Descrição:</td>
		<td><input type="text" name="descricao" readonly value="<?php echo $row[descricao];?>" size="50" style="background-color:#FFFF99;"></td>
	</tr>
	<tr>
		<td>Grau de Risco:</td>
		<td><input type="text" name="grau_risco" readonly value="<?php echo $row[grau_risco];?>" style="background-color:#FFFF99;"></td>
	</tr>
	<tr>
		<td>Grupo CIPA:</td>
		<td><input type="text" name="grupo_cipa" readonly value="<?php echo $row[grupo_cipa];?>" style="background-color:#FFFF99;"></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Buscar" name="btn_enviar"></td>
	</tr>
</table>

</form>
</body>
</html>