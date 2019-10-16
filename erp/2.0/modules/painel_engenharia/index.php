<?PHP

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/


$url = $_SERVER['HTTP_HOST']

?>
               	
                
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">                
                
               


<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>
<tr>
<td width=250 class='text roundborder' valign=top>




				<table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                <td align=center class='text roundborderselected'>
                    <b>Engenharia de Seguran&ccedil;a</b>
                </td>
                </tr>
                </table>
                
                
                
                
                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class="roundbordermix text" height=30 align=center onmouseover=\"showtip('tipbox', '- Informe o ano de referência ao Relatório em Busca para visualizar os gerados.');\" onmouseout=\"hidetip('tipbox');\">
                        <table border=0 width=100% align=center>
                        <tr>
                        <?php
                        echo '<td class="text" onmouseover=\'showtip("tipbox", "- Cadastro de Setor");\' onmouseout=\'hidetip("tipbox");\' ><a href="http://'.$url.'/erp/producao/lista_setor.php" target="_blank" ><b>Cadastro de Setor</b></a></td>';
                        ?>
                        </tr>
						</table>
                        
                        <table border=0 width=100% align=center>
                        <tr>
                        <?php
                        echo '<td class="text" onmouseover=\'showtip("tipbox", "- Cadastro Geral da Função");\' onmouseout=\'hidetip("tipbox");\' ><a href="http://'.$url.'/erp/producao/lista_funcao.php" target="_blank" ><b>Cadastro Geral da Função</b></a></td>';
                        ?>
                        </tr>
						</table>
                        
                        <table border=0 width=100% align=center>
                        <tr>
                        <?php
                        echo '<td class="text" onmouseover=\'showtip("tipbox", "- Cadastro de Treinamento");\' onmouseout=\'hidetip("tipbox");\' ><a href="http://'.$url.'/erp/treinamento/index.php" target="_blank" ><b>Cadastro de Treinamento</b></a></td>';
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
            <b>Painel de Engenharia de Seguran&ccedil;a</b>
            
        </td>
        </tr>
        
        
        </table>
				
				
</tr>
</table>