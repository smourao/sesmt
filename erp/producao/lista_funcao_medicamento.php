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

if( !empty($_GET[medi]) ){
	$sql_excluir = " delete from funcao_medicamento where cod_medi = $_GET[medi] ";
	$result_excluir = pg_query($connect, $sql_excluir);
	if ($result_excluir) echo "<script>alert('Medicamento desassociado com sucesso!');</script>";
}

///////////////////////// pra buscar os dados de função
$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao	FROM funcao where cod_funcao = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);

/************************************************************************************/

if ($_POST["enviar"]=="Gravar"){ // verificar se houve o comando de enviar

	$funcao = $_POST["funcao"]; // recebe o código da função
	
	if(isset($_POST["medi"])) // verifica se tem medi
	{
		foreach($_POST["medi"] as $medi) // recebe a lista de medi's
		{
			// monta o insert no banco
			$query_medi_funcao = $query_medi_funcao . "insert into funcao_medicamento(cod_funcao, cod_medi) values ($funcao, $medi); ";
		}
	}
	else
	{
		$erro = "<font color=#FF0000> Medicamento não selecionada!</font>";
	}
	
	$result_medi_funcao = pg_query($connect, $query_medi_funcao);

	if ($result_medi_funcao) { // se os inserts foram corretos
		echo '<script> alert("Medicamento associado com sucesso!");</script>';
	}else {
		$erro = pg_last_error($connect); // em caso de erro
	}
}

	////////////////////////// pra buscar os dados de medi

	$sql_funcao_medi = "select cod_medi from funcao_medicamento where cod_funcao = $funcao";
	$result_funcao_medi = pg_query($connect, $sql_funcao_medi);
	if( pg_num_rows($result_funcao_medi) > 0 ){
		while( $row_funcao_medi = pg_fetch_array($result_funcao_medi) )
		{
			$medi_cadatrado = $medi_cadatrado . ", $row_funcao_medi[cod_medi]";
		}
	}
	// se tiver algum medi para esta função, esta query não traz
	if( !empty($medi_cadatrado) ){
		$query_medi = "select cod_medi, dsc_medi from medicamento where cod_medi not in (" . substr($medi_cadatrado,1,100) . ") order by dsc_medi";
	}
	// senão traz tudo.
	else{
		$query_medi = "select cod_medi, dsc_medi from medicamento order by dsc_medi";
	}

	$result_medi = pg_query($connect, $query_medi) 
		or die ("Erro na query: $query_medi ==> ".pg_last_error($connect));

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

<form action="lista_funcao_medicamento.php" method="post" name="frm_associacao">
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
    <td colspan="2" align="center" bgcolor="#009966"><br><h2>Função - Medicamento</h2><br></td>
  </tr>
  <tr>
    <td align="center"><h3>FUNÇÃO</h3></td>
    <td align="center"><h3>MEDICAMENTOS</h3></td>
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
	</td>
	<td align="center"><br>
		<select name = "medi[]" multiple="multiple" style="width:400px" size="10" >
<?php
  while($row_medi = pg_fetch_array($result_medi)) // ******************** cria lista de medi
  {
		echo "<option value=$row_medi[cod_medi] title=\"$row_medi[dsc_medi]\"> $row_medi[dsc_medi] </option>";
  }
?>
		</select><p>
	</td>
  </tr>
  <tr>
	  <td align="center" colspan="25" bgcolor="#009966" ><br>
	  <input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_funcao_epi.php?funcao=<?php echo $funcao; ?>');return document.MM_returnValue;" style="width:100;">
	  &nbsp;&nbsp;&nbsp;
	  <input type="submit" name="enviar" value="Gravar" style="width:100;">  
	  &nbsp;&nbsp; &nbsp;
      <input type="reset" name="limpar" value="Limpar" style="width:100;"> 
	  &nbsp;&nbsp; &nbsp;  
	  <input name="btn_medi_funcao" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_funcao_exame.php?funcao=<?php echo $funcao; ?>'); return document.MM_returnValue" value="Avançar >>" style="width:100;">
	<br>&nbsp;
  </tr>
</table>
<p> &nbsp;
<?php
if( !empty($medi_cadatrado) ){

	$sql_medi_cadatrado = "select cod_medi, dsc_medi from medicamento where cod_medi in (" . substr($medi_cadatrado,1,100) . ") order by dsc_medi";

	$result_medi_cadatrado = pg_query($connect, $sql_medi_cadatrado) 
		or die ("Erro na query: $sql_medi_cadatrado ==> ".pg_last_error($connect));
echo "<table width=800 border=2 align=center>";
	echo"	<tr>";
	echo"		<td colspan=2 align=center bgcolor=white> <font color=black> <b> Medicamentos já associados: </b> </font> </td>";
	echo"	</tr>";

	while ( $row_medi_cadatrado = pg_fetch_array($result_medi_cadatrado) ){
		echo"	<tr>";
		echo"		<th class=linksistema width=55>  <a href=\"lista_funcao_medicamento.php?medi=$row_medi_cadatrado[cod_medi]&funcao=$funcao\" > Excluir </a> </th>";
		echo"		<td> &nbsp;&nbsp;&nbsp; $row_medi_cadatrado[dsc_medi] </td>";
		echo"	</tr>";
	}
echo "</table> <P>&nbsp;";
}
?>

</form>
</body>
</html>