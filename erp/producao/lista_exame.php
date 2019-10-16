<?php
include "sessao.php";
include "../config/connect.php";

if( !empty($_GET[excluido]) ){
	echo "<script>alert('A função $_GET[excluido] foi excluída.');</script>";
}

if($exame=="")
{
	$query_exame = "select cod_exame
						, especialidade
						, dsc_exame 
					from exame where cod_exame <> 0";
}else
{
	$query_exame = "select cod_exame, especialidade,
					 dsc_exame
					 from exame
					 where especialidade like '%$exame%'
					 or dsc_exame like '%$exame%' and cod_exame <> 0";
}

$query_exame.= " order by cod_exame";

$result_exame = pg_query($connect, $query_exame) 
	or die ("Erro na query: $query_exame ==> ".pg_last_error($connect));

?>
<html>
<head>
<title>SESMT - exame</title>
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
		EXAME<BR> &nbsp;</th>
	  </tr>
    <tr>
	<tr>
		<th colspan="3" bgcolor="#009966">
		<br>&nbsp;
			<input name="btn_novo" type="button" id="btn_novo" onClick="MM_goToURL('parent','cad_exame.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;
			<!--input name="btn_epi_exame" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_epi_exame.php'); return document.MM_returnValue" value="EPI" style="width:100;"> &nbsp;&nbsp;
			< input name="btn_exame_medicamento" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_exame_medicamento.php'); return document.MM_returnValue" value="Medicamento - Função" style="width:130;"> &nbsp;&nbsp;
			<input name="btn_exame_exame" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_exame_exame.php'); return document.MM_returnValue" value="Exame - Função" style="width:100;"> &nbsp;&nbsp; -->
			<input name="btn_voltar" type="button" onClick="MM_goToURL('parent','../adm/index.php'); return document.MM_returnValue" value="Sair" style="width:100;">&nbsp;

		<br> &nbsp;
		</th>
	</tr>	 
  </tr>
    <tr>
      <td height="26" colspan="3" class="linhatopodiresq">
	  <form action="lista_exame.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
		  <table width="500" border="0" align="center">
			<tr>
			  <th width="25%"><div align="right"><strong>Exame: &nbsp;&nbsp;&nbsp;</strong></div></th>
			  <td width="50%"><input name="exame" type="text" size="30" style="background:#FFFFCC"></td>
			  <td width="25%"><input type="submit" name="Submit" value="Pesquisar" class="InputButton" style="width:100;"></td>
			</tr>
		  </table>
      </form>	 
	  </td>
    </tr>
  <tr>
    <th colspan="3" class="linhatopodiresq" bgcolor="#009966">
		<h3>Registros no Sistema - Função </h3>
	</th>
  </tr>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresq" width="10%"><div align="center" class="fontebranca12"><strong>Código </strong></div></td>
	<td bgcolor="#009966" class="linhatopodiresq" width="30%"><div align="center" class="fontebranca12"><strong>Nome</strong></div></td>
    <td bgcolor="#009966" class="linhatopodiresq" width="60%"><div align="center" class="fontebranca12"><strong>Descri&ccedil;&atilde;o </strong></div></td>
  </tr>
<?php
  while($row=pg_fetch_array($result_exame))
  {
?>
  <tr>
    <td class="linhatopodiresq" align="center">	  <div class="linksistema">
	   &nbsp;&nbsp;<a href="alt_exame.php?exame=<?php echo $row[cod_exame]?>"> <?php echo $row[cod_exame]?></a>	  </div>	</td>
    <td class="linhatopodir" >	  <div align="left" class="linksistema">
	  &nbsp;&nbsp;<a href="alt_exame.php?exame=<?php echo $row[cod_exame]?>"> <?php echo $row[especialidade]?></a>	  </div>	</td>
	<td class="linhatopodir" align="left"><div class="linksistema">
	   &nbsp;&nbsp;<a href="alt_exame.php?exame=<?php echo $row[cod_exame]?>"> <?php echo $row[dsc_exame]?></a>		</div>	</td>
  </tr>
<?php
  }
pg_close($connect);
?>
  <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="3">&nbsp;</th>
  </tr>
</table>
<br>
</body>
</html>
