<img src='images/sub-excluir-orcamento.jpg' border=0>
<?PHP
if($_POST && $_POST[delOrcOk]){
    if(is_numeric($_GET[cod_orc]) && (int)($_GET[cod_orc]) > 0){
        $sql = "SELECT * FROM cliente WHERE cliente_id = ".(int)($_SESSION[cod_cliente]);
        $cliente = pg_fetch_array(pg_query($sql));
        
        $sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = ".(int)($_GET[cod_orc])." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
        $buf = pg_query($sql);
        if(pg_num_rows($buf)){
            $sql = "DELETE FROM site_orc_produto WHERE cod_orcamento = ".(int)($_GET[cod_orc])." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
            pg_query($sql);
            $sql = "DELETE FROM site_orc_info WHERE cod_orcamento = ".(int)($_GET[cod_orc])." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
            if(pg_query($sql)){
                //send_mail();
                $msg = "";
                $msg .= "<center><b>$cliente[razao_social]</b></center>";
                $msg .= "<p>";
                $msg .= "Orçamento número $_GET[cod_orc] excluído pelo cliente através do site às ".date("H:i:s")." do dia ".date("d/m/Y").".";
                $msg .= "<p>";
                $msg .= "Logado no site como: $_SESSION[user_id]<BR>";
                $msg .= "IP: ".$_SERVER[REMOTE_ADDR];
                $msg .= "<p>";

                $title = "Exclusão de orçamento número: $_GET[cod_orc]";

                report_mail($msg, $title);
                makeLog($_SESSION[user_id], $detail = "Orçamento $_GET[cod_orc] excluído pelo cliente.", 202, $sql);
                
                echo "<div class='novidades_text'>";
                echo "<p align=justify>";
                echo "O orçamento número: ".str_pad($_GET[cod_orc], 4, "0",0)."
                foi excluído com sucesso.";
                echo "<p align=justify>";
                echo "</div>";
                echo "<p>";
                echo "<center><input type='button' id='btnBack' name='btnBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
            }else{
                echo "<div class='novidades_text'>";
                echo "<p align=justify>";
                echo "Não foi possível aprovar o orçamento informado. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
                echo "</div>";
                echo "<p>";
                echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
                makeLog($_SESSION[user_id], $detail = "Erro ao excluir o orçamento $_GET[cod_orc] pelo cliente.", 203, $sql);
            }
        }else{
            echo "<div class='novidades_text'>";
            echo "<p align=justify>";
            echo "O orçamento informado não é válido ou não está disponível. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
            echo "</div>";
            echo "<p>";
            echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
            makeLog($_SESSION[user_id], $detail = "Erro ao excluir o orçamento $_GET[cod_orc] pelo cliente.", 203, $sql);
        }
    }else{
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "O orçamento informado não é válido ou não está disponível. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
        echo "</div>";
        echo "<p>";
        echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
        makeLog($_SESSION[user_id], $detail = "Erro ao excluir o orçamento $_GET[cod_orc] pelo cliente.", 203, $sql);
    }
}else{
    if(is_numeric($_GET[cod_orc]) && (int)($_GET[cod_orc]) > 0){
        $sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = ".(int)($_GET[cod_orc])." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
        $buf = pg_query($sql);
        if(pg_num_rows($buf)){
            $buffer = pg_fetch_array($buf);
            echo "<div class='novidades_text'>";
            echo "<p align=justify>";
            echo "Você selecionou <font color=red><b>excluir</b></font> o orçamento número: <a href='?do=orcamentos&act=view&cod_orc=$buffer[cod_orcamento]'>".str_pad($buffer[cod_orcamento], 4, "0",0)."</a>. ";
            echo "Após excluir este orçamento, o mesmo não poderá mais ser recuperado.";
            echo "<p align=justify>";
            echo "Tem certeza que deseja excluir este orçamento?";
            echo "</div>";
            echo "<p>";
            echo "<form method='post' name='frmDelOrc' id='frmDelOrc'>";
            echo "<center><input type='submit' id='delOrcOk' name='delOrcOk' value='Sim, excluir este orçamento.'>&nbsp;<input type='button' id='delOrcCancel' name='delOrcCancel' value='Não, cancelar a exclusão.' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
            echo "</form>";
        }else{
            echo "<div class='novidades_text'>";
            echo "<p align=justify>";
            echo "O orçamento informado não é válido ou não está disponível. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
            echo "</div>";
            echo "<p>";
            echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
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
