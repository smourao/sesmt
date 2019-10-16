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

$ano = $_POST[sYear];

?>
               	

<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>
<tr>
<td width=250 class='text roundborder' valign=top>




				<table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                <td align=center class='text roundborderselected'>
                    <b>PPP Avulso</b>
                </td>
                </tr>
                </table>
                
                
                
                
                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class="roundbordermix text" height=30 align=center onmouseover=\"showtip('tipbox', '- Informe o ano de referência ao Relatório em Busca para visualizar os gerados.');\" onmouseout=\"hidetip('tipbox');\">
                       <table border=0 width=100% align=center>
                        <tr>
                        <td class="text"><b>PPP</b></td>
                        
						<td rowspan=2 align=center class="text">
                        <input type="submit" class="btn" value="Gerar" onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&ppplist=true" ?>'">
                        </td>
						
                        </tr>
						
						

                        </table>
						
						
                        
                    </td>
                </tr>
                </table>
                
                
                
                
                
                
                




                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                <td align=center class='text roundborderselected'>
                    <b>Busca por data</b>
                </td>
                </tr>
                </table>

                
				
				<table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class="roundbordermix text" height=30 align=center onmouseover=\"showtip('tipbox', '- Informe o ano de referência ao Relatório em Busca para visualizar os gerados.');\" onmouseout=\"hidetip('tipbox');\">
                       <table border=0 width=100% align=center>
                        <tr>
                        <td class="text"><b>Ano</b></td>
                        <td class='text'>
                        <input type="text" class="inputText" name="sYear" id="sYear" value="<?php echo $sYear ?>" size=5 maxlength=4>
                        </td>
						
						<td rowspan=2 align=center class="text">
                        <input type="submit" class="btn" value="Buscar" onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&sYear=' + document.getElementById('sYear').value + '" ?>'">
                        </td>
						
                        </tr>
						
						

                        </table>
						
						
                        
                    </td>
                </tr>
                </table>
                <P>
                
                <?php
                // --> TIPBOX
				?>
                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class=text height=30 valign=top align=justify>
                        <div id="tipbox" class="roundborderselected text" style="display: none;">&nbsp;</div>
                    </td>
                </tr>
                </table>
		</td>
				
				
		 <td class="text roundborder" valign=top>
        <table width=100% border=0 cellspacing=2 cellpadding=2>
        <tr>
        <td align=center class="text roundborderselected">
            <b>Relatórios</b>
            
        </td>
        </tr>
        <tr>
        <td>
        <?php
		if($_GET[sYear]){
			include("list.php");
		}
		elseif($_GET[ppplist]){
			include("ppp_avulso.php");
		}
		?>
        </table>
				
				
</tr>
</table>