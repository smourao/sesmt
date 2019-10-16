<?PHP

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
?>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>
<tr>
<td width=250 class='text roundborder' valign=top>




				<table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                <td align=center class='text roundborderselected'>
                    <b>Tabela de Pre&ccedil;os</b>
                </td>
                </tr>
                </table>
                
                
                
                
                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class="roundbordermix text" height=30 align=center onmouseover=\"showtip('tipbox', '- Informe o ano de referência ao Relatório em Busca para visualizar os gerados.');\" onmouseout=\"hidetip('tipbox');\">
                       <table border=0 width=100% align=center>
                        <tr>
                        <td class="text"><b><input type="submit" class="btn" value="Novo" onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&novo=true" ?>'"></b></td>
                        
						<td rowspan=2 align=center class="text">
                        <input type="submit" class="btn" value="Lista" onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&lista=true" ?>'">
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
            <b>Tabela de Pre&ccedil;os</b>
            
        </td>
        </tr>
        <tr>
        <td>
        <?php
		if($_GET[novo]){
			include("nova_tabela.php");
			
		}elseif($_GET[lista]){
			include("lista_tabela.php");
			
		}elseif($_GET[edittable]){
			include("edit_tabela.php");
			
		}
		?>
        </table>
				
				
</tr>
</table>