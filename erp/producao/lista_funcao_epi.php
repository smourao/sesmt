<?php
include "sessao.php";
include "../config/connect.php";

$erro = "";

if ($_GET){
	$funcao = $_GET[funcao];
}
else{
	$funcao = $_POST[funcao];
}

if( !empty($_GET[epi]) ){
	$sql_excluir = " delete from epi_funcao where cod_epi = $_GET[epi] ";
	$result_excluir = pg_query($connect, $sql_excluir);
	if ($result_excluir) echo "<script>alert('EPI desassociado com sucesso!');</script>";
}

///////////////////////// pra buscar os dados de função
$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao	FROM funcao where cod_funcao = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);

/************************************************************************************/

if ($_POST["enviar"]=="Gravar"){ // verificar se houve o comando de enviar

	$funcao = $_POST["funcao"]; // recebe o código da função
	
	if(isset($_POST["epi"])) // verifica se tem EPI
	{
		foreach($_POST["epi"] as $epi) // recebe a lista de EPI's
		{
			// monta o insert no banco
			$query_epi_funcao = $query_epi_funcao . "insert into epi_funcao(cod_funcao, cod_epi, data_criacao) values ($funcao, $epi, '" . date("y-m-d") ."' ); ";
		}
	}
	else
	{
		$erro = "<font color=#FF0000> EPI não selecionada!</font>";
	}
	
	$result_epi_funcao = pg_query($connect, $query_epi_funcao);

	if ($result_epi_funcao) { // se os inserts foram corretos
		echo '<script> alert("EPI associada com sucesso!");</script>';
	}else {
		$erro = pg_last_error($connect); // em caso de erro
	}
}

	////////////////////////// pra buscar os dados de EPI

	$sql_funcao_epi = "select cod_epi from epi_funcao where cod_funcao = $funcao";
	$result_funcao_epi = pg_query($connect, $sql_funcao_epi);
	if( pg_num_rows($result_funcao_epi) > 0 ){
		while( $row_funcao_epi = pg_fetch_array($result_funcao_epi) )
		{
			$epi_cadatrado = $epi_cadatrado . ", $row_funcao_epi[cod_epi]";
		}
	}
	// se tiver algum EPI para esta função, esta query não traz
	if( !empty($epi_cadatrado) ){
/*		$query_epi = "select cod_epi, dsc_epi from epi where cod_epi not in (" . substr($epi_cadatrado,1,100) . ") order by dsc_epi"; */
		$query_epi = "select cod_epi, dsc_epi from epi where cod_epi not in (select cod_epi from epi_funcao where cod_funcao = $funcao) order by dsc_epi";
	}
	// senão traz tudo.
	else{
		$query_epi = "select cod_epi, dsc_epi from epi order by dsc_epi";
	}

	$result_epi = pg_query($connect, $query_epi) 
		or die ("Erro na query: $query_epi ==> ".pg_last_error($connect));

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
</header>

<script type="text/javascript">
	function MM_goToURL() {
		var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
		for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
</script>
<title>..:: SESMT ::..</title>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>

<form action="lista_funcao_epi.php" method="post" name="frm_associacao">
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0">
<?php // ************************* em caso de erro
	if($erro!=""){

		echo "<tr>
				  <td height=26 colspan=2 bgcolor=#FFFFFF><font color=#FF0000><?=$erro?></font></td>
			  </tr>";
	}            
// ****************************************
?>
  <tr>
    <td colspan="2" align="center" bgcolor="#009966"><br><h2>Associação de EPI e Função</h2><br></td>
  </tr>
  <tr>
    <td width="300" align="center"><h3>FUNÇÃO</h3></td>
    <td width="400" align="center"><h3>EPI</h3></td>
  </tr>
  <tr>
    <td>
		<br>
		<input type="hidden" name="funcao" value="<?php echo $funcao; ?>">
		&nbsp;&nbsp;Função: <br>&nbsp;&nbsp;&nbsp;
		<input type="text" name="nome_funcao" value="<?php echo $row_funcao[nome_funcao]; ?>" size="50" readonly><p>
		&nbsp;&nbsp;Dinâmica da Função: <br>&nbsp;&nbsp;&nbsp;
		<textarea rows="5" cols="40" name="dsc_funcao" readonly style="font-size:12px;"><?php echo $row_funcao[dsc_funcao]; ?></textarea>
		<br>&nbsp;
	</td>    <td align="center"><br>
		<select name = "epi[]" multiple="multiple" style="width:400px" size="10" >
<?php
  while($row_epi = pg_fetch_array($result_epi)) // ******************** cria lista de EPI
  {
		echo "<option value=$row_epi[cod_epi] title=\"$row_epi[dsc_epi]\"> $row_epi[dsc_epi] </option>";
  }
?>
		</select><p>
	</td>
  <!--
  <tr -->
  </tr>
  <td align="center" colspan="5" bgcolor="#009966" class="linhatopodiresq"><br>
	  <input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','alt_funcao.php?funcao=<?php echo $funcao; ?>');return document.MM_returnValue;" style="width:100;">
	  &nbsp;&nbsp;&nbsp;
	  <input type="submit" name="enviar" value="Gravar" style="width:100;">  
	  &nbsp;&nbsp; &nbsp;
      <input type="reset" name="limpar" value="Limpar" style="width:100;"> 
	  &nbsp;&nbsp; &nbsp;  
	  <input name="btn_epi_funcao" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_funcao_medicamento.php?funcao=<?php echo $funcao; ?>'); return document.MM_returnValue" value="Avançar >>" style="width:100;">
	<br>&nbsp;
  </tr>
</table>
<p> &nbsp;
<?php
if( !empty($epi_cadatrado) ){

/*	$sql_epi_cadatrado = "select cod_epi, dsc_epi from epi where cod_epi in (" . substr($epi_cadatrado,1,100) . ") order by dsc_epi";*/
	$sql_epi_cadatrado = "select cod_epi, dsc_epi from epi where cod_epi in (select cod_epi from epi_funcao where cod_funcao = $funcao) order by dsc_epi";

	$result_epi_cadatrado = pg_query($connect, $sql_epi_cadatrado) 
		or die ("Erro na query: $sql_epi_cadatrado ==> ".pg_last_error($connect));
echo "<table width=800 border=2 align=center>";
	echo"	<tr>";
	echo"		<td colspan=2 align=center bgcolor=white> <font color=black> <b> EPIs já associados: </b> </font> </td>";
	echo"	</tr>";

	while ( $row_epi_cadatrado = pg_fetch_array($result_epi_cadatrado) ){
		echo"	<tr>";
		echo"		<th class=linksistema >  <a href=\"lista_epi_funcao.php?epi=$row_epi_cadatrado[cod_epi]&funcao=$funcao\" > Excluir </a> </th>";
		echo"		<td> &nbsp;&nbsp;&nbsp; $row_epi_cadatrado[dsc_epi] </td>";
		echo"	</tr>";
	}
echo "</table> <P>&nbsp;";
}
?>

</form>
</body>
</html>