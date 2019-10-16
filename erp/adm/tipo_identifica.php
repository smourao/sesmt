<?php
include "../sessao.php";
include "../config/connect.php";

ob_start();
if($_POST['descricao']!=""){
$query_incluir="INSERT into financeiro_identificacao (sigla, descricao) values ('".addslashes($_POST['sigla'])."', '".addslashes($_POST['descricao'])."')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));
echo"<script>alert('Descrição Incluída com Sucesso!');</script>";
//header("location: tipo_contato_adm.php");
}

?>
<html>
<head>
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="form1" method="post" action="tipo_identifica.php">
  <table width="700" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
      <th colspan="2" bgcolor="#009966"><br><h3>Cadastro do Tipo de Identificação</h3><br></th>
    </tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
    <tr>
	  <td align="right"><strong>Sigla:&nbsp;&nbsp;&nbsp;</strong></td>
	  <td>&nbsp;&nbsp;<input name="sigla" type="text" size="10" style="background:#FFFFCC"></td>
	</tr>
	<tr>
	  <td align="right"><strong>Descrição:&nbsp;&nbsp;&nbsp;</strong></td>
	  <td>&nbsp;&nbsp;<textarea name="descricao" cols="40" rows="5" style="background:#FFFFCC"></textarea></td>
	</tr>
	<tr>
	  <td colspan="2">&nbsp;</td>
	</tr>
	<tr>
	  <th colspan="2" bgcolor="#009966">
	  <br>
	    <input type="submit" name="Submit" value="Incluir"> &nbsp;&nbsp;&nbsp;
	    <input type="button" name="btn_voltar" onClick="MM_goToURL('parent', 'lista_identifica.php');return document.MM_returnValue" value="<< Voltar">
	  <br>&nbsp;
	  </th>
	</tr>
    <tr>
	  <td colspan="2">&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>