<?php
include "sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$funcao = $_GET["funcao"];
}
else{
	$funcao = $_POST["cod_funcao"];
}

if ( $_POST[btn_excluir] == "Excluir" ){ // se excluir for ativado.

	$query_excluir = "delete from funcao_epi where cod_epi = $funcao; " ;
	$query_excluir = $query_excluir . "delete from funcao_exame where cod_exame = $funcao; " ;
	$query_excluir = $query_excluir . "delete from funcao_medi where cod_medi = $funcao; " ;
	$query_excluir = $query_excluir . "delete from funcao_curso where cod_curso = $funcao; " ;
	$query_excluir = $query_excluir . "delete from funcao_ambiental where cod_funcao = $funcao; " ;
	$query_excluir = $query_excluir . "update funcionarios set cod_funcao = null where cod_funcao = $funcao; " ;
	$query_excluir = $query_excluir . "delete from funcao where cod_funcao = $funcao; " ;

	$result = pg_query($query_excluir) // executa a atualização
		or die ("Erro na exclusão da tabela \"FUNÇÃo\". ==> " . pg_last_error($connect));
		
	echo '<script> alert("FUNÇÃO Excluida com Sucesso!");</script>';

	header("location: lista_funcao.php?excluido=".$_POST[nome_funcao]);

}
else if ( $_POST[btn_enviar] == "Gravar" )
{
	$sql_update = "update funcao set 
					nome_funcao = '$nome_funcao' 
					, dsc_funcao = '$dsc_funcao' 
				   where cod_funcao = $funcao";

	$result_update = pg_query($connect, $sql_update) 
		or die ("Erro na query: $sql_update==> " . pg_last_error($connect) );
	if ($result_update) echo "<script>alert('Função atualizada com sucesso!');</script>";
}

	$query_funcao = "select cod_funcao, nome_funcao, dsc_funcao 
					 from funcao where cod_funcao = $funcao";
	
	$result_funcao= pg_query($connect, $query_funcao) 
		or die ("Erro na query: $query_funcao==> " . pg_last_error($connect) );

    $row = pg_fetch_array($result_funcao);

?>
<html>
<head>
<title>..:: SESMT ::..</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<form name="frm_funcao" action="alt_funcao.php" method="post">
	<table align="center" width="800" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<th colspan="2" bgcolor="#009966"><br><h3>Cadastro de Função:</h3><br></th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right" valign="top"><strong>Código:&nbsp;&nbsp;&nbsp;</strong></td>
			<td >&nbsp;&nbsp;<input type="text" name="cod_funcao" size="5" value="<?php echo $row[cod_funcao]?>" readonly="true"><br> &nbsp;</td>
		</tr>
		<tr>
			<td align="right" valign="top"><strong>Nome:&nbsp;&nbsp;&nbsp;</strong></td>
			<td>&nbsp;&nbsp;<textarea name="nome_funcao" rows="5" style="background:#FFFFCC; width:350px; font-size:12px;"><?php echo $row[nome_funcao]?></textarea><br> &nbsp;</td>
		</tr>
		<tr>
			<td align="right" valign="top"><strong>Din&acirc;mica da Fun&ccedil;&atilde;o:&nbsp;&nbsp;&nbsp;</strong></td>
			<td>&nbsp;&nbsp;<textarea name="dsc_funcao" rows="5" cols="50" style="background:#FFFFCC; width:350px; font-size:12px;"><?php echo $row[dsc_funcao]?></textarea><br> &nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="2" bgcolor="#009966">
			<br>
				<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_funcao.php');return document.MM_returnValue;" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="button" name="novo" value="Novo" onClick="MM_goToURL('parent','cad_funcao.php');return document.MM_returnValue;" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="submit" value="Gravar" name="btn_enviar" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input type="submit" value="Excluir" name="btn_excluir" style="width:100;">
				&nbsp;&nbsp;&nbsp;
				<input name="btn_epi_funcao" type="button" id="btn_novo" onClick="MM_goToURL('parent','funcao_epi.php?funcao=<?php echo $row[cod_funcao];?>'); return document.MM_returnValue" value="Avançar >>" style="width:100;">
				<br>
				&nbsp;
			</th>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
  </table>
</form>
</body>
</html>