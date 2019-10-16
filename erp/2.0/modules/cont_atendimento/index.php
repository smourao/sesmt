<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                switch($_GET[sp]){
/*************************************************************************************************/
// --> NEW_AG
/*************************************************************************************************/
                    case 'new_ag':
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
                                echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Novo' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=new_ag';\"  onmouseover=\"showtip('tipbox', '- Agendamento, permite o agendamento para ASO\'s e exames complementares.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                                echo "<td class='text' align=center><input type='button' class='btn' name='btnCon' value='Confirmar'   onclick=\"location.href='?dir=cont_atendimento&p=confirmar';\"  onmouseover=\"showtip('tipbox', '- Confirmar, permite a confirmação de exames realizados.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                                echo "</tr>";
                                echo "</table>";
                            echo "</td>";
                        echo "</tr>";
                        echo "</table>";
                    break;
/******************************************************************************************************************/
// --> NEW_AG_CLIENTE
/******************************************************************************************************************/
                    case 'new_ag_cliente':
                        if($_GET[step] == 1){
                            echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                            echo "<tr>";
                            echo "<td align=center class='text roundborderselected'>";
                                echo "<b>Busca por cliente</b>";
                            echo "</td>";
                            echo "</tr>";
                            echo "</table>";

                            echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                            echo "<tr>";
                            echo "<form method=POST name='frmAgeFindCli'>";
                                echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome da empresa no campo e clique em Busca.');\" onmouseout=\"hidetip('tipbox');\">";
                                    echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                                    echo "&nbsp;";
                                    echo "<input type='submit' class='btn' name='btnSearch' value='Busca' onclick=\"if(document.getElementById('search').value==''){return false;}\">";
                                echo "</td>";
                            echo "</form>";
                            echo "</tr>";
                            echo "</table>";
                            echo "<P>";
                        }elseif($_GET[step] == 2){
                            echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                            echo "<tr>";
                            echo "<td align=center class='text roundborderselected'>";
                                echo "<b></b>";
                            echo "</td>";
                            echo "</tr>";
                            echo "</table>";
                        }elseif($_GET[step] == 3){
                            if($_GET[act] == 'del' && is_numeric($_GET[cod_func])){
                                $sql = "DELETE FROM site_agendamento_exame WHERE cod_agendamento = ".(int)($_GET[cod_agendamento])." AND cod_func = ".(int)($_GET[cod_func]);
                                if(@pg_query($sql)){
                                    redirectme("?dir=$_GET[dir]&p=$_GET[p]&sp=$_GET[sp]&step=$_GET[step]&cod_agendamento=$_GET[cod_agendamento]");
                                }else{
                                    showMessage('Houve um erro ao excluir este funcionário. Por favor, entre em contato com o setor de suporte!',1);
                                }
                            }
                            $sql = "SELECT * FROM site_agendamento_aso WHERE cod_agendamento = ".(int)($_GET[cod_agendamento]);
                            $rag = @pg_query($sql);
                            $aginfo = @pg_fetch_array($rag);
                            
                            echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                            echo "<tr>";
                            echo "<td align=center class='text roundborderselected'>";
                                echo "<b>Busca por funcionário</b>";
                            echo "</td>";
                            echo "</tr>";
                            echo "</table>";

                            echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                            echo "<tr>";
                            echo "<form method=POST name='frmFindFunc'>";
                                echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome da empresa no campo e clique em Busca.');\" onmouseout=\"hidetip('tipbox');\">";
                                    echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                                    echo "&nbsp;";
                                    echo "<input type='submit' class='btn' name='btnSearchFunc' value='Busca' onclick=\"if(document.getElementById('search').value==''){return false;}\">";
                                echo "</td>";
                            echo "</form>";
                            echo "</tr>";
                            echo "</table>";
                            
                            echo "<P>";
                            
                            //$sql = "SELECT * FROM site_agendamento_exame WHERE cod_agendamento = '".(int)($_GET[cod_agendamento])."'";
                            $sql = "SELECT sae.cod_func, f.nome_func FROM site_agendamento_exame sae, funcionarios f WHERE
                                    sae.cod_agendamento = ".(int)($_GET[cod_agendamento])."
                                    AND
                                    f.cod_cliente = $aginfo[cod_cliente]
                                    AND
                                    f.cod_func = sae.cod_func
                                    GROUP BY sae.cod_func, f.nome_func
                                    ORDER BY f.nome_func";
                            $rae = @pg_query($sql);
                            $resex = @pg_fetch_all($rae);
                            
                            echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                            echo "<tr>";
                            echo "<td align=center class='text roundborderselected'>";
                                echo "<b>Resumo de funcionários</b>";
                            echo "</td>";
                            echo "</tr>";
                            echo "</table>";

                            echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                            echo "<tr>";
                                echo "<td class='roundborder text' height=30 align=left>";
                                echo "<table width=100% border=0>";
                                echo "<tr>";
                                echo "<td align=left class='text'>Funcionários selecionados:</td>";
                                echo "<td align=right class='text' width=20><b>".@pg_num_rows($rae)."</b></td>";
                                echo "</tr>";
                                echo "</table>";
                                echo "<div style=\"overflow:auto; width: 100%;\">";
                                echo "<table width=100% border=0>";
                                for($z=0;$z<@pg_num_rows($rae);$z++){
                                    echo "<tr class='roundbordermix'>";
                                    echo "<td class='text10 roundborder' width=25>".str_pad($z+1, 3, "0", 0). "</td>";
                                    echo "<td class='text10 roundborder curhand' alt='Clique aqui para remover este funcionário.' title='Clique aqui para remover este funcionário.' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=$_GET[sp]&step=$_GET[step]&cod_agendamento=$_GET[cod_agendamento]&act=del&cod_func={$resex[$z][cod_func]}';\">".$resex[$z][nome_func]."</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                echo "</div>";
                                echo "</td>";
                            echo "</tr>";
                            echo "</table>";

                            echo "<P>";
                        }elseif($_GET[step] == 4){
                            echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                            echo "<tr>";
                            echo "<td align=center class='text roundborderselected'>";
                                echo "<b>&nbsp;</b>";
                            echo "</td>";
                            echo "</tr>";
                            echo "</table>";
                        }elseif($_GET[step] == 5){
                            echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                            echo "<tr>";
                            echo "<td align=center class='text roundborderselected'>";
                                echo "<b>&nbsp;</b>";
                            echo "</td>";
                            echo "</tr>";
                            echo "</table>";
                        }elseif($_GET[step] == 6){
                            echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                            echo "<tr>";
                            echo "<td align=center class='text roundborderselected'>";
                                echo "<b>&nbsp;</b>";
                            echo "</td>";
                            echo "</tr>";
                            echo "</table>";
                        }

                    break;
/******************************************************************************************************************/
// --> DEFAULT
/******************************************************************************************************************/
                    default:
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
                                echo "<td class='text' align=center><input type='button' class='btn' name='btnNewAgend' value='Agendar Novo' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=new_ag';\"  onmouseover=\"showtip('tipbox', '- Agendamento, permite o agendamento para ASO\'s e exames complementares.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                                echo "<td class='text' align=center><input type='button' class='btn' name='btnCon' value='Confirmar'   onclick=\"location.href='?dir=cont_atendimento&p=confirmar';\"  onmouseover=\"showtip('tipbox', '- Confirmar, permite a confirmação de exames realizados.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                                echo "</tr>";
                                echo "</table>";
                            echo "</td>";
                        echo "</tr>";
                        echo "</table>";
                    break;
                }
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
        switch($_GET[sp]){
            case 'new_ag':
                $pagetitle = "Agendamento";
            break;
            case 'new_ag_cliente':
                if($_GET[step] == 1)
                    $pagetitle = "Agendamento de cliente -> Seleção de cliente";
                elseif($_GET[step] == 3)
                    $pagetitle = "Agendamento de cliente -> Seleção de funcionários";
                elseif($_GET[step] == 4)
                    $pagetitle = "Agendamento de cliente -> Seleção de clínica";
                else
                    $pagetitle = "Agendamento de cliente";
            break;
            default:
                $pagetitle = " &nbsp; ";
            break;
        }
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
        echo "<b>{$pagetitle}</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

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
