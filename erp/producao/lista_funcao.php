<?php

include "sessao.php";
include "../config/connect.php";

if( !empty($_GET[excluido]) ){
	echo "<script>alert('A função $_GET[excluido] foi excluída.');</script>";
}

if($funcao=="")
{
	$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao 
					from funcao where cod_funcao <> 0";
}else
{
	$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao
					 from funcao
					 where lower(dsc_funcao) like '%". strtolower(addslashes($funcao)) ."%'
					 or lower(nome_funcao) like '%". strtolower(addslashes($funcao)) ."%' and cod_funcao <> 0";
}
$query_funcao.= " order by cod_funcao";

$result_funcao = pg_query($connect, $query_funcao) 
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
?>

<html>
<head>
<title>..:: SESMT - FUNCAO ::..</title>
<script language="javascript" src="../scripts.js"> </script>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>

<table width="700" border="3" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<th bgcolor="#009966" class="linhatopodiresqbase" colspan="4"><BR>TELA DE FUNÇÃO<BR> &nbsp;</th>
	  </tr>
    <tr>
	<tr>
		<th colspan="4" bgcolor="#009966">
		<br>&nbsp;
			<input name="btn_novo" type="button" id="btn_novo" onClick="MM_goToURL('parent','cad_funcao.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;
			<input name="btn_voltar" type="button" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">&nbsp;
		<br> &nbsp;
		</th>
	</tr>	 
  </tr>
    <tr>
      <td height="26" colspan="4" class="linhatopodiresq">
	  <form action="lista_funcao.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
		  <table width="500" border="0" align="center">
			<tr>
			  <th width="25%"><div align="right"><strong>Função: &nbsp;&nbsp;&nbsp;</strong></div></th>
			  <td width="50%"><input name="funcao" type="text" size="30" style="background:#FFFFCC"></td>
			  <td width="25%"><input type="submit" name="Submit" value="Pesquisar" class="InputButton" style="width:100;"></td>
			</tr>
		  </table>
      </form>	 
	  </td>
    </tr>
  <tr>
    <th colspan="4" class="linhatopodiresq" bgcolor="#009966">
		<h3>Registros no Sistema - Função </h3>
	</th>
  </tr>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresq" width="6%"><div align="center" class="fontebranca12"><strong>Código </strong></div></td>
	<td bgcolor="#009966" class="linhatopodiresq" width="30%"><div align="center" class="fontebranca12"><strong>Nome</strong></div></td>
    <td bgcolor="#009966" class="linhatopodiresq" width="55%"><div align="center" class="fontebranca12"><strong>Dinâmica da Função </strong></div></td>
    <td bgcolor="#009966" class="linhatopodiresq" width="9%"><div align="center" class="fontebranca12"><strong>Geral</strong></div></td>
  </tr>
<?php
  while($row=pg_fetch_array($result_funcao))
  {
?>
  <tr>
    <td class="linhatopodiresq" align="center"><div class="linksistema"><a href="alt_funcao.php?funcao=<?php echo $row[cod_funcao]?>"><?php echo $row[cod_funcao]?></a></div></td>
	<td class="linhatopodir" align="left"><div class="linksistema">&nbsp;<a href="alt_funcao.php?funcao=<?php echo $row[cod_funcao]?>"><?php echo $row[nome_funcao]?></a></div></td>
    <td class="linhatopodir"><div align="left" class="linksistema">&nbsp;<a href="alt_funcao.php?funcao=<?php echo $row[cod_funcao]?>"><?php echo $row[dsc_funcao]?></a></div></td>
    <th class="linhatopodir"><div class="linksistema"><a href="visualizar_funcao.php?funcao=<?php echo $row[cod_funcao]?>"> Visualizar</a></div></th>
  </tr>
<?php
  }
pg_close($connect);
?>
  <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="4">&nbsp;</th>
  </tr>
</table>
<br>
</body>
</html>