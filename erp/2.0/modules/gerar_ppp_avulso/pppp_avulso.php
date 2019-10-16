<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>

<?PHP

/***************************************************************************************************/
	$pppavulsosql = "SELECT id, razao_social, nome_func, data_lancamento FROM ppp_avulso";
	
	$pppavulsoquery = pg_query($pppavulsosql);
	
	$pppavulso = pg_fetch_all($pppavulsoquery);
	
	$pppavulsonum = pg_num_rows($pppavulsoquery);

/***************************************************************************************************/

if($_GET[ppplist]){
	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Cadastro PPP Avulso</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";

    if($_GET[ppplist]){
		
		?>
		
		<form action="http://sesmt-rio.com/erp/2.0/modules/relatorio_aso_avulso/insertppp.php" id="frm" method="post">
		
        <?php
        
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=40% align=center class='text'>";

				echo "<b>Razão Social</b>";

				echo "</td>";

                echo "<td width=40% align=center class='text'>";

                echo "<b>Nome do Funcionário</b>";

                echo "</td>";

                echo "<td width=20% align=center class='text'>";

                echo "<b>Enviar</b>";

                echo "</td>";

            echo "</tr>";
			
			echo "<tr>";
			
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<input type='text' name='razao_social'>";

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<input type='text' name='nome_func'>";

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<input type='submit' name='enviar'>";

                echo "</td>";
			
			echo "</tr>";
			
		 echo "</table>";
		 
		 echo "</form>";
		 
		 
		 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=20% align=center class='text'>";

				echo "<b>Cod</b>";

				echo "</td>";
				
				echo "<td width=20% align=center class='text'>";

                echo "<b>Razão Social</b>";

                echo "</td>";

                echo "<td width=20% align=center class='text'>";

                echo "<b>Nome do Funcionário</b>";

                echo "</td>";

                echo "<td width=20% align=center class='text'>";

                echo "<b>Data de Lançamento</b>";

                echo "</td>";
				
				echo "<td width=20% align=center class='text'>";

                echo "<b>Visualizar</b>";

                echo "</td>";

            echo "</tr>";
			
			for($x=0;$x<$pppavulsonum;$x++){
			
			$br_data1 = explode('-',($pppavulso[$x][data_lancamento]));
			$br_data2 = $br_data1[2].'/'.$br_data1[1].'/'.$br_data1[0];	
				
				
			
			echo "<tr>";
		
				echo "<td align=center class='text roundbordermix curhand' onclick=\"location.href='?dir=gerar_ppp_avulso&p=cadastro&id={$pppavulso[$x][id]}';\">";

                    echo $pppavulso[$x][id];

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand' onclick=\"location.href='?dir=gerar_ppp_avulso&p=cadastro&id={$pppavulso[$x][id]}';\">";

                    echo $pppavulso[$x]['razao_social'];

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand' onclick=\"location.href='?dir=gerar_ppp_avulso&p=cadastro&id={$pppavulso[$x][id]}';\">";

                    echo $pppavulso[$x]['nome_func'];

                echo "</td>";
				
				echo "<td align=center class='text roundbordermix curhand' onclick=\"location.href='?dir=gerar_ppp_avulso&p=cadastro&id={$pppavulso[$x][id]}';\">";

                    echo $br_data2;

                echo "</td>";
				
				echo "<td align=center class='text roundbordermix curhand' onclick=\"location.href='http://www.sesmt-rio.com/erp/2.0/modules/gerar_ppp_avulso/relatorio/index.php?id={$pppavulso[$x][id]}';\">";

                    echo 'Visualizar';

                echo "</td>";
			
			echo "</tr>";
			
			}
			
		echo "</table>";

    }else{

    //caso não seja encontrado nenhum registro

       

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
</body>
</html>
