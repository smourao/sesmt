<?php
include "sessao.php";
include "../config/connect.php";
$erro = "";

if ($_GET){
	$funcao = $_GET[funcao];
}else{
	$funcao = $_POST[funcao];
}

if($_POST){
$items = array("Álcool 70%", "Algodão em golinha", "Gases", "Cotonete", "Atadura",
"Reparil Gel (Hematomas)",
"Esparadrapo", "Tesoura", "Solução anti séptica (Povedine)", "Termômetro", "Água Oxigenada",
"Soro Fisiológico (Limpeza de ferimentos)", "Luva Descartável", "Pinça", "Repelente de Insetos",
"Curativo adesivo tipo band-aid", "relação dos materiais e quantidade contida no armário.",
"controle de retirada", "Vaselina liquida ou Dersani (para queimaduras)");


for($x=0;$x<count($items);$x++){
   $sql = "SELECT * FROM funcao_medi WHERE cod_medi = {$cod_medi} AND descricao = '{$items[$x]}'";
   $result = pg_query($connect, $sql);
   if(pg_num_rows($result) < 1){
       $sql="INSERT INTO funcao_medi (cod_medi, descricao)values({$cod_medi}, '{$items[$x]}')";
       $result = pg_query($connect, $sql);
   }
}
}
/*
if ( $_POST["enviar"]=="Gravar" )
{ // verificar se houve o comando de enviar
	$sql = "update funcao set funcao_medi = '$_POST[funcao_medi]' where cod_funcao = $funcao;";
	$result_sql = pg_query($connect, $sql)
		or die ( "Erro na query: $sql ==> ".pg_last_error($connect) );

	if ($result_sql){
		echo "<script>alert('Medicamentos atualizados com sucesso!');</script>";
	}
}
  */
  
///////////////////////// pra buscar os dados de função
$query_funcao = "select cod_funcao, dsc_funcao, nome_funcao, funcao_medi FROM funcao where cod_funcao = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);
/************************************************************************************/
?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
<title>..:: SESMT &gt;&gt; Fun&ccedil;&atilde;o - Kit de Primeiros Socorros ::..</title>
</header>
<body OnLoad="remove_medi(-1);" bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<form action="funcao_medi.php" method="post" name="frm_associacao">
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center" bgcolor="#009966"><br>
		<h2>Kit de Primeiros Socorros</h2>
		<br></td>
	</tr>
	<tr>
		<td width="400" align="center"><h3>FUNÇÃO</h3></td>
		<td width="400" align="center"><h3>COMPONENTES</h3></td>
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
            <input type=hidden id=cod_medi name=cod_medi value="<?PHP echo $funcao;?>">
			<textarea name="funcao_medi" id="funcao_medi" rows="2" style="width:350px; font-size:12px;"></textarea> <br>&nbsp;
			<input type=button value="Cadastrar" name="med_new" id="med_new" OnClick="save_medi();">
<form method=post>
			<input type=submit value="Cadastrar Kit Básico">
</form>

		</td>
	</tr>
	<tr>
		<th colspan="2" bgcolor="#009966">
			<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','prog_complementares.php?funcao=<?php echo $funcao; ?>');return document.MM_returnValue;" style="width:100;">
            <!--
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="enviar" value="Gravar" style="width:100;">
			-->
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="limpar" value="Limpar" style="width:100;">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input name="btn_epi_funcao" type="button" id="btn_novo" onClick="MM_goToURL('parent','funcao_exame.php?funcao=<?php echo $funcao; ?>'); return document.MM_returnValue" value="Avançar >>" style="width:100;">
		</th>
	</tr>
</table>
<p>
</form>
</body>
</html>
