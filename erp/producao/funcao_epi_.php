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


if ( $_POST["enviar"]=="Gravar" )
{ // verificar se houve o comando de enviar
	$sql = "update funcao set funcao_epi = '$_POST[funcao_epi]' where cod_funcao = $funcao;";
	$result_sql = pg_query($connect, $sql)
		or die ( "Erro na query: $sql ==> ".pg_last_error($connect) );
	if ($result_sql){
		echo "<script>alert('EPI atualizados com sucesso!');</script>";
	}
}


///////////////////////// pra buscar os dados de função
$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao, funcao_epi FROM funcao where cod_funcao = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);

/************************************************************************************/

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
<title>..:: SESMT &gt;&gt; Fun&ccedil;&atilde;o - EPI  ::..</title>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>

<form action="funcao_epi.php" method="post" name="frm_associacao">
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center" bgcolor="#009966"><br>
		<h2>Equipamentos indicados para a Fun&ccedil;&atilde;o </h2>
		<br></td>
	</tr>
	<tr>
		<td width="400" align="center"><h3>FUNÇÃO</h3></td>
		<td width="400" align="center"><h3>EPI</h3></td>
	</tr>
	<tr>
		<td>
			<input type="hidden" name="funcao" value="<?php echo $funcao; ?>">

			&nbsp;&nbsp;Função: <br>&nbsp;&nbsp;&nbsp;
			<textarea name="nome_funcao" rows="5" style="background:#FFFFCC; width:350px; font-size:12px;"  readonly><?php echo $row_funcao[nome_funcao]?></textarea><p>
			&nbsp;&nbsp;Dinâmica da Função: <br>&nbsp;&nbsp;&nbsp;
			<textarea rows="5" name="dsc_funcao" readonly style="background:#FFFFCC; font-size:12px; width:350px;"><?php echo $row_funcao[dsc_funcao]; ?></textarea>
			<br>&nbsp;
		</td>
		<td align="center"> Equipamento de proteção Individual: <br>
			<textarea name="funcao_epi" rows="8" style="width:350px; font-size:12px;"><?php echo $row_funcao[funcao_epi]; ?></textarea> <br>&nbsp;
		</td>
	</tr>
	<tr>
		<th colspan="2" bgcolor="#009966">
			<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','alt_funcao.php?funcao=<?php echo $funcao; ?>');return document.MM_returnValue;" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="enviar" value="Gravar" style="width:100;">  
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="limpar" value="Limpar" style="width:100;"> 
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input name="btn_epi_funcao" type="button" id="btn_novo" onClick="MM_goToURL('parent','funcao_medi.php?funcao=<?php echo $funcao; ?>'); return document.MM_returnValue" value="Avançar >>" style="width:100;">
		</th>
	</tr>
</table>
<p> 
</form>
</body>
</html>