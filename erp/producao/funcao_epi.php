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

<title>..:: SESMT &gt;&gt; Fun&ccedil;&atilde;o - EPI  ::..</title>
</head>
<body OnLoad="remove_epi(-1);" bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
&nbsp;<p>
<center><h2>SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<form action="funcao_epi.php" method="post" name="frm_associacao">
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0" id=tbl name=tbl>
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
		<td valign=top>
			<input type="hidden" name="funcao_id" value="<?php echo $funcao; ?>">
			&nbsp;&nbsp;Função: <br>&nbsp;&nbsp;&nbsp;
			<textarea name="nome_funcao" rows="5" style="background:#FFFFCC; width:350px; font-size:12px;"  readonly><?php echo $row_funcao[nome_funcao]?></textarea><p>
			&nbsp;&nbsp;Dinâmica da Função: <br>&nbsp;&nbsp;&nbsp;
			<textarea rows="5" name="dsc_funcao" readonly style="background:#FFFFCC; font-size:12px; width:350px;"><?php echo $row_funcao[dsc_funcao]; ?></textarea>
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
           <input type=hidden id=cod_epi name=cod_epi value="<?PHP echo $funcao;?>">
        Equipamento de proteção Individual: <br>
			<textarea onkeyup="sug_epi();" name="funcao" id="funcao" rows="2" style="width:350px; font-size:12px;"><?php echo $row_funcao[funcao_epi]; ?></textarea> <br>&nbsp;
           <input type=button value="Cadastrar" name="cad_new" id="cad_new" OnClick="savedata();">
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
			<input type="button" name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','alt_funcao.php?funcao=<?php echo $funcao; ?>');return document.MM_returnValue;" style="width:100;">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="limpar" value="Limpar" style="width:100;">
			&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input name="btn_epi_funcao" type="button" id="btn_novo" onClick="MM_goToURL('parent','av_ambiente.php?funcao=<?php echo $funcao; ?>'); return document.MM_returnValue" value="Avançar >>" style="width:100;">
		</th>
	</tr>
</table>
<p>
</form>
</body>
</html>
