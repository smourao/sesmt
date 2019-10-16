<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";

$cod_cgrt                      = (int)($_GET[cod_cgrt]);
$cod_setor                     = (int)($_GET[cod_setor]);

$ult_higienizacao_mec           = $_GET[ult_higienizacao_mec];
$ult_limpeza_filtros_portatil   = $_GET[ult_limpeza_filtros_portatil];
$area_circulacao                = (int)($_GET[area_circulacao]);

//preparando compos data
if(!empty($ult_higienizacao_mec)){
    $ult_higienizacao_mec = explode("/", $ult_higienizacao_mec);
    $ult_higienizacao_mec = "'".$ult_higienizacao_mec[2]."/".$ult_higienizacao_mec[1]."/".$ult_higienizacao_mec[0]."'";
}else{
    $ult_higienizacao_mec = "null";
}

if(!empty($ult_limpeza_filtros_portatil)){
    $ult_limpeza_filtros_portatil = explode("/", $ult_limpeza_filtros_portatil);
    $ult_limpeza_filtros_portatil = "'".$ult_limpeza_filtros_portatil[2]."/".$ult_limpeza_filtros_portatil[1]."/".$ult_limpeza_filtros_portatil[0]."'";
}else{
    $ult_limpeza_filtros_portatil = "null";
}

$sql = "UPDATE cliente_setor
SET
      dt_ventilacao		   	   = {$ult_higienizacao_mec}
    , higiene                  = {$ult_limpeza_filtros_portatil}
    , ar_port_area_circulacao  = {$area_circulacao}
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