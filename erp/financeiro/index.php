<?PHP
session_start();
include("include/db.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SESMT - Segurança do Trabalho e Medicina Ocupacional ::</title>
<script type="text/javascript" src="java.js"></script>
<script type="text/javascript" src="include/java/flash.js"></script>
<script type="text/javascript" src="include/java/ajax.js"></script>
<script type="text/javascript" src="include/java/mm_css_menu.js"></script>
<script type="text/javascript" src="include/java/js.js"></script>
<script type="text/javascript" src="include/java/java.js"></script>
<script type="text/javascript" src="include/java/keyboard.js"></script>
<script type="text/javascript" src="f.js"></script>
<script type="text/javascript" src="mmd.js"></script>
<script type="text/javascript" src="../screen.js"></script>
<style type="text/css" media="screen">
@import url("include/css/css.css");
body{
 font-family: verdana;
 /*color: #FFFFFF;*/
 font-size: 12px;
}
td{
 font-family: verdana;
 /*color: #FFFFFF;*/
 font-size: 12px;
}
.excluir{
 font-family: verdana;
 color: #FF0000;
 font-size: 12px;
}
.excluir:hover{
 font-family: verdana;
 color: #fa3d3d;
 font-size: 12px;
}
.concluido{
 font-family: verdana;
 color: #008000;
 font-size: 12px;
}
.concluido:hover{
 font-family: verdana;
 color: #2a9d2a;
 font-size: 12px;
}
#loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}
#loading_done{
position: relative;
display: none;
}
.trans{
filter:alpha(opacity=95);
-moz-opacity:0.95;
-khtml-opacity: 0.95;
opacity: 0.95;
}
.relatorio {
position: absolute;
border: 3px solid black;
background: #097b42;
color: #FFFFFF;
width: 300px;
height: 400px;
}
</style>
<style>
.dia {font-family: helvetica, arial; font-size: 8pt; color: #FFFFFF;}
.data {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970;}
.data:hover{font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#000000; font-weight:bold;}
.mes {font-family: helvetica, arial; font-size: 8pt;}
.Cabecalho_Calendario {font-family: helvetica, arial; font-size: 10pt; color: #000000; text-decoration:none; font-weight:bold;}
.Cabecalho_Calendario:hover{font-family: helvetica, arial; font-size: 10pt; color: #000000; text-decoration:none; font-weight:bold;}
.mes {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970;}
.mes:hover {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970; font-weight:bold;}
</style>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">

<div id="test" class="relatorio trans" style="display:block;">
   <!-- ### DIV - TITULO DA JANELA -->
   <div id=titulo name=titulo style="background: #000000;">
      <table width=100%>
      <tr>
         <td class=fontebranca><b>Alertas</b></td>
         <td align=right width=60 valign=center>
            <img src="../images/minimizar.jpg" style="cursor:pointer;" onClick="minimize();">
            <img src="../images/restaurar.jpg" style="cursor:pointer;" onClick="maximize();">
            <img src="../images/fechar.jpg" style="cursor:pointer;" onClick="document.getElementById('test').style.display='none';">
         </td>
      </tr>
      </table>
   </div>
   <div id=cont>
      <iframe name='calert' id='calert' src='calert.php' style="width: 100%; height: 380px;" frameborder=0></iframe>
   </div>
</div>

<script type="text/javascript">
function adjust(){
  var scrOfX = 0, scrOfY = 0;
  var dv = document.getElementById("test");
  var cn = document.getElementById("cont");
  var h = 0;
  if(cn.style.display == "none"){
     h = 20;
  }else{
     h = 400;
  }
  if( typeof( window.pageYOffset ) == 'number' ) {
    scrOfY = window.pageYOffset;    //Netscape compliant
    scrOfX = window.pageXOffset;
    dv.style.left = getWidth() - 323 + scrOfX + "px";
    dv.style.top = getHeight() - h -10 + scrOfY + "px";
  }else{
    scrOfY = document.body.scrollTop;    //DOM compliant
    scrOfX = document.body.scrollLeft;
    dv.style.left = getWidth() - 300 + scrOfX + "px";
    dv.style.top = getHeight() - h + scrOfY + "px";
  }
/*
  } else if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) ) {
    scrOfY = document.body.scrollTop;    //DOM compliant
    scrOfX = document.body.scrollLeft;
    dv.style.left = getWidth() - 300 + scrOfX + "px";
    dv.style.top = getHeight() - h + scrOfY + "px";
  } else if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) ) {
    scrOfY = document.documentElement.scrollTop;    //IE6 standards compliant mode
    scrOfX = document.documentElement.scrollLeft;
    dv.style.left = getWidth() - 300 + scrOfX + "px";
    dv.style.top = getHeight() - h + scrOfY + "px";
  }
*/
}

function minimize(){
   var dv = document.getElementById("test");
   var cn = document.getElementById("cont");
   cn.style.display = 'none';
   dv.style.height = 20 + "px";
   adjust();
}

function maximize(){
   var dv = document.getElementById("test");
   var cn = document.getElementById("cont");
   dv.style.height = 400 + "px";
   cn.style.display = 'block';
   adjust();
}

//setTimeout("adjust()", 1000);
window.onload = function(){adjust()};
window.onscroll = function(){adjust()};
window.onresize = function(){adjust()};
minimize();
</script>
<?PHP

    $diav = date("d");
    $mesv = date("m");
    $anov = date("Y");

$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   EXTRACT(day FROM f.vencimento) = '{$diav}' AND
   EXTRACT(month FROM f.vencimento) = '{$mesv}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   EXTRACT(year FROM f.vencimento) = '{$anov}' AND
   (i.id = f.cod_fatura ) AND
   i.status = 1 AND
   f.pago = 0
   ORDER BY
   f.vencimento
";
$result = pg_query($sql);
if(pg_num_rows($result)>0){
   echo "<script>maximize();</script>";
}
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   EXTRACT(day FROM f.vencimento) = '".date("d", mktime(0,0,0,$mesv,$diav+1,$anov))."' AND
   EXTRACT(month FROM f.vencimento) = '".date("m", mktime(0,0,0,$mesv,$diav+1,$anov))."' AND -- SELECIONA APENAS O MES ESPECÍFICO
   EXTRACT(year FROM f.vencimento) = '".date("Y", mktime(0,0,0,$mesv,$diav+1,$anov))."' AND
   (i.id = f.cod_fatura ) AND
   i.status = 1 AND
   f.pago = 0
   ORDER BY
   f.vencimento
";
$result = pg_query($sql);
if(pg_num_rows($result)>0){
   echo "<script>maximize();</script>";
}
?>
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="6" class="linhatopodiresq" bgcolor="#009966">
        <br>CONTROLE FINANCEIRO SESMT<br>&nbsp;</th>
    </tr>
</table>
<table width=700 border=0 cellspacing=2 cellpadding=5 align=center>
<tr>
<td align=left>
    <a href="?s=lancamentos" class="fontebranca12">Lançamentos</a> |
    <a href="?s=receitas" class="fontebranca12">Receitas</a> |
    <a href="?s=despesas" class="fontebranca12">Despesas</a> |
    <a href="?s=resumo" class="fontebranca12">Resumo</a> |
    <a href="?s=evolucao" class="fontebranca12">Evolução Financeira</a> |
    <a href="?s=pesquisa_de_lancamento" class="fontebranca12">Pesquisa de Lançamento</a> |
    <a href="?s=mmd_index" class="fontebranca12">Meu Melhor Dia</a>
</td>
</tr>
</table>
<p>
<table width=700 height=400 border=1 cellspacing=2 cellpadding=5 align=center>
<tr>
<td align=center valign=top>
<?PHP
     $p = ''.$_GET['s'].'.php';
     if(file_exists($p)){
         include $p;
     }else{
        if($_GET['s']==""){
            //include 'index.php';
        }else{
            include 'notfound.php';
        }
     }
?>
</td>
</tr>
</table>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#009966" colspan=6 align=center class="linhatopodiresqbase">
    <div align="center"><font color="#FFFFFF">
    				<input name="btn_sair" class=btn type="button" id="btn_sair" onClick="location.href='../adm/#financeiro';" value="Sair" style="width:100;">
    </font>&nbsp;</div></td>
  </tr>
</table>
<script type="text/javascript">
//adjust();
</script>

