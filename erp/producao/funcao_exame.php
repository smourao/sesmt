<?php
include "sessao.php";
include "../config/connect.php";

$erro = "";

if ($_GET){
	$funcao = $_GET[funcao];
}else{
	$funcao = $_POST[funcao];
}

if ( $_POST["enviar"]=="Gravar" )
{ // verificar se houve o comando de enviar
	$sql = "update funcao set funcao_exame = '$_POST[funcao_exame]' where cod_funcao = $funcao;";
	$result_sql = pg_query($connect, $sql)
		or die ( "Erro na query: $sql ==> ".pg_last_error($connect) );

	if ($result_sql){
		echo "<script>alert('Exames atualizados com sucesso!');</script>";
	}
}

///////////////////////// pra buscar os dados de função
$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao, funcao_exame FROM funcao where cod_funcao = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);
/************************************************************************************/

//***********************************************************************************
// SLAYER
//***********************************************************************************
//$sql = "SELECT exame_id FROM funcao_exame WHERE cod_exame=".$funcao;
$sql = "SELECT * FROM exame WHERE cod_exame NOT IN (SELECT exame_id FROM funcao_exame WHERE cod_exame=".$funcao.") ORDER BY especialidade";// WHERE cod_exame não esteja sendo exibido
$res = pg_query($connect, $sql);
$buffer = pg_fetch_all($res);
?>

<html>
<header>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js" charset="iso-8859-1">
</script>
</header>
<title>..:: SESMT &gt;&gt; Fun&ccedil;&atilde;o - Exame ::..</title>
<body OnLoad="remove_exa(-1);" bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<form action="funcao_exame.php" method="post" name="frm_associacao">
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center" bgcolor="#009966"><br>
		<h2>Exames indicados para a  Função</h2>
		<br></td>
	</tr>
	<tr>
		<td width="400" align="center"><h3>FUNÇÃO</h3></td>
		<td width="400" align="center"><h3>EXAMES</h3></td>
	</tr>
	<tr>
		<td>
			<input type="hidden" name="funcao" value="<?php echo $funcao; ?>">
			&nbsp;&nbsp;Função: <br>&nbsp;&nbsp;&nbsp;
			<textarea name="nome_funcao" rows="5" style="background:#FFFFCC; width:350px; font-size:12px;" readonly><?php echo $row_funcao[nome_funcao]?></textarea><p>
			&nbsp;&nbsp;Dinâmica da Função: <br>&nbsp;&nbsp;&nbsp;
			<textarea rows="5" name="dsc_funcao" readonly style="background:#FFFFCC; font-size:12px; width:350px;"><?php echo $row_funcao[dsc_funcao]; ?></textarea>
			<br>&nbsp;
		</td>
		<td align="center">
  	<div id="cadastrados">
             <?PHP echo $text;?>
        </div>
            <input type=hidden id=cod_exa name=cod_exa value="<?PHP echo $funcao;?>">

<?PHP
echo "<select name=\"funcao_exame\" id=\"funcao_exame\" >";
for($x=0;$x<pg_num_rows($res);$x++){
    echo "<option value='{$buffer[$x]['cod_exame']}'>{$buffer[$x]['especialidade']}</option>";
}
echo "</select>";
?>
<!--<textarea name="funcao_exame" id="funcao_exame" rows="2" style="width:350px; font-size:12px;">
<?php //echo $row_funcao[funcao_exame]; ?>
</textarea>-->
<br>&nbsp;

            <input type=button value="Cadastrar" name="exa_new" id="exa_new" OnClick="save_exa();">

		</td>
	</tr>
	<tr>
		<th colspan="2" bgcolor="#009966">
			<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','funcao_medi.php?funcao=<?php echo $funcao; ?>');return document.MM_returnValue;" style="width:100;">
            <!--
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="enviar" value="Gravar" style="width:100;">
			-->
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="limpar" value="Limpar" style="width:100;">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input name="btn_epi_funcao" type="button" id="btn_novo" onClick="MM_goToURL('parent','funcao_curso.php?funcao=<?php echo $funcao; ?>'); return document.MM_returnValue" value="Avançar >>" style="width:100;">
		</th>
	</tr>
</table>
<p>
</form>
</body>
</html>
