<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";

$categoria     = addslashes(strtolower($_GET[cat]));
$material      = addslashes(strtolower($_GET[mat]));
$espessura     = addslashes(strtolower($_GET[esp]));
$acabamento    = addslashes(strtolower($_GET[aca]));
$tamanho       = addslashes(strtolower($_GET[tam]));
$legenda       = addslashes(strtolower($_GET[leg]));

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
        if($_GET[mat])
        $dsc = str_replace(" de ".$_GET[mat].",", "", $dsc);
        if($_GET[esp])
        $dsc = str_replace(" ".$_GET[esp].",", "", $dsc);
        if($_GET[tam])
        $dsc = str_replace(" ".$_GET[tam]."", "", $dsc);
        if($_GET[aca])
        $dsc = str_replace(" e acabamento ".$_GET[aca], "", $dsc);
        
        $items .= $buffer[$x][cod_prod]."|".$buffer[$x][cod_chave]."|".$buffer[$x][desc_detalhada_prod]."|".$buffer[$x][desc_resumida_prod]."|".$dsc."|".$_GET[cat]."|".$_GET[mat]."|".$_GET[esp]."|".$_GET[aca]."|".$_GET[tam]."£";
    }
}else{
    $rcod = "0§";
}
//return codes: 0 - Nothing found, 1 - Results found
echo $rcod.$items;

?>
