<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>

<?PHP

if(isset($_GET[ativar])){
	
	$statuspreco_sql = "UPDATE preco_aso_cnpj SET status = 0 WHERE id={$_GET[ativar]}";
	$statuspreco = pg_query($statuspreco_sql);
	
}elseif(isset($_GET[desativar])){
	
	$statuspreco_sql = "UPDATE preco_aso_cnpj SET status = 1 WHERE id={$_GET[desativar]}";
	$statuspreco = pg_query($statuspreco_sql);
	
}




/***************************************************************************************************/
	$pacnpjsql = "SELECT * FROM preco_aso_cnpj ORDER BY id DESC";
	
	$pacnpjquery = pg_query($pacnpjsql);
	
	$pacnpj = pg_fetch_all($pacnpjquery);
	
	$pacnpjnum = pg_num_rows($pacnpjquery);

/***************************************************************************************************/


	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Cadastro de CPNJ</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";

   
		
		?>
		
		<form action="http://sesmt-rio.com/erp/2.0/modules/preco_aso_cnpj/insertcnpj.php" id="frm" method="post">
		
        <?php
        
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=40% align=center class='text'>";

				echo "<b>CNPJ</b>";

				echo "</td>";

                echo "<td width=40% align=center class='text'>";

                echo "<b>Preço</b>";

                echo "</td>";

                echo "<td width=20% align=center class='text'>";

                echo "<b>Salvar</b>";

                echo "</td>";

            echo "</tr>";
			
			echo "<tr>";
			
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<input type='text' name='cnpj' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\" required >";

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

					echo "<input type='text' class='inputTextobr' size=8 name=preco id=preco onkeypress=\"return FormataReais(this, '.', ',', event);\">";

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<input type='submit' name='salvar' value='Salvar'>";

                echo "</td>";
			
			echo "</tr>";
			
		 echo "</table>";
		 
		 echo "</form>";
		 
		 
		 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=25% align=center class='text'>";

				echo "<b>Cod</b>";

				echo "</td>";
				
				echo "<td width=25% align=center class='text'>";

                echo "<b>CNPJ</b>";

                echo "</td>";

                echo "<td width=25% align=center class='text'>";

                echo "<b>Preço</b>";

                echo "</td>";

				echo "<td width=25% align=center class='text'>";

                echo "<b>Opções</b>";

                echo "</td>";

            echo "</tr>";
			
			for($x=0;$x<$pacnpjnum;$x++){
			
			$br_data1 = explode('-',($pacnpj[$x][data_lancamento]));
			$br_data2 = $br_data1[2].'/'.$br_data1[1].'/'.$br_data1[0];	
				
				
			
			echo "<tr>";
		
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo $pacnpj[$x][id];

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

                    echo $pacnpj[$x]['cnpj_cliente'];

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand'>";

                    echo $pacnpj[$x]['preco_aso'];

                echo "</td>";
				
				echo "<td align=center class='text roundbordermix curhand'>";
				
				if($pacnpj[$x][status] == 1)

                    echo "<a href='?dir=preco_aso_cnpj&p=index&ativar={$pacnpj[$x][id]}'>Ativar</a>";
					
				else
				
					echo "<a href='?dir=preco_aso_cnpj&p=index&desativar={$pacnpj[$x][id]}'>Desativar</a>";

                echo "</td>";
			
			echo "</tr>";
			
			}
			
		echo "</table>";

   

    echo "</td>";

    echo "</tr>";

    echo "</table>";



?>
</body>
</html>