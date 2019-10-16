<?php
include "sessao.php";
include "../config/connect.php";

$erro = "";

if ($_GET){
	$funcao = $_GET[setor];
}else{
	$funcao = $_POST[funcao];
}


///////////////////////// pra buscar os dados de função
$query_funcao = "select * FROM setor where cod_setor = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);
/************************************************************************************/

//***********************************************************************************
// SLAYER
//***********************************************************************************
//$sql = "SELECT exame_id FROM funcao_exame WHERE cod_exame=".$funcao;
$sql = "SELECT * FROM exame WHERE cod_exame NOT IN (SELECT exame_id FROM setor_exame WHERE cod_exame=".$funcao.") ORDER BY especialidade";// WHERE cod_exame não esteja sendo exibido
$res = pg_query($connect, $sql);
$buffer = pg_fetch_all($res);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js" charset="iso-8859-1">
</script>
</head>
<title>..:: SESMT &gt;&gt; Setor - Exame ::..</title>
<body OnLoad="remove_setor_exa(-1);" bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<form method="post" name="frm_associacao">
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center" bgcolor="#009966"><br>
		<h2>Exames indicados para o Setor</h2>
		<br></td>
	</tr>
	<tr>
		<td width="400" align="center"><h3>SETOR</h3></td>
		<td width="400" align="center"><h3>EXAMES</h3></td>
	</tr>
	<tr>
		<td>
			<input type="hidden" name="funcao" value="<?php echo $funcao; ?>">
			&nbsp;&nbsp;Setor: <br>&nbsp;&nbsp;&nbsp;
			<textarea name="nome_funcao" rows="5" style="background:#FFFFCC; width:350px; font-size:12px;" readonly><?php echo $row_funcao[nome_setor]?></textarea><p>
			&nbsp;&nbsp;Descrição do Setor: <br>&nbsp;&nbsp;&nbsp;
			<textarea rows="5" name="dsc_funcao" readonly style="background:#FFFFCC; font-size:12px; width:350px;"><?php echo $row_funcao[desc_setor]; ?></textarea>
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

<br>&nbsp;

            <input type=button value="Cadastrar" name="exa_new" id="exa_new" OnClick="save_setor_exa();">

		</td>
	</tr>
	<tr>
		<th colspan="2" bgcolor="#009966">
			<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="location.href='funcao_setor_medi.php?setor=<?php echo $funcao; ?>';" style="width:100;">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="limpar" value="Limpar" style="width:100;">
   			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
      		<input type="button" name="Sair" value="Sair" style="width:100;" onclick="location.href='lista_setor.php'">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input name="btn_epi_funcao" type="button" id="btn_novo" onClick="location.href='visualizar_setor.php?setor=<?php echo $funcao; ?>';" value="Avançar >>" style="width:100;">
		</th>
	</tr>
</table>
<p>
</form>
</body>
</html>
