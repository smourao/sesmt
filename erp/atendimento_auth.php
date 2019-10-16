<?PHP
session_start();
include("include/db.php");
include("sessao.php");

function dateDiff($sDataInicial, $sDataFinal)
{
 $sDataI = explode("-", $sDataInicial);
 $sDataF = explode("-", $sDataFinal);

 $nDataInicial = mktime(0, 0, 0, $sDataI[1], $sDataI[0], $sDataI[2]);
 $nDataFinal = mktime(0, 0, 0, $sDataF[1], $sDataF[0], $sDataF[2]);

 return ($nDataInicial > $nDataFinal) ?
    floor(($nDataFinal - $nDataInicial)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
   //floor(($nDataInicial - $nDataFinal)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
}

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

<link href="css_js/css.css" rel="stylesheet" type="text/css">

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
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="6" class="linhatopodiresq" bgcolor="#009966">
        <br>AUTORIZAÇÃO DE ATENDIMENTO<br>&nbsp;</th>
    </tr>
</table>
<table width=700 border=0 cellspacing=2 cellpadding=5 align=center>
  <tr>
    <td bgcolor="#009966" colspan=6 align=center class="linhatopodiresqbase">
    <div align="center"><font color="#FFFFFF">
    				<input name="btn_sair" class=btn type="button" id="btn_sair" onClick="location.href='http://sesmt-rio.com/erp/tela_principal.php';" value="Sair" style="width:100;">
    </font>&nbsp;</div></td>
  </tr>
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

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

  if($mes >=12){
      $n_mes = "01";
      $n_ano = $ano+1;
      $p_mes = $mes-1;
      $p_ano = $ano;
  }elseif($mes <= 01){
     $n_mes = STR_PAD($mes+1, 2, "0", STR_PAD_LEFT);
     $n_ano = $ano;
     $p_mes = 12;
     $p_ano = $ano-1;
  }else{
      $n_mes = STR_PAD($mes+1, 2, "0", STR_PAD_LEFT);
      $n_ano = $ano;
      $p_mes = STR_PAD($mes-1, 2, "0", STR_PAD_LEFT);
      $p_ano = $ano;
  }

     echo "<center><a href=\"javascript:location.href='atendimento_auth.php?m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='atendimento_auth.php?m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></center>";

/**************************************************************************************/
// MAIN PART OF THE SITE / SHOW
/**************************************************************************************/
echo'
<table border=1 width=100% align=center>
<tr>
   <td width=70 align="center"><b>Venc.</b></td>
   <td align="center"><b>Título</b></td>
   <!--<td align="center" width=30><b>Parcela</b></td>-->
   <td align="center" width=70><b>Situação</b></td>
</tr>';

$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   substr(f.vencimento, 6,2) = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   substr(f.vencimento, 1,4) = '{$ano}' AND
   (i.id = f.cod_fatura) AND
   i.status = 0
   ORDER BY
   f.vencimento
";


$sql = "
SELECT
   i.id, i.data_vencimento, i.migrado, i.cod_cliente, i.cod_fatura,
   cl.razao_social, cl.status
--   f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   site_fatura_info i,
--   site_fatura_produto f,
   cliente cl
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   substr(i.data_vencimento, 6,2) = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   substr(i.data_vencimento, 1,4) = '{$ano}' AND
   --(i.id = f.cod_fatura) AND
   --i.status = 0 AND
   i.cod_cliente = cl.cliente_id
   ORDER BY
   cl.razao_social
";

$result = pg_query($sql);
$data = pg_fetch_all($result);
echo "<input type=hidden name=hmes id=hmes value='{$mes}'>";
echo "<input type=hidden name=hano id=hano value='{$ano}'>";
$total_mes = 0;
$bg_color = array("#cfded2","#e5eae6");

for($x=0;$x<pg_num_rows($result);$x++){
if($data[$x][status] == "ativo"){
/*
$msg = "<center><b>".addslashes($data[$x]['titulo'])."</b></center><p>";
$msg .= "<b>Data de Lançamento: </b>".date("d/m/Y", strtotime($data[$x]['data_lancamento']))."<br>";
$msg .= "<b>Data de Vencimento: </b>".date("d/m/Y", strtotime($data[$x]['vencimento']))."<br>";
$msg .= "<b>Forma de Pagamento: </b>".$data[$x]['forma_pagamento']."<br>";

if($data[$x]['forma_pagamento'] == "Cheque" || $data[$x]['forma_pagamento'] == "Cheque pré-datado"){
   if($data[$x]['numero_cheque']!= ""){
      $msg .= "<b>Nº Cheque: </b>".$data[$x]['numero_cheque']."<p>";
   }else{
      $msg .= "<b>Nº Cheque: </b>Não inserido<p>";
   }
}
$msg .= "<b>Histórico: </b><br>".addslashes($data[$x]['historico'])."<BR>";
*/

  $dias_vencidos = dateDiff(date("d-m-Y", strtotime($data[$x]['data_vencimento'])), date("d-m-Y"));
  $sql = "SELECT valor FROM site_fatura_produto WHERE cod_fatura = '{$data[$x][cod_fatura]}' ORDER BY valor";
  $rprod = pg_query($sql);
  $items = pg_fetch_all($rprod);
  
  if($dias_vencidos > 5){
     if($data[$x]['migrado'] != 1){
         //Fatura vazia ou apenas com 2 taxas básicas, tbm considerada vazia
         if(pg_num_rows($rprod)<=0 || (pg_num_rows($rprod)==2 && in_array('4.00', $items[0]) && in_array('6.50', $items[1]))){
             $msg = "<b><font color=green>Liberado</font> mediante confirmação de pagamento do financeiro.</b>";
         }else{
             $msg = "<b><font color=red>Bloqueado</font> por não constar pagamento após vencido o prazo de pagamento.</b>";
         }
     }else{
        $msg = "<b><font color=green>Liberado</font> mediante confirmação de pagamento do financeiro.</b>";
     }
  }else{
     $msg = "<b><font color=green>Liberado</font> por estar dentro do prazo para pagamento.</b>";
  }
  
echo"
<tr>
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>".date("d/m/Y", strtotime($data[$x]['data_vencimento']))."</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=left onMouseOver=\"return overlib('{$msg}');\" onMouseOut=\"return nd();\"><font color=black>".STR_PAD($data[$x]['cod_cliente'], 4, "0", STR_PAD_LEFT)." - {$data[$x]['razao_social']}</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black><center>
   <div id='d{$data[$x]['rec_id']}'  onclick=\"javascript:setTimeout('receita_total()', 1500);\"><center>
";

     if($dias_vencidos > 5){
        if($data[$x]['migrado'] != 1){
            //Fatura vazia ou apenas com 2 taxas básicas, tbm considerada vazia
            if(pg_num_rows($rprod)<=0 || (pg_num_rows($rprod)==2 && in_array('4.00', $items[0]) && in_array('6.50', $items[1]))){
                echo "<b><font color=black>Liberado</b>";
            }else{
                echo "<i>Pendente</i>";
            }
        }else{
            echo "<b><font color=black>Liberado</b>";
        }
     }else{
        echo "<b><font color=black>Liberado</b>";
     }

   echo"</div></td>";

/*
   echo "<td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black><center>
   <div id='dcn{$data[$x]['rec_id']}'><center>
   ";
   //print $data[$x]['numero_doc'] != "" ? $data[$x]['numero_doc'] : "<a href=\"javascript:add_doc_number('{$data[$x]['rec_id']}',prompt('Digite o número do documento:',''));\" class=fontepreta12>Adicionar</a>";
   print $data[$x]['numero_doc'] != "" ? $data[$x]['numero_doc'] : "";
   echo "</font></div></td>";
*/
echo "</tr>";
/*
if($data[$x]['pago'] > 0){
   $total_mes += $data[$x]['valor'];
}
*/
}else{

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
