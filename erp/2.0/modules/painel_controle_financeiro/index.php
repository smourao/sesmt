<?PHP

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/


$url = $_SERVER['HTTP_HOST']

?>
               	

<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>
<tr>
<td width=250 class='text roundborder' valign=top>




				<table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                <td align=center class='text roundborderselected'>
                    <b>Financeiro</b>
                </td>
                </tr>
                </table>
                
                
                
                
                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class="roundbordermix text" height=30 align=center onmouseover=\"showtip('tipbox', '- Informe o ano de referência ao Relatório em Busca para visualizar os gerados.');\" onmouseout=\"hidetip('tipbox');\">
                        <table border=0 width=100% align=center>
                        <tr>
                        <?php
                        echo '<td class="text" onmouseover=\'showtip("tipbox", "- Controle Financeiro");\' onmouseout=\'hidetip("tipbox");\' ><a href="http://'.$url.'/erp/financeiro/" target="_blank" ><b>Controle Financeiro</b></a></td>';
                        ?>
                        </tr>
						</table>
                        
                        <table border=0 width=100% align=center>
                        <tr>
                        <?php
                        echo '<td class="text" onmouseover=\'showtip("tipbox", "- Gerar Nota Fiscal");\' onmouseout=\'hidetip("tipbox");\' ><a href="https://notacarioca.rio.gov.br/senhaweb/login.aspx" target="_blank" ><b>Gerar Nota Fiscal</b></a></td>';
                        ?>
                        </tr>
						</table>
                        
                        <table border=0 width=100% align=center>
                        <tr>
                        <?php
                        echo '<td class="text" onmouseover=\'showtip("tipbox", "- Gerar Resumo de Fatura");\' onmouseout=\'hidetip("tipbox");\' ><a href="http://'.$url.'/erp/adm/resumo_de_fatura/resumo_de_fatura_index.php" target="_blank" ><b>Gerar Resumo de Fatura</b></a></td>';
                        ?>
                        </tr>
						</table>
						
                        <table border=0 width=100% align=center>
                        <tr>
                        <?php
                        echo '<td class="text" onmouseover=\'showtip("tipbox", "- Planilha de Resumo de Fatura");\' onmouseout=\'hidetip("tipbox");\' ><a href="http://'.$url.'/erp/adm/resumo_de_fatura/planilha_resumo_fatura.php" target="_blank" ><b>Planilha de Resumo de Fatura</b></a></td>';
                        ?>
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
            <b>Painel de Controle Financeiro</b>
            
        </td>
        </tr>
        
        
        </table>
				
				
</tr>
</table>