<?php
include "sessao.php";
include "../config/connect.php";

if( !empty($_GET[excluido]) ){
	echo "<script>alert('O medicamento \"$_GET[excluido]\" foi excluído.');</script>";
}

if($medicamento=="")
{
	$query_medicamento = "SELECT cod_medi, dsc_medi FROM medicamento where cod_medi <> 0";
}else
{
	$query_medicamento = "SELECT cod_medi, dsc_medi FROM medicamento where lower(dsc_medi) like '%" . strtolower($medicamento) . "%' and cod_medi <> 0";
}

$query_medicamento.= " order by cod_medi";

$result_medicamento = pg_query($connect, $query_medicamento) 
	or die ("Erro na query: $query_medicamento ==> ".pg_last_error($connect));

?>
<html>
<head>
<title>..:: SESMT ::..</title>
<script language="javascript" src="../scripts.js"> </script>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">

&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>

<table width="800" border="3" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<th bgcolor="#009966" class="linhatopodiresqbase" colspan="3"><BR>
			<h2>MEDICAMENTO</h2>
		</th>
	  </tr>
    <tr>
	<tr>
		<th colspan="2" bgcolor="#009966">
		<br>&nbsp;
			<input name="btn_novo" type="button" id="btn_novo" onClick="MM_goToURL('parent','cad_medicamento.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;
			<!--input name="btn_medicamento_medicamento" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_medicamento_medicamento.php'); return document.MM_returnValue" value="medicamento" style="width:100;"> &nbsp;&nbsp;
			< input name="btn_medicamento_medicamento" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_medicamento_medicamento.php'); return document.MM_returnValue" value="Medicamento - Função" style="width:130;"> &nbsp;&nbsp;
			<input name="btn_medicamento_exame" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_medicamento_exame.php'); return document.MM_returnValue" value="Exame - Função" style="width:100;"> &nbsp;&nbsp; -->
			<input name="btn_voltar" type="button" onClick="MM_goToURL('parent','../adm/index.php'); return document.MM_returnValue" value="Sair" style="width:100;">&nbsp;

		<br> &nbsp;
		</th>
	</tr>	 
  </tr>
    <tr>
      <td height="26" colspan="3" class="linhatopodiresq">
	  <form action="lista_medicamento.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
		  <table width="500" border="0" align="center">
			<tr>
			  <th width="25%"><div align="right"><strong>Medicamento: &nbsp;&nbsp;&nbsp;</strong></div></th>
			  <td width="50%"><input name="medicamento" type="text" size="30" style="background:#FFFFCC"></td>
			  <td width="25%"><input type="submit" name="Submit" value="Pesquisar" class="InputButton" style="width:100;"></td>
			</tr>
		  </table>
      </form>	 
	  </td>
    </tr>
  <tr>
    <th colspan="2" class="linhatopodiresq" bgcolor="#009966">
		<h3>Registros no Sistema - Função </h3>
	</th>
  </tr>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresq" width="10%"><div align="center" class="fontebranca12"><strong>Código </strong></div></td>
    <td bgcolor="#009966" class="linhatopodiresq" width="60%"><div align="center" class="fontebranca12"><strong>Descri&ccedil;&atilde;o </strong></div></td>
  </tr>
<?php
  while($row=pg_fetch_array($result_medicamento))
  {
?>
  <tr>
    <td class="linhatopodiresq" align="center">	  <div class="linksistema">
	   &nbsp;&nbsp;<a href="alt_medicamento.php?medicamento=<?php echo $row[cod_medi]?>"> <?php echo $row[cod_medi]?></a>	  </div>	</td>
    <td class="linhatopodir" >	  <div align="left" class="linksistema">
	  &nbsp;&nbsp;<a href="alt_medicamento.php?medicamento=<?php echo $row[cod_medi]?>"> <?php echo $row[dsc_medi]?></a>	  </div>	</td>
  </tr>
<?php
  }
pg_close($connect);
?>
  <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="2">&nbsp;</th>
  </tr>
</table>
<br>
</body>
</html>
