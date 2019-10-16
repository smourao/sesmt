<?PHP
include("include/db.php");
$cod = $_GET['cod'];
$titulo = $_GET['titulo'];
$vencimento = $_GET['data'];
//$valor = $_GET['valor'];


$date = explode("/", $vencimento);
$date[0] = STR_PAD($date[0], 2, "0", STR_PAD_LEFT);
$date[1] = STR_PAD($date[1], 2, "0", STR_PAD_LEFT);
         if(strlen($valor)>6){
            $valor = str_replace(".", "", $_GET['valor']);
            $valor = str_replace(",", ".", $valor);
         }else{
            $valor = str_replace(",", ".", $_GET['valor']);
         }
         //$valor_parcela = round(($valor/$_POST['parcelas']), 2);

$sql = "UPDATE financeiro_fatura SET titulo='".addslashes($titulo)."', vencimento='".date("Y/m/d", strtotime($date[2]."/".$date[1]."/".$date[0]))."', valor='{$valor}' WHERE id='{$cod}'";
if(pg_query($sql)){
   $sql = "SELECT * FROM financeiro_fatura WHERE id='{$cod}'";
   $data = pg_fetch_array(pg_query($sql));
   echo $data[titulo]."|".date("d/m/Y", strtotime($data[vencimento]))."|".number_format($data[valor], 2, ".",",");
}else{
   echo "0";
}

?>
