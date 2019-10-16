<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";

if ( $_GET[excluir]=="sim" and !empty($_GET[setor]) ){
	$sql_excluir = "delete from setor where cod_setor = $_GET[setor] ";
	$result_excluir = pg_query($connect, $sql_excluir);
	if($result_excluir){
		echo ("<script>alert('Setor excluído com sucesso!');</script>");
	}
	else{
		echo ("<script>alert('Setor não foi excluído!');</script>");
	}
}

$query_setor = "SELECT cod_setor, desc_setor, nome_setor FROM setor where cod_setor <> 0 order by cod_setor";

$result_setor = pg_query($connect, $query_setor) 
	or die ("Erro na query: $query_setor ==> ".pg_last_error($connect));
?>
<html>
<head>
<title>::SESMT:: Setor</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="750" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="4" class="linhatopodiresq" bgcolor="#009966"><br>
    	SETOR<br>
    	&nbsp;</th>
    </tr>
	<tr>
		<th bgcolor="#009966" colspan="4">
		  <br>&nbsp;
			<input name="btn_novo" type="button" id="btn_novo" onClick="MM_goToURL('parent','cad_setor.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="btn_sair" type="button" id="btn_sair" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
		  <br>&nbsp;
		 </th>
	</tr>
  <tr>
    <th colspan="4" class="linhatopodiresq" bgcolor="#009966">
      <h3>Registros no Sistema</h3>    </th>
  </tr>
  <tr>
    <td width="50" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>&nbsp;</strong></div></td>
    <td width="60" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Código</strong></div></td>
    <td width="200" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Nome</strong></div></td>
    <td width="440" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Descrição</strong></div></td>
  </tr>
<?php
  while($row = pg_fetch_array($result_setor)){
?>
  <tr>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	  &nbsp;<a href="lista_setor.php?setor=<?php echo $row[cod_setor];?>&excluir=sim">Excluir</a></div>	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	  &nbsp;<a href="cad_setor.php?&setor=<?php echo $row[cod_setor];?>"> <?php echo $row[cod_setor];?></a>	  </div>    </td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	  &nbsp;<a href="cad_setor.php?&setor=<?php echo $row[cod_setor];?>"> <?php echo $row[nome_setor];?></a>	  </div>    </td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	  &nbsp;<a href="cad_setor.php?&setor=<?php echo $row[cod_setor];?>"> <?php echo $row[desc_setor];?></a>	  </div>    </td>
  </tr>
<?php
  }
  $fecha = pg_close($connect);
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
</body>
</html>