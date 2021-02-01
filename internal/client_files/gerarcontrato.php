<center><img src='images/gerar_contrato.jpg' border=0></center>
<div class='novidades_text'>
<p align=justify>
O gerar contrato, permite que o próprio cliente selecione sua data de vencimento e forma de pagamento para um
orçamento aprovado e faça seu contrato com base nas informações fornecidas, tudo de forma rápida e prática.
<p align=justify>
Para gerar seu contrato, preencha os campos abaixo com as informações solicitadas e siga as instruções na tela.
<?PHP
/***************************************************************************************************************/
// --> POST
/***************************************************************************************************************/
if($_POST && $_POST[btnDoContract]){
    //:D buceta de asa!!!
    //print_r($_POST);
    $sql = "SELECT * FROM site_gerar_contrato WHERE cod_cliente = ".(int)($_SESSION[cod_cliente]);
    if(!pg_num_rows(pg_query($sql))){
        $sql = "UPDATE site_orc_info SET aprovado = 1 WHERE cod_cliente  = ".(int)($_SESSION[cod_cliente])." AND cod_orcamento = ".(int)($_POST[num_orc]);
        pg_query($sql);
    
        $sql = "INSERT INTO site_gerar_contrato (cod_cliente, cod_filial, cod_orcamento, tipo_contrato, n_parcelas,
        validade, vencimento, valor_contrato, ano_orcamento, atendimento_medico, status, email, data_criacao,
        ultima_alteracao, resumo_gerado)
        VALUES
        ('".(int)($_SESSION[cod_cliente])."', 1, ".(int)($_POST[num_orc]).", '$_POST[tipo_contrato]',
        ".(int)($_POST[forma_pagamento]).", '$_POST[validade_contrato]', '".date("Y/m/".$_POST[vencimento])."',
        '$_POST[valor_orc]', ".date("Y").", 'Não', 0, '$_SESSION[user_id]', '".date("Y/m/d")."', '".date("Y/m/d")."', 0)";

        if(pg_query($sql)){
            echo "<p align=justify>";
            echo "Seu contrato foi gerado com sucesso!";
            $sql = "SELECT * FROM cliente WHERE cliente_id = ".(int)($_SESSION[cod_cliente]);
            $cliente = pg_fetch_array(pg_query($sql));
            $msg = "";
            $msg .= "<center><b>$cliente[razao_social]</b></center>";
            $msg .= "<p>";
            $msg .= "O cliente $cliente[razao_social] gerou seu contrato com base no orçamento número <a href='http://www.sesmt-rio.com/erp/cria_orcamento.php?act=edit&cod_cliente=$_SESSION[cod_cliente]&cod_filial=1&orcamento=$_POST[num_orc]' target=_blank>$_POST[num_orc]</a> através do site às ".date("H:i:s")." do dia ".date("d/m/Y").".";
            $msg .= "<p>";
            $msg .= "Logado no site como: $_SESSION[user_id]<BR>";
            $msg .= "IP: ".$_SERVER[REMOTE_ADDR];
            $msg .= "<p>";
            $title = "Contrato gerado pelo cliente -  $cliente[razao_social]";
            report_mail($msg, $title, 'celso.leo@gmail.com');
            makeLog($_SESSION[user_id], $detail = "Contrato gerado pelo cliente.", 100, $sql);
        }else{
            $msg  = "sql -> $sql<BR>";
            $msg .= "Hora: ".date("d/m/Y à\s H:i:s")."<BR>";
            $msg .= "cod_cliente: ".$_SESSION[cod_cliente]."<BR>";
            $msg .= "cod_orcamento: ".$_POST[num_orc];
            
            $title = "Falha ao gerar contrato no site -  cliente: $_SESSION[cod_cliente]";
            report_mail($msg, $title, 'celso.leo@gmail.com;suporte@sesmt-rio.com');
            makeLog($_SESSION[user_id], $detail = "Erro ao tentar gerar contrato.", 101, $sql);
            echo "<p align=justify>";
            echo "Houve um problema ao tentar gerar este contrato. Por favor, tente novamente em alguns instantes, caso o problema persista, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.";
        }
    }
}

echo "<p><BR></div>";

