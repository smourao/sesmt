<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";

$cod_cgrt                      = (int)($_GET[cod_cgrt]);
$cod_setor                     = (int)($_GET[cod_setor]);
$n_aparelhos                   = (int)($_GET[n_aparelhos]);
$marca_aparelho                = $_GET[marca_aparelho];
$modelo_aparelho               = $_GET[modelo_aparelho];
$capacidade_aparelho           = $_GET[capacidade_aparelho];

$ult_limpeza_filtros           = $_GET[ult_limpeza_filtros];
$ult_limpeza_dutos             = $_GET[ult_limpeza_dutos];
$prox_limpeza_filtros          = $_GET[prox_limpeza_filtros];
$prox_limpeza_dutos            = $_GET[prox_limpeza_dutos];

//preparando compos data
if(!empty($ult_limpeza_filtros)){
    $ult_limpeza_filtros = explode("/", $ult_limpeza_filtros);
    $ult_limpeza_filtros = "'".$ult_limpeza_filtros[2]."/".$ult_limpeza_filtros[1]."/".$ult_limpeza_filtros[0]."'";
}else{
    $ult_limpeza_filtros = "null";
}

if(!empty($ult_limpeza_dutos)){
    $ult_limpeza_dutos = explode("/", $ult_limpeza_dutos);
    $ult_limpeza_dutos = "'".$ult_limpeza_dutos[2]."/".$ult_limpeza_dutos[1]."/".$ult_limpeza_dutos[0]."'";
}else{
    $ult_limpeza_dutos = "null";
}

if(!empty($prox_limpeza_filtros)){
    $prox_limpeza_filtros = explode("/", $prox_limpeza_filtros);
    $prox_limpeza_filtros = "'".$prox_limpeza_filtros[2]."/".$prox_limpeza_filtros[1]."/".$prox_limpeza_filtros[0]."'";
}else{
    $prox_limpeza_filtros = "null";
}

if(!empty($prox_limpeza_dutos)){
    $prox_limpeza_dutos = explode("/", $prox_limpeza_dutos);
    $prox_limpeza_dutos = "'".$prox_limpeza_dutos[2]."/".$prox_limpeza_dutos[1]."/".$prox_limpeza_dutos[0]."'";
}else{
    $prox_limpeza_dutos = "null";
}


$empresa_prestadora_servico    = $_GET[empresa_prestadora_servico];

$sql = "UPDATE cliente_setor
SET
    num_aparelhos 		       = '$n_aparelhos'
    , dt_ventilacao		   	   = {$ult_limpeza_filtros}
    , proxima_limpeza_mecanica = {$prox_limpeza_filtros}
    , marca					   = '$marca_aparelho'
    , ultima_limpeza_duto	   = {$ult_limpeza_dutos}
    , proxima_limpeza_duto	   = {$prox_limpeza_dutos}
    , modelo				   = '$modelo_aparelho'
    , capacidade			   = '$capacidade_aparelho'
    , empresa_servico		   = '$empresa_prestadora_servico'
WHERE
    id_ppra = $cod_cgrt
AND
    cod_setor = $cod_setor";
    
if(pg_query($sql)){
    echo "1";
}else{
    echo "0";
}
?>
