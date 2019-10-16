<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("../config/connect.php");

$cod_cliente = (int)($_GET['cod_cliente']);
$venc = $_GET[vencimento];
$venc = explode("/", $venc);
$venc = $venc[2]."-".$venc[1]."-".$venc[0];

    //MAX COD FOR THE NEW FATURA
    $sql = "SELECT MAX(cod_fatura) as cod_fatura FROM site_fatura_info";
    $r = pg_query($sql);
    $max = pg_fetch_array($r);
    $max = $max[cod_fatura]+1;

    //GET ORC INFO
    $sql = "SELECT * FROM site_orc_medi_info WHERE cod_cliente = {$cod_cliente} AND migrado = 0 AND done = 1";
    $rlo = pg_query($sql);
    $orc = pg_fetch_all($rlo);
    $lfu = "";
    
    //se registros forem encontrados
    if(pg_num_rows($rlo)){
        //LOOP FOR PRODUCTS OF EACH ORC
        for($y=0;$y<pg_num_rows($rlo);$y++){
            $sql = "SELECT * FROM site_orc_medi_produto WHERE cod_orcamento = ".(int)($orc[$y][cod_orcamento]);
            $rlp = pg_query($sql);
            $pro = pg_fetch_all($rlp);

            for($z=0;$z<pg_num_rows($rlp);$z++){
                $sql = "SELECT * FROM exame WHERE cod_exame = {$pro[$z][cod_produto]}";
                $ppp = pg_fetch_array(pg_query($sql));
                //INSERIR PRODUTOS
                $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = $max AND descricao = '$ppp[especialidade]'";
                $rtx = pg_query($sql);
                if(pg_num_rows($rtx)){
                    $tmpv = pg_fetch_array($rtx);
                    $qnt = $tmpv[quantidade] + $pro[$z][quantidade];
                    $sql = "UPDATE site_fatura_produto SET quantidade = $qnt WHERE cod_fatura = $max AND descricao = '$ppp[especialidade]'";
                    pg_query($sql);
                }else{
                    $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade, parcelas,
                    valor)
                    VALUES
                    ('$max', '{$cod_cliente}', 1, '{$ppp[especialidade]}', '{$pro[$z][quantidade]}', '1/01',
                    '{$pro[$z][preco_aprovado]}')";
                    pg_query($sql);
                }

                $lfu .= $pro[$z][funcionarios];
            }

            $fun = explode("|", $lfu);
            $fun = array_flip(array_flip($fun));
        }
        
        //INSERT ENCARGOS BANCÁRIOS NO VALOR DE 4,00 COM N. CONTRATO
        $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
        parcelas, valor) VALUES
        ('$max', '{$cod_cliente}','1',
        'Taxa de cobrança de encargo bancário conforme, Cláusula: 3 (p) vigente no contrato de numero: ".$dt[ano_contrato].".".STR_PAD($_GET[cod_cliente],3, "0", STR_PAD_LEFT)."',
        1, '1/01', '4.00')";
        pg_query($sql);

        //INSERT TAXA DE CORRESPONDÊNCIA NO VALOR DE 6,50 COM N. CONTRATO
        $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
        parcelas, valor) VALUES
        ('$max', '{$cod_cliente}','1',
        'Taxa correspondente a envio de correspondência, Conforme cláusula 3.1(p) do contrato de número: ".$dt[ano_contrato].".".STR_PAD($_GET[cod_cliente],3, "0", STR_PAD_LEFT)."',
        1, '1/01', '6.50')";
        pg_query($sql);

        $fut = "";//lista de funcionarios "3|9|15|..."
        foreach($fun as $f){
            if(is_numeric($f))
                $fut .= $f."|";
        }

        //INSERIR RESUMO DE FATURA
        $sql = "INSERT INTO site_fatura_info (cod_fatura, cod_cliente, cod_filial, data_criacao, data_emissao,
        data_vencimento, parcela, tipo_fatura, tipo_fatura_list, tipo_contrato)
        VALUES
        ('{$max}','{$cod_cliente}',1,'".date("Y-m-d")."','".date("Y-m-d")."','$venc',
        '1/01',1,'{$fut}', 'Específico')";

        if(pg_query($sql)){
            $sql = "UPDATE site_orc_medi_info SET migrado = 1 WHERE cod_cliente = {$cod_cliente} AND migrado = 0 AND done = 1";
            pg_query($sql);
            //retornar msg de OK
            echo "1|$cod_cliente";
        }else{
            //remover produtos com o cod max
            $sql = "DELETE * FROM site_fatura_produto WHERE cod_fatura  = $max";
            pg_query($sql);
            //retornar erro
            echo "0|$cod_cliente";
        }
    }else{
        echo "0|$cod_cliente";
    }
/************************************************************************************************************/
?>
