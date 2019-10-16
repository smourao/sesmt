<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/


//echo "<center><img src='images/cont_atendimento_title.png' border=0></center>";

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Selecione uma opção</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Agendamento' onclick=\"location.href='?dir=cont_atendimento&p=agendamento';\"  onmouseover=\"showtip('tipbox', '- Agendamento, permite o agendamento para ASO\'s e exames complementares.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='btnCon' value='Confirmar'   onclick=\"location.href='?dir=cont_atendimento&p=confirmar';\"  onmouseover=\"showtip('tipbox', '- Confirmar, permite a confirmação de exames realizados.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr><tr>";
                        //echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Certificado'  onmouseover=\"showtip('tipbox', '- Certificado, exibe o certificado da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        //echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Localizar'  onmouseover=\"showtip('tipbox', '- Localizar, permite que seja executada uma busca por outros clientes.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr><tr>";
                        //echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=new';\"  onmouseover=\"showtip('tipbox', '- Novo, permite o cadastro de um novo cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        //echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Mapa' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]&sp=mapa';\" onmouseover=\"showtip('tipbox', '- Mapa, exibe um mapa com a localização da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
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
        echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
        echo "<b>&nbsp;</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

        echo "<br>";

        if($_GET[sp]){
            if(file_exists(current_module_path.anti_injection($_GET[sp]).'.php')){
                include(anti_injection($_GET[sp]).'.php');
            }else{
                showMessage('A página solicitada não está disponível no servidor. Por favor, entre em contato com o setor de suporte!',2);
            }
        }
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>

