<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>

<?PHP

/***************************************************************************************************/
	$materialtablesql = "SELECT * FROM material_tabela";
	
	$materialtablequery = pg_query($materialtablesql);
	
	$materialtable = pg_fetch_all($materialtablequery);
	
	$materialtablenum = pg_num_rows($materialtablequery);

/***************************************************************************************************/

if($_GET[lista]){
	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Lista de Tabelas</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";


		
		
		 
		 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=20% align=center class='text'>";

				echo "<b>Cod</b>";

				echo "</td>";
				
				echo "<td width=60% align=center class='text'>";

                echo "<b>Material</b>";

                echo "</td>";

                echo "<td width=20% align=center class='text'>";

                echo "<b>Entrar</b>";

                echo "</td>";

            echo "</tr>";
			
			for($x=0;$x<$materialtablenum;$x++){
			
				$idmaterial = $materialtable[$x][id_material];
				
			
			echo "<tr>";
		
				?>
				<td align=center class='text roundbordermix curhand' onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&edittable=".$idmaterial."" ?>'">
<?php

                    echo $idmaterial;

                echo "</td>";

				?>
				<td align=center class='text roundbordermix curhand' onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&edittable=".$idmaterial."" ?>'">
<?php

                    echo $materialtable[$x]['nome'];

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand'>";

?>
					<input type="button" value="Visualizar" onclick="window.open('<?php echo "http://sesmt-rio.com/erp/2.0/modules/tabela_preco/relatorio/?idmaterial=".$idmaterial."" ?>','mywindow','toolbar=yes, scrollbars=yes, resizable=yes, width=800,height=700')">

<?php

                echo "</td>";
			
			echo "</tr>";
			
			}
			
		echo "</table>";

  

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
