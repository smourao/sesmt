<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";

if($atividade=='' || $btn_voltar=='voltar')
{
	$query_atividade="select cod_atividade, upper(dsc_atividade) as dsc_atividade from atividade";
}else
{
	$query_atividade="select cod_atividade, upper(dsc_atividade) as dsc_atividade
					  from atividade where upper(dsc_atividade) like '%". strtoupper($atividade) ."%'";
}

$query_atividade.=" order by cod_atividade";

$result_atividade=pg_query($connect, $query_atividade) 
	or die ("Erro na query: $query_atividade ==> ".pg_last_error($connect));

?>
<html>
<head>
<title>SESMT - Atividade</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="500" border="2" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="2"><br>TELA DE ATIVIDADES<br>&nbsp;</th>
  </tr>
  <tr>
  <tr>
  	<th colspan="2" bgcolor="#009966">
	<br>&nbsp;
		<input name="btn_novo" type="button" id="btn_novo" onClick="MM_goToURL('parent','cad_atividade.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="btn1" type="button" id="btn1" onClick="MM_goToURL('parent','../adm/index.php'); return document.MM_returnValue"  value="Sair" style="width:100;">
		<br>&nbsp;
		</th>
		</tr>
        </tr>
  <tr>
      <td height="26" colspan="5" class="linhatopodiresq">
	  <form action="lista_atividade.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
      	<table width="400" border="0" align="center">
        	<tr>
          	<td width="25%"><strong>Atividade:</strong></td>
          	<td width="50%"><input name="atividade" type="text" size="30" style="background:#FFFFCC"></td>
          	<td width="25%"><input type="submit" name="Submit" value="Pesquisar" class="InputButton" style="width:100;"></td>
  </tr>
      </table>
      </form>
	 </td>
    </tr>
  <tr>
    <th colspan="2" class="linhatopodiresq" bgcolor="#009966">
	<h3>Registros no Sistema - Atividade</h3>
	</th>
  </tr>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Código Atividade</strong></div></td>
    <td bgcolor="#009966" class="linhatopodir"><div align="center" class="fontebranca12"><strong>Nome Atividade</strong> </div>   </td>
  </tr>
<?php
  while($row=pg_fetch_array($result_atividade))
  {
?>
  <tr>
    <td class="linhatopodiresq" align="center">
	  <div class="linksistema">
	   &nbsp;&nbsp;<a href="cad_atividade.php?id=<?=$row[cod_atividade]?>"><?=$row[cod_atividade]?></a>  </div>	</td>
    <td class="linhatopodir" >
	  <div align="left" class="linksistema">
	  &nbsp;&nbsp;<a href="cad_atividade.php?id=<?=$row[cod_atividade]?>"><?=$row[dsc_atividade]?></a>  </div>	</td>
  </tr>
<?php
  }
  $fecha = pg_close($connect);
?>
  <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="2">&nbsp;</th>
  </tr>
</table>
<br>
</body>
</html>
