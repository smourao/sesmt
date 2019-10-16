<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");
$id = $_GET['id'];

$sql = "SELECT * FROM site_avaliacao_ambiental WHERE id='{$id}'";
$result = pg_query($sql);
$buffer = pg_fetch_array($result);

$total = /*$buffer['relatorio']+*/$buffer['bomba']+$buffer['diaria_prof']+
       $buffer['custo_lab']+$buffer['sedex']+$buffer['cassete']+
       $buffer['ciclone']+$buffer['certificado']+$buffer['aac'];

//number_format($total, 2, ',','.')

$resumida = "Análise de $buffer[substancia]";
$detalhada = "Análise de $buffer[substancia], Conforme limite estabelecido pela NR 15 na Lei 6.514/77 e Port. 3.214/78 do MTE";

$sql = "SELECT MAX(cod_prod) as max FROM produto";
$result = pg_query($sql);
$max = pg_fetch_array($result);

$sql = "INSERT INTO produto (cod_prod, desc_detalhada_prod, desc_resumida_prod, cod_atividade, preco_prod)
VALUES
('".($max[max]+1)."','{$detalhada}','{$resumida}','3','{$total}')";

if(pg_query($sql)){
   //echo $buffer[id]."|".$buffer[substancia]."|".number_format($total, 2, ',','.')."|".$resumida."|".$detalhada;
   $sql = "UPDATE site_avaliacao_ambiental SET migrado = 1, prod_id = '".($max[max]+1)."' WHERE id={$id}";
   pg_query($sql);
   echo "1|".$resumida." - Migrado com sucesso para o cadastro de produtos!";
}else{
   echo "0|Erro ao migrar produto!";
}

?>
