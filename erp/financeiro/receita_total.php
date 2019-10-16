<?PHP
include("include/db.php");
$mes = $_GET['mes'];
$ano = $_GET['ano'];

if(is_numeric($mes) && is_numeric($ano)){
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   substr(f.vencimento, 6,2) = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   substr(f.vencimento, 1,4) = '{$ano}' AND
   (i.id = f.cod_fatura) AND
   i.status = 0

";
$result = pg_query($sql);
$data = pg_fetch_all($result);
//$total_mes = 0;
for($x=0;$x<pg_num_rows($result);$x++){
   if($data[$x]['pago'] > 0){
      $total_mes += $data[$x]['valor'];
   }
}
}
   //echo pg_num_rows($result);
   echo number_format($total_mes, 2, ",",".");
?>
