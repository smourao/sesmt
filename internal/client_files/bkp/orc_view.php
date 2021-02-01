<img src='images/sub-visualizar-orcamento.jpg' border=0>
<?PHP
$sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = ".(int)(anti_injection($_GET[cod_orc]))." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
$roi = pg_query($sql);
$orcinfo = pg_fetch_array($roi);
if(pg_num_rows($roi)){
    $sql = "SELECT op.*, p.* FROM site_orc_produto op, produto p WHERE cod_orcamento = ".(int)(anti_injection($_GET[cod_orc]))." AND op.cod_produto = p.cod_prod";
    $rop = pg_query($sql);
    $orcprod = pg_fetch_all($rop);

    echo "<div class='novidades_text'>";
    echo "<p align=justify>";
    echo "Você está visualizando o orçamento de número <b>{$_GET[cod_orc]}</b>. ";
    if($orcinfo[aprovado])
        echo "Este orçamento foi gerado em ".date("d/m/Y", strtotime($orcinfo[data_criacao]))." e já está aprovado!";
    else
        echo "Este orçamento foi gerado em ".date("d/m/Y", strtotime($orcinfo[data_criacao]))." e está aguardando sua aprovação, <a href='?do=orcamentos&act=confirm&cod_orc=".(int)($orcinfo[cod_orcamento])."'>clique aqui</a> para aprovar este orçamento agora!";
    echo "</div>";
    
    echo "<div style=\"text-align: right;\"><img class='curhand' src='images/print-version.jpg' border=0 alt='Versão para impressão' title='Versão para impressão' onclick=\"newwindow('internal/client_files/print_orc.php?cod_orc=".(int)($orcinfo[cod_orcamento])."&cod_cliente=".(int)($_SESSION[cod_cliente])."',800,600);\"></div>";
    
    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    echo "<tr>";
        echo "<td class='bgTitle' align=center width=40>Item</td>";
        echo "<td class='bgTitle' align=center>Descrição</td>";
        echo "<td class='bgTitle' align=center width=40>Qnt</td>";
        echo "<td class='bgTitle' align=center width=70>Unitário</td>";
        echo "<td class='bgTitle' align=center width=90>Valor total</td>";
    echo "</tr>";
    $total = 0;
    for($x=0;$x<pg_num_rows($rop);$x++){
        if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';
        if($orcinfo[aprovado]){
            $preco_produto = $orcprod[$x][preco_aprovado];
            
            if($orcprod[$x][preco_prod] > $orcprod[$x][preco_aprovado] && $orcprod[$x][preco_aprovado] > 0)
                $desconto_aprovado = $orcprod[$x][preco_prod] - $orcprod[$x][preco_aprovado];
            else
                $desconto_aprovado = 0;
                
        }else
            $preco_produto = $orcprod[$x][preco_prod];
            

        
        echo "<tr>";
            echo "<td class='$bgclass' align=center>".($x+1)."</td>";
            echo "<td class='$bgclass' align=left><p align=justify>{$orcprod[$x][desc_resumida_prod]}</a></td>";
            echo "<td class='$bgclass' align=center>{$orcprod[$x][quantidade]}</td>";
            echo "<td class='$bgclass' align=right>R$ ".number_format($preco_produto, 2, ',','.');
            //if($desconto_aprovado) echo "<BR><span style=\"font-size: 8px; color: #FF0000;\" alt='Desconto por alteração de valor.' title='Desconto por alteração de valor.'>- R$ ".number_format($desconto_aprovado, 2, ',','.')."</span>";
            echo "</td>";
            echo "<td class='$bgclass' align=right>R$ ".number_format(($preco_produto * $orcprod[$x][quantidade]), 2, ',','.')."</td>";
        echo "</tr>";
        $total += ($preco_produto * $orcprod[$x][quantidade]);
    }
    echo "<tr>";
        echo "<td class='bgTitle' align=right colspan=4>Total</td>";
        echo "<td class='bgTitle' align=right>R$ ".number_format($total, 2, ',','.')."</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<p><BR>";
    
    echo "<center><input type='button' id='' name='' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
    
}else{
    echo "<div class='novidades_text'>";
    echo "<p align=justify>";
    echo "O orçamento de número <b>".(int)($_GET[cod_orc])."</b> que você está tentando visualizar não está disponível no momento ou não existe. Por favor, tente acessar novamente em alguns minutos, caso o problema persista, por favor, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
    echo "</div>";
}

?>

