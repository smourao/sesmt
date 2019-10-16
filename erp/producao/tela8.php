<?php
include "../config/config.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tela 8</title>
<script language="javascript" src="../scripts.js"></script>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">

td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style1 {font-size: 14px}
.style2 {font-size: 12px}
.style3 {font-family: Arial, Helvetica, sans-serif}
.style4 {font-size: 12}
</style>
</head>
<body bgcolor="#006633">&nbsp;
<form action="tela8.php" name="frm_tela" method="post">
<div align="center" class="fontebranca22bold">
<table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
	<td bgcolor="#009966"><center>
	  <h2 class="style3">Avaliação Ambiental </h2>
	</center></td>
	</tr>
</table></div>
<div align="center">
<table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="fontebranca10 style2" align="left">Tipo de Avaliação</td>
		<td class="fontepreta10" align="left"><input type="text" name="tipo_avaliacao" size="20" /></td>
	</tr>
	<tr>
		<td class="fontebranca10 style2" align="left">Metodológia da Avaliação/Objetivo</td>
		<td class="fontepreta10" align="left"><TEXTAREA COLS=70 ROWS=5 NAME="metodologia_avaliacao"> </TEXTAREA> </td>
	</tr>
	<tr>
		<td class="fontebranca10 style2" align="left">Órgão Certificador</td>
		<td class="fontepreta10" align="left"><input type="text" name="orgao_certificador" size="50" /></td>
	</tr>
</table>
<div align="center">
<table width="90%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<th>
		<input type="submit" name="novo" value="Novo" /> &nbsp;&nbsp;
		<input type="submit" name="excluir" value="Excluir" />&nbsp;&nbsp;
		<input type="submit" name="enviar" value="Enviar" />&nbsp;&nbsp;
		<input type="submit" name="voltar" value="Voltar" />
	</th>
</table></div>
</form>
</body>
</html>