/***************************************************************************************************************/
//Verifica se já existe orçamento
$sql = "SELECT * FROM site_gerar_contrato WHERE cod_cliente = ".(int)($_SESSION[cod_cliente]);
$rce = pg_query($sql);
if(pg_num_rows($rce) == 0){
    $sql = "SELECT oi.cod_orcamento, oi.data_criacao, count(op.*) as a FROM site_orc_info oi, site_orc_produto op, produto p
    WHERE
        oi.cod_cliente = ".(int)($_SESSION[cod_cliente])."
    AND
        oi.cod_orcamento = op.cod_orcamento
    AND
        p.cod_prod = op.cod_produto
    AND
        oi.cod_orcamento
        NOT IN (SELECT cod_orcamento FROM site_gerar_contrato WHERE cod_cliente = ".(int)($_SESSION[cod_cliente]).")
    GROUP BY
        oi.cod_orcamento, oi.data_criacao
    ORDER BY
        cod_orcamento";
    $rol = pg_query($sql);
    $lorc = pg_fetch_all($rol);
    
    if(pg_num_rows($rol)){
        echo "<BR><img src='images/sub-dados-do-contrato.jpg' border=0>";
        //print_r($lorc);
        echo "<table width=100% cellspacing=2 cellpadding=2 border=0>";

        echo "<form id='frmDoContract' name='frmDoContract' method=post onsubmit=\"return check_gerar_contrato(this);\">";

        echo "<tr>";
            echo "<td width=180>Orçamento:</td>";
            echo "<td width=180>";
                echo "<select class='required' name='num_orc' id='num_orc' onchange=\"check_orc_info(this.value);\" onblur=\"change_classname('num_orc', 'required');\">";
                echo "<option></option>";
                for($x=0;$x<pg_num_rows($rol);$x++){
                    echo "<option value='{$lorc[$x][cod_orcamento]}'>".str_pad($lorc[$x][cod_orcamento], 4, "0",0)."/".date("Y", strtotime($lorc[$x][data_criacao]))."</option>";
                }
                echo "</select>";
                echo "&nbsp;<span id='loading_orc_info'></span>";
            echo "</td>";
            echo "<td rowspan=5 valign=top><div id='orc_info'>&nbsp;</div></td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td width=180>Tipo de contrato:</td>";
            echo "<td>";
                echo "<select name='tipo_contrato' id='tipo_contrato' class='required'  onchange=\"change_classname('tipo_contrato', 'required');\">";
                    echo "<option value=''></option>";
                    echo "<option value='aberto'>Aberto</option>";
                    echo "<option value='fechado'>Fechado</option>";
                    echo "<option value='misto'>Misto</option>";
                    echo "<option value='especifico'>Específico</option>";
                echo "</select>";
            echo "</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td width=180>Forma de pagamento:</td>";
            echo "<td>";
                echo "<select class='required' name='forma_pagamento' id='forma_pagamento' onchange=\"change_classname('forma_pagamento', 'required');\">";
                    echo "<option value=''></option>";
                    echo "<option value='1' >À vista</option>";
	                echo "<option value='3' >03 vezes</option>";
                    echo "<option value='6' >06 vezes  c/ taxa 18%</option>";
                    echo "<option value='10'>10 vezes  c/ taxa 18%</option>";
                    echo "<option value='12'>12 vezes  c/ taxa 18%</option>";
                echo "</select>";
            echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
            echo "<td width=180>Validade do contrato:</td>";
            echo "<td>";
                echo "<select class='required' name='validade_contrato' id='validade_contrato' onchange=\"change_classname('validade_contrato', 'required');\">";
	                echo "<option value='12 Meses'>12 Meses</option>";
                    echo "<option value='24 Meses'>24 Meses</option>";
                    echo "<option value='30 Meses'>30 Meses</option>";
                    echo "<option value='48 Meses'>48 Meses</option>";
            	    echo "<option value='60 Meses'>60 Meses</option>";
                echo "</select>";
            echo "</td>";
        echo "</tr>";
        
        echo "<tr>";
            echo "<td width=180>Dia de vencimento:</td>";
            echo "<td>";
                echo "<select class='required' name='vencimento' id='vencimento' onchange=\"change_classname('vencimento', 'required');\">";
                echo "<option value=''></option>";
                echo "</select>";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "<input type=hidden id='valor_orc' name='valor_orc' value='0'>";
        echo "<BR><p>";
        
        echo "<center><input type=submit id='btnDoContract' name='btnDoContract' value='Gerar contrato'></center>";
        echo "</form>";
        
    }else{
        echo "<img src='images/sub-dados-do-contrato.jpg' border=0>";
        echo "<p align=justify>";
        echo "Não existem orçamentos gerados para que seja possível gerar um novo contrato.";
    }
}else{
    $contrato = pg_fetch_array($rce);
    echo "<div class='novidades_text'>";
    echo "<BR><img src='images/sub-dados-do-contrato.jpg' border=0>";
    echo "<p align=justify>";
    echo "Você pode visualizar seu contrato clicando <a href='internal/client_files/pdf/contrato.php?id=$contrato[id]&cod_cliente=$contrato[cod_cliente]' target=_blank>aqui</a>, ou pode baixá-lo clicando <a href='internal/client_files/pdf/contrato.php?id=$contrato[id]&cod_cliente=$contrato[cod_cliente]&out=D' target=_blank>aqui</a>.";
    echo "<p><BR>";
    echo "<img src='images/sub-procedimentos.jpg' border=0>";
    echo "<p align=justify>";
    echo "Para que o contrato tenha validade, os seguintes passos devem ser seguidos:";
    echo "<p><BR>";
    echo "- Impressão do contrato em duas vias;<BR>";
    echo "- Leitura atenta do contrato;<BR>";
    echo "- Rubricar cada folha do contrato, assinar a última folha e reconhecer firma da assinatura;<BR>";
    echo "- Enviar à SESMT<sup>®</sup> a cópia do contrato via correios, junto com a cópia da primeira e última folha do contrato social ou estatuto.<BR>";
    echo "";
    echo "<p><BR>";
    echo "<img src='images/sub-consideracoes.jpg' border=0>";
    echo "<p align=justify>";
    echo "Os anexos são normatizações que dão validade as cláusulas em que se diz respeito cada um deles, sendo tão somente necessária a rubrica das primeiras páginas, a assinatura da última e o respectivo reconhecimento de firma da assinatura.";
    echo "<p align=justify>";
    echo "Solicitamos ainda, informar ao escritório de contabilidade que presta serviços à sua empresa sobre a celebração do contrato com a SESMT<sup>®</sup>, para que, formalmente apresentados, possamos coletar informações importante à prestação dos serviços.";
    echo "<p align=justify>";
    echo "Para visualizar e imprimir o contrato, você precisa ter instalado em seu computador um programa para visualizar arquivos em PDF, como o <a href='http://get.adobe.com/br/reader/' target=_blank>Acrobat Reader</a> ou o <a href='http://www.baixaki.com.br/download/foxit-pdf-reader.htm' target=_blank>FoxIt</a>.";
    echo "</div>";
}
?>

