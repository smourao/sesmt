<?PHP
session_start();
include("include/db.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: SESMT - Seguran�a do Trabalho e Medicina Ocupacional ::</title>
<script type="text/javascript" src="java.js"></script>
<script type="text/javascript" src="include/java/flash.js"></script>
<script type="text/javascript" src="include/java/ajax.js"></script>
<script type="text/javascript" src="include/java/mm_css_menu.js"></script>
<script type="text/javascript" src="include/java/js.js"></script>
<script type="text/javascript" src="include/java/java.js"></script>
<script type="text/javascript" src="include/java/keyboard.js"></script>


<script type="text/javascript" src="f.js"></script>


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
<p>
<center><h2> SESMT - Seguran�a do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="6" class="linhatopodiresq" bgcolor="#009966">
        <br>CONTROLE FINANCEIRO SESMT<br>&nbsp;</th>
    </tr>
</table>
<!--
<table width=700 border=1 cellspacing=2 cellpadding=5 align=center>
<tr>
<td align=center>CONTROLE FINANCEIRO SESMT</td>
</tr>
</table>
-->
<table width=700 border=0 cellspacing=2 cellpadding=5 align=center>
  <tr>
    <td bgcolor="#009966" colspan=6 align=center class="linhatopodiresqbase">
    <div align="center"><font color="#FFFFFF">
    				<input name="btn_sair" class=btn type="button" id="btn_sair" onClick="location.href='http://sesmt-rio.com/erp/tela_principal.php';" value="Sair" style="width:100;">
    </font>&nbsp;</div></td>
  </tr>

<!--<tr>
<td align=center>
    <a href="?s=lancamentos" class="fontebranca12">Lan�amentos</a> |
    <a href="?s=receitas" class="fontebranca12">Receitas</a> |
    <a href="?s=despesas" class="fontebranca12">Despesas</a> |
    <a href="?s=resumo" class="fontebranca12">Resumo</a> |
    <a href="?s=evolucao" class="fontebranca12">Evolu��o Financeira</a>
</td>
</tr>-->

</table>
<p>
<table width=700 height=400 border=1 cellspacing=2 cellpadding=5 align=center>
<tr>
<td align=center valign=top>



<?PHP
if(isset($_GET['m'])){
    $mes = $_GET['m'];
}else{
    $mes = date("m");
}

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

$meses = array("", "Janeiro", "Fevereiro", "Mar�o", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");



  if($mes >=12){
      $n_mes = 01;
      $n_ano = $ano+1;
  }elseif($mes <= 01){
     $p_mes = 12;
     $p_ano = $ano-1;
  }else{
      $n_mes = STR_PAD($mes+1, 2, "0", STR_PAD_LEFT);
      $n_ano = $ano;
      $p_mes = STR_PAD($mes-1, 2, "0", STR_PAD_LEFT);
      $p_ano = $ano;
  }

//     echo "<center><a href=\"javascript:location.href='?s=receitas&m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?s=receitas&m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></center>";
/**************************************************************************************/
// MAIN PART OF THE SITE / SHOW
/**************************************************************************************/
echo'
<table border=1 width=100% align=center>
<tr>
   <td width=70 align="center"><b>Venc.</b></td>
   <td align="center"><b>T�tulo</b></td>
   <td align="center" width=30><b>Parcela</b></td>
<!--   <td align="center" width=100><b>Valor</b></td>-->
   <td align="center" width=70><b>Pagamento</b></td>
<!--   <td align="center" width=70><b>N� Doc.</b></td> -->
</tr>';

$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   substr(f.vencimento, 6,2) = '{$mes}' AND -- SELECIONA APENAS O MES ESPEC�FICO
   substr(f.vencimento, 1,4) = '{$ano}' AND
   (i.id = f.cod_fatura) AND
   i.status = 0
   ORDER BY
   f.vencimento
";
$result = pg_query($sql);
$data = pg_fetch_all($result);
echo "<input type=hidden name=hmes id=hmes value='{$mes}'>";
echo "<input type=hidden name=hano id=hano value='{$ano}'>";
$total_mes = 0;
$bg_color = array("#cfded2","#e5eae6");
for($x=0;$x<pg_num_rows($result);$x++){
//echo ($x % 2);
$msg = "<center><b>".addslashes($data[$x]['titulo'])."</b></center><p>";
$msg .= "<b>Data de Lan�amento: </b>".date("d/m/Y", strtotime($data[$x]['data_lancamento']))."<br>";
$msg .= "<b>Data de Vencimento: </b>".date("d/m/Y", strtotime($data[$x]['vencimento']))."<br>";
$msg .= "<b>Forma de Pagamento: </b>".$data[$x]['forma_pagamento']."<br>";
if($data[$x]['forma_pagamento'] == "Cheque" || $data[$x]['forma_pagamento'] == "Cheque pr�-datado"){
   if($data[$x]['numero_cheque']!= ""){
      $msg .= "<b>N� Cheque: </b>".$data[$x]['numero_cheque']."<p>";
   }else{
      $msg .= "<b>N� Cheque: </b>N�o inserido<p>";
   }
}
$msg .= "<b>Hist�rico: </b><br>".addslashes($data[$x]['historico'])."<BR>";
echo"
<tr>
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>".date("d/m/Y", strtotime($data[$x]['vencimento']))."</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=left onMouseOver=\"return overlib('{$msg}');\" onMouseOut=\"return nd();\"><font color=black>{$data[$x]['titulo']}</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>{$data[$x]['parcela_atual']}/{$data[$x]['n_parcelas']}</td>
<!--   <td bgcolor='".$bg_color[($x%2)]."' align=right><font color=black>R$ ".number_format($data[$x]['valor'], 2, ",",".")."</td>-->
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black><center>
   <div id='d{$data[$x]['rec_id']}'  onclick=\"javascript:setTimeout('receita_total()', 1500);\"><center>";
  // print $data[$x]['pago'] == 0 ? "<a href=\"javascript:receita_paga('{$data[$x]['rec_id']}');\" class=fontepreta12>Confirmar</a>" : "<b><font color=black>Pago!</b>";
   print $data[$x]['pago'] == 0 ? "Aguardando" : "<b><font color=black>Pago!</b>";
   echo"</div></td>";

/*
   echo "<td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black><center>
   <div id='dcn{$data[$x]['rec_id']}'><center>
   ";
   //print $data[$x]['numero_doc'] != "" ? $data[$x]['numero_doc'] : "<a href=\"javascript:add_doc_number('{$data[$x]['rec_id']}',prompt('Digite o n�mero do documento:',''));\" class=fontepreta12>Adicionar</a>";
   print $data[$x]['numero_doc'] != "" ? $data[$x]['numero_doc'] : "";
   echo "</font></div></td>";
*/
echo "</tr>";
if($data[$x]['pago'] > 0){
   $total_mes += $data[$x]['valor'];
}

}
echo"
<!--
<tr>
   <td align=right colspan=3>&nbsp;<b>Total</b></td>
   <td align=right colspan=3><div id='soma_receita'><b>R$ ".number_format($total_mes, 2, ",",".")."</b></div></td>
</tr>
-->
";
echo "</table>";
?>
</td>
</tr>
</table>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#009966" colspan=6 align=center class="linhatopodiresqbase">
    <div align="center"><font color="#FFFFFF">
    				<input name="btn_sair" class=btn type="button" id="btn_sair" onClick="location.href='http://sesmt-rio.com/erp/tela_principal.php';" value="Sair" style="width:100;">
    </font>&nbsp;</div></td>
  </tr>
</table>
