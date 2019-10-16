<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>





<?PHP

if(isset($_GET[gravar_destrato])){
	
	
	$query_max = "SELECT max(cod_destrato) as cod_destrato FROM site_gerar_destrato";
	$result_max = pg_query($query_max);
	$row_max = pg_fetch_array($result_max);
	$cod_destrato = $row_max[cod_destrato] + 1;
	
	$pegarcontratosql = "SELECT id FROM site_gerar_contrato WHERE cod_cliente = ".$_POST[razao_social];
	$pegarcontratoquery = pg_query($pegarcontratosql);
	$pegarcontrato = pg_fetch_array($pegarcontratoquery);
	$cod_contrato = $pegarcontrato[id];
	
	
	
	$hoje = date("Y-m-d");
	$data_pedido_rescisao = $_POST['data_pedido_rescisao'];
	$data_fim_relacao = $_POST['$data_fim_relacao'];
	
	
	$data_pedido_rescisao = date("Y-m-d", strtotime($data_pedido_rescisao));
	$data_fim_relacao = date("Y-m-d", strtotime($data_fim_relacao));
	
	
	$gerar_destrato_sql = "INSERT INTO site_gerar_destrato (cod_destrato,cod_contrato,cod_cliente,data_destrato,data_pedido_rescisao,data_fim_relacao,status) VALUES ('".$cod_destrato."','".$cod_contrato."','".$_POST[razao_social]."','".$hoje."','".$data_pedido_rescisao."','".$data_fim_relacao."',0)";
	
	
	$gerar_destrato = pg_query($gerar_destrato_sql);
	
	
}








/***************************************************************************************************/
	$destratosql = "SELECT c.razao_social, c.cliente_id FROM site_gerar_contrato sc, cliente c, site_gerar_destrato sd WHERE c.cliente_id = sc.cod_cliente AND sc.cod_cliente != sd.cod_cliente AND sc.status = 2 ORDER BY cliente_id";
	
	$destratoquery = pg_query($destratosql);
	
	$destrato = pg_fetch_all($destratoquery);
	
	$destratonum = pg_num_rows($destratoquery);

/***************************************************************************************************/


	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Gerar Destrato</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";


		
		echo "<form action='?dir=$_GET[dir]&p=index&action=novo_destrato&gravar_destrato=true' method='post'>";
		 
		 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=75% align=center class='text'>";

				echo "<b>Razão Social</b>";

				echo "</td>";
				
				echo "<td width=10% align=center class='text'>";

                echo "<b>Pedido da Rescisão</b>";

                echo "</td>";
				
				echo "<td width=10% align=center class='text'>";

				echo "<b>Fim da Relação</b>";

				echo "</td>";
				
				echo "<td width=5% align=center class='text'>";

				echo "<b>Gerar</b>";

				echo "</td>";

            echo "</tr>";
			$numcod = 0;
			
			
				
				
			
				
				
			
			echo "<tr>";
		
				?>
				<td align=center class='text roundbordermix curhand'>
                
                
<?php

                    echo "<select name='razao_social' style='width: 100%'>
                	
                    		<option></option>
						";	
							
							for($x=0;$x<$destratonum;$x++){
								
								echo "<option value='".$destrato[$x][cliente_id]."'>".str_pad($destrato[$x][cliente_id], 4,"0",STR_PAD_LEFT)." - ".$destrato[$x]['razao_social']."</option>";
								
							}
                
                	echo "</select>";

                echo "</td>";



				?>
				<td align=center class='text roundbordermix curhand'>
                
				<?php

				echo "<input type='text' size=9 maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" name='data_pedido_rescisao'>";

                echo "</td>";
				
				
				
				?>
				<td align=center class='text roundbordermix curhand'>
<?php

                   echo "<input type='text' size=9 maxlength='10' OnKeyPress=\"formatar(this, '##/##/####')\" name='data_fim_relacao'>";

                echo "</td>";
				
				
				
				?>
				
<?php
				
				
				
				echo "<td align=center class='text roundbordermix curhand'>";


                    echo "<input type='submit' name='save_new' value='Salvar'>";

                echo "</td>";




				?>
				
<?php

			
			echo "</tr>";
			
			
			
		echo "</table>";
		
		echo "</form>";

  

    echo "<td>";

    echo "</tr>";

    echo "</table>";




?>
</body>
</html>