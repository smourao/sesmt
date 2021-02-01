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
                $msg .= "Or�amento n�mero $_GET[cod_orc] exclu�do pelo cliente atrav�s do site �s ".date("H:i:s")." do dia ".date("d/m/Y").".";
                $msg .= "<p>";
                $msg .= "Logado no site como: $_SESSION[user_id]<BR>";
                $msg .= "IP: ".$_SERVER[REMOTE_ADDR];
                $msg .= "<p>";

                $title = "Exclus�o de or�amento n�mero: $_GET[cod_orc]";

                report_mail($msg, $title);
                makeLog($_SESSION[user_id], $detail = "Or�amento $_GET[cod_orc] exclu�do pelo cliente.", 202, $sql);
                
                echo "<div class='novidades_text'>";
                echo "<p align=justify>";
                echo "O or�amento n�mero: ".str_pad($_GET[cod_orc], 4, "0",0)."
                foi exclu�do com sucesso.";
                echo "<p align=justify>";
                echo "</div>";
                echo "<p>";
                echo "<center><input type='button' id='btnBack' name='btnBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
            }else{
                echo "<div class='novidades_text'>";
                echo "<p align=justify>";
                echo "N�o foi poss�vel aprovar o or�amento informado. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
                echo "</div>";
                echo "<p>";
                echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
                makeLog($_SESSION[user_id], $detail = "Erro ao excluir o or�amento $_GET[cod_orc] pelo cliente.", 203, $sql);
            }
        }else{
            echo "<div class='novidades_text'>";
            echo "<p align=justify>";
            echo "O or�amento informado n�o � v�lido ou n�o est� dispon�vel. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
            echo "</div>";
            echo "<p>";
            echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
            makeLog($_SESSION[user_id], $detail = "Erro ao excluir o or�amento $_GET[cod_orc] pelo cliente.", 203, $sql);
        }
    }else{
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "O or�amento informado n�o � v�lido ou n�o est� dispon�vel. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
        echo "</div>";
        echo "<p>";
        echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
        makeLog($_SESSION[user_id], $detail = "Erro ao excluir o or�amento $_GET[cod_orc] pelo cliente.", 203, $sql);
    }
}else{
    if(is_numeric($_GET[cod_orc]) && (int)($_GET[cod_orc]) > 0){
        $sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = ".(int)($_GET[cod_orc])." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
        $buf = pg_query($sql);
        if(pg_num_rows($buf)){
            $buffer = pg_fetch_array($buf);
            echo "<div class='novidades_text'>";
            echo "<p align=justify>";
            echo "Voc� selecionou <font color=red><b>excluir</b></font> o or�amento n�mero: <a href='?do=orcamentos&act=view&cod_orc=$buffer[cod_orcamento]'>".str_pad($buffer[cod_orcamento], 4, "0",0)."</a>. ";
            echo "Ap�s excluir este or�amento, o mesmo n�o poder� mais ser recuperado.";
            echo "<p align=justify>";
            echo "Tem certeza que deseja excluir este or�amento?";
            echo "</div>";
            echo "<p>";
            echo "<form method='post' name='frmDelOrc' id='frmDelOrc'>";
            echo "<center><input type='submit' id='delOrcOk' name='delOrcOk' value='Sim, excluir este or�amento.'>&nbsp;<input type='button' id='delOrcCancel' name='delOrcCancel' value='N�o, cancelar a exclus�o.' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
            echo "</form>";
        }else{
            echo "<div class='novidades_text'>";
            echo "<p align=justify>";
            echo "O or�amento informado n�o � v�lido ou n�o est� dispon�vel. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
            echo "</div>";
            echo "<p>";
            echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"location.href='?do=orcamentos&act=list';\"></center>";
        }
    }else{
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo "O or�amento informado n�o � v�lido ou n�o est� dispon�vel. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com nossa <a href='?do=contato'>central de atendimento</a>.";
        echo "</div>";
        echo "<p>";
        echo "<center><input type='button' id='confirmBack' name='confirmBack' value='Voltar' onclick=\"history.go(-1);\"></center>";
    }
}
?>
