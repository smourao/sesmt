<?php

include "sessao.php";

include "../config/connect.php"; //arquivo que contém a conexão com o Banco.



if ( $_POST[btn_enviar] == "Gravar" ){



	$cod_funcao  = $_POST["cod_funcao"]; 

	$dsc_funcao = $_POST["dsc_funcao"];

	$nome_funcao = $_POST["nome_funcao"];



	$query_busca="SELECT cod_funcao FROM funcao WHERE cod_funcao = ".$cod_funcao; //query que verifica se código já esta cadastrado



	$result_busca = pg_query($query_busca) //executa query

		or die ("Erro na busca da tabela FUNÇÃO. ==> " . pg_last_error($connect)); //mostra erro



	$row_busca = pg_fetch_array($result_busca); // recebe o resultado da query (linhas)

	

	if ($teste_busca = pg_num_rows($result_busca) < 1) { // se não teve mais de uma linha



		$query_funcao = "insert into funcao (cod_funcao, dsc_funcao, nome_funcao) 

		values ($cod_funcao,'$dsc_funcao', '$nome_funcao')";



		$result_funcao = pg_query($query_funcao)

			or die("Erro na query: $query_funcao".pg_last_error($connect));



		echo '<script> alert("FUNÇÃO Cadastrada com Sucesso!");</script>';



		header("location: alt_funcao.php?funcao=$cod_funcao");

	}



}

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

<form name="frm_funcao" action="cad_funcao.php" method="post">

	<table align="center" width="800" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">

		<tr>

			<th colspan="2" bgcolor="#009966"> <br><h3>Cadastro de Função:</h3><br></th>

		</tr>

		<tr>

			<td colspan="2" >&nbsp;</td>

		</tr>

		<?php

			$query_max = "SELECT max(cod_funcao) as cod_funcao FROM funcao";

		

			$result_max = pg_query($query_max) //executa query

				or die ("Erro na busca da tabela FUNÇÃO. ==> " . pg_last_error($connect)); //mostra erro

		

			$row_max = pg_fetch_array($result_max); // recebe o resultado da query (linhas)

		?>

		<tr>

			<td align="right" valign="top"><strong>Código:&nbsp;&nbsp;&nbsp;</strong></td>

			<td >&nbsp;&nbsp;<input type="text" name="cod_funcao" size="5" value="<?php echo ($row_max[cod_funcao] + 1)?>" readonly="true"><br> &nbsp;</td>

		</tr>

		<tr>

			<td align="right" valign="top"><strong>Nome:&nbsp;&nbsp;&nbsp;</strong></td>

			<td >&nbsp;&nbsp;<textarea name="nome_funcao" rows="5" style="background:#FFFFCC; width:350px; font-size:12px;"><?PHP echo $_GET['fun'];?></textarea> <br> &nbsp;</td>

		</tr>

		<tr>

			<td align="right" valign="top"><strong>Din&acirc;mica da Fun&ccedil;&atilde;o:&nbsp;&nbsp;&nbsp;</strong></td>

			<td>&nbsp;&nbsp;<textarea name="dsc_funcao" rows="5" style="background:#FFFFCC; width:350px; font-size:12px;"><?PHP echo $_GET['din'];?></textarea><br> &nbsp;</td>

		</tr>

		<tr>

			<td colspan="2" >&nbsp;</td>

		</tr>

		<tr>

			<th colspan="2" bgcolor="#009966">

			<br>

				<input type="submit" value="Gravar" name="btn_enviar" style="width:100;">

				&nbsp;&nbsp;&nbsp;

				<input type="reset"  value="Limpar" style="width:100;">

				&nbsp;&nbsp;&nbsp;

				<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','lista_funcao.php');return document.MM_returnValue;" style="width:100;">

			<br>&nbsp;

			</th>

		</tr>

		<tr>

			<td colspan="2" >&nbsp;</td>

		</tr>

  </table>

</form>

</body>

</html>
