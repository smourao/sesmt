<?php
session_start();
function romano($N){
        $N1 = $N;
        $Y = "";
        while ($N/1000 >= 1) {$Y .= "M"; $N = $N-1000;}
        if ($N/900 >= 1) {$Y .= "CM"; $N=$N-900;}
        if ($N/500 >= 1) {$Y .= "D"; $N=$N-500;}
        if ($N/400 >= 1) {$Y .= "CD"; $N=$N-400;}
        while ($N/100 >= 1) {$Y .= "C"; $N = $N-100;}
        if ($N/90 >= 1) {$Y .= "XC"; $N=$N-90;}
        if ($N/50 >= 1) {$Y .= "L"; $N=$N-50;}
        if ($N/40 >= 1) {$Y .= "XL"; $N=$N-40;}
        while ($N/10 >= 1) {$Y .= "X"; $N = $N-10;}
        if ($N/9 >= 1) {$Y .= "IX"; $N=$N-9;}
        if ($N/5 >= 1) {$Y .= "V"; $N=$N-5;}
        if ($N/4 >= 1) {$Y .= "IV"; $N=$N-4;}
        while ($N >= 1) {$Y .= "I"; $N = $N-1;}
        return $Y;
}

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

// CONFIGURAÇÃO MESES E ANOS
if(!isset($_SESSION[m])){
    $_SESSION[m] = date("m");
}
if(!isset($_SESSION[y])){
    $_SESSION[y] = date("Y");
}
if(isset($_GET['m'])){
    $mes = $_GET['m'];
    $_SESSION[m] = $mes;
}else{
    if(isset($_SESSION[m])){
        $mes = $_SESSION[m];
    }else{
        $mes = date("m");
    }
}
if(isset($_GET['y'])){
    $ano = $_GET['y'];
    $_SESSION[y] = $ano;
}else{
    if(isset($_SESSION[y])){
        $ano = $_SESSION[y];
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

function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", "pca",//Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", "pca,", //Siglas com vírgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", "(pca)", //Siglas entre parênteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "nbr", "nbr.", "a0", "a3", "a4", "(a4)"); //Siglas diversas
$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $at[$x] = strtolower($at[$x]);

  if(in_array($at[$x], $siglas)){
     $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>3){
        $at[$x] = ucwords($at[$x]);
    }

    $temp .= $at[$x]." ";
}
return $temp;
}

function anti_injection($sql)
{
    // remove palavras que contenham sintaxe sql
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
    $sql = trim($sql);//limpa espaços vazio
    $sql = strip_tags($sql);//tira tags html e php
    $sql = addslashes($sql);//Adiciona barras invertidas a uma string
    return $sql;
}
?>
<html>
<head>
<title>Biblioteca Técnica</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../orc.js"></script>
<script language="javascript" src="../scripts.js"></script>
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
        <br>BIBLIOTECA TÉCNICA<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
   			    <input name="btn_listar" type="button" id="btn_listar" onClick="location.href='?action=list'" value="Listar" style="width:100;">
				<input name="btn_add" type="button" id="btn_add" onClick="location.href='?action=new'" value="Novo Registro" style="width:100;">
				<input name="btn_add" type="button" id="btn_add" onClick="location.href='?action=new_curso'" value="Novo Curso" style="width:100;">
                <input name="btn_sair" type="button" id="btn_sair" onClick="location.href='../tela_principal.php'" value="Sair" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="5" class="linhatopodiresq">
<p>
<table width=100% border=0 cellspacing=2 cellpading=5 id=maint>
<tr>
   <td valign=top id=ls>
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

