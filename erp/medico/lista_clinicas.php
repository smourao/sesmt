<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";

if($clinica=='' || $btn_voltar=='voltar')
{
	$query_clinica = "select cod_clinica, razao_social_clinica, tel_clinica from clinicas";
}else
{
	$query_clinica = "select cod_clinica, razao_social_clinica, tel_clinica 
					  from clinicas 
					  where lower(razao_social_clinica) like '%". strtolower(addslashes($clinica)) ."%'";
}

$query_clinica.= " order by razao_social_clinica";

$result_clinica = pg_query($connect, $query_clinica) 
	or die ("Erro na query: $query_clinica ==> ".pg_last_error($connect));

?>
<html>
<head>
<title>SESMT - CLÍNICAS</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>

<table width="500" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="3"><BR>TELA DE CLÍNICAS<BR>&nbsp;</th>
	</tr>
		<tr>
		<tr>
			<th colspan="3" bgcolor="#009966">
			<br>&nbsp;
            	<input name="btn_novo" type="button" id="btn_novo" onClick="MM_goToURL('parent','../medico/cadastro_clinicas.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input name="btn1" type="submit" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
			<br>&nbsp;
	   </th>	
  </tr>
  </tr>
    <tr>
      <td height="26" colspan="5" class="linhatopodiresq">
	  <form action="../medico/lista_clinicas.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
      <table width="400" border="0" align="center">
        <tr>
          <th width="20%"><strong>Clínica:</strong></th>
          <td width="50%"><input name="clinica" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%"><input type="submit" name="Submit" value="Pesquisar" class="InputButton" style="width:100;"></td>
        </tr>
      </table>
	  </form>
	  	 </td>
    </tr>
  <tr>
    <th colspan="3" class="linhatopodiresq" bgcolor="#009966">
      <h3>Registros no Sistema - Clínicas </h3>
    </th>
  </tr>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Razão Social</strong></div></td>
	<td bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Telefone </strong></div> </td>
  </tr>
<?php
  while($row=pg_fetch_array($result_clinica))
  {
?>
  <tr>
	<td class="linhatopodir">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="../medico/cadastro_clinicas_alt.php?cod_clinica=<?php echo $row[cod_clinica]?>"><?php echo $row[razao_social_clinica]?></a> </div> </td>
    <td class="linhatopodir" >
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="../medico/cadastro_clinicas_alt.php?cod_clinica=<?php echo $row[cod_clinica]?>"><?php echo $row[tel_clinica]?></a>	  </div>	</td>
  </tr>
<?php
  }
  $fecha = pg_close($connect);
?>
  <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="3">&nbsp;</th>
  </tr>
</table>
<br>
</body>
</html>
