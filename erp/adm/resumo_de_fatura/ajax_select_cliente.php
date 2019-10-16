<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];

if(is_numeric($cod_cliente)){
    $sql = "SELECT * FROM cliente WHERE cliente_id=$cod_cliente";
}else{
    $sql = "SELECT * FROM cliente WHERE lower(razao_social) like '%".strtolower($cod_cliente)."%' ORDER BY cliente_id";
}
    $result = pg_query($sql);
    $buffer = pg_fetch_all($result);
    $tmp = "";
    
    for($x=0;$x<pg_num_rows($result);$x++){
    $mes = $_GET[mes];//date("m");
    $ano = $_GET[ano];//date("Y");

       $sql = "
       SELECT
       *
       FROM
       site_fatura_info
       WHERE
       cod_cliente = {$buffer[$x]['cliente_id']}
       AND
       cod_filial = {$buffer[$x]['filial_id']}
       AND
       (
       EXTRACT(month FROM data_emissao) = {$mes}
       AND
       EXTRACT(year FROM data_emissao) = {$ano}
       OR
       EXTRACT(month FROM data_criacao) = {$mes}
       AND
       EXTRACT(year FROM data_criacao) = {$ano}
       AND
       data_emissao is null
       )
       ";
       $r = pg_query($sql);
                                                                                                                                                       //0 = cliente (não parceira)
       $tmp .= $buffer[$x]['cliente_id']."|".$buffer[$x]['razao_social']."|".$buffer[$x]['filial_id']."|".pg_num_rows($r)."|".$_GET[mes]."|".$_GET[ano]."|0";
       $tmp .= "§";
    }
    
    
/**************************************************************************************************/
// TESTE ADICIONAR ITEMS DE PARCERIA COMERCIAL
/**************************************************************************************************/
if(is_numeric($cod_cliente)){
    $sql = "SELECT * FROM cliente_pc WHERE cliente_id=$cod_cliente";
}else{
    $sql = "SELECT * FROM cliente_pc WHERE lower(razao_social) like '%".strtolower($cod_cliente)."%' ORDER BY cliente_id";
}
    $result = pg_query($sql);
    $buffer = pg_fetch_all($result);

    for($x=0;$x<pg_num_rows($result);$x++){
    $mes = $_GET[mes];//date("m");
    $ano = $_GET[ano];//date("Y");
/*
       $sql = "
       SELECT
       *
       FROM
       site_fatura_info
       WHERE
       cod_cliente = {$buffer[$x]['cliente_id']}
       AND
       cod_filial = {$buffer[$x]['filial_id']}
       AND
       (
       EXTRACT(month FROM data_emissao) = {$mes}
       AND
       EXTRACT(year FROM data_emissao) = {$ano}
       OR
       EXTRACT(month FROM data_criacao) = {$mes}
       AND
       EXTRACT(year FROM data_criacao) = {$ano}
       AND
       data_emissao is null
       )
       ";
       $r = pg_query($sql);
      */                                                                                             //".pg_num_rows($r)."           //1 = parceria
       $tmp .= $buffer[$x]['cliente_id']."|".$buffer[$x]['razao_social']."|".$buffer[$x]['filial_id']."|0|".$_GET[mes]."|".$_GET[ano]."|1";
       $tmp .= "§";
    }
    
echo $tmp;

