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

if( !empty($_GET[exame]) ){
	$sql_excluir = " delete from funcao_exame where cod_exame = $_GET[exame] ";
	$result_excluir = pg_query($connect, $sql_excluir);
	if ($result_excluir) echo "<script>alert('Exame desassociado com sucesso!');</script>";
}

///////////////////////// pra buscar os dados de função
$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao	FROM funcao where cod_funcao = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);

/************************************************************************************/

if ($_POST["enviar"]=="Gravar"){ // verificar se houve o comando de enviar

	$funcao = $_POST["funcao"]; // recebe o código da função
	
	if(isset($_POST["exame"])) // verifica se tem exame
	{
		foreach($_POST["exame"] as $exame) // recebe a lista de exame's
		{
			// monta o insert no banco
			$query_funcao_exame = $query_funcao_exame . "insert into funcao_exame(cod_funcao, cod_exame) values ($funcao, $exame ); ";
		}
	}
	else
	{
		$erro = "<font color=#FF0000> Exame não selecionado!</font>";
	}
	
	$result_funcao_exame = pg_query($connect, $query_funcao_exame);

	if ($result_funcao_exame) { // se os inserts foram corretos
		echo '<script> alert("Exame associado com sucesso!");</script>';
	}else {
		$erro = pg_last_error($connect); // em caso de erro
	}
}

	////////////////////////// pra buscar os dados de exame

	$sql_funcao_exame = "select cod_exame from funcao_exame where cod_funcao = $funcao";
	$result_funcao_exame = pg_query($connect, $sql_funcao_exame);
	if( pg_num_rows($result_funcao_exame) > 0 ){
		while( $row_funcao_exame = pg_fetch_array($result_funcao_exame) )
		{
			$exame_cadatrado = $exame_cadatrado . ", $row_funcao_exame[cod_exame]";
		}
	}
	// se tiver algum exame para esta função, esta query não traz
	if( !empty($exame_cadatrado) ){
		$query_exame = "select cod_exame, dsc_exame from exame where cod_exame not in (" . substr($exame_cadatrado,1,100) . ") order by dsc_exame";
	}
	// senão traz tudo.
	else{
		$query_exame = "select cod_exame, dsc_exame from exame order by dsc_exame";
	}

	$result_exame = pg_query($connect, $query_exame) 
		or die ("Erro na query: $query_exame ==> ".pg_last_error($connect));

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

<form action="lista_funcao_exame.php" method="post" name="frm_associacao">
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
    <td colspan="2" align="center" bgcolor="#009966"><br><h2>Função - Exame</h2><br></td>
  </tr>
  <tr>
    <td width="300" align="center"><h3>FUNÇÃO</h3></td>
    <td width="500" align="center"><h3>EXAME</h3></td>
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
		<select name = "exame[]" multiple="multiple" style="width:400px" size="10">
<?php
  while($row_exame = pg_fetch_array($result_exame)) // ******************** cria lista de exame
  {
		echo "<option value=$row_exame[cod_exame] title=\"$row_exame[dsc_exame]\"> $row_exame[dsc_exame] </option>";
  }
?>
		</select><p>
	</td>
  <!--
  <tr -->
  </tr>
  <td align="center" colspan="5" bgcolor="#009966" class="linhatopodiresq"><br>
	  <input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_funcao_medicamento.php?funcao=<?php echo $funcao; ?>');return document.MM_returnValue;" style="width:100;">
	  &nbsp;&nbsp;&nbsp;
	  <input type="submit" name="enviar" value="Gravar" style="width:100;">  
	  &nbsp;&nbsp; &nbsp;
      <input type="reset" name="limpar" value="Limpar" style="width:100;"> 
	  &nbsp;&nbsp; &nbsp;  
	  <input name="btn_funcao_exame" type="button" id="btn_novo" onClick="MM_goToURL('parent','lista_funcao_curso.php?funcao=<?php echo $funcao; ?>'); return document.MM_returnValue" value="Avançar >>" style="width:100;">
	<br>&nbsp;
  </tr>
</table>
<p> &nbsp;
<?php
if( !empty($exame_cadatrado) ){

	$sql_exame_cadatrado = "select cod_exame, dsc_exame, especialidade from exame where cod_exame in (" . substr($exame_cadatrado,1,100) . ") order by dsc_exame";

	$result_exame_cadatrado = pg_query($connect, $sql_exame_cadatrado) 
		or die ("Erro na query: $sql_exame_cadatrado ==> ".pg_last_error($connect));
echo "<table width=800 border=2 align=center>";
	echo"	<tr>";
	echo"		<td colspan=3 align=center bgcolor=white> <font color=black> <b> Exames já associados: </b> </font> </td>";
	echo"	</tr>";

	while ( $row_exame_cadatrado = pg_fetch_array($result_exame_cadatrado) ){
		echo"	<tr>";
		echo"		<th class=linksistema width=55>  <a href=\"lista_funcao_exame.php?exame=$row_exame_cadatrado[cod_exame]&funcao=$funcao\" > Excluir </a> </th>";
		echo"		<td> &nbsp;&nbsp;&nbsp; $row_exame_cadatrado[especialidade] </td>";
		echo"		<td> &nbsp;&nbsp;&nbsp; $row_exame_cadatrado[dsc_exame] </td>";
		echo"	</tr>";
	}
echo "</table> <P>&nbsp;";
}
?>

</form>
</body>
</html>