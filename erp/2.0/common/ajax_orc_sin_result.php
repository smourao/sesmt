<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";

$categoria     = addslashes(strtolower($_GET[cate]));
$material      = addslashes(strtolower($_GET[mate]));
$espessura     = addslashes(strtolower($_GET[espe]));
$acabamento    = addslashes(strtolower($_GET[acab]));
$tamanho       = addslashes(strtolower($_GET[tama]));
$legenda       = addslashes(strtolower($_GET[lege]));

//reverse tamanho
$tam = explode("x", $tamanho);
$rtam = $tam[1]."x".$tam[0];

if($legenda){
    $sql = "SELECT * FROM loja_legendas WHERE categoria = '$categoria' AND legenda = '$legenda'";
    $rle = pg_query($sql);
    $le = pg_fetch_array($rle);
    $sql = "
    SELECT
        *
    FROM
        produto
    WHERE
        LOWER(desc_detalhada_prod) LIKE '%$categoria%$le[padrao]%$le[numero]%$material%$espessura%$tamanho%$acabamento%'
    OR
        LOWER(desc_detalhada_prod) LIKE '%$categoria%$le[padrao]%$le[numero]%$material%$espessura%$rtam%$acabamento%'
    OR
        LOWER(desc_resumida_prod) LIKE '%$categoria%$le[padrao]%$le[numero]%$material%$espessura%$tamanho%$acabamento%'
    OR
        LOWER(desc_resumida_prod) LIKE '%$categoria%$le[padrao]%$le[numero]%$material%$espessura%$rtam%$acabamento%'
    ";
}else{
    $sql = "
    SELECT
        *
    FROM
        produto
    WHERE
        LOWER(desc_detalhada_prod) LIKE '%$categoria%$material%$espessura%$tamanho%$acabamento%'
    OR
        LOWER(desc_detalhada_prod) LIKE '%$categoria%$material%$espessura%$rtam%$acabamento%'
    OR
        LOWER(desc_resumida_prod) LIKE '%$categoria%$material%$espessura%$tamanho%$acabamento%'
    OR
        LOWER(desc_resumida_prod) LIKE '%$categoria%$material%$espessura%$rtam%$acabamento%'
    ";
}

$res = pg_query($sql);
if(pg_num_rows($res)){
    $buffer = pg_fetch_all($res);
    $rcod = pg_num_rows($res)."§";
    $items = "";
    for($x=0;$x<pg_num_rows($res);$x++){
        $dsc = str_replace("Fornecimento de ", "", $buffer[$x][desc_resumida_prod]);
        if($_GET[mate])
        $dsc = str_replace(" de ".$_GET[mate].",", "", $dsc);
        if($_GET[espe])
        $dsc = str_replace(" ".$_GET[espe].",", "", $dsc);
        if($_GET[tama])
        $dsc = str_replace(" ".$_GET[tama]."", "", $dsc);
        if($_GET[acab])
        $dsc = str_replace(" e acabamento ".$_GET[acab], "", $dsc);
        
        $items .= $buffer[$x][cod_prod]."|".$buffer[$x][cod_chave]."|".$buffer[$x][desc_detalhada_prod]."|".$buffer[$x][desc_resumida_prod]."|".$dsc."|".$_GET[cate]."|".$_GET[mate]."|".$_GET[espe]."|".$_GET[acab]."|".$_GET[tama]."£";
    }
}else{
    $rcod = "0§";
}
//return codes: 0 - Nothing found, 1 - Results found
echo $rcod.$items;

?>
