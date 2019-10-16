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
		
		
		
		$urlwww = $_SERVER['SERVER_NAME'];
						
			if($urlwww == 'www.sesmt-rio.com'){
		
		?>
		
        
		<form action="http://www.sesmt-rio.com/erp/2.0/modules/tabela_preco/inserttabela.php" id="frm" method="post">
		
        <?php
		
		
			}else{
				
				
			?>
            <form action="http://sesmt-rio.com/erp/2.0/modules/tabela_preco/inserttabela.php" id="frm" method="post">
            <?php 
			
			}
		
		echo "<table width=15% border=0>";
		
		
		
		
			echo "<tr>";

				echo "<td align=left class='text'>";
				echo "<b>Aumento(%): </b>";
				echo "</td>";
				
				echo "<td align=left class='text'>";
			?>	
            
            <script language='JavaScript'>
				function keypressed( obj , e ) {
     var tecla = ( window.event ) ? e.keyCode : e.which;
     var texto = document.getElementById("porcen").value
    
    if ( tecla == 8 || tecla == 0 )
        return true;
    if ( tecla != 46 && tecla < 48 || tecla > 57 )
        return false;
    
}
			</script>
            
            	<input type="text" name="porcen" id="porcen" size="2" onkeypress="return keypressed( this , event );"/>
			<?php 
				echo "</td>";
				
			echo "</tr>";
		
		echo "</table>";
        
		
		
		
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
