<?php
include "../sessao.php";
include "../config/connect.php";

$funcionario_id = $_SESSION[usuario_id];
$grupo_id = $_SESSION[grupo];

if($avulso=='' && $grupo_id != 'clinica')
{
	$query_avulso = "select cod_aso, razao_social_cliente, funcionario_id 
					 from aso_avulso";
}else
{
	$query_avulso = "select cod_aso, razao_social_cliente, funcionario_id 
					 from aso_avulso 
				  	 where lower(razao_social_cliente) like '%".addslashes(strtolower($avulso))."%'
					 AND funcionario_id = $funcionario_id";
}

$query_avulso.=" order by cod_aso";

$result_avulso=pg_query($connect, $query_avulso) 
	or die ("Erro na query: $query_avulso ==> ".pg_last_error($connect));

?>
<html>
<head>
<title>SESMT - ASO AVULSO</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="500" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="3"><br>TELA DE ASO SEM EXAMES COMPLEMENTARES<br></th>
	</tr>
	   <tr>
	   <tr>
		<th colspan="3" bgcolor="#009966">
		<br>&nbsp;
		<input name="btn_novo" type="submit" id="btn_novo" onClick="MM_goToURL('parent','aso_complementar.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="btn1" type="submit" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
		<br>&nbsp;
		</th>
		</tr>
    </tr>
  
    <tr>
      <td height="26" colspan="5" class="linhatopodiresq">
	  <form action="lista_aso_complementar.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
      <table width="400" border="0" align="center">
        <tr>
          <td width="10%"><strong>Razão Social:</strong></td>
          <td width="50%"><input name="avulso" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%"><input type="submit" name="Submit" value="Pesquisar" style="width:100;">	</td>
        </tr>
      </table>
	 </form>	
	  </td>
    </tr>
  <tr>
    <th colspan="3" bgcolor="#009966" class="linhatopodiresq">
      <h3>Registros no Sistema </h3>
    </th>
  </tr>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Código do ASO </strong></div></td>
    <td bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Nome do Cliente </strong></div></td>
 	<td bgcolor="#009966" class="linhatopodiresq">&nbsp;</td>
 </tr>
<?php
  while($row=pg_fetch_array($result_avulso))
  {
?>
  <tr>
    <td class="linhatopodiresq" align="center">
	  <div class="linksistema">
	   &nbsp;&nbsp;<a href="aso_complementar.php?cod_aso=<?php echo $row[cod_aso]?>"><?php echo $row[cod_aso]?></a>	  </div>	</td>
    <td class="linhatopodir" >
	  <div align="left" class="linksistema">
	  &nbsp;&nbsp;<a href="aso_complementar.php?cod_aso=<?php echo $row[cod_aso]?>"><?php echo $row[razao_social_cliente]?></a>	  </div>	</td>
    <td class="linhatopodir" >
	  <div align="left" class="linksistema">
	  &nbsp;&nbsp;<a href="aso_complementar_alterar.php?cod_aso=<?php echo $row[cod_aso]?>"><?php echo "Alterar";?></a>	  </div>	</td>

  </tr>
<?php
  }
  $fecha = pg_close($connect);
?>
  <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="3"><br>
	</tr>
</table>
<br>
</body>
</html>
