<img src='images/sub-aprovar-orcamento.jpg' border=0>
<?PHP
if($_POST && $_POST[confirmOrcOk]){
    if(is_numeric($_GET[cod_orc]) && (int)($_GET[cod_orc]) > 0){
        $sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = ".(int)($_GET[cod_orc])." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
        $buf = pg_query($sql);
        if(pg_num_rows($buf)){
            $sql = "UPDATE site_orc_info SET aprovado = 1 WHERE cod_orcamento = ".(int)($_GET[cod_orc])." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
            if(pg_query($sql)){
                //send_mail();
                $sql = "SELECT * FROM cliente WHERE cliente_id = ".(int)($_SESSION[cod_cliente]);
                $cliente = pg_fetch_array(pg_query($sql));
                $msg = "";
                $msg .= "<center><b>$cliente[razao_social]</b></center>";
                $msg .= "<p>";
                $msg .= "Orçamento número <a href='http://www.sesmt-rio.com/erp/cria_orcamento.php?act=edit&cod_cliente=$_SESSION[cod_cliente]&cod_filial=1&orcamento=$_GET[cod_orc]' target=_blank>$_GET[cod_orc]</a> finalizado pelo cliente através do site às ".date("H:i:s")." do dia ".date("d/m/Y").".";
                $msg .= "<p>";
                $msg .= "Logado no site como: $_SESSION[user_id]<BR>";
                $msg .= "IP: ".$_SERVER[REMOTE_ADDR];
                $msg .= "<p>";

                $title = "Aprovação de orçamento número: $_GET[cod_orc]";

                report_mail($msg, $title);
                makeLog($_SESSION[user_id], $detail = "Orçamento $_GET[cod_orc] aprovado pelo cliente.", 200, $sql);
                
                echo "<div class='novidades_text'>";
                echo "<p align=justify>";
                echo "O orçamento número: <a href='?do=orcamentos&act=view&cod_orc=$_GET[cod_orc]'>".str_pad($_GET[cod_orc], 4, "0",0)."</a>
                foi aprovado e um comunicado foi enviado ao setor responsável.";
                echo "<p align=justify>";
                echo "A SESMT<sup>®</sup> agradece sua solicitação e entrará em contato em breve. Em caso de dúvidas, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
                echo "</div>";
                echo "<p>";
                echo "<center><input type='button' id='btnBack' name='btnBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
            }else{
                echo "<div class='novidades_text'>";
                echo "<p align=justify>";
                echo "Não foi possível aprovar o orçamento informado. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
                echo "</div>";
                echo "<p>";
                echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"history.go(-1);\"></center>";
                makeLog($_SESSION[user_id], $detail = "Erro ao aprovar o orçamento $_GET[cod_orc] pelo cliente.", 201, $sql);
            }
        }
    }else{
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "O orçamento informado não é válido ou não está disponível. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
        echo "</div>";
        echo "<p>";
        echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"history.go(-1);\"></center>";
        makeLog($_SESSION[user_id], $detail = "Erro ao aprovar o orçamento $_GET[cod_orc] pelo cliente.", 201, $sql);
    }
}else{
    if(is_numeric($_GET[cod_orc]) && (int)($_GET[cod_orc]) > 0){
        $sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = ".(int)($_GET[cod_orc])." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
        $buf = pg_query($sql);

        if(pg_num_rows($buf)){
            $buffer = pg_fetch_array($buf);
            $sql = "SELECT * FROM site_orc_produto WHERE cod_orcamento = ".(int)($_GET[cod_orc])." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
            if(pg_num_rows(pg_query($sql))){
                echo "<div class='novidades_text'>";
                echo "<p align=justify>";
                echo "Você selecionou aprovar o orçamento número: <a href='?do=orcamentos&act=view&cod_orc=$buffer[cod_orcamento]'>".str_pad($buffer[cod_orcamento], 4, "0",0)."</a>. ";
                echo "Ao aprovar este orçamento, você está concordando com todos os serviços listados.";
                echo "<p align=justify>";
                echo "Tem certeza que deseja aprovar este orçamento e solicitar sua execução?";
                echo "</div>";
                echo "<p>";
                echo "<form method='post' name='frmConfirmOrc' id='frmConfirmOrc'>";
                echo "<center><input type='submit' id='confirmOrcOk' name='confirmOrcOk' value='Sim, aprovar este orçamento.'>&nbsp;<input type='button' id='confirmOrcCancel' name='confirmOrcCancel' value='Não, cancelar a aprovação.' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
                echo "</form>";
            }else{
                echo "<div class='novidades_text'>";
                echo "<p align=justify>";
                echo "O orçamento informado não pode ser confirmado, pois não possui items. em caso de dúvidas, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
                echo "</div>";
                echo "<p>";
                echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"history.go(-1);\"></center>";
            }
        }else{
            echo "<div class='novidades_text'>";
            echo "<p align=justify>";
            echo "O orçamento informado não é válido ou não está disponível. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
            echo "</div>";
            echo "<p>";
            echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"history.go(-1);\"></center>";
        }
    }else{
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "O orçamento informado não é válido ou não está disponível. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
        echo "</div>";
        echo "<p>";
        echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"history.go(-1);\"></center>";
    }
}
?>
