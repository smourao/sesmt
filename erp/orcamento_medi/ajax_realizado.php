<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("../config/connect.php");

$orcamento = $_GET['id'];

$sql = "SELECT * FROM site_orc_medi_info WHERE cod_orcamento = '{$orcamento}'";
$result = pg_query($sql);
$done = pg_fetch_array($result);
$tc = 0;
if($done[done] == 0)
    $tc = 1;

if($tc){
/************************************************************************************************************/
// -> GERAR O RESUMO DE FATURA
/************************************************************************************************************/
    $sql = "SELECT MAX(cod_fatura) as cod_fatura FROM site_fatura_info";
    $r = pg_query($sql);
    $max = pg_fetch_array($r);
    $max = $max[cod_fatura]+1;

    $sql = "SELECT * FROM site_orc_medi_produto WHERE cod_orcamento = ".(int)($orcamento);
    $rpr = pg_query($sql);
    $pro = pg_fetch_all($rpr);

    $lfu = "";
    for($x=0;$x<pg_num_rows($rpr);$x++){
        $lfu .= $pro[$x][funcionarios];
    }
    $fun = explode("|", $lfu);
    $fun = array_flip(array_flip($fun));

    $fut = "";
    //for($y=0;$y<count($fun);$y++){
    foreach($fun as $f){
        if(is_numeric($f))
            $fut .= $f."|";//$fun[$y]."£";
    }

    if(empty($done[done])){
        //BUSCAR DATAS (DESCARTADA)
        /*
        //verifica se existe data no contrato
        $sql = "SELECT * FROM site_gerar_contrato WHERE cod_cliente = ".(int)($done[cod_cliente]);
        $rnext = pg_query($sql);
        if(pg_num_rows($rnext)){
            $next  = pg_fetch_array($rnext);
            $nextdia = date("d", strtotime($next[vencimento]));
        }else{
            //Se não houver contrato, busca a data da última fatura
            $sql = "SELECT * FROM site_fatura_info WHERE cod_cliente = ".(int)($done[cod_cliente]);
            $rnext = pg_query($sql);
            if(pg_num_rows($rnext)){
                $next = pg_fetch_array($rnext);
                $nextdia = date("d", strtotime($next[data_vencimento]));
            }else{
                //Se não houver porra nenhuma acima, coloca a data de vencimento para o próximo dia 1
                $nextdia = 1;
            }
        }
        //mês de cobrança?
        if(date("d") >= $nextdia)
            $nextmes = date("m", mktime(0,0,0,date("m")+1,date("d"), date("Y")));
        else
            $nextmes = date("m");
        */
        if(date("d") > 15){
            //$nextday = 15;
            $venc = date("Y-m-15", mktime(0,0,0,date("m")+1,date("d"), date("Y")));
            $emissao   = date("Y-m-d", mktime(0,0,0,date("m")+1, 1, date("Y")));
        }else{
            //$nextday = 1;
            $venc = date("Y-m-1", mktime(0,0,0,date("m")+1,date("d"), date("Y")));
            $emissao   = date("Y-m-d", mktime(0,0,0,date("m"), 16, date("Y")));
        }
        
        //INSERIR RESUMO DE FATURA
        /*
        $sql = "INSERT INTO site_fatura_info (cod_fatura, cod_cliente, cod_filial, data_criacao, data_emissao,
        data_vencimento, parcela, tipo_fatura, tipo_fatura_list)
        VALUES
        ('{$max}','{$done[cod_cliente]}',1,'".date("Y-m-d")."','$emissao','$venc',
        '1/01',1,'{$fut}')";
        pg_query($sql);

        for($i=0;$i<pg_num_rows($rpr);$i++){
            $sql = "SELECT * FROM exame WHERE cod_exame = {$pro[$i][cod_produto]}";
            $ppp = pg_fetch_array(pg_query($sql));

            $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade, parcelas,
            valor)
            VALUES
            ('$max', '{$done[cod_cliente]}', 1, '{$ppp[especialidade]}', '{$pro[$i][quantidade]}', '1/01',
            '{$pro[$i][preco_aprovado]}')";
            pg_query($sql);
        }
        */
    }
/************************************************************************************************************/
}

$sql = "UPDATE site_orc_medi_info SET done = '1' WHERE cod_orcamento = '{$orcamento}'";
$result = pg_query($sql);


if($result){
   echo "1|{$orcamento}";
}else{
   echo "0|{$orcamento}";
}
?>
