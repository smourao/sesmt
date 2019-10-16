<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";

if($vendedor=='' || $btn_voltar=='voltar')
{
	$query_vendedor="select cod_vendedor, upper(nome_vendedor) as nome_vendedor from vendedor";
}else
{
	$query_vendedor="select cod_vendedor, upper(nome_vendedor) as nome_vendedor
					  from vendedor where upper(nome_vendedor) like '%". strtoupper($vendedor) ."%'";
}

$query_vendedor.=" order by cod_vendedor";

$result_vendedor=pg_query($connect, $query_vendedor) 
	or die ("Erro na query: $query_vendedor ==> ".pg_last_error($connect));

?>
<html>
<head>
<title>SESMT - Vendedor</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="scripts.js">
</script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="500" border="2" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="2"><br>TELA DE VENDEDOR<br>&nbsp;</th>
  </tr>
  <tr>
  <tr>
  	<th colspan="2" bgcolor="#009966">
	<br>&nbsp;
		<input name="btn_novo" type="button" id="btn_novo" onClick="MM_goToURL('parent','cad_vendedor.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="btn1" type="button" id="btn1" onClick="MM_goToURL('parent','../adm/index.php'); return document.MM_returnValue"  value="Sair" style="width:100;">
		<br>&nbsp;
		</th>
		</tr>
        </tr>
  <tr>
      <td height="26" colspan="5" class="linhatopodiresq">
	  <form action="lista_vendedor.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
      	<table width="400" border="0" align="center">
        	<tr>
          	<td width="25%"><strong>Vendedor:</strong></td>
          	<td width="50%"><input name="vendedor" type="text" size="30" style="background:#FFFFCC"></td>
          	<td width="25%"><input type="submit" name="Submit" value="Pesquisar" class="InputButton" style="width:100;"></td>
  </tr>
      </table>
      </form>
	 </td>
    </tr>
  <tr>
    <th colspan="2" class="linhatopodiresq" bgcolor="#009966">
	<h3>Registros no Sistema - Vendedor</h3>
	</th>
  </tr>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Código Vendedor</strong></div></td>
    <td bgcolor="#009966" class="linhatopodir"><div align="center" class="fontebranca12"><strong>Nome Vendedor</strong> </div>   </td>
  </tr>
<?php
  while($row=pg_fetch_array($result_vendedor))
  {
?>
  <tr>
    <td class="linhatopodiresq" align="center">
	  <div class="linksistema">
	   &nbsp;&nbsp;<a href="cad_vendedor.php?id=<?=$row[cod_vendedor]?>"><?=$row[cod_vendedor]?></a>  </div>	</td>
    <td class="linhatopodir" >
	  <div align="left" class="linksistema">
	  &nbsp;&nbsp;<a href="cad_vendedor.php?id=<?=$row[cod_vendedor]?>"><?=$row[nome_vendedor]?></a>  </div>	</td>
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
