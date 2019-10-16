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

if( !empty($_GET[curso]) ){
	$sql_excluir = " delete from curso_funcao where cod_prod = $_GET[curso] ";
	$result_excluir = pg_query($connect, $sql_excluir);
	if ($result_excluir) echo "<script>alert('Curso desassociado com sucesso!');</script>";
}

///////////////////////// pra buscar os dados de função
$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao	FROM funcao where cod_funcao = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);

/************************************************************************************/

if ($_POST["enviar"]=="Gravar"){ // verificar se houve o comando de enviar

	$funcao = $_POST["funcao"]; // recebe o código da função
	
	if(isset($_POST["curso"])) // verifica se tem curso
	{
		foreach($_POST["curso"] as $curso) // recebe a lista de curso's
		{
			// monta o insert no banco
			$query_curso_funcao = $query_curso_funcao . "insert into curso_funcao(cod_funcao, cod_prod) values ($funcao, $curso ); ";
		}
	}
	else
	{
		$erro = "<font color=#FF0000> Curso não selecionado!</font>";
	}
	
	$result_curso_funcao = pg_query($connect, $query_curso_funcao);

	if ($result_curso_funcao) { // se os inserts foram corretos
		echo '<script> alert("Curso associado com sucesso!");</script>';
	}else {
		$erro = pg_last_error($connect); // em caso de erro
	}
}

	////////////////////////// pra buscar os dados de curso

	$sql_curso_funcao = "select cod_prod from curso_funcao where cod_funcao = $funcao";
	$result_curso_funcao = pg_query($connect, $sql_curso_funcao);
	if( pg_num_rows($result_curso_funcao) > 0 ){
		while( $row_curso_funcao = pg_fetch_array($result_curso_funcao) )
		{
			$curso_cadatrado = $curso_cadatrado . ", $row_curso_funcao[cod_prod]";
		}
	}
	// se tiver algum curso para esta função, esta query não traz
	if( !empty($curso_cadatrado) ){
		$query_curso = "select cod_prod, replace(desc_detalhada_prod,'\"','``') as desc_detalhada_prod from produto where cod_prod not in (" . substr($curso_cadatrado,1,100) . ") order by desc_detalhada_prod";
	}
	// senão traz tudo.
	else{
		$query_curso = "select cod_prod, desc_detalhada_prod from produto where cod_atividade = 3 order by desc_detalhada_prod";
	}

	$result_curso = pg_query($connect, $query_curso) 
		or die ("Erro na query: $query_curso ==> ".pg_last_error($connect));

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
<title>SESMT - Teste Associação</title>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>

<form action="lista_funcao_curso.php" method="post" name="frm_associacao">
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
    <td colspan="2" align="center" bgcolor="#009966"><br>
    <h2>Função - Curso</h2>
    <br></td>
  </tr>
  <tr>
    <th width="300" ><h3>FUNÇÃO</h3></th>
    <th width="500" ><h3>CURSO</h3></th>
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
	</td>    <td align="center"><br> &nbsp;
		<select name = "curso[]" multiple="multiple" style="width:400px" size="10">
<?php
  while($row_curso = pg_fetch_array($result_curso)) // ******************** cria lista de curso
  {
		echo "<option value=$row_curso[cod_prod] title=\"$row_curso[desc_detalhada_prod]\" > $row_curso[desc_detalhada_prod] </option>";
  }
?>
		</select> <p>
	</td>
  <!--
  <tr -->
  </tr>
  <td align="center" colspan="5" bgcolor="#009966" class="linhatopodiresq" ><br>
	  <input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_funcao_exame.php?funcao=<?php echo $funcao; ?>');return document.MM_returnValue;" style="width:100;">
	  &nbsp;&nbsp;&nbsp;
	  <input type="submit" name="enviar" value="Gravar" style="width:100;">  
	  &nbsp;&nbsp; &nbsp;
      <input type="reset" name="limpar" value="Limpar" style="width:100;"> 
	  &nbsp;&nbsp; &nbsp;  
	  <input name="btn_curso_funcao" type="button" id="btn_novo" onClick="MM_goToURL('parent','funcao.php?funcao=<?php echo $funcao; ?>'); return document.MM_returnValue" value="Avançar >>" style="width:100;">
	<br>&nbsp;
  </tr>
</table>
<p> &nbsp;
<?php
if( !empty($curso_cadatrado) ){

	$sql_curso_cadatrado = "select cod_prod, desc_detalhada_prod from produto where cod_prod in (" . substr($curso_cadatrado,1,100) . ") order by desc_detalhada_prod";

	$result_curso_cadatrado = pg_query($connect, $sql_curso_cadatrado) 
		or die ("Erro na query: $sql_curso_cadatrado ==> ".pg_last_error($connect));
echo "<table width=800 border=2 align=center>";
	echo"	<tr>";
	echo"		<td colspan=2 align=center bgcolor=white> <font color=black> <b> Cursos já associados: </b> </font> </td>";
	echo"	</tr>";

	while ( $row_curso_cadatrado = pg_fetch_array($result_curso_cadatrado) ){
		echo"	<tr>";
		echo"		<th class=linksistema width=55> <a href=\"lista_funcao_curso.php?curso=$row_curso_cadatrado[cod_prod]&funcao=$funcao\" > Excluir </a> </th>";
		echo"		<td> &nbsp; $row_curso_cadatrado[desc_detalhada_prod] </td>";
		echo"	</tr>";
	}
echo "</table> <P>&nbsp;";
}
?>

</form>
</body>
</html>