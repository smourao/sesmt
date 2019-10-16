<?php
session_start();
include "../functions.php";

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

// CONFIGURAÇÃO MESES E ANOS
if(!isset($_SESSION[mtreinamento])){
    $_SESSION[mtreinamento] = date("m");
}
if(!isset($_SESSION[ytreinamento])){
    $_SESSION[ytreinamento] = date("Y");
}
if(isset($_GET['m'])){
    $mes = $_GET['m'];
    $_SESSION[mtreinamento] = $mes;
}else{
    if(isset($_SESSION[mtreinamento])){
        $mes = $_SESSION[mtreinamento];
    }else{
        $mes = date("m");
    }
}
if(isset($_GET['y'])){
    $ano = $_GET['y'];
    $_SESSION[ytreinamento] = $ano;
}else{
    if(isset($_SESSION[ytreinamento])){
        $ano = $_SESSION[ytreinamento];
    }else{
        $ano = date("Y");
    }
}

   if($mes >= 12){
      $n_mes = 01;
      $n_ano = $ano+1;
      $p_mes = $mes-1;
      $p_ano = $ano;
   }elseif($mes <= 01){
     $n_mes = $mes+1;
     $n_ano = $ano;
     $p_mes = 12;
     $p_ano = $ano-1;
   }else{
      $n_mes = STR_PAD($mes+1, 2, "0", STR_PAD_LEFT);
      $n_ano = $ano;
      $p_mes = STR_PAD($mes-1, 2, "0", STR_PAD_LEFT);
      $p_ano = $ano;
   }

   $p_ano = STR_PAD($p_ano, 2, "0", STR_PAD_LEFT);
   $p_mes = STR_PAD($p_mes, 2, "0", STR_PAD_LEFT);
   $n_ano = STR_PAD($n_ano, 2, "0", STR_PAD_LEFT);
   $n_mes = STR_PAD($n_mes, 2, "0", STR_PAD_LEFT);


if(!isset($_SESSION[usuario_id])){
    header('Location: http://www.sesmt-rio.com/erp/index.php?sessao=0');
}
include "../config/connect.php";

$orc = $_GET['orcamento'];
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
<title>Treinamento</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../orc.js"></script>
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="../js.js"></script>
<script language="javascript" src="../screen.js"></script>
<script language="javascript" src="bt.js"></script>
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
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<center><h2><a name=top>SESMT - Segurança do Trabalho</a></h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966">
        <br>TREINAMENTO<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
   			    <!--
                <input name="btn_listar" type="button" id="btn_listar" onClick="location.href='?action=list'" value="Listar" style="width:100;">
				<input name="btn_add" type="button" id="btn_add" onClick="location.href='?action=new_curso'" value="Novo Curso" style="width:100;">
                -->
                <input name="btn_add" type="button" id="btn_ini" onClick="location.href='?action=list'" value="Início" style="width:120;">
                <input name="btn_add" type="button" id="btn_add" onClick="location.href='?action=new'" value="Novo Treinamento" style="width:120;">
                <input name="btn_add" type="button" id="btn_add" onClick="location.href='?action=new_curso'" value="Novo Curso" style="width:120;">
                <input name="btn_sair" type="button" id="btn_sair" onClick="location.href='../tela_principal.php'" value="Sair" style="width:120;">
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

