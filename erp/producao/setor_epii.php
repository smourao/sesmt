<?php
include "sessao.php";
include "../config/connect.php";
$erro = "";
if ($_GET){
	$setor = $_GET[setor];
}else{
	$setor = $_POST[setor];
}

///////////////////////// pra buscar os dados de função
$sql = "select * FROM setor where cod_setor = $setor";
$result = pg_query($sql);
$row = pg_fetch_array($result);

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

function sug_epi(){
times = 0;
var url = "sug_epi.php?texto="+document.getElementById('funcao').value;
url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
http.open("GET", url, true);
http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
http.setRequestHeader("Pragma", "no-cache");
http.onreadystatechange = sug_epi_result;
http.send(null);
}

function sug_epi_result(){
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

<title>..:: SESMT &gt;&gt; Setor - EPI  ::..</title>
</head>
<body OnLoad="remove_setor_epi(-1);" bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<form action="funcao_epi.php" method="post" name="frm_associacao">
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0" id=tbl name=tbl>
	<tr>
		<td colspan="2" align="center" bgcolor="#009966"><br>
		<h2>Equipamentos indicados para o Setor </h2>
		<br></td>
	</tr>
	<tr>
		<td width="400" align="center"><h3>SETOR</h3></td>
		<td width="400" align="center"><h3>EPI</h3></td>
	</tr>
	<tr>
		<td valign=top>
			<input type="hidden" name="setor_id" value="<?php echo $setor; ?>">
			&nbsp;&nbsp;Setor: <br>&nbsp;&nbsp;&nbsp;
			<textarea name="nome_setor" rows="5" style="background:#FFFFCC; width:350px; font-size:12px;"  readonly><?php echo $row[nome_setor]?></textarea><p>
			&nbsp;&nbsp;Descrição do Setor: <br>&nbsp;&nbsp;&nbsp;
			<textarea rows="5" name="dsc_setor" readonly style="background:#FFFFCC; font-size:12px; width:350px;"><?php echo $row[desc_setor]; ?></textarea>
			<br>&nbsp;
		</td>
		<td>
		<!-- TABELA DE EPI CADASTRADOS-->
         <div id="cadastrados">
            <?PHP echo $text;?>
         </div>
       		<!-- FIM DA TABELA-->
        <p>
           <center>
           <input type=hidden id=cod_epi name=cod_epi value="<?PHP echo $setor;?>">
        Equipamento de proteção Individual: <br>
			<textarea onkeyup="sug_epi();" name="funcao" id="funcao" rows="2" style="width:350px; font-size:12px;"><?php echo $row[setor_epi]; ?></textarea> <br>&nbsp;
           <input type=button value="Cadastrar" name="cad_new" id="cad_new" OnClick="save_setor_epi();">
           <input type=hidden name=cod_prod id=cod_prod value="">
           <br>
              <!-- TABELA CO SUGESTÕES - AJAX POWER GUIDO -->
              <div id=sgt name=sgt style="display: none;position: relative; border: 0px solid; width: 100%; height: 100%;background-color: #009966;">
               <center><font size=1 color=white><i>Atualizando...</i></font></center>
              </div>
              
		</td>
	</tr>
	<tr>
		<th colspan="2" bgcolor="#009966">
			<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="location.href='cad_setor.php?setor=<?php echo $setor; ?>';" style="width:100;">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="limpar" value="Limpar" style="width:100;">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="Sair" value="Sair" style="width:100;" onclick="location.href='lista_setor.php'">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input name="btn_epi_funcao" type="button" id="btn_novo" onClick="location.href='av_setor_ambiente.php?setor=<?php echo $setor; ?>';" value="Avançar >>" style="width:100;">

		</th>
	</tr>
</table>
<p>
</form>
</body>
</html>
