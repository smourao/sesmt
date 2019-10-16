<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);

//echo "<center><img src='images/cont_atendimento_title.png' border=0></center>";

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
    echo "<td width=250 class='text roundborder' valign=top>";
        //No client type selected - show all options - first step...
        if(!$_GET[tc]){
            echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
            echo "<tr>";
            echo "<td align=center class='text roundborderselected'>";
                echo "<b>Selecione o tipo de cliente</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";

            echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
            echo "<tr>";
                echo "<td class='roundbordermix text' height=30 align=left>";
                    echo "<table width=100% border=0>";
                    echo "<tr>";
                    echo "<td class='text' align=left>";
                        echo "<input type=radio name=rdTipoCliente id=rdTipoCliente value='1' onclick=\"location.href='?dir=cont_atendimento&p=agendamento&tc=1';\"> Cliente SESMT<BR>";
                        echo "<input type=radio name=rdTipoCliente id=rdTipoCliente value='2' onclick=\"location.href='?dir=cont_atendimento&p=agendamento&tc=2';\"> Avulso - Pessoa Jurídica<BR>";
                        echo "<input type=radio name=rdTipoCliente id=rdTipoCliente value='3' onclick=\"location.href='?dir=cont_atendimento&p=agendamento&tc=3';\"> Avulso - Pessoa Física";
                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                echo "</td>";
            echo "</tr>";
            echo "</table>";
        }elseif($_GET[tc] == 1){
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
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome da empresa no campo e clique em Busca para pesquisar uma empresa.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";
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
        //no selected
        if(!$_GET[tc]){
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td align=center class='text roundborderselected'>";
            echo "<b>&nbsp;</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<center><font size=1>";
            echo "</font></center>";
        }elseif($_GET[tc]==1){
		  
            if(is_numeric($_POST[search])){
                $sql = "SELECT * FROM cliente WHERE cliente_id = {$_POST[search]}";
            }else{
			  if($_POST[search] == ""){
			    $sql = "SELECT * FROM cliente WHERE cliente_id = -1";
			  }else{
                $sql = "SELECT * FROM cliente WHERE lower(razao_social) LIKE '%".strtolower($_POST[search])."%'";
              }
			}
            $res = pg_query($sql);
            $list = pg_fetch_all($res);
            
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td align=center class='text roundborderselected'>";
            echo "<b>Busca por cliente SESMT</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td align=left class='text' width=20><b>Cód:</b></td>";
            echo "<td align=left class='text'><b>Empresa:</b></td>";
            //echo "<td align=left class='text' width=100><b>Exibir no site:</b></td>";
            echo "</tr>";
            for($i=0;$i<pg_num_rows($res);$i++){
                echo "<tr class='text roundbordermix'>";
                echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=cont_atendimento&p=agenda_cliente&cod_cliente={$list[$i]['cliente_id']}';\">".str_pad($list[$i]['cliente_id'], 4, "0", 0)."</td>";
                echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=cont_atendimento&p=agenda_cliente&cod_cliente={$list[$i]['cliente_id']}';\">{$list[$i]['razao_social']}</td>";
/*
                echo "<td align=left class='text roundborder' id='dcont".$list[$i][cliente_id]."'>";
                echo "<input type='checkbox' disabled id='showsite".$list[$i][cliente_id]."' name='showsite".$list[$i][cliente_id]."'";
                print $list[$i][showsite] ? " checked " : "";
                echo " onclick=\"show_in_website('".$list[$i][cliente_id]."');\"> <a href=\"javascript:show_in_website('".$list[$i][cliente_id]."');\">Exibir</a>";
                echo "</td>";
*/
                echo "</tr>";
            }
            echo "</table>";
        }
        echo "<p>";


/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>