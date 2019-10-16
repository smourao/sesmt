<?PHP
/***************************************************************************************************/
// --> STEP LIST
//
// 0. Pesquisa de relatórios gerados
// 1. Pesquisa de empresas para gerar um novo relatório
// 2. Configuração de setores, jornada de trabalho, etc...
// 3. Relação de funcionários
// 4. Dados complementares sobre a empresa, pavimentos, etc...
// 5. Seleção de setores para a edição de dados específicos
// 6. Dados sobre edificação como: ventilação, piso, iluminação, parede e cobertura.
// 7. Configuração de posto de trabalho
// 8. Adicionar setores
// 9. Remover setores
// 10. Informações sobre o relatório
// 11. Exclusão do relatório
// 12. Confirmação do relatório
// 13. Gráficos do Histograma (APGRE)
/***************************************************************************************************/
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/

               	$sYear  = is_numeric($_GET[sYear]) ? $_GET[sYear] : date("Y");

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
echo "<td width=250 class='text roundborder' valign=top>";

                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Busca por data</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                
				echo "<form name='frm' action='?dir=$_GET[dir]&p=$_GET[p]&sYear=document.getElementById(sYear);' method='post'>";
				echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Informe o ano de referência ao Relatório em Busca para visualizar os gerados.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<table border=0 width=100% align=center>";
                        echo "<tr>";
                        echo "<td class='text'><b>Ano</b></td>";
                        echo "<td class='text'>";
                        echo "<input type='text' class='inputText' name='sYear' id='sYear' value='{$sYear}' size=5 maxlength=4>";
                        echo "</td>";
						
						echo "<td rowspan=2 align=center class='text'>";
                        echo "<input type='submit' class='btn'>";
                        echo "</td>";
						
                        echo "</tr>";
						
						

                        echo "</table>";
				echo "</form>";
						
						
                        
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                
                
                // --> TIPBOX
                echo "<table width=250 border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
		echo "</td>";
				
				
		 echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
            echo "<b>Relatórios</b>";
            
        echo "</td>";
        echo "</tr>";
        echo "</table>";
				
				
echo "</tr>";
echo "</table>";

?>