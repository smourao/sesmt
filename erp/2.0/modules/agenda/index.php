<?PHP
/***************************************************************************************************/
// --> FUNCTIONS
/***************************************************************************************************/
function dia($dia){
    switch($dia){
        case "0" : echo "Dom"; break;
        case "1" : echo "Seg"; break;
        case "2" : echo "Ter"; break;
        case "3" : echo "Qua"; break;
        case "4" : echo "Qui"; break;
        case "5" : echo "Sex"; break;
        case "6" : echo "Sáb"; break;
    }
}
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
if($_GET['m'] != "")
    $mes = $_GET['m'];
else
    $mes = date("n");

if($_GET['y'] != "")
    $ano = $_GET['y'];
else
    $ano = date("Y");


$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
$dsem = 0;
$dmes = 1;
$semana = 0;
$dia = date("j");//"d" 01 - 31 | "j" 1 - 31
$dia_semana = date("w", mktime(0, 0, 0, $mes, 1, $ano));//date("w");
$dsel = $_GET[d];
$t_mes = date("t", mktime(0, 0, 0, $mes, 1, $ano)); //cal_days_in_month(CAL_GREGORIAN, 8, 2003);
//$agen = array();

$sql = "SELECT * FROM site_aso_agendamento
        WHERE EXTRACT(month FROM data_agendamento) = $mes
        AND
        EXTRACT(year FROM data_agendamento) = $ano";
$ragen = pg_query($sql);
$lagen = pg_fetch_all($ragen);
$diasagen = array();
for($x=0;$x<pg_num_rows($ragen);$x++){
    $diasagen[] = date("j", strtotime($lagen[$x][data_agendamento]));
}

if(empty($dsel) && in_array($dia, $diasagen))
    $dsel = $dia;

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
                    echo "<td class='text' height=30 align=left>";
                    
/**************************************************************************************************/
// -->  CALENDAR
/**************************************************************************************************/
                    echo "<table border=0 width=240 height=180 align=center cellpadding=0 cellspacing=0>";
                    if($dsel)
                        $passday = $dsel;
                    else
                        $passday = $dia;
                    
                    echo "<tr class='text roundborderselected'>";
                    echo "<td align=left class='curhand' onclick=\"location.href='?dir=agenda&p=index&d=$passday&m=".date("n&\y=Y", mktime(0,0,0,$mes-1, $dia, $ano))."';\"  onmouseover=\"showtip('tipbox', '- Exibir mês anterior.');\" onmouseout=\"hidetip('tipbox');\"><</td>";
                    echo "<td align=center class='text' colspan=5>".$meses[$mes]." de $ano</td>";
                    echo "<td align=right class='curhand' onclick=\"location.href='?dir=agenda&p=index&d=$passday&m=".date("n&\y=Y", mktime(0,0,0,$mes+1, $dia, $ano))."';\" onmouseover=\"showtip('tipbox', '- Exibir mês seguinte.');\" onmouseout=\"hidetip('tipbox');\">></td>";
                    echo "</tr>";

                    //dias da semana
                    echo "<tr class='text roundborderselected'>";
                    for($x=0;$x<7;$x++){
                        echo "<td height=10 align=center class='text' width=34><b>";
                        dia($x);
                        echo "</b></td>";
                    }
                    echo "</tr>";
                    //*******************************************
                    //LOOP PRINCIPAL
                    //*******************************************
                    while($dmes <= $t_mes){
                         echo "<tr>";
                         //ACCERT OF VARIABLES - RESETS
                         If($dia_semana > 6)
                             $dia_semana = 0;
                         $dsem = 0;
                         $semana = 0;

                         //Monta semana na agenda
                         while($semana < 7){
                             if($dsem>6)
                                 $dsem = 0;

                          $dtz = $ano."-".str_pad($mes, 2, "0", STR_PAD_LEFT)."-".str_pad($dmes, 2, "0", STR_PAD_LEFT);
                          if($dmes <= $t_mes){
                             if($dia_semana == $dsem){
                                       $total_dia = 0;//total para cada dia
                                       //se houver agendamentos
                                           //if data verificado = hoje
                                           if($dmes == $dia /*|| $dmes == date("j")*/){
                                               //if existe agendamento pra data
                                               if(in_array($dmes, $diasagen)){
                                                   //if dia verificado = dia selecionado
                                                   if($dmes == $dsel){
                                                       echo "<td align=center class='text roundborderselectedred curhand' height=30";
                                                       echo ";' onclick=\"location.href='?dir=agenda&p=index&d=$dmes&m=$mes&y=$ano';\"><b>$dmes</b></td>";
                                                   }else{
                                                       echo "<td align=center class='text roundborderselected curhand' height=30";
                                                       echo ";' onclick=\"location.href='?dir=agenda&p=index&d=$dmes&m=$mes&y=$ano';\"><b>$dmes</b></td>";
                                                   }
                                               }else{
                                                   echo "<td align=center class='text roundborderselected' height=30";
                                                   echo ";' alt='Não há compromissos para esta data!' title='Não há compromissos para esta data!'><i>$dmes</i></td>";
                                               }
                                           }else{
                                               //if existe agendamento pra data
                                               if(in_array($dmes, $diasagen)){
                                                   //if dia verificado = dia selecionado
                                                   if($dmes == $dsel){
                                                       echo "<td  align=center class='text roundborderselectedred curhand' height=30";
                                                       echo ";' onclick=\"location.href='?dir=agenda&p=index&d=$dmes&m=$mes&y=$ano';\"><b>$dmes</td>";
                                                   }else{
                                                       echo "<td  align=center class='text roundbordermix curhand' height=30";
                                                       echo ";' onclick=\"location.href='?dir=agenda&p=index&d=$dmes&m=$mes&y=$ano';\"><b>$dmes</td>";
                                                   }
                                               }else{
                                                   echo "<td  align=center class='text roundbordermix' height=30";
                                                   echo ";' alt='Não há compromissos para esta data!' title='Não há compromissos para esta data!'><i>$dmes</i></td>";
                                               }
                                           }
                                 $dia_semana++;
                                 $dsem++;
                                 $dmes++;
                             }else{
                                //BEGIN OF CALENDAR - BLANK SPACES
                                echo "<td align=center class='text roundbordermix'>&nbsp;</td>";
                                $dsem++;
                             }
                          }else{
                                //END OF CALENDAR - BLANK SPACES
                                echo "<td align=center class='text roundbordermix'>&nbsp;</td>";
                                $dsem++;
                          }
                             $semana++;
                         }
                        echo "</tr>";
                    }
                    echo "</table>";
