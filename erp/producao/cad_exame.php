<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if ( $_POST[btn_enviar] == "Gravar" ){

	$cod_exame  = $_POST["cod_exame"]; 
	$dsc_exame = $_POST["dsc_exame"];
	$especialidade = $_POST["especialidade"];

	$query_busca="SELECT cod_exame FROM exame WHERE cod_exame = ".$cod_exame; //query que verifica se código já esta cadastrado

	$result_busca = pg_query($query_busca) //executa query
		or die ("Erro na busca da tabela FUNÇÃO. ==> " . pg_last_error($connect)); //mostra erro

	$row_busca = pg_fetch_array($result_busca); // recebe o resultado da query (linhas)
	
	if ($teste_busca = pg_num_rows($result_busca) < 1) { // se não teve mais de uma linha

		$query_exame = "insert into exame (cod_exame, dsc_exame, especialidade) 
		values ($cod_exame,'$dsc_exame', '$especialidade')";

		$result_exame = pg_query($query_exame)
			or die("Erro na query: $query_exame".pg_last_error($connect));

		echo '<script> alert("Exame Cadastrado com Sucesso!");</script>';

		header("location: alt_exame.php?exame=$cod_exame");
	}

}
?>

<html>
<head>
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_exame" action="cad_exame.php" method="post">
	<table align="center" width="800" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<th colspan="2" bgcolor="#009966"> <br>
			<h3>EXAME:</h3>
			<br></th>
		</tr>
		<tr>
			<td colspan="2" >&nbsp;</td>
		</tr>
		<?php
			$query_max = "SELECT max(cod_exame) as cod_exame FROM exame";
		
			$result_max = pg_query($query_max) //executa query
				or die ("Erro na busca da tabela EXAME. ==> " . pg_last_error($connect)); //mostra erro
		
			$row_max = pg_fetch_array($result_max); // recebe o resultado da query (linhas)
		?>
		<tr>
			<td align="right" ><strong>Código:&nbsp;&nbsp;&nbsp;</strong></td>
			<td >&nbsp;&nbsp;<input type="text" name="cod_exame" size="5" value="<?php echo ($row_max[cod_exame] + 1)?>" readonly="true"></td>
		</tr>
		<tr>
			<td align="right" ><strong>Nome:&nbsp;&nbsp;&nbsp;</strong></td>
			<td >&nbsp;&nbsp;<input type="text" name="especialidade" size="30" style="background:#FFFFCC"></td>
		</tr>
		<tr>
			<td align="right"><strong>Descrição:&nbsp;&nbsp;&nbsp;</strong></td>
			<td>&nbsp;&nbsp;<textarea name="dsc_exame" rows="5" cols="50" style="background:#FFFFCC"></textarea></td>
		</tr>
		<tr>
			<td colspan="2" >&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2" bgcolor="#009966">
			<br>
				<input type="submit" value="Gravar" name="btn_enviar" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="reset"  value="Limpar" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_exame.php');return document.MM_returnValue;" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
		<tr>
			<td colspan="2" >&nbsp;</td>
		</tr>
  </table>
</form>
</body>
</html>