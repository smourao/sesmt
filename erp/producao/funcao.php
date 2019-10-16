<?php

include "sessao.php";
include "../config/connect.php";

if ($_GET)
{
	$funcao = $_GET[funcao];
}
else
{
	$funcao = $_POST[funcao];
}

?>
<html>
<head>
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">

&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>

<table align="center" width="800" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td colspan="2" align="center" bgcolor="#009966"><br><h2>Dados Associados a Função:</h2></td>
	</tr>
<?php
$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao	FROM funcao where cod_funcao = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);
?>
	<tr>
		<th colspan="2" bgcolor="#FFFFFF"><h3><font color="#000000"> FUNÇÃO </font> </h3></th>
	</tr>
	<tr>
		<td width="200"> &nbsp;&nbsp; <strong>Função</strong>: &nbsp; <?php echo $row_funcao[nome_funcao]; ?> <br /> &nbsp;</td>
		<td> &nbsp;&nbsp; <strong>Dinâmica da Função:</strong> &nbsp; <?php echo $row_funcao[dsc_funcao]; ?> <br /> &nbsp; </td>
	</tr>
<?php
///////////////// dados de EPI
$sql_epi_cadatrado = "select cod_epi, dsc_epi from epi where cod_epi in (select cod_epi from epi_funcao) order by dsc_epi";

$result_epi_cadatrado = pg_query($connect, $sql_epi_cadatrado) 
	or die ("Erro na query: $sql_epi_cadatrado ==> ".pg_last_error($connect));

if ( pg_num_rows($result_epi_cadatrado) > 0 ){
		echo"	<tr>";
		echo"		<th colspan=2 bgcolor=#FFFFFF><h3><font color=#000000> EPIs associados: </font> </h3></th>";
		echo"	</tr>";
		echo"	<tr>";
		echo"		<th> Código: </th>";
		echo"		<th> Descrição: </th>";
		echo"	</tr>";
	while ( $row_epi_cadatrado = pg_fetch_array($result_epi_cadatrado) ){
		echo"	<tr>";
		echo"		<th> $row_epi_cadatrado[cod_epi] </th>";
		echo"		<td> &nbsp;&nbsp;&nbsp; $row_epi_cadatrado[dsc_epi] </td>";
		echo"	</tr>";
	}
}

///////////////// dados de Medicamento
$sql_medi_cadatrado = "select cod_medi, dsc_medi from medicamento where cod_medi in (select cod_medi from funcao_medicamento) order by dsc_medi";

$result_medi_cadatrado = pg_query($connect, $sql_medi_cadatrado) 
	or die ("Erro na query: $sql_medi_cadatrado ==> ".pg_last_error($connect));

if ( pg_num_rows($result_medi_cadatrado) > 0 ){
		echo"	<tr>";
		echo"		<th colspan=2 bgcolor=#FFFFFF><h3><font color=#000000> Medicamentos associados: </font> </h3></th>";
		echo"	</tr>";
		echo"	<tr>";
		echo"		<th> Código: </th>";
		echo"		<th> Descrição: </th>";
		echo"	</tr>";
	while ( $row_medi_cadatrado = pg_fetch_array($result_medi_cadatrado) ){
		echo"	<tr>";
		echo"		<th> $row_medi_cadatrado[cod_medi] </th>";
		echo"		<td> &nbsp;&nbsp;&nbsp; $row_medi_cadatrado[dsc_medi] </td>";
		echo"	</tr>";
	}
}

///////////////// dados de Exame
$sql_exame_cadatrado = "select cod_exame, dsc_exame from exame where cod_exame in (select cod_exame from funcao_exame) order by dsc_exame";

$result_exame_cadatrado = pg_query($connect, $sql_exame_cadatrado) 
	or die ("Erro na query: $sql_exame_cadatrado ==> ".pg_last_error($connect));

if ( pg_num_rows($result_exame_cadatrado) > 0 ){
		echo"	<tr>";
		echo"		<th colspan=2 bgcolor=#FFFFFF><h3><font color=#000000> Exames associados: </font> </h3></th>";
		echo"	</tr>";
		echo"	<tr>";
		echo"		<th> Código: </th>";
		echo"		<th> Descrição: </th>";
		echo"	</tr>";
	while ( $row_exame_cadatrado = pg_fetch_array($result_exame_cadatrado) ){
		echo"	<tr>";
		echo"		<th> $row_exame_cadatrado[cod_exame] </th>";
		echo"		<td> &nbsp;&nbsp;&nbsp; $row_exame_cadatrado[dsc_exame] </td>";
		echo"	</tr>";
	}
}

///////////////// dados de Cursos
$sql_prod_cadatrado = "select cod_prod, desc_detalhada_prod from produto where cod_prod in (select cod_prod from curso_funcao) order by desc_detalhada_prod";

$result_prod_cadatrado = pg_query($connect, $sql_prod_cadatrado) 
	or die ("Erro na query: $sql_prod_cadatrado ==> ".pg_last_error($connect));

if ( pg_num_rows($result_prod_cadatrado) > 0 ){
		echo"	<tr>";
		echo"		<th colspan=2 bgcolor=#FFFFFF><h3><font color=#000000> Cursos Indicados: </font> </h3></th>";
		echo"	</tr>";
		echo"	<tr>";
		echo"		<th> Código: </th>";
		echo"		<th> Descrição: </th>";
		echo"	</tr>";
	while ( $row_prod_cadatrado = pg_fetch_array($result_prod_cadatrado) ){
		echo"	<tr>";
		echo"		<th> $row_prod_cadatrado[cod_prod] </th>";
		echo"		<td> &nbsp;&nbsp;&nbsp; $row_prod_cadatrado[desc_detalhada_prod] </td>";
		echo"	</tr>";
	}
}

?>
<tr>
	<td align="center" colspan="2" bgcolor="#009966" ><br>
		<input type="button" name="voltar" value="&lt;&lt; &nbsp; Voltar" onClick="MM_goToURL('parent','lista_funcao_curso.php?funcao=<?php echo $funcao; ?>');return document.MM_returnValue;" style="width:100;">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="btn_medi_funcao" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_funcao.php'); return document.MM_returnValue" value=" Concluir" style="width:100;">
		<br>&nbsp;
	</td>
</tr>

</table>
</body>
</html>