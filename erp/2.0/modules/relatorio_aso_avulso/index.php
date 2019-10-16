<?PHP

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
		}else{
			
		$anocolocar = date("Y");
		
		

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Resultado da busca</b> ".$_GET[sYear];

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";

    

        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=10 align=center class='text'>";

				echo "<b>Semana</b>";

				echo "</td>";

                echo "<td width=10 align=center class='text'>";

                echo "<b>Ano</b>";

                echo "</td>";

                echo "<td width=10 align=center class='text'>";

                echo "<b>N° de Lançamentos</b>";

                echo "</td>";

                echo "<td width=20 align=center class='text'>";

                echo "<b>Valor Total</b>";

                echo "</td>";
				
				echo "<td width=100 align=center class='text'>";

                echo "<b>Relatório</b>";

                echo "</td>";

            echo "</tr>";
			
			$dataAM = date("m");

        for($x=1;$x<54;$x++){
			
			$consultasql = "SELECT * FROM financeiro_relatorio WHERE semana = $x AND ano = $anocolocar AND pago = 1 AND (SELECT DATE_PART('MONTH', CURRENT_TIMESTAMP) AS data_lancamento) = '{$dataAM}'";
			$consultaquery = pg_query($consultasql);
			$consulta = pg_fetch_all($consultaquery);
			$consultanum = pg_num_rows($consultaquery);
			
			$consultaentradasql = "SELECT * FROM financeiro_relatorio WHERE semana = $x AND ano = $anocolocar AND status = 0 AND pago = 1 AND (SELECT DATE_PART('MONTH', CURRENT_TIMESTAMP) AS data_lancamento) = '{$dataAM}'";
			$consultaentradaquery = pg_query($consultaentradasql);
			$consultaentrada = pg_fetch_all($consultaentradaquery);
			$consultaentradanum = pg_num_rows($consultaentradaquery);
			$valorentrada = 0;
			
			$consultasaidasql = "SELECT * FROM financeiro_relatorio WHERE semana = $x AND ano = $anocolocar AND status = 1 AND pago = 1 AND (SELECT DATE_PART('MONTH', CURRENT_TIMESTAMP) AS data_lancamento) = '{$dataAM}'";
			$consultasaidaquery = pg_query($consultasaidasql);
			$consultasaida = pg_fetch_all($consultasaidaquery);
			$consultasaidanum = pg_num_rows($consultasaidaquery);
			$valorsaida = 0;
			
			for($y=0;$y<$consultaentradanum;$y++){
				
				$valorentrada += $consultaentrada[$y][valor];
			}
			
			for($z=0;$z<$consultasaidanum;$z++){
				
				$valorsaida += $consultasaida[$z][valor];
			}
			
			
			$valortotal = $valorentrada - $valorsaida;
			
			if($consultanum  == 0){
				echo "<tr hidden=''>";
			}else{
				echo "<tr>";
			}
        	

                echo "<td align=center class='text roundbordermix curhand'>";

                    echo $x;

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

                    echo $anocolocar;

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand'>";

                    echo $entradanum;

                echo "</td>";
				
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo "R$ ".number_format($valortotal, 2, ',','.');

                echo "</td>";
				
				echo "<td align=center class='text roundbordermix curhand'>";
?>
                    <input type="button" value="Visualizar" onclick="window.open('<?php echo "http://sesmt-rio.com/erp/2.0/modules/relatorio_aso_avulso/relatorio/?semana=$x&ano=$anocolocar" ?>','mywindow','status=no,scrollbars=yes,toolbar=no,resizable=yes,width=800,height=700')">
<?php
                echo "</td>";
				
        	echo "</tr>";

        }

        echo "</table>";

    

    echo "<td>";

    echo "</tr>";

    echo "</table>";






		
		
		
		
		
		
		
		
			
			
		}
		?>
        </table>
				
				
</tr>
</table>