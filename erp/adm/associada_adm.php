<?php
include "../sessao.php";
include "../config/connect.php";

$query="select associada_id, random, nome, telefone from associada";

$result=pg_query($query) or die("Erro na query: $query".pg_last_error($connect));

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista de Associada</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<form action="associada_adm.php" method="post" name="riscos" id="riscos">
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>      <div align="center"></div>      <div align="center"></div>      <div align="center"></div></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Franquias SESMT</font></div></td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12"><br>
      <table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12"><input name="btn_incluir" type="submit" id="btn_incluir" value="Incluir" onClick="MM_goToURL('parent','associada_incluir.php');return document.MM_returnValue"></td>
        <td class="fontebranca12"><input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','index.php');return document.MM_returnValue" value="&lt;&lt; Voltar"></td>
      </tr>
      
    </table>
      <br></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td width="50" class="linhatopodiresq"><div align="center" class="fontepreta12">ID</div></td>
    <td width="70" class="linhatopodir"><div align="center" class="fontepreta12">Código</div></td>
	<td width="280" class="linhatopodir"><div align="center" class="fontepreta12">Nome</div></td>
    <td width="100" class="linhatopodir"><div align="center" class="fontepreta12">Telefone</div></td>
  </tr>
  <?php
  while($row=pg_fetch_array($result)){
  ?>
  <tr>
    <td class="linhatopodiresq"><div align="center" class="linksistema"><a href="../adm/associada_alterar.php?associada_id=<?php echo $row[associada_id]?>"><?php echo $row[associada_id]?></a></div></td>
	<td class="linhatopodir"><div align="center" class="linksistema"><a href="../adm/associada_alterar.php?associada_id=<?php echo $row[associada_id]?>"><?php echo $row[random]?></a></div></td>
    <td class="linhatopodir"><div align="center" class="linksistema"><a href="../adm/associada_alterar.php?associada_id=<?php echo $row[associada_id]?>"><?php echo $row[nome]?></a></div></td>
    <td class="linhatopodir"><div align="center" class="linksistema"><a href="../adm/associada_alterar.php?associada_id=<?php echo $row[associada_id]?>"><?php echo $row[telefone]?></a></div></td>
  </tr>
  <?php
  }
  ?>
  <tr bgcolor="#CCCCCC">
    <td class="linhatopodiresqbase">&nbsp;</td>
    <td class="linhatopodirbase">&nbsp;</td>
    <td class="linhatopodirbase">&nbsp;</td>
	<td class="linhatopodirbase">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
