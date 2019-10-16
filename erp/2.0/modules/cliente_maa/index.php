<?PHP

	$query_cli = "SELECT cli.cliente_id, cli.razao_social FROM cliente cli, site_orc_info soi, site_orc_produto sop WHERE sop.cod_produto = 70311 AND sop.cod_orcamento = soi.cod_orcamento AND soi.aprovado = 1 AND soi.cod_cliente = cli.cliente_id AND (cli.status = 'ativo' OR cli.status = 'parceria') GROUP BY razao_social, cli.cliente_id ORDER BY razao_social";
	
    $result_cli = pg_query($query_cli);
	
	$result = pg_fetch_all($result_cli);
	
	$result_num = pg_num_rows($result_cli);
	
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>&nbsp;</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=left>";
					echo "<td class='text' align=center>&nbsp;</td>";  echo "</td>";
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
        echo "<td align=center class='text roundborderselected'><b>Lista das Empresas com Mapa Anual de Acidentes</b></td>";
        echo "</tr>";
        echo "</table>";

	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=7><b>Código:</b></td>";
		echo "<td align=left class='text' width=200><b>Razão Social:</b></td>";
        echo "</tr>";
		
		for($x=0;$x<$result_num;$x++){
		
            echo "<tr class='text roundbordermix'>";
            echo "<td align=center class='text roundborder curhand'>". STR_PAD($result[$x][cliente_id], 4, "0", STR_PAD_LEFT) ."</td>";
			echo "<td align=left class='text roundborder curhand'>{$result[$x][razao_social]}";
			echo "</td>";
            echo "</tr>";
		}
        echo "</table>";

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>