<?php

include "../config/connect.php";
include "../sessao.php";

$query = "SELECT * FROM desc_fatura order by descricao";
$result = pg_query($connect, $query);

?>
<html>
<head>
<title>Cadastro de Cliente</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form action="lista_desc.php" method="post" enctype="multipart/form-data" name="form1">
<table width="500" align="center" cellpadding="0" cellspacing="0" border="0">
<p><tr>
	<td align="center"><input type="button" name="btn_incluir" onClick="MM_goToURL('parent', 'desc_fat.php');return document.MM_returnValue" value="Incluir">&nbsp;&nbsp;
	<input type="button" name="btn_voltar" onClick="MM_goToURL('parent', 'index.php#financeiro');return document.MM_returnValue" value="<< Voltar"></td>
</tr>
</table><br>
<table width="500" align="center" cellpadding="0" cellspacing="0" border="1">
  <tr>
   	<td colspan="2" class="linhatopodiresq"><div align="center" class="fontebranca22bold">Registros no Sistema</div></td>
  </tr>
  <tr>
    <td width="20" align="center" class="fontebranca12">ID </td>
    <td width="380" class="fontebranca12">&nbsp;Descri��o </td>
  </tr>
<?php
  
	  while($row=pg_fetch_array($result))
	  {
?>
  <tr>
    <td class="linhatopodiresq"><div align="center" class="linksistema"><a href="desc_fat_alt.php?id=<?php echo $row[id]?>&descricao=<?php echo $row[descricao]?>"><?php echo $row[id]?></a>&nbsp;</div></td>
    <td class="linhatopodir"><div align="left" class="linksistema"><a href="desc_fat_alt.php?id=<?php echo $row[id]?>&descricao=<?php echo $row[descricao]?>">&nbsp;<?php echo $row[descricao]?></a>&nbsp;</div></td>
  </tr>
<?php
}
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
</form>
</body>
</html>