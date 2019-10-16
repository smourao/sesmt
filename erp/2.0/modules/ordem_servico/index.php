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
                    <b>Ordem de Serviço</b>
                </td>
                </tr>
                </table>
                
                
                
                
                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class="roundbordermix text" height=30 align=center onmouseover=\"showtip('tipbox', '- Informe o ano de referência ao Relatório em Busca para visualizar os gerados.');\" onmouseout=\"hidetip('tipbox');\">
                       <table border=0 width=100% align=center>
                        <tr>
                        
						<td align=center class="text">
                        <input type="submit" class="btn" value="Minha Lista" onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&lista=true" ?>'">
                        </td>
                        
                        <td align=center class="text">
                        <input type="submit" class="btn" value="Meus Pedidos" onclick="location.href='<?php echo "?dir=ordem_servico&p=index&action=minha_ordem" ?>'">
                        </td>
						
                        </tr>
                        
                        <tr>
                        
						<td align=center class="text">
                        <input type="submit" class="btn" value="Novo" onclick="location.href='<?php echo "?dir=ordem_servico&p=index&action=new" ?>'">
                        </td>
                        
                        
                        <?php
                        
						if($_GET['action']){
							
						?>
                        
                        <td align=center class="text">
                        <input type="submit" class="btn" value="Voltar" onclick="location.href='<?php echo "?dir=ordem_servico&p=index&lista=true" ?>'">
                        </td>
							
						<?php
						}else{
						
						$url = "http://" . $_SERVER['HTTP_HOST'] . "/erp/2.0/";
                        ?>
                        <td align=center class="text">
                        <input type="submit" class="btn" value="Voltar" onclick="location.href='<?php echo "$url" ?>'">
                        </td>
						
                        <?php
						}
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
            <b>Ordem de Serviço</b>
            
        </td>
        </tr>
        <tr>
        <td>
        <?php
		if($_GET[action] == 'view'){
			include("view_os.php");
			
		}else if($_GET[action] == 'new'){
			include("new_os.php");
			
		}else if($_GET[action] == 'minha_ordem'){
			include("minha_ordem.php");
			
		}else{
			include("minha_lista.php");
			
		}
		?>
        </table>
				
				
</tr>
</table>