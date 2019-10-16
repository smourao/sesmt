<?PHP

/***************************************************************************************************/



/***************************************************************************************************/

if($_POST || $_GET[sYear] && is_numeric($_GET[sYear])){


    $result = pg_query($sql);

    $clist = pg_fetch_all($result);

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        if($_GET[sYear] && is_numeric($_GET[sYear])){

            echo "<b>Resultado da busca</b> ".$_GET[sYear];

        }



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";

    if($_GET[sYear]){

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
			
			$consultasql = "SELECT * FROM financeiro_relatorio WHERE semana = $x AND ano = $_GET[sYear] AND pago = 1 AND (SELECT DATE_PART('MONTH', CURRENT_TIMESTAMP) AS data_lancamento) = '{$dataAM}'";
			$consultaquery = pg_query($consultasql);
			$consulta = pg_fetch_all($consultaquery);
			$consultanum = pg_num_rows($consultaquery);
			
			
			$entradanumsql = "SELECT * FROM financeiro_relatorio WHERE semana = $x AND ano = $_GET[sYear] AND status = 0 AND pago = 1 AND (SELECT DATE_PART('MONTH', CURRENT_TIMESTAMP) AS data_lancamento) = '{$dataAM}'";
			$entradanumquery = pg_query($entradanumsql);
			$entradanum = pg_num_rows($entradanumquery);
			
			
			
			$consultaentradasql = "SELECT * FROM financeiro_relatorio WHERE semana = $x AND ano = $_GET[sYear] AND status = 0 AND pago = 1 AND (SELECT DATE_PART('MONTH', CURRENT_TIMESTAMP) AS data_lancamento) = '{$dataAM}'";
			$consultaentradaquery = pg_query($consultaentradasql);
			$consultaentrada = pg_fetch_all($consultaentradaquery);
			$consultaentradanum = pg_num_rows($consultaentradaquery);
			$valorentrada = 0;
			
			$consultasaidasql = "SELECT * FROM financeiro_relatorio WHERE semana = $x AND ano = $_GET[sYear] AND status = 1 AND (SELECT DATE_PART('MONTH', CURRENT_TIMESTAMP) AS data_lancamento) = '{$dataAM}'";
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
			
			
			$valortotal = ($valorentrada - $valorsaida) - 20;
			
			if($consultanum == 0){
				echo "<tr hidden=''>";
			}else{
				echo "<tr>";
			}
        	

                echo "<td align=center class='text roundbordermix curhand'>";

                    echo $x;

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

                    echo $_GET[sYear];

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand'>";

                    echo $entradanum;

                echo "</td>";
				
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo "R$ ".number_format($valorentrada, 2, ',','.');

                echo "</td>";
				
				echo "<td align=center class='text roundbordermix curhand'>";
?>
                    <input type="button" value="Visualizar" onclick="window.open('<?php echo "http://sesmt-rio.com/erp/2.0/modules/relatorio_aso_avulso/relatorio/?semana=$x&ano=$_GET[sYear]" ?>','mywindow','status=no,scrollbars=yes,toolbar=no,resizable=yes,width=800,height=700')">
<?php
                echo "</td>";
				
        	echo "</tr>";

        }

        echo "</table>";

    }else{

    //caso não seja encontrado nenhum registro

        if($_GET[sYear] && is_numeric($_GET[sYear])){

            echo "Não foram encontrados registros para a data informada.";

        }else{

            echo "Não foram encontrados relatórios para o termo informado.";

        }

    }

    echo "<td>";

    echo "</tr>";

    echo "</table>";

}else{



    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        echo "<b>Busca por relatórios</b>";

    echo "</td>";

    echo "</tr>";

    echo "</table>";

}

?>

