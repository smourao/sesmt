<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include("include/db.php");

$datai = $_GET['date_i'];
$dataf = $_GET['date_f'];

if($datai != $dataf){
   $msg = "<i>Resultado de pesquisa por período entre <b>".date("d/m/Y", strtotime($datai))."</b> à <b>".date("d/m/Y", strtotime($dataf))."</b>:</i><br>";
}else{
   $msg = "<i>Resultado de pesquisa por dia <b>".date("d/m/Y", strtotime($datai))."</b></i><br>";
}
$msg .= "<table width=100% border=1>";
$msg .= "<tr>";
$msg .= "   <td align=center width=60><b>Vencimento</b></td>";
$msg .= "   <td align=center><b>Descrição</b></td>";
$msg .= "   <td align=center width=100><b>Valor</b></td>";
$msg .= "</tr>";

/*
$sql = "
SELECT
   *
FROM
   financeiro_fatura
WHERE
   vencimento BETWEEN '{$datai}' AND '{$dataf}'
AND
   status = 0
AND
   1=2
ORDER BY vencimento
";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);
 */
$total = 0;
$sub_total = 0;
/*
for($x=0;$x<pg_num_rows($result);$x++){
if($buffer[$x]['pago'] == 1){
   $msg .= "<tr>";
   $msg .= "   <td align=center>".date("d/m/Y", strtotime($buffer[$x]['vencimento']))."</td>";
   $msg .= "   <td>{$buffer[$x]['titulo']}</td>";
   $msg .= "   <td align=right>R$ ".number_format($buffer[$x]['valor'], 2, ',','.')."</td>";
   $msg .= "</tr>";
   $total += $buffer[$x]['valor'];
}else{
   $msg .= "<tr>";
   $msg .= "   <td align=center bgcolor='#c05d5d'>".date("d/m/Y", strtotime($buffer[$x]['vencimento']))."</td>";
   $msg .= "   <td bgcolor='#c05d5d'>{$buffer[$x]['titulo']}</td>";
   $msg .= "   <td align=right bgcolor='#c05d5d'>R$ ".number_format($buffer[$x]['valor'], 2, ',','.')."</td>";
   $msg .= "</tr>";
   $sub_total += $buffer[$x]['valor'];
}
}
*/

$sql = "SELECT
   *
FROM
   site_fatura_info
WHERE
   data_vencimento BETWEEN '{$datai}' AND '{$dataf}'
--AND
--   migrado = 0
";
$rz = pg_query($sql);
$resumo = pg_fetch_all($rz);

for($i=0;$i<pg_num_rows($rz);$i++){
   $par = explode("/", $resumo[$i]['parcela']);
   if($par[1] == "12"){
   $sql = "SELECT SUM(valor*quantidade) as valor FROM site_fatura_produto WHERE cod_fatura = '{$resumo[$i]['cod_fatura']}'";
   $rd = pg_query($sql);
   $data = pg_fetch_array($rd);
   
   $sql = "SELECT * FROM cliente WHERE cliente_id = '{$resumo[$i]['cod_cliente']}' AND filial_id = '{$resumo[$i]['cod_filial']}'";
   $rc = pg_query($sql);
   $cliente = pg_fetch_array($rc);
   if($resumo[$i]['migrado']){
      $msg .= "<tr>";
      $msg .= "   <td align=center>".date("d/m/Y", strtotime($resumo[$i]['data_vencimento']))."</td>";
      $msg .= "   <td>{$cliente['razao_social']}</td>";
      $msg .= "   <td align=right>R$ ".number_format($data['valor'], 2, ',','.')."</td>";
      $msg .= "</tr>";
      $total += $data['valor'];
   }else{
      $msg .= "<tr>";
      $msg .= "   <td align=center bgcolor='#c05d5d'>".date("d/m/Y", strtotime($resumo[$i]['data_vencimento']))."</td>";
      $msg .= "   <td bgcolor='#c05d5d'>{$cliente['razao_social']}</td>";
      $msg .= "   <td align=right bgcolor='#c05d5d'>R$ ".number_format($data['valor'], 2, ',','.')."</td>";
      $msg .= "</tr>";
   $sub_total += $data['valor'];
   }
   //$total += $data['valor'];
   }
}



$msg .= "<tr>";
$msg .= "   <td align=right colspan=2><b>Total Creditado</b></td>";
$msg .= "   <td align=right><b>R$ ".number_format($total, 2, ',','.')."</b></td>";
$msg .= "</tr>";

$msg .= "<tr>";
$msg .= "   <td align=right colspan=2><b>Total a Receber</b></td>";
$msg .= "   <td align=right><b>R$ ".number_format(($sub_total), 2, ',','.')."</b></td>";
$msg .= "</tr>";

$msg .= "<tr>";
$msg .= "   <td align=right colspan=2><b>Total Geral</b></td>";
$msg .= "   <td align=right><b>R$ ".number_format(($total+$sub_total), 2, ',','.')."</b></td>";
$msg .= "</tr>";

$msg .= "</table>";

echo $msg;
?>
