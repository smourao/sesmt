<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>

<?PHP

/***************************************************************************************************/
	

/***************************************************************************************************/


	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Cadastro de Tabela</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";
		
		?>
		
		<form action="http://sesmt-rio.com/erp/2.0/modules/tabela_preco/inserttabela.php" id="frm" method="post">
		
        <?php
        
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=40% align=center class='text'>";

				echo "<b>Nome</b>";

				echo "</td>";

                echo "<td width=40% align=center class='text'>";

                echo "<b>Fosco</b>";

                echo "</td>";

               /* echo "<td width=20% align=center class='text'>";

                echo "";

                echo "</td>"; */
 
            echo "</tr>";
			
			echo "<tr>";
			
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<input type='text' name='nome' required>";

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

				?>


                    <input type="text" name="valor1" onKeyPress="return FormataReais(this, '.', ',', event);" required>
					
				<?php	
					
					

                echo "</td>";

               /* echo "<td align=center>";

                    echo "";

                echo "</td>"; */
			
			echo "</tr>";
			
		 echo "</table>";
		 
		 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		 echo "<tr>";

				echo "<td width=40% align=center class='text'>";

				echo "<b>Brilhante</b>";

				echo "</td>";

                echo "<td width=40% align=center class='text'>";

                echo "<b>Fosforescente</b>";

                echo "</td>";

              /*  echo "<td width=20% align=center class='text'>";

                echo "<b>Enviar</b>";

                echo "</td>"; */

            echo "</tr>";
			
			echo "<tr>";
			
				echo "<td align=center class='text roundbordermix curhand'>";

                    ?>


                    <input type="text" name="valor2" onKeyPress="return FormataReais(this, '.', ',', event);" required>
					
				<?php	

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

                    ?>


                    <input type="text" name="valor3" onKeyPress="return FormataReais(this, '.', ',', event);" required>
					
				<?php	

                echo "</td>";
				echo "</tr>";
				echo "</table>";

              /*  echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<input type='submit' name='enviar'>";

                echo "</td>"; */
			
			echo "</tr>";
			echo "</table>";
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
		 	echo "<td align=center class='text roundbordermix curhand'>";
			echo "<input type='submit' name='enviar'>";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			
		 echo "</form>";
		 echo "</table>";
		 

?>
</body>
</html>
