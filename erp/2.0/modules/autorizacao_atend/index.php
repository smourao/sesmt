<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$step = $_GET[step];
if(empty($step)) $step = 1;

if(isset($_GET['d'])){
    $dia = $_GET['d'];
}else{
    $dia = date("d");
}
if(isset($_GET['m'])){
    $mes = $_GET['m'];
}else{
    $mes = date("m");
}
if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

//echo "<center><img src='images/autoauth_title.png' border=0></center>";

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
        switch($step){
/* --> [ STEP 1 ] *********************************************************************************/
            case 1:
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Selecione a empresa</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1'>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome da empresa no campo e clique em Busca para verificar se uma empresa está em débito.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                
                // --> TIPBOX
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
            break;
        }
        echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        switch($step){
/* --> [ STEP 1 ] *********************************************************************************/
            case 1:
                if($_POST[search]){
                    $sql = "SELECT c.razao_social, fi.cod_cliente, fi.cod_filial
                    FROM site_fatura_info fi, cliente c
                    WHERE fi.cod_cliente = c.cliente_id
                    AND
                    fi.cod_filial = c.filial_id
                    AND
                    (
                    (
                    --EXTRACT(month FROM fi.data_vencimento) < {$mes}
                    --AND
                    EXTRACT(year FROM fi.data_vencimento) < {$ano}
                    )OR(
                    EXTRACT(day FROM fi.data_vencimento) < {$dia}
                    AND
                    EXTRACT(month FROM fi.data_vencimento) = {$mes}
                    AND
                    EXTRACT(year FROM fi.data_vencimento) = {$ano}
                    )OR(
                    EXTRACT(month FROM fi.data_vencimento) < {$mes}
                    AND
                    EXTRACT(year FROM fi.data_vencimento) = {$ano}
                    )
                    )
                    AND
                    lower(c.razao_social) LIKE '%".strtolower(addslashes($_POST[search]))."%'
                    AND
                    fi.migrado = 0
                    GROUP BY c.razao_social, fi.cod_cliente, fi.cod_filial
                	ORDER BY count(fi.cod_cliente) DESC";
                }else{
                    $sql = "SELECT c.razao_social, fi.cod_cliente, fi.cod_filial
                    FROM site_fatura_info fi, cliente c
                    WHERE fi.cod_cliente = c.cliente_id
                    AND
                    fi.cod_filial = c.filial_id
                    AND
                    (
                    (
                    --EXTRACT(month FROM fi.data_vencimento) < {$mes}
                    --AND
                    EXTRACT(year FROM fi.data_vencimento) < {$ano}
                    )OR(
                    EXTRACT(day FROM fi.data_vencimento) < {$dia}
                    AND
                    EXTRACT(month FROM fi.data_vencimento) = {$mes}
                    AND
                    EXTRACT(year FROM fi.data_vencimento) = {$ano}
                    )OR(
                    EXTRACT(month FROM fi.data_vencimento) < {$mes}
                    AND
                    EXTRACT(year FROM fi.data_vencimento) = {$ano}
                    )
                    )
                    AND
                    fi.migrado = 0
                    GROUP BY c.razao_social, fi.cod_cliente, fi.cod_filial
                	ORDER BY count(fi.cod_cliente) DESC";
            	}
                $result_cli = pg_query($sql);
            
                echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                echo "<b>Empresas em débito</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<p>";
                
                echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                echo "<tr>";
                echo "<td align=left class='text'><b>Empresa:</b></td>";
                echo "<td align=left class='text'><b>Fatura:</b></td>";
                echo "</tr>";
                $i = 1;
                $u = 1;
                while($row=pg_fetch_array($result_cli)){
                    if($row['cod_filial']){
                       $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']} AND filial_id={$row['cod_filial']}";
                    }else{
                       $sql = "SELECT * FROM cliente WHERE cliente_id = {$row['cod_cliente']}";
                    }
                    $result = pg_query($sql);
                    $cd = pg_fetch_array($result);
                    
                    $sql = "SELECT fi.cod_fatura, fi.cod_cliente, fi.cod_filial FROM site_fatura_info fi, cliente c
                    WHERE
                    c.cliente_id = '{$row[cod_cliente]}'
                    AND
                    fi.cod_cliente = c.cliente_id
                    AND
                    fi.cod_filial = c.filial_id
                    AND
                    (
                    (
                    --EXTRACT(month FROM fi.data_vencimento) < {$mes}
                    --AND
                    EXTRACT(year FROM fi.data_vencimento) < {$ano}
                    )OR(
                    EXTRACT(day FROM fi.data_vencimento) < {$dia}
                    AND
                    EXTRACT(month FROM fi.data_vencimento) = {$mes}
                    AND
                    EXTRACT(year FROM fi.data_vencimento) = {$ano}
                    )OR(
                    EXTRACT(month FROM fi.data_vencimento) < {$mes}
                    AND
                    EXTRACT(year FROM fi.data_vencimento) = {$ano}
                    )
                    )
                    AND
                    fi.migrado = 0
                    GROUP BY fi.cod_fatura, fi.cod_cliente, fi.cod_filial
                	ORDER BY fi.cod_fatura ASC";

                    $rfat = pg_query($sql);
                    $fat  = pg_fetch_all($rfat);
                    
                    for($r=0;$r<pg_num_rows($rfat);$r++){
                        $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$fat[$r]['cod_fatura']}'";
                        $rin = pg_query($sql);
                        $items = pg_fetch_all($rin);
                        $total=0;
                        for($x=0;$x<pg_num_rows($rin);$x++){
                            $total = $total + ($items[$x]['quantidade']*$items[$x]['valor']);
                        }
                        $multa = ($total * 3)/100;
                        $juros = ($total * 0.29)/100;
                        if($row['data_pagamento']){
                            $data_pag = date("d-m-Y", strtotime($row['data_pagamento']));
                        }else{
                            $data_pag = date("d-m-Y");
                        }
                        $dias_vencidos = dateDiff(date("d-m-Y", strtotime($row['data_vencimento'])), $data_pag);
                        $sql = "SELECT * FROM site_fatura_info WHERE cod_cliente = {$row['cod_cliente']} AND
                        migrado = 0 AND
                        (
                        (
                        --EXTRACT(month FROM data_vencimento) < {$mes}
                        --AND
                        EXTRACT(year FROM data_vencimento) < {$ano}
                        )OR(
                        EXTRACT(day FROM data_vencimento) < {$dia}
                        AND
                        EXTRACT(month FROM data_vencimento) = {$mes}
                        AND
                        EXTRACT(year FROM data_vencimento) = {$ano}
                        )OR(
                        EXTRACT(month FROM data_vencimento) < {$mes}
                        AND
                        EXTRACT(year FROM data_vencimento) = {$ano}
                        )
                        )
                       ";
                       $rv = pg_query($sql);
                       $vencidos = pg_fetch_all($rv);

                       $vv  = 0; // valor vencido - todas as faturas
                       $tdv = 0; // total de dias vencidos
                       $tvj = 0; // valor total com somatorio de juros e dias
                       $mv  = 0; // Multas de valores vencidos
                       $jv  = 0; // Juros de valores vencidos
                       $ad = array();
                       for($i=0;$i<pg_num_rows($rv);$i++){
                           $tdv += dateDiff(date("d-m-Y", strtotime($vencidos[$i]['data_vencimento'])), date("d-m-Y"));
                           $ad[] = $tdv;
                           $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$vencidos[$i]['cod_fatura']}'";
                           $pr = pg_query($sql);
                           $pt = pg_fetch_all($pr);
                           //TEST THE NUMBER OF PRODUCTS AND IF DON'T HAVE MORE THAN 3 VALUES INSIDE EACH
                           if(pg_num_rows($pr)<=0 || (pg_num_rows($pr)==2 && in_array('4.00', $pt[0]) && in_array('6.50', $pt[1]))){
                               //DO NOTHING
                           }else{
                               //soma valores de items na variavel $vv; obtem valor total da fatura.
                               for($o=0;$o<pg_num_rows($pr);$o++){
                                  $vv += $pt[$o][valor] * $pt[$o][quantidade];
                               }
                               // valores de cada vencimento separados
                               $mv   = ($vv * 3)/100;
                               $jv   = ($vv * 0.29)/100;
                               $mva  += $mv;
                               $jva  += $jv;
                               //soma valor da fatura + multa da fatura + juros da fatura * dias vencidos até a data atual
                               $mesesvencidos = ceil($tdv/30);
                               $tvj += $vv + ($mv*$mesesvencidos) + ($jv * $tdv);
                           }
                        }
                    }
                    
                    if($tvj == 0){
                        //echo "zero";
                        //FATURA ZERADA = CLIENTE SEM FATURA VÁLIDA
                    }else{
                    echo "<td align=left class='text roundbordermix'>{$cd['razao_social']}</td>";
                    echo "<td align=left class='text roundbordermix'>";
                        if(pg_num_rows($rv)>1){
                            echo "".pg_num_rows($rv)." faturas vencidas.";
                        }elseif(pg_num_rows($rv)==1){
                            echo "".pg_num_rows($rv)." fatura vencida.";
                        }
                    echo "</td>";
                    echo "</tr>";
                    $i++;
                    $u++;
                }
                }//end while!!!
                echo "</table>";
           break;
        }
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>