/**************************************************************************************************/

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
        if($dsel){
            echo "<td align=center class='text roundborderselected'><b>Compromissos para $dsel de ".$meses[$mes]." de $ano</b></td>";
        }else{
            echo "<td align=center class='text roundborderselected'><b>&nbsp;</b></td>";
        }
        echo "</tr>";
        echo "</table>";
        
        echo "<P>";
        /*
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td class='text'>";
        echo "<b>Compromissos:</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        */
        if($dsel){
            $sql = "SELECT * FROM site_aso_agendamento
            WHERE
            EXTRACT(day FROM data_agendamento) = $dsel
            AND
            EXTRACT(month FROM data_agendamento) = $mes
            AND
            EXTRACT(year FROM data_agendamento) = $ano";
            $res = pg_query($sql);
            $comp = pg_fetch_all($res);
            if(pg_num_rows($res)>0){
                for($x=0;$x<pg_num_rows($res);$x++){
                    $sql = "SELECT c.*, f.*, cl.* FROM cliente c, funcionarios f, clinicas cl
                    WHERE
                    c.cliente_id = {$comp[$x][cod_cliente]}
                    AND
                    f.cod_func = {$comp[$x][cod_funcionario]} AND f.cod_cliente = c.cliente_id
                    AND
                    cl.cod_clinica = {$comp[$x][cod_clinica]}
                    ";
                    $rdata = pg_query($sql);
                    $buffer= pg_fetch_array($rdata);

                    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                    echo "<tr>";
                    echo "<td align=justify class='text roundborder'>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td align=center class='text roundborderselected'><b>Agendamento de ASO</b></td>";
                        echo "</tr>";
                        echo "</table>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' width=150><b>Empresa:</b></td><td class='text'>$buffer[razao_social]</td>";
                        echo "</tr><tr>";
                        echo "<td class='text' width=150><b>Funcionário:</b></td><td class='text'>$buffer[nome_func]</td>";
                        echo "</tr><tr>";
                        echo "<td class='text' width=150><b>Clínica:</b></td><td class='text'>$buffer[razao_social_clinica]</td>";
                        echo "</tr>";
                        echo "</table>";
                        /*
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td align=center class='text roundbordermix'>";
                            echo "<input type='button' class='btn' name='btnEditar' value='Editar'>";
                            echo "&nbsp;";
                            echo "<input type='button' class='btn' name='btnExcluir' value='Excluir'>";
                        echo "</td>";
                        echo "</tr>";
                        echo "</table>";
                        */
                    echo "<td>";
                    echo "</tr>";
                    echo "</table>";
                    echo "<BR>";
                }
            }else{
            
            }
        }
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>
