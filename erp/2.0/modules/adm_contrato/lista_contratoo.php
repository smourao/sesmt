<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">

<script language="javascript">
function cStatus(id, val){
    var url = "ajax_change_status.php?id="+id;
    url = url + "&val=" + val;
    url = url + "&cache=" + new Date().getTime();//para evitar problemas com o cache
    http.open("GET", url, true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
    http.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
    http.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
    http.setRequestHeader("Pragma", "no-cache");
    http.onreadystatechange = cStatus_result;
    http.send(null);
}

function cStatus_result(){
if(http.readyState == 4)
{
    var msg = http.responseText;
    alert(msg);
}else{
    if (http.readyState==1){
        //alert('');
    }
 }
}
</script>

<style>
/* Tooltip container */
.tooltip {
    position: relative;
    display: inline-block;
    /* border-bottom: 1px dotted black;  If you want dots under the hoverable text */
}

/* Tooltip text */
.tooltip .tooltiptext {
    visibility: hidden;
    width: 300px;
    background-color: #2B8A30;
    color: #fff;
    text-align: center;
    padding: 5px 0;
	border:solid;
    border-radius: 6px;
	border-color: #61B72E;
 
    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */
.tooltip:hover .tooltiptext {
    visibility: visible;
}
</style>


</head>
<body>





<?PHP

/***************************************************************************************************/
	$contratosql = "SELECT c.razao_social, c.ano_contrato, c.email as mail, ci.* FROM site_gerar_contrato ci, cliente c WHERE
                c.cliente_id = ci.cod_cliente AND ci.status != 2 ORDER BY id";
	
	$contratoquery = pg_query($contratosql);
	
	$contrato = pg_fetch_all($contratoquery);
	
	$contratonum = pg_num_rows($contratoquery);

/***************************************************************************************************/


	
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

    echo "<tr>";

    echo "<td align=center class='text roundborderselected'>";

        

            echo "<b>Lista de Contratos</b> ";

        



    echo "</td>";

    echo "</tr>";

    echo "</table>";

    

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";

    echo "<tr>";

    echo "<td align=left class='text'>";


		
		
		 
		 echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";

            echo "<tr>";

				echo "<td width=5% align=center class='text'>";

				echo "<b>Cod</b>";

				echo "</td>";
				
				echo "<td width=30% align=center class='text'>";

                echo "<b>Razão Social</b>";

                echo "</td>";
				
				echo "<td width=15% align=center class='text'>";

				echo "<b>Contrato</b>";

				echo "</td>";
				
				echo "<td width=15% align=center class='text'>";

				echo "<b>Resumo</b>";

				echo "</td>";
				
				echo "<td width=10% align=center class='text'>";

				echo "<b>Enviar</b>";

				echo "</td>";
				
				echo "<td width=10% align=center class='text'>";

				echo "<b>Orçamento</b>";

				echo "</td>";				

                echo "<td width=15% align=center class='text'>";

                echo "<b>Status</b>";

                echo "</td>";

            echo "</tr>";
			$numcod = 0;
			
			for($x=0;$x<$contratonum;$x++){
				
				
				$numcod = $numcod + 1;
			
				$idcontrato = $contrato[$x][id];
				
				$razao_social = $contrato[$x]['razao_social'];
				
				$cod_cliente = $contrato[$x][cod_cliente];
				
				$email_cliente = $contrato[$x]['mail'];
				
				$ano_contrato = $contrato[$x][cod_orcamento]."/".$contrato[$x][ano_orcamento];
				
				$tipo_contrato = $contrato[$x]['tipo_contrato'];
				
				$sala = $contrato[$x]['atendimento_medico'];
				
				$parcelas = $contrato[$x][n_parcelas];
				
				$vencimento_contrato = date("d/m/Y", strtotime($contrato[$x]['vencimento']));
				
				$criacao_contrato = date("d/m/Y", strtotime($contrato[$x]['data_criacao']));
				
				$ultima_contrato = date("d/m/Y", strtotime($contrato[$x]['ultima_alteracao']));
				
				$random = rand(10000, 99999);
				
				$ano_num_contrato = $contrato[$x][ano_contrato].".".str_pad($contrato[$x][cod_cliente], 4, "0", 0);
				
				$orcamento_contrato = $contrato[$x][cod_orcamento]."/".$contrato[$x][ano_orcamento];
				
				$status = $contrato[$x][status];
			
			echo "<tr>";
		
				?>
				<td align=center class='text roundbordermix curhand'>
<?php

                    echo $numcod;

                echo "</td>";



				?>
				<td align=center class='text roundbordermix curhand'>
<?php

echo '<a href="http://www.sesmt-rio.com/contratos/aberto.php?cod_cliente='.$cod_cliente.'&cid='.$ano_contrato.'&tipo_contrato='.$tipo_contrato.'&sala='.$sala.'&parcelas='.$parcelas.'&vencimento='.$vencimento_contrato.'&rnd='.$random.'" target="_blank">'.$razao_social;

                echo "</td>";
				
				
				
				?>
				<td align=center class='text roundbordermix curhand' onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&edittable=".$idmaterial."" ?>'">
<?php

                    echo "<div class='tooltip'>".$ano_num_contrato;
					echo "<span class='tooltiptext'><center><b>".$razao_social."</b></center><p><b>Vencimento: </b>".$vencimento_contrato."<br><b>Data de Criação: </b>".$criacao_contrato."<br><b>Última Alteração: </b>".$ultima_contrato."</span>";
					echo "</div>";

                echo "</td>";
				
				
				
				?>
				<td align=center class='text roundbordermix curhand' onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&action=propriedade&cod_cliente=".$cod_cliente."" ?>'">
<?php

                    echo "Visualizar";

                echo "</td>";
				
				
				
				
				
				echo "<td align=center class='text roundbordermix curhand' onClick=\" if(mail = prompt('Digite o E-Mail que receberá o orçamento:','$email_cliente')) { location.href='?dir=adm_contrato&p=index&en=1&mail='+mail+'&cod_cliente={$cod_cliente}&cid={$ano_contrato}&tipo_contrato={$tipo_contrato}&sala={$sala}&parcelas={$parcelas}&vencimento=".$vencimento_contrato."'}\">";


                    echo "Enviar";

                echo "</td>";




				?>
				<td align=center class='text roundbordermix curhand' onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&edittable=".$idmaterial."" ?>'">
<?php

                    echo $orcamento_contrato;

                echo "</td>";

                echo "<td align=center class='text roundbordermix curhand'>";


				echo "<select id=status name=status onchange=\"cStatus('{$idcontrato}', this.value);\">";
                    echo "<option value=0"; print $status == 0 ? " selected ":" "; echo ">Aguardando</option>";
                    echo "<option value=1"; print $status == 1 ? " selected ":" "; echo ">Finalizado</option>";
                    echo "<option value=2"; print $status == 2 ? " selected ":" "; echo ">Cancelado</option>";
                echo "</select>";



                echo "</td>";
			
			echo "</tr>";
			
			}
			
		echo "</table>";

  

    echo "<td>";

    echo "</tr>";

    echo "</table>";




?>
</body>
</html>
