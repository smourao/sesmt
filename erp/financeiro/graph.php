<?php
session_start();
include("include/db.php");
require_once 'phplot/phplot.php';
$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
$totalmes = array();

if(!$type){
for($x=0;$x<12;$x++){
   $sql = "
   SELECT
      i.id, i.valor_total, i.n_parcelas, i.mes, i.ano, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago
   FROM
      financeiro_info i, financeiro_fatura f
   WHERE
      i.mes = '".STR_PAD(($x+1), 2, "0", STR_PAD_LEFT)."' AND -- SELECIONA APENAS O MES ESPECÍFICO 2 DIGITOS
      i.ano = '".($_GET['ano'])."' AND
      (i.id = f.cod_fatura )
   ORDER BY
      f.vencimento";
   $result = pg_query($sql);
   $data = pg_fetch_all($result);

   for($i=0;$i<pg_num_rows($result);$i++){
      if($data[$i]['status'] == 0){
         $totalmes[$x] += $data[$i]['valor'];
      }else{
         $totalmes[$x] -= $data[$i]['valor'];
      }
   }
}
//create a PHPlot object with 800x600 pixel image
$plot = new PHPlot(650,450);
$plot->SetPlotType('lines');
for($x=0;$x<12;$x++){
     $example_data[$x] = array(($meses[$x+1]),$totalmes[$x]);
}

$plot->SetDataValues($example_data);
$plot->SetDataColors(array('green', 'green', 'blue'));
//$plot->SetTickColor('red'); //Linha de valores
//$plot->SetLightGridColor('red');//pontilhado horizontal
//Set titles
$plot->SetTitle("Projeção Gráfica\nAno: ".$_GET['ano']."");
$plot->SetXTitle('Mês Referência');
$plot->SetYTitle('Saldo (R$)');
//Turn off X axis ticks and labels because they get in the way:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
//Draw it
$plot->DrawGraph();
}else{
 for($x=0;$x<12;$x++){
   $sql = "
   SELECT
      i.id, i.valor_total, i.n_parcelas, i.mes, i.ano, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago
   FROM
      financeiro_info i, financeiro_fatura f
   WHERE
      i.mes = '".STR_PAD(($x+1), 2, "0", STR_PAD_LEFT)."' AND -- SELECIONA APENAS O MES ESPECÍFICO 2 DIGITOS
      i.ano = '".($_GET['ano']-2)."' AND
      (i.id = f.cod_fatura )
   ORDER BY
      f.vencimento";
   $result = pg_query($sql);
   $data = pg_fetch_all($result);
   
   $sql = "
   SELECT
      i.id, i.valor_total, i.n_parcelas, i.mes, i.ano, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago
   FROM
      financeiro_info i, financeiro_fatura f
   WHERE
      i.mes = '".STR_PAD(($x+1), 2, "0", STR_PAD_LEFT)."' AND -- SELECIONA APENAS O MES ESPECÍFICO 2 DIGITOS
      i.ano = '".($_GET['ano']-1)."' AND
      (i.id = f.cod_fatura )
   ORDER BY
      f.vencimento";
   $result2 = pg_query($sql);
   $data2 = pg_fetch_all($result2);

   $sql = "
   SELECT
      i.id, i.valor_total, i.n_parcelas, i.mes, i.ano, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago
   FROM
      financeiro_info i, financeiro_fatura f
   WHERE
      i.mes = '".STR_PAD(($x+1), 2, "0", STR_PAD_LEFT)."' AND -- SELECIONA APENAS O MES ESPECÍFICO 2 DIGITOS
      i.ano = '".$_GET['ano']."' AND
      (i.id = f.cod_fatura )
   ORDER BY
      f.vencimento";
   $result3 = pg_query($sql);
   $data3 = pg_fetch_all($result3);


   for($i=0;$i<pg_num_rows($result);$i++){
      if($data[$i]['status'] == 0){
         $totalmes[$x] += $data[$i]['valor'];
      }else{
         $totalmes[$x] -= $data[$i]['valor'];
      }
   }
   
   for($i=0;$i<pg_num_rows($result2);$i++){
      if($data2[$i]['status'] == 0){
         $totalmes2[$x] += $data2[$i]['valor'];
      }else{
         $totalmes2[$x] -= $data2[$i]['valor'];
      }
   }

   for($i=0;$i<pg_num_rows($result3);$i++){
      if($data3[$i]['status'] == 0){
         $totalmes3[$x] += $data3[$i]['valor'];
      }else{
         $totalmes3[$x] -= $data3[$i]['valor'];
      }
   }

   
}


/*
$data = array(
  array('Jan', 40, 2, 4), array('Feb', 30, 3, 4), array('Mar', 20, 4, 4),
  array('Apr', 10, 5, 4), array('May',  3, 6, 4), array('Jun',  7, 7, 4),
  array('Jul', 10, 8, 4), array('Aug', 15, 9, 4), array('Sep', 20, 5, 4),
  array('Oct', 18, 4, 4), array('Nov', 16, 7, 4), array('Dec', 14, 3, 4),
);*/
$data = array();
for($x=0;$x<12;$x++){
     if($totalmes[$x] == ""){
        $totalmes[$x] = 0.00;
     }
     if($totalmes2[$x] == ""){
        $totalmes2[$x] = 0.00;
     }
     if($totalmes3[$x] == ""){
        $totalmes3[$x] = 0.00;
     }
     $data[$x] = array($meses[$x+1],$totalmes[$x], $totalmes2[$x], $totalmes3[$x]);
}

$plot = new PHPlot(650, 450);
$plot->SetImageBorderType('plain');
$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);
# Main plot title:
$plot->SetTitle("Projeção Gráfica\nAno: ".($_GET['ano']-2)."/".$_GET['ano']."");
# Make a legend for the 3 data sets plotted:
$plot->SetLegend(array($_GET['ano']-2, $_GET['ano']-1, $_GET['ano']));
# Turn off X tick labels and ticks because they don't apply here:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
$plot->DrawGraph();
}
?>
