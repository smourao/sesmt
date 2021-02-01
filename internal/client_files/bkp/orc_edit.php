<?PHP
$sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = ".(int)(anti_injection($_GET[cod_orc]))." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
$roi = pg_query($sql);
$orcinfo = pg_fetch_array($roi);
if(pg_num_rows($roi) && !$orcinfo[aprovado]){

    if(!$_GET[sa]){
        $sql = "SELECT op.*, p.* FROM site_orc_produto op, produto p WHERE cod_orcamento = ".(int)(anti_injection($_GET[cod_orc]))." AND op.cod_produto = p.cod_prod";
        $rop = pg_query($sql);
        $orcprod = pg_fetch_all($rop);
        echo "<img src='images/sub-editar-orcamento.jpg' border=0>";
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "Você está editando o orçamento de número <b>{$_GET[cod_orc]}</b>. ";
        echo "Este orçamento foi gerado em ".date("d/m/Y", strtotime($orcinfo[data_criacao]))." e está aguardando sua aprovação, <a href='?do=orcamentos&act=confirm&cod_orc=".(int)($orcinfo[cod_orcamento])."'>clique aqui</a> para aprovar este orçamento agora!";
        echo "</div>";

       // echo "<div style=\"text-align: right;\"><img class='curhand' src='images/print-version.jpg' border=0 alt='Versão para impressão' title='Versão para impressão' onclick=\"newwindow('internal/client_files/print_orc.php?cod_orc=".(int)($orcinfo[cod_orcamento])."&cod_cliente=".(int)($_SESSION[cod_cliente])."',800,600);\"></div>";
        echo "<input type=button value='Adicionar item' onclick=\"location.href='?do=orcamentos&act=edit&cod_orc=".(int)($_GET[cod_orc])."&sa=add_item';\">";

        echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        echo "<tr>";
            echo "<td class='bgTitle' align=center width=40>Opção</td>";
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
                echo "<td class='$bgclass' align=center>";
                //echo $x+1;
                //echo "<BR><p>";
                echo "<a href='?do=orcamentos&act=$_GET[act]&cod_orc=$_GET[cod_orc]&sa=edit_item&cod_item={$orcprod[$x][id]}'><img src='images/ico-edit.png' border=0 alt='Editar item' title='Editar item'></a>";
                echo "&nbsp;";
                echo "<a href='?do=orcamentos&act=$_GET[act]&cod_orc=$_GET[cod_orc]&sa=del_item&cod_item={$orcprod[$x][id]}' onclick=\"if(!confirm('Tem certeza que deseja excluir este orçamento?','')){ return false;}\"><img src='images/ico-del.png' border=0 alt='Excluir item' title='Excluir item'></a>";
                echo "</td>";
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

        echo "<BR>";

        echo "<b>Legenda:</b>";
        echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        echo "<tr>";
        /*echo "<td width=25><img src='images/ico-ok.png' border=0 alt='Aprovar orçamento' title='Aprovar orçamento'></td><td><font size=1>Aprovar orçamento.</font></td>";
        echo "</tr><tr>";
        echo "<td width=25><img src='images/ico-view.png' border=0 alt='Visualizar orçamento' title='Visualizar orçamento'></td><td><font size=1>Visualizar orçamento.</font></td>";
        echo "</tr><tr>";
        */
        echo "<td width=25><img src='images/ico-edit.png' border=0 alt='Editar item' title='Editar item'></td><td><font size=1>Editar item.</font></td>";
        echo "</tr><tr>";
        echo "<td width=25><img src='images/ico-del.png' border=0 alt='Excluir item' title='Excluir item'></td><td><font size=1>Excluir item.</font></td>";
        echo "</tr>";
        echo "</table>";
        echo "<BR>";
        echo "<center><input type='button' id='' name='' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
    }elseif($_GET[sa] == 'edit_item' && is_numeric($_GET[cod_item])){
    /********************************************************************************************************/
    //Edição item do orçamento
        $sql = "SELECT op.*, p.* FROM site_orc_produto op, produto p WHERE cod_orcamento = ".(int)(anti_injection($_GET[cod_orc]))." AND op.id = ".(int)($_GET[cod_item])." AND op.cod_produto = p.cod_prod";
        $rop = pg_query($sql);
        $orcprod = pg_fetch_array($rop);
        if(pg_num_rows($rop)){
            echo "<div class='novidades_text'>";
            echo "<p align=justify>";
            echo "Você está editando o orçamento de número <b>{$_GET[cod_orc]}</b>. ";
            echo "Este orçamento foi gerado em ".date("d/m/Y", strtotime($orcinfo[data_criacao]))." e está aguardando sua aprovação, <a href='?do=orcamentos&act=confirm&cod_orc=".(int)($orcinfo[cod_orcamento])."'>clique aqui</a> para aprovar este orçamento agora!";

            //EDIT ITEM
            if($_POST && $_POST[btnEditItem] && is_numeric($_POST[txtQuant]) && (int)($_POST[txtQuant]) > 0){
                $sql = "UPDATE site_orc_produto SET quantidade = ".(int)($_POST[txtQuant])." WHERE id = ".(int)($_GET[cod_item])." AND cod_orcamento = ".(int)($_GET[cod_orc])." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
                if(pg_query($sql)){
                    echo "<p align=justify>Atualizando dados, por favor, aguarde... <script>location.href='?do=orcamentos&act=edit&cod_orc=".(int)($_GET[cod_orc])."';</script>";
                    makeLog($_SESSION[user_id], "Orçamento $_GET[cod_orc] alterado pelo cliente, produto: $orcprod[cod_produto] - $orcprod[desc_resumida_prod], quantidade dê $orcprod[quantidade] para ".(int)($_POST[txtQuant]).".", 204, $sql);
                }else{
                    echo "<p align=justify>Houve um problema ao tentar atualizar este item. Por favor, tente novamente em alguns minutos, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
                    makeLog($_SESSION[user_id], "Erro ao alterar orçamento $_GET[cod_orc] pelo cliente, produto: $orcprod[cod_produto] - $orcprod[desc_resumida_prod], quantidade dê $orcprod[quantidade] para ".(int)($_POST[txtQuant]).".", 205, $sql);
                }
            }

            echo "</div>";
            echo "<img src='images/sub-editar-item.jpg' border=0>";
            echo "<BR>";

            echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
            echo "<form id='frmEditItem' name='frmEditItem' method=post>";

            echo "<tr>";
                echo "<td width=180>Código do orçamento:</td>";
                echo "<td><b>".str_pad((int)($_GET[cod_orc]), 4, "0", 0)."</b></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td width=180>Descrição do item:</td>";
                echo "<td><textarea readonly rows=3 class='' style=\"width: 100%;\">{$orcprod[desc_detalhada_prod]}</textarea></td>";
            echo "</tr>";
            echo "<tr>";
                echo "<td width=180>Quantidade:</td>";
                echo "<td><input type=text size=3 maxlength=5 value='{$orcprod[quantidade]}' name='txtQuant' id='txtQuant' class='required' onkeydown=\"return only_number(event);\" onkeyup=\"change_classname('txtQuant', 'required');\"></td>";
            echo "</tr>";
            echo "</table>";
            echo "<BR><p>";
            echo "<center><input type=submit id='btnEditItem' name='btnEditItem' value='Salvar alteração' onclick=\"if(document.getElementById('txtQuant').value <=0 || document.getElementById('txtQuant').value == ''){ document.getElementById('txtQuant').className = 'required_wrong'; document.getElementById('txtQuant').focus(); return false;}\"> &nbsp; <input type=button id=btnBack name=btnBack value='Voltar' onclick=\"location.href='?do=orcamentos&act=edit&cod_orc={$_GET[cod_orc]}';\"></center>";
            echo "</form>";
        }else{
            echo "<div class='novidades_text'>";
            echo "<p align=justify>";
            echo "Você está editando o orçamento de número <b>{$_GET[cod_orc]}</b>. ";
            echo "Este orçamento foi gerado em ".date("d/m/Y", strtotime($orcinfo[data_criacao]))." e está aguardando sua aprovação, <a href='?do=orcamentos&act=confirm&cod_orc=".(int)($orcinfo[cod_orcamento])."'>clique aqui</a> para aprovar este orçamento agora!";
            echo "<p align=justify>";
            echo "O item selecionado para edição não existe ou não está disponível no momento. Por favor, tenta novamente em alguns minutos, caso o problema persista, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
            echo "</div>";
            echo "<center><input type=button id=btnBack name=btnBack value='Voltar' onclick=\"location.href='?do=orcamentos&act=edit&cod_orc=".(int)($_GET[cod_orc])."';\"></center>";
        }
    }elseif($_GET[sa] == 'del_item' && is_numeric($_GET[cod_item])){
    //Exclusão de item do orçamento
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "Você está editando o orçamento de número <b>{$_GET[cod_orc]}</b>. ";
        echo "Este orçamento foi gerado em ".date("d/m/Y", strtotime($orcinfo[data_criacao]))." e está aguardando sua aprovação, <a href='?do=orcamentos&act=confirm&cod_orc=".(int)($orcinfo[cod_orcamento])."'>clique aqui</a> para aprovar este orçamento agora!";

        $sql = "SELECT op.*, p.* FROM site_orc_produto op, produto p WHERE cod_orcamento = ".(int)(anti_injection($_GET[cod_orc]))." AND op.id = ".(int)($_GET[cod_item])." AND op.cod_produto = p.cod_prod";
        $rop = pg_query($sql);
        $orcprod = pg_fetch_array($rop);
        if(pg_num_rows($rop)){
            $sql = "DELETE FROM site_orc_produto WHERE id = ".(int)($_GET[cod_item])." AND cod_cliente = ".(int)($_SESSION[cod_cliente])." AND cod_orcamento = ".(int)($_GET[cod_orc]);
            if(pg_query($sql)){
                echo "<p align=justify>Atualizando dados, por favor, aguarde... <script>location.href='?do=orcamentos&act=edit&cod_orc=".(int)($_GET[cod_orc])."';</script>";
                makeLog($_SESSION[user_id], "Item excluído do orçamento $_GET[cod_orc] pelo cliente, produto: $orcprod[cod_produto] - $orcprod[desc_resumida_prod], quantidade: $orcprod[quantidade].", 206, $sql);
            }else{
                echo "<p align=justify>Houve um problema ao tentar excluir este item. Por favor, tente novamente em alguns minutos, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
                makeLog($_SESSION[user_id], "Erro ao excluir item do orçamento $_GET[cod_orc] pelo cliente, produto: $orcprod[cod_produto] - $orcprod[desc_resumida_prod], quantidade: $orcprod[quantidade].", 207, $sql);
            }
            echo "</div>";
        }else{
            echo "<p align=justify>";
            echo "O item selecionado para exclusão não existe ou não está disponível no momento. Por favor, tenta novamente em alguns minutos, caso o problema persista, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
            echo "<center><input type=button id=btnBack name=btnBack value='Voltar' onclick=\"location.href='?do=orcamentos&act=edit&cod_orc=".(int)($_GET[cod_orc])."';\"></center>";
            echo "</div>";
        }
    }elseif($_GET[sa] == 'add_item' && is_numeric($_GET[cod_orc])){
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "Você está adicionando items ao orçamento de número <b>{$_GET[cod_orc]}</b>. ";
        echo "Este orçamento foi gerado em ".date("d/m/Y", strtotime($orcinfo[data_criacao]))." e está aguardando sua aprovação, <a href='?do=orcamentos&act=confirm&cod_orc=".(int)($orcinfo[cod_orcamento])."'>clique aqui</a> para aprovar este orçamento agora!";
        echo "<p align=justify>";
        echo "Para adicionar um novo item ao orçamento, faça uma busca pelo nome do item, selecione o item desejado, informe a quantidade e clique em \"Ok\" para confirmar.";
        echo "</div>";
        echo "<img src='images/sub-adicionar-item.jpg' border=0>";
        
        echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
        echo "<form id='frmAddItem' name='frmAddItem' method=post onsubmit=\"if(document.getElementById('txtItemName').value == '' || document.getElementById('txtItemName').value.length < 3){ document.getElementById('txtItemName').className = 'required_wrong'; document.getElementById('txtItemName').focus(); return false;}\">";

        echo "<tr>";
            echo "<td width=180>Código do orçamento:</td>";
            echo "<td><b>".str_pad((int)($_GET[cod_orc]), 4, "0", 0)."</b></td>";
        echo "</tr>";
        echo "<tr>";
            echo "<td width=180>Nome do item:</td>";
            echo "<td><input type=text size=30 name='txtItemName' id='txtItemName' value='$_POST[txtItemName]' class='required' onkeyup=\"change_classname('txtItemName', 'required');\">&nbsp;<img src='images/ico-help.png' style=\"cursor: help;\" alt='Digite o nome do item que deseja localizar com pelo menos 3 caracteres e clique em procurar item.' title='Digite o nome do item que deseja localizar com pelo menos 3 caracteres e clique em procurar item.' align='top' border='0'></td>";
        echo "</tr>";
        echo "</table>";
        echo "<BR><p>";
        echo "<center><input type=submit id='btnFindItem' name='btnFindItem' value='Procurar item' onclick=\"if(document.getElementById('txtItemName').value == '' || document.getElementById('txtItemName').value.length < 3){ document.getElementById('txtItemName').className = 'required_wrong'; document.getElementById('txtItemName').focus(); return false;}\"> &nbsp; <input type=button id=btnBack name=btnBack value='Voltar' onclick=\"location.href='?do=orcamentos&act=edit&cod_orc={$_GET[cod_orc]}';\"></center>";
        echo "</form>";

        if($_POST && $_POST[txtItemName]){
            echo "<div class='novidades_text'>";
            echo "<p align=justify><BR>";
            echo "<img src='images/sub-resultado-busca.jpg' border=0>";
            echo "</div>";
            $cod_prod_not_return = "69854"; //código de produtos não retornáveis na busca
            $sql = "SELECT numero_funcionarios FROM cliente WHERE cliente_id = ".(int)($_SESSION[cod_cliente]);
            $nfunc = pg_fetch_array(pg_query($sql));
            $sql = "SELECT * FROM produto WHERE (lower(desc_detalhada_prod) LIKE '%".strtolower(anti_injection($_POST[txtItemName]))."%' OR lower(desc_resumida_prod) LIKE '%".strtolower(anti_injection($_POST[txtItemName]))."%') AND preco_prod > 0 AND cod_prod NOT IN ($cod_prod_not_return) AND (g_min is null OR $nfunc[numero_funcionarios] BETWEEN g_min AND g_max) ORDER BY cod_prod";
            //echo $sql;
            $rpd = pg_query($sql);
            if(pg_num_rows($rpd)){
                echo "<br>&nbsp;".pg_num_rows($rpd)." item(s) encontrados na busca por \"<b>".anti_injection($_POST[txtItemName])."</b>\".";
                $produtos = pg_fetch_all($rpd);
                echo "<div id='searchresult' style=\"width: 100%; height: 500px; overflow: auto;\">";
                    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
                    echo "<tr>";
                        echo "<td class='bgTitle' align=center width=40>Nº</td>";
                        echo "<td class='bgTitle' align=center width=65>Cód. Prod.</td>";
                        echo "<td class='bgTitle' align=center>Descrição</td>";
                        echo "<td class='bgTitle' align=center width=65>Opção</td>";
                    echo "</tr>";
                    for($x=0;$x<pg_num_rows($rpd);$x++){
                        if($x%2)
                            $bgclass = 'bgContent1';
                        else
                            $bgclass = 'bgContent2';
                        echo "<tr>";
                        echo "<td class='$bgclass' align=center>".str_pad(($x+1), 3, "0",0)."</td>";
                        echo "<td class='$bgclass' align=center>{$produtos[$x][cod_prod]}</td>";
                        echo "<td class='$bgclass' align=left><p align=justify>{$produtos[$x][desc_detalhada_prod]}</p></td>";
                        echo "<td class='$bgclass' align=center><input type=button id='btnAddNewItem' name='btnAddNewItem' value='Adicionar' onclick=\"document.getElementById('cod_item').value='{$produtos[$x][cod_prod]}';document.getElementById('item_cod').innerHTML='{$produtos[$x][cod_prod]}';document.getElementById('desc_item').innerHTML='".str_replace("\"", "`", str_replace("'", "`", $produtos[$x][desc_detalhada_prod]))."';document.getElementById('adddetails').style.display = 'block';document.getElementById('searchresult').style.display = 'none';\"></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                echo "</div>";
                echo "<div id='adddetails' style=\"display: none; width: 100%; height: 500px; overflow: auto;\">";
                    echo "<input type=hidden value='' id='cod_item'>";
                    echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";
                    echo "<tr>";
                        echo "<td width=180>Código do item:</td>";
                        echo "<td><b><span id='item_cod'></span></b></td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td width=180>Descrição do item:</td>";
                        echo "<td><textarea id='desc_item' readonly rows=3 class='' style=\"width: 99%;\"></textarea></td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td width=180>Quantidade:</td>";
                        echo "<td><input type=text size=3 maxlength=5 value='1' name='addItemQnt' id='addItemQnt' class='required' onkeydown=\"return only_number(event);\" onkeyup=\"change_classname('addItemQnt', 'required');\"></td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td width=180>Status:</td>";
                        echo "<td><span id='insertstatus'></span></td>";
                    echo "</tr>";
                    echo "</table>";
                    echo "<BR><p>";
                    echo "<center><input type=button id='btnAddItemAjax' name='btnAddItemAjax' value='Adicionar Item' onclick=\"if(document.getElementById('addItemQnt').value <=0 || document.getElementById('addItemQnt').value == ''){ document.getElementById('addItemQnt').className = 'required_wrong'; document.getElementById('addItemQnt').focus(); return false;}else{add_orc_produto(".(int)($_GET[cod_orc]).", document.getElementById('cod_item').value, document.getElementById('addItemQnt').value, ".(int)($_SESSION[cod_cliente]).");}\"> &nbsp; <input type=button id=btnBack name=btnBack value='Voltar' onclick=\"document.getElementById('adddetails').style.display = 'none';document.getElementById('searchresult').style.display = 'block';\"></center>";
                echo "</div>";
            }else{
                echo "<p align=justify>Não foram encontrados resultados para \"<b>".anti_injection($_POST[txtItemName])."</b>\"";
            }
            echo "<BR>";
        }
    }
}else{
    echo "<div class='novidades_text'>";
    echo "<p align=justify>";
    echo "O orçamento de número <b>".(int)($_GET[cod_orc])."</b> que você está tentando editar não está disponível no momento, não existe ou não pode ser alterado. Caso este orçamento não tenha sido finalizado e ainda assim não esteja disponível para edição, por favor, tente acessar novamente em alguns minutos, caso o problema persista, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
    echo "</div>";
    echo "<center><input type=button id=btnBack name=btnBack value='Voltar' onclick=\"location.href='?do=orcamentos';\"></center>";
}

?>

