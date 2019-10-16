<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
</head>
<body>

<?PHP

$dataA = date("m/Y");
$dataAA = date("Y-m");
$dataAY = date("Y");
$dataAM = date("m");
$sema1 = idate('W');
$data1 = date("Y-m-d");
$ano1 = date("Y");
$mes1 = date("m");
$dia1 = date("d");

if($_GET['c']){
	
	if($_GET['v']){
		
		if(is_numeric($_GET['v'])){
	
			$update_fr = "UPDATE financeiro_relatorio SET pago = 1, valor = {$_GET['v']}, data_lancamento = '{$data1}', semana = {$sema1}, ano = {$ano1} WHERE cod_aso = {$_GET['c']}";
			
			$update_ff = "UPDATE financeiro_fatura SET pago = 1, valor = {$_GET['v']}, data_lancamento = '{$data1}' WHERE cod_aso = {$_GET['c']}";
			
			$update_fi = "UPDATE financeiro_info SET valor_total = {$_GET['v']}, data_lancamento = '{$data1}', data = '{$data1}', data_entrada_saida = '{$data1}', dia = {$dia1}, mes = {$mes1}, ano = {$ano1} WHERE cod_aso = {$_GET['c']}";
			
			pg_query($update_fr);
			
			pg_query($update_ff);
			
			if(pg_query($update_fi)){
				
				echo "<script>window.location.href = '?dir=triagem_medica&p=index';</script>";
				
			}else{
				
				echo "<script>alert('Erro: Falar com Suporte');</script>";
				echo "<script>window.location.href = '?dir=triagem_medica&p=index';</script>";
				
			}
		}else{
			echo "<script>alert('Informe um valor válido.');</script>";
		}
	}else{
		echo "<script>alert('Informe o valor do ASO.');</script>";
	}
}

if($_GET['del']){

$q1 = "DELETE FROM aso_avulso WHERE cod_aso = {$_GET['del']}";
$q2 = "DELETE FROM financeiro_relatorio WHERE cod_aso = {$_GET['del']}";
$q3 = "DELETE FROM financeiro_fatura WHERE cod_aso = {$_GET['del']}";
$q4 = "DELETE FROM financeiro_info WHERE cod_aso = {$_GET['del']}";

pg_query($q1);
pg_query($q2);
pg_query($q3);
pg_query($q4);

echo "<script>window.location.href = '?dir=triagem_medica&p=index';</script>";

}

/***************************************************************************************************/

if($_GET['semana']){
	$semana = $_GET['semana'];
}else{
	$consultasql = "SELECT * FROM financeiro_relatorio WHERE ano = ".date('Y')." ORDER BY id DESC LIMIT 1";
	$consultaquery = pg_query($consultasql);
	$consulta = pg_fetch_array($consultaquery);
	$semana = $consulta['semana'];
}



	$triagemasosql = "SELECT fr.cod_aso, fr.pago, av.cod_aso, av.razao_social_cliente, av.data, fr.valor
	FROM aso_avulso as av
	LEFT JOIN financeiro_relatorio as fr ON av.cod_aso = fr.cod_aso
	WHERE (SELECT DATE_PART('YEAR', CURRENT_TIMESTAMP) AS data_lancamento) = '{$dataAY}'
	AND (SELECT DATE_PART('MONTH', CURRENT_TIMESTAMP) AS data_lancamento) = '{$dataAM}'
	AND semana = {$semana}
	ORDER BY av.cod_aso DESC";
	
	$triagemasoquery = pg_query($triagemasosql);
	
	$triagemaso = pg_fetch_all($triagemasoquery);
	
	$triagemasonum = pg_num_rows($triagemasoquery);

/***************************************************************************************************/


	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Lista de ASO</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";


		
		
		 
		 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";
			
			if($_SESSION[usuario_id] == 1 || $_SESSION[usuario_id] == 4 || $_SESSION[usuario_id] == 18 || $_SESSION[usuario_id] == 43 ){

				echo "<td width=8% align=center class='text'>";
	
			}else{
				
				echo "<td width=20% align=center class='text'>";
				
			}
			
				echo "<b>Cod</b>";

				echo "</td>";

				echo "<td width=60% align=center class='text'>";

                echo "<b>Razão Social</b>";

                echo "</td>";

                echo "<td width=18% align=center class='text'>";

                echo "<b>Migrar</b>";

                echo "</td>";
				
				if($_SESSION[usuario_id] == 1 || $_SESSION[usuario_id] == 4 || $_SESSION[usuario_id] == 18 || $_SESSION[usuario_id] == 43 ){
				
				echo "<td width=9% align=center class='text'>";

				echo "<b>Excluir</b>";

				echo "</td>";
				
				}

            echo "</tr>";
			$numcod = 0;
			
			for($x=0;$x<$triagemasonum;$x++){
			
				$idaso = $triagemaso[$x][cod_aso];
			
			
		
				?>
				
				<tr>
				
				<td align=center class='text roundbordermix curhand' onClick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&editar=".$idaso ?>'">
<?php

                    echo $idaso;

                echo "</td>";

				?>


<td align=center class='text roundbordermix curhand' onClick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&editar=".$idaso ."&semana=$_GET[semana]" ?>'">
<?php

                    echo $triagemaso[$x]['razao_social_cliente'];

                echo "</td>";

                echo "<td align=center class='text roundbordermix'>";

				if(isset($triagemaso[$x]['pago'])){
				
					if($triagemaso[$x]['pago'] == 0){
?>
						<input class="btn" type="button" value="Migrar!" onclick="Migrar(<?php echo $triagemaso[$x]['valor']; ?>, <?php echo $triagemaso[$x]['cod_aso']; ?>)">

<?php
					}else{
						if($_SESSION[usuario_id] == 1 || $_SESSION[usuario_id] == 4 || $_SESSION[usuario_id] == 18 || $_SESSION[usuario_id] == 43 ){
							
							
							?>
							
							<input type="button" value="Migrado (Alterar)" onclick="Migrar(<?php echo $triagemaso[$x]['valor']; ?>, <?php echo $triagemaso[$x]['cod_aso']; ?>)">
							
							<?php
							
						}else{
							echo "Migrado";
						}
						
					}
				
				}else{
					echo "Migrado";
				}

                echo "</td>";
				
				if($_SESSION[usuario_id] == 1 || $_SESSION[usuario_id] == 4 || $_SESSION[usuario_id] == 18 || $_SESSION[usuario_id] == 43 ){
				
				echo "<td align=center class='text roundbordermix'>";

				?>
							
							<a onclick="Excluir(<?php echo $triagemaso[$x]['cod_aso']; ?>)" href="#">Excluir</a>
							
							<?php

				echo "</td>";
				
				}
			
			echo "</tr>";
			
			}
			
		echo "</table>";

  

    echo "<td>";

    echo "</tr>";

    echo "</table>";




?>
</body>
<script>
function Migrar(valor, cod) {
    var confirma = prompt("Confirme o Valor do ASO:", valor);
    if (confirma != null) {
		window.location = "?dir=triagem_medica&p=index&lista=true&v=" + confirma + "&c=" + cod;
	}
}
function Excluir(cod) {
    var confirma = confirm("Deseja realmente excluir o ASO " + cod + "?");
    if (confirma == true) {
		window.location = "?dir=triagem_medica&p=index&lista=true&del=" + cod;
	}
}
</script>
</html>
