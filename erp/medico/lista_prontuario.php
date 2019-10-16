<?php
include "../sessao.php";
include "../config/connect.php";

	if(is_numeric($_POST[cod_cliente])){
		$sql_busca = "select cliente_id, razao_social
					  from cliente
					  where cliente_id = $_POST[cod_cliente]";
	}elseif(empty($_POST[cod_cliente])){
	$sql_busca = "select cliente_id, razao_social
					  from cliente
					  order by razao_social";
	}else{
		$sql_busca = "select cliente_id, razao_social
					  from cliente
					  where lower(razao_social) like '%". strtolower(addslashes($_POST[cod_cliente])) ."%'";
	}
		
		$consulta_busca = pg_query($connect, $sql_busca);

?>
<html>
<head>
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>

<table width="600" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="3"><BR>TELA DE PRONTUÁRIOS<BR>&nbsp;</th>
	</tr>
		<tr>
		<tr>
			<th colspan="3" bgcolor="#009966">
			<br>&nbsp;
				<input name="btn1" type="submit" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
			<br>&nbsp;
	   </th>	
  </tr>
  </tr>
    <tr>
      <td height="26" colspan="5" class="linhatopodiresq">
	  <form action="../medico/lista_prontuario.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
      <table width="450" border="0" align="center">
        <tr>
          <th width="20%"><strong>Cliente(Nome/Cód):</strong></th>
          <td width="50%"><input name="cod_cliente" type="text" size="40" value="<?php echo $_POST[cod_cliente]; ?>"></td>
          <td width="25%"><input type="submit" name="Submit" value="Pesquisar" class="InputButton" style="width:70;"></td>
        </tr>
      </table>
	  </form>
	  	 </td>
    </tr>
  <tr>
    <th colspan="3" class="linhatopodiresq" bgcolor="#009966">
      <h3>Registros no Sistema - Prontuários </h3>
    </th>
  </tr>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Razão Social</strong></div></td>
  </tr>
<?php
  while($row=pg_fetch_array($consulta_busca)) {
?>
  <tr>
	<td class="linhatopodir">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="../medico/cad_prontuario.php?cod_cliente=<?php echo $row[cliente_id]?>"><?php echo $row[razao_social]?></a> </div> </td>
  </tr>
<?php
  }
//}
  $fecha = pg_close($connect);
?>
  <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="3">&nbsp;</th>
  </tr>
</table>
<br>
</body>
</html>