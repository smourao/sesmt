<?php
include "sessao.php";
include "../config/connect.php";

$erro = "";

if ($_GET){
	$funcao = $_GET[setor];
}else{
	$funcao = $_POST[setor];
}
///////////////////////// pra buscar os dados de função
$query_funcao = "select * FROM setor where cod_setor = $funcao";
$result_funcao = pg_query($connect, $query_funcao)
	or die ("Erro na query: $query_funcao ==> ".pg_last_error($connect));
$row_funcao = pg_fetch_array($result_funcao);
/************************************************************************************/
?>
<html>
<head>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">
body { behavior:url("../csshover.htc"); }
td.hl1{
   background-color: #009966;
}

td.hl1:hover{
   background-color: #1f7c5d;
}
</style>

<script language="javascript" src="../scripts.js"></script>
<script language="javascript">
if(times){
}else{
   var times = 0;
}

function sug_complementares(){
times = 0;
var url = "sug_complementares.php?texto="+document.getElementById('funcao_programas').value;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
http.setRequestHeader("Pragma", "no-cache");
http.onreadystatechange = sug_complementares_result;
http.send(null);
}

function sug_complementares_result(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    document.getElementById('sgt').innerHTML = msg;
    //alert(times);
}else{
    times = times +1;
    if (http.readyState==1){
       document.getElementById('sgt').style.display = 'block';
       //document.getElementById('sgt').innerHTML = "<center><font size=1 color=white><i>Atualizando...</i></font></center>";
    }
 }
}
</script>
<title>..:: SESMT &gt;&gt; SETOR - PROGRAMAS COMPLEMENTARES ::..</title>
</head>
<body OnLoad="remove_setor_programas(-1);" bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>

<form action="prog_complementares.php" method="post" name="frm_associacao">
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="center" bgcolor="#009966"><br>
		<h2>Programas indicados para o Setor</h2>
		<br></td>
	</tr>
	<tr>
		<td width="400" align="center"><h3>SETOR</h3></td>
		<td width="400" align="center"><h3>PROGRAMAS COMPLEMENTARES</h3></td>
	</tr>
	<tr>
		<td>
			<input type="hidden" name="funcao" value="<?php echo $funcao;?>" >
			&nbsp;&nbsp;Setor: <br>&nbsp;&nbsp;&nbsp;
           <textarea name="nome_funcao" rows="5" style="background:#FFFFCC; width:350px; font-size:12px;" readonly><?php echo $row_funcao[nome_setor]?></textarea><p>
			&nbsp;&nbsp;Descrição do Setor: <br>&nbsp;&nbsp;&nbsp;
			<textarea rows="5" name="dsc_funcao" readonly style="background:#FFFFCC; font-size:12px; width:350px;"><?php echo $row_funcao[desc_setor]; ?></textarea>
			<input type=hidden name=cod_prod id=cod_prod value="">
			<br>&nbsp;
		</td>
		<td align="center">
		<div id="cadastrados">
             <?PHP echo $text;?>
        </div>
            <input type=hidden id=cod_funcao name=cod_funcao value="<?PHP echo $funcao;?>">
			<textarea onkeyup="sug_complementares();" name="funcao_programas" id="funcao_programas" rows="2" style="width:350px; font-size:12px;"></textarea> <br>&nbsp;
            <input type=button value="Cadastrar" name="programas_new" id="programas_new" OnClick="save_setor_programas();">
            <br>
              <!-- TABELA CO SUGESTÕES - AJAX POWER GUIDO -->
            <div id=sgt name=sgt style="display: none;position: relative; border: 0px solid; width: 100%; height: 100%;background-color: #009966;">
               <center><font size=1 color=white><i>Atualizando...</i></font></center>
            </div>
        </td>
	</tr>
	<tr>
		<th colspan="2" bgcolor="#009966">
			<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="location.href='av_setor_ambiente.php?setor=<?php echo $funcao;?>';" style="width:100;">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="limpar" value="Limpar" style="width:100;">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
   		    <input type="button" name="Sair" value="Sair" style="width:100;" onclick="location.href='lista_setor.php'">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input name="avancar" type="button" id="btn_novo" onClick="location.href='funcao_setor_medi.php?setor=<?php echo $funcao;?>';" value="Avançar >>" style="width:100;">
	</tr>
</table>
<p>
</form>
</body>
</html>
