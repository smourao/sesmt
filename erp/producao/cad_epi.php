<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que cont�m a conex�o com o Banco.

if ( $_POST[btn_enviar] == "Gravar" ){

	$cod_epi  = $_POST["cod_epi"]; 
	$dsc_epi = $_POST["dsc_epi"];


	$query_busca="SELECT cod_epi FROM epi WHERE cod_epi = $cod_epi"; //query que verifica se c�digo j� esta cadastrado

	$result_busca = pg_query($query_busca) //executa query
		or die ("Erro na busca da tabela EPI. ==> " . pg_last_error($connect)); //mostra erro

	$row_busca = pg_fetch_array($result_busca); // recebe o resultado da query (linhas)
	
	if ($teste_busca = pg_num_rows($result_busca) < 1) { // se n�o teve mais de uma linha

		$query_epi = "insert into epi (cod_epi, dsc_epi) values ($cod_epi,'$dsc_epi')";

		$result_epi = pg_query($query_epi)
			or die("Erro na query: $query_epi".pg_last_error($connect));

		echo '<script> alert("EPI Cadastrado com Sucesso!");</script>';

		header("location: alt_epi.php?epi=$cod_epi");
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
<form name="frm_epi" action="cad_epi.php" method="post">
	<table align="center" width="800" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<th colspan="2" bgcolor="#009966"> <br><h3>EPI - Equipamento de Prote&ccedil;&atilde;o Individual</h3>
			<br></th>
		</tr>
		<tr>
			<td colspan="2" >&nbsp;</td>
		</tr>
		<?php
			$query_max = "SELECT max(cod_epi) as cod_epi FROM epi";
		
			$result_max = pg_query($query_max) //executa query
				or die ("Erro na busca da tabela EPI. ==> " . pg_last_error($connect)); //mostra erro
		
			$row_max = pg_fetch_array($result_max); // recebe o resultado da query (linhas)
		?>
		<tr>
			<td align="right" ><strong>C�digo:&nbsp;&nbsp;&nbsp;</strong></td>
			<td >&nbsp;&nbsp;<input type="text" name="cod_epi" size="5" value="<?php echo ($row_max[cod_epi] + 1)?>" readonly="true"></td>
		</tr>
		<tr>
			<td align="right"><strong>Descri��o:&nbsp;&nbsp;&nbsp;</strong></td>
			<td>&nbsp;&nbsp;<textarea name="dsc_epi" rows="5" cols="50" style="background:#FFFFCC"></textarea></td>
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
				<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_epi.php');return document.MM_returnValue;" style="width:100;">
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