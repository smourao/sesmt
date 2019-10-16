<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>

<?PHP

/***************************************************************************************************/

$id_material = $_GET[edittable];


$materialsql = "SELECT * FROM material_tabela WHERE id_material = $id_material";
$materialquery = pg_query($materialsql);
$material = pg_fetch_array($materialquery);
$materialnum = pg_num_rows($materialquery);

$foscosql = "SELECT * FROM tipo_material_tabela WHERE id_material = $id_material AND nome = 'Fosco'";
$foscoquery = pg_query($foscosql);
$fosco = pg_fetch_array($foscoquery);
$fosconum = pg_num_rows($foscoquery);


$brilhosql = "SELECT * FROM tipo_material_tabela WHERE id_material = $id_material AND nome = 'Brilhante'";
$brilhoquery = pg_query($brilhosql);
$brilho = pg_fetch_array($brilhoquery);
$brilhonum = pg_num_rows($brilhoquery);

$fosfosql = "SELECT * FROM tipo_material_tabela WHERE id_material = $id_material AND nome = 'Fosforescente'";
$fosfoquery = pg_query($fosfosql);
$fosfo = pg_fetch_array($fosfoquery);
$fosfonum = pg_num_rows($fosfoquery);

/***************************************************************************************************/


	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Editar Tabela</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";
		
		
		
		echo "<form action='http://sesmt-rio.com/erp/2.0/modules/tabela_preco/updatetabela.php?editmat=$id_material' id='frm' method='post'>";
		
		
		
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
 
            echo "</tr>";
			
			echo "<tr>";
			
				echo "<td align=center class='text roundbordermix curhand'>";

                    echo "<input type='text' name='nome' value='$material[nome]' required>";

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

				?>


                    <input type="text" name="valor1" <?php echo "value='".number_format($fosco['valor'], 2, ',','.')."'" ?> onKeyPress="return FormataReais(this, '.', ',', event);" required>
					
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


                    <input type="text" name="valor2" <?php echo "value='".number_format($brilho['valor'], 2, ',','.')."'" ?> onKeyPress="return FormataReais(this, '.', ',', event);" required>
					
				<?php	

                echo "</td>";

				echo "<td align=center class='text roundbordermix curhand'>";

                    ?>


                    <input type="text" name="valor3" <?php echo "value='".number_format($fosfo['valor'], 2, ',','.')."'" ?> onKeyPress="return FormataReais(this, '.', ',', event);" required>
					
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
