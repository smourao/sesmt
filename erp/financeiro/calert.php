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
<center>
<?PHP

    $dia = date("d");
    $mes = date("m");
    $ano = date("Y");

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

/***************************************************************************************************/
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   EXTRACT(day FROM f.vencimento) = '{$dia}' AND
   EXTRACT(month FROM f.vencimento) = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   EXTRACT(year FROM f.vencimento) = '{$ano}' AND
   (i.id = f.cod_fatura ) AND
   i.status = 1 AND
   f.pago = 0
   ORDER BY
   f.vencimento
";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);
echo "<table width=100% border=1 cellspacing=0 cellpadding=0";
echo "<tr>";
echo "   <td align=center colspan=3><b>Vencem Hoje</b></td>";
echo "</tr>";
echo "<tr>";
echo "   <td align=center><b>Descrição</b></td>";
echo "   <td align=center><b>Venc.</b></td>";
echo "   <td align=center><b>Valor</b></td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($result);$x++){
   echo "<tr>";
   echo "   <td><font size=1>".substr($buffer[$x]['titulo'], 0, 19)."...</font></td>";
   echo "   <td align=center ><font size=1>".date("d/m/Y", strtotime($buffer[$x]['vencimento']))."</font></td>";
   echo "   <td><font size=1>R$ ".number_format($buffer[$x]['valor'], 2, ',','.')."</font></td>";
   echo "</tr>";
}
echo "</table>";
/***************************************************************************************************/
echo "<p>";
/***************************************************************************************************/
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   EXTRACT(day FROM f.vencimento) = '".date("d", mktime(0,0,0,$mes,$dia+1,$ano))."' AND
   EXTRACT(month FROM f.vencimento) = '".date("m", mktime(0,0,0,$mes,$dia+1,$ano))."' AND -- SELECIONA APENAS O MES ESPECÍFICO
   EXTRACT(year FROM f.vencimento) = '".date("Y", mktime(0,0,0,$mes,$dia+1,$ano))."' AND
   (i.id = f.cod_fatura ) AND
   i.status = 1 AND
   f.pago = 0
   ORDER BY
   f.vencimento
";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);
echo "<table width=100% border=1 cellspacing=0 cellpadding=0";
echo "<tr>";
echo "   <td align=center colspan=3><b>Vencem Amanhã</b></td>";
echo "</tr>";
echo "<tr>";
echo "   <td align=center><b>Descrição</b></td>";
echo "   <td align=center><b>Venc.</b></td>";
echo "   <td align=center><b>Valor</b></td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($result);$x++){
   echo "<tr>";
   echo "   <td><font size=1>".substr($buffer[$x]['titulo'], 0, 19)."...</font></td>";
   echo "   <td align=center ><font size=1>".date("d/m/Y", strtotime($buffer[$x]['vencimento']))."</font></td>";
   echo "   <td><font size=1>R$ ".number_format($buffer[$x]['valor'], 2, ',','.')."</font></td>";
   echo "</tr>";
}
echo "</table>";
/***************************************************************************************************/
echo "<p>";
/***************************************************************************************************/
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --EXTRACT(day FROM f.vencimento) <= '".date("d", mktime(0,0,0,$mes,$dia,$ano))."' AND
   EXTRACT(month FROM f.vencimento) < '".date("m", mktime(0,0,0,$mes,$dia,$ano))."' AND -- SELECIONA APENAS O MES ESPECÍFICO
   EXTRACT(year FROM f.vencimento) <= '".date("Y", mktime(0,0,0,$mes,$dia,$ano))."'
   AND
   (i.id = f.cod_fatura ) AND
   i.status = 1 AND
   f.pago = 0
   OR
   EXTRACT(day FROM f.vencimento) < '".date("d", mktime(0,0,0,$mes,$dia,$ano))."' AND
   EXTRACT(month FROM f.vencimento) = '".date("m", mktime(0,0,0,$mes,$dia,$ano))."' AND -- SELECIONA APENAS O MES ESPECÍFICO
   EXTRACT(year FROM f.vencimento) <= '".date("Y", mktime(0,0,0,$mes,$dia,$ano))."'
   AND
   (i.id = f.cod_fatura ) AND
   i.status = 1 AND
   f.pago = 0
   ORDER BY
   f.vencimento
";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);
echo "<table width=100% border=1 cellspacing=0 cellpadding=0";
echo "<tr>";
echo "   <td align=center colspan=3><b>Despesas Vencidas</b></td>";
echo "</tr>";
echo "<tr>";
echo "   <td align=center><b>Descrição</b></td>";
echo "   <td align=center><b>Venc.</b></td>";
echo "   <td align=center><b>Valor</b></td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($result);$x++){
   echo "<tr>";
   echo "   <td><font size=1>".substr($buffer[$x]['titulo'], 0, 19)."...</font></td>";
   echo "   <td align=center ><font size=1>".date("d/m/Y", strtotime($buffer[$x]['vencimento']))."</font></td>";
   echo "   <td><font size=1>R$ ".number_format($buffer[$x]['valor'], 2, ',','.')."</font></td>";
   echo "</tr>";
}
echo "</table>";
/***************************************************************************************************/

?>
