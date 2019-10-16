<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");
function dateDiff($sDataInicial, $sDataFinal)
{
 $sDataI = explode("-", $sDataInicial);
 $sDataF = explode("-", $sDataFinal);

 if(is_numeric($sDataI[0]) && is_numeric($sDataI[1]) && is_numeric($sDataI[2])){
    $nDataInicial = mktime(0, 0, 0, $sDataI[1], $sDataI[0], $sDataI[2]);
 }
 if(is_numeric($sDataF[0]) && is_numeric($sDataF[1]) && is_numeric($sDataF[2])){
    $nDataFinal = mktime(0, 0, 0, $sDataF[1], $sDataF[0], $sDataF[2]);
 }

 return ($nDataInicial > $nDataFinal) ?
    floor(($nDataFinal - $nDataInicial)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
   //floor(($nDataInicial - $nDataFinal)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
}

function tofloat($num){
    $num = str_replace(".", "", $num);
    $num = str_replace(",", ".", $num);
    return $num;
}

$valor = tofloat($_GET['valor']);
$valor_o = tofloat($_GET['valor_o']);
$data = str_replace("/", "-", $_GET['data']);
$data_o = str_replace("/", "-", $_GET['data_o']);


$multa = ($valor * 3)/100;
$juros = ($valor * 0.29)/100;
$dias_vencidos = dateDiff($data_o,$data);

$mult_multa = ceil(($dias_vencidos/30));

if($dias_vencidos > 0){
   $total_geral = $valor + ($multa*$mult_multa) + ($juros * $dias_vencidos);
}else{
   $total_geral = $valor;
}

echo $dias_vencidos."|".number_format($total_geral, 2, ',','.');

?>
