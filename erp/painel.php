<?php
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";

$login_grupo = split ("-", auth($_GET[sessao_id]));
if ($login_grupo[0]=="administrador" || $login_grupo[0]=="funcionario"){
}else{
header("location: http://$dominio/index.php?erro=2");
}
  	

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema Sesmt</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<table width="290" height="212" border="2" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="284" align="center" class="fontepreta14bold">Cadastro de Clientes</td>
  </tr>
  <tr>
    <td class="fontepreta14">- Cadastro de Clientes </td>
  </tr>
  <tr>
    <td class="fontepreta14">- Cadastro de C&oacute;digo de Produto </td>
  </tr>
  <tr>
    <td class="fontepreta14">- Cadastro de Colaboradores </td>
  </tr>
  <tr>
    <td class="fontepreta14">- Cadastro de N&uacute;mero de Telefones </td>
  </tr>
  <tr>
    <td class="fontepreta14">- Cadastro de Fornecedor </td>
  </tr>
  <tr>
    <td class="fontepreta14">- Cadastro de Laudo </td>
  </tr>
</table>
</body>
</html>
