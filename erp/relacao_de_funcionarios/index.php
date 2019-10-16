<?php
session_start();
if(!isset($_SESSION[usuario_id])){
    header('Location: http://www.sesmt-rio.com/erp/index.php?sessao=0');
}
include "../functions.php";
include "../config/connect.php";

$bgred = '#D75757';
$bggreen = '#006633';

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

function anti_injection($sql)
{
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
    $sql = trim($sql);//limpa espaços vazio
    $sql = strip_tags($sql);//tira tags html e php
    $sql = addslashes($sql);//Adiciona barras invertidas a uma string
    return $sql;
}
?>
<html>
<head>
<title>Relação de Funcionários</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="../js.js"></script>
<script language="javascript" src="../screen.js"></script>
<script language="javascript" src="../ajax.js"></script>
<style type="text/css" title="mystyles" media="all">
<!--
loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

loading_done{
position: relative;
display: none;
}

td.por{
    background-color: #000000;
}
td.por2{
    background-color: #66000A;
}

table.tmsg{
    border: 2px solid #000000;
}
td.msg1{
    background-image: url('msgbg1.jpg');
    background-repeat: repeat-x;
    font-size: 12px;
}
td.msg2{
    background-image: url('msgbg1.jpg');
    background-repeat: repeat-x;
    font-size: 12px;
}

-->
</style>
<script>
function show_cep(){
var url = "../findit.php?id="+document.getElementById("cep").value;
http.open("GET", url, true);
http.onreadystatechange = show_cep_reply;
http.send(null);
}

function show_cep_reply(){
if(http.readyState == 4)
{
    var msg = http.responseText;
	var data = msg.split("|");
	//alert(data[1]);
    document.getElementById("endereco").value = data[1];
	document.getElementById("bairro").value = data[2].toString();
	document.getElementById("cidade").value = data[3].toString();
	document.getElementById("estado").value = data[4].toString();
}else{
 if (http.readyState==1){
        document.getElementById("endereco").value = 'atualizando...';
		document.getElementById("bairro").value = 'atualizando...';
		document.getElementById("cidade").value = 'atualizando...';
		document.getElementById("estado").value = 'atualizando...';
    }
 }

}
</script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<center><h2><a name=top>SESMT - Segurança do Trabalho</a></h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966">
        <br>RELAÇÃO DE FUNCIONÁRIOS<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
                <input name="btn_add" type="button" id="btn_ini" onClick="location.href='?action=list&cod_cliente=<?PHP echo $_GET[cod_cliente];?>&cod_filial=<?PHP echo $_GET[cod_filial];?>'" value="Início" style="width:120;">
                <input name="btn_add" type="button" id="btn_add" onClick="location.href='?action=new&cod_cliente=<?PHP echo $_GET[cod_cliente];?>&cod_filial=<?PHP echo $_GET[cod_filial];?>'" value="Novo Cadastro" style="width:120;">
                <input name="btn_sair" type="button" id="btn_sair" onClick="location.href='../cadastro_cliente.php?cliente_id=<?PHP echo $_GET[cod_cliente];?>&filial_id=<?PHP echo $_GET[cod_filial];?>'" value="Sair" style="width:120;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="5" class="linhatopodiresq">
<p>
<table width=100% border=0 cellspacing=2 cellpading=5 id=maint>
<tr>
   <td valign=middle id=ls>
<?PHP
$sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
    $result = pg_query($sql);
    $empresa = pg_fetch_array($result);
    echo "<center><b>$empresa[razao_social]</b></center><BR>";
$p = "./".$_GET['action'].'.php';
if(file_exists($p)){
    include($p);
}else{
    include('list.php');
}
?>
	 </td>
    </tr>
</table>
</body>
</html>

