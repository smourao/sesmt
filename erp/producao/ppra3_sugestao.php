<?php 
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "ppra_functions.php";

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

if($_GET){
	$cliente = $_GET["cliente"];
	$setor   = $_GET["setor"];
	$fid  = $_GET["fid"];
}
else{
	$cliente = $_POST["cliente"];
	$setor   = $_POST["setor"];
	$fid  = $_POST["fid"];
}
if($_GET[fid]){
	$sql = "SELECT l.*
			FROM funcionarios f, cgrt_func_list l 
			WHERE f.cod_cliente = l.cod_cliente
			AND f.cod_func = l.cod_func
			AND f.cod_cliente = {$_GET[cliente]}
			AND f.cod_func = {$_GET['fid']}
			AND l.cod_setor = {$_GET['setor']}
			AND l.cod_cgrt = {$_GET[id_ppra]}";
	$r = pg_query($sql);
	
	if(pg_num_rows($r)<=0){
		$sql = "SELECT l.*
		FROM funcionarios f, cgrt_func_list l
		WHERE f.cod_cliente = l.cod_cliente
		AND f.cod_func = l.cod_func
		AND f.cod_cliente = {$_GET[cliente]}
		AND l.cod_cgrt = {$_GET[id_ppra]}
		AND f.cod_func = {$_GET['fid']}
		AND
		(l.cod_setor = {$_GET['setor']} OR l.setor_adicional LIKE '{$_GET['setor']}|%' OR l.setor_adicional LIKE '%|{$_GET['setor']}|%')";
		$r = pg_query($sql);
	}
}else{
	$sql = "SELECT l.*
			FROM funcionarios f, cgrt_func_list l 
			WHERE f.cod_cliente = l.cod_cliente
			AND f.cod_func = l.cod_func
			AND f.cod_cliente = {$_GET[cliente]}
			--AND f.cod_func = {$_GET['fid']}
			AND l.cod_setor = {$_GET['setor']}
			AND l.cod_cgrt = {$_GET[id_ppra]}";
	$r = pg_query($sql);
	
	if(pg_num_rows($r)<=0){
		$sql = "SELECT l.*
		FROM funcionarios f, cgrt_func_list l
		WHERE f.cod_cliente = l.cod_cliente
		AND f.cod_func = l.cod_func
		AND f.cod_cliente = {$_GET[cliente]}
		AND l.cod_cgrt = {$_GET[id_ppra]}
		--AND f.cod_func = {$_GET['fid']}
		AND
		(l.cod_setor = {$_GET['setor']} OR l.setor_adicional LIKE '{$_GET['setor']}|%' OR l.setor_adicional LIKE '%|{$_GET['setor']}|%')";
		$r = pg_query($sql);
	}
}
$row = pg_fetch_all($r);
$cod_f =  $row[0]['cod_funcao'];
//echo "-->".$sql;
//echo "<br>-->".$cod_f;

/************ INICIO DA INCLUSÃO *************/
if(!empty($cliente) and !empty($setor) and $_POST){
    if(isset($cod_f)){
    ppra_progress_update($cliente, $setor);
    for($x=0;$x<count($_POST[tmp]);$x++){
        if($_POST[data][$x] == ""){
    	    $dataz = date("{$ano}-m-d");//"null";
    	}else{
    	    $dt = explode("/", $_POST[data][$x]);
    		if(count($dt)>2){
    		   $dataz = "".$dt[2] = $ano."-".$dt[1]."-".$dt[0]."";//se for informado com 3 valores
    		}else{
       		   $dataz = "".$dt[1] = $ano."-".$dt[0]."-01";//se for informado com 2 valores
    		}
    	}

    		$sql_verifica = "SELECT * FROM sugestao
    						WHERE cod_setor               = {$setor}
    						AND med_prev                  = {$_POST[tmp][$x]}
                            AND id_ppra                   = $_GET[id_ppra]";
    		$result_verifica = pg_query($sql_verifica);

    		if (pg_num_rows($result_verifica)==0 ){
    		$query_medida = "INSERT INTO sugestao (cod_cliente, cod_funcao, cod_setor, med_prev, plano_acao, data, id_ppra)
    											  VALUES
    											  ({$cliente}, {$cod_f}, {$setor}, '{$_POST[tmp][$x]}', '{$_POST[plano_acao][$x]}', '{$dataz}', $_GET[id_ppra]);";
    		$result_medida = pg_query($query_medida);
    		//echo $query_medida;
    		}else{
    			$query_medida = "UPDATE sugestao SET
    							plano_acao = '{$_POST[plano_acao][$x]}',
    							data = '{$dataz}'
    							WHERE
                                cod_setor = $setor
    							and med_prev = {$_POST[tmp][$x]}
    							and id_ppra = $_GET[id_ppra]";
    			$result_medida = pg_query($query_medida);
    		}
    }
    if($result_medida)
        echo '<script> alert("Os dados foram alterados com sucesso!");</script>';
    else
        echo '<script> alert("Não foi possivel armazenar os dados informados!");</script>';
    }else{
        echo '<script> alert("Não foi possivel armazenar os dados informados, pois não existem funcionários no setor!");</script>';
    }
}
/******************** DADOS DO CLIENTE **********************/
if(!empty($cliente)){
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco, func_terc
    FROM cliente c, cliente_setor cs
    where cs.cod_cliente = c.cliente_id
    and cs.id_ppra = $_GET[id_ppra]
    and cs.cod_setor = $_GET[setor]";
	$result_cli = pg_query($query_cli);
}

/*************** DADOS DO SETOR DO CLIENTE ****************/
if(!empty($setor)){
	$query_set = "SELECT cod_setor, desc_setor, nome_setor
				  FROM setor where cod_setor = $setor";
	$result_set = pg_query($query_set);
}
?>
<html>
<head>
<title>Sugestões</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<style type="text/css">
<!--
.style1 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size:12px;}
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_medida_produto" method="POST">
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
    <tr>
		<th bgcolor="#009966" colspan=2>
			<br> CADASTRO DE MEDIDAS PREVENTIVAS <br>&nbsp;		</th>
    </tr>
	<?php 
	if($result_cli){
		$row_cli = pg_fetch_array($result_cli);
	?>
		<tr>
			<td bgcolor=#FFFFFF colspan=2>
				<br> <font color="black">
				&nbsp;&nbsp;&nbsp; Nome do Cliente: <b><?php echo $row_cli[razao_social]; ?></b> <br>
				&nbsp;&nbsp;&nbsp; Endereço: 		<b><?php echo $row_cli[endereco]; 	  ?></b> <br>
				&nbsp;&nbsp;&nbsp; Bairro:   		<b><?php echo $row_cli[bairro]; 	  ?></b> <br>
				&nbsp;&nbsp;&nbsp; Telefone: 		<b><?php echo $row_cli[telefone];     ?></b> <br>
				&nbsp;&nbsp;&nbsp; E-mail:   		<b><?php echo $row_cli[email]; 		  ?></b> <hr>			
				</font> </td>
		</tr>
	<?php 
	}
	if($result_set){
		$row_set = pg_fetch_array($result_set);
	?>
		<tr>
			<td bgcolor=#FFFFFF colspan=2>
				<font color="black">
				&nbsp;&nbsp;&nbsp; Nome do Setor:	   <b> <?php echo $row_set[nome_setor]; ?></b> <br>
				&nbsp;&nbsp;&nbsp; Descrição do Setor: <b> <?php echo $row_set[desc_setor]; ?></b> <hr>
				</font>			</td>
		</tr>
	<?php 
	}
	
	$sql = "SELECT * FROM cgrt_func_list WHERE cod_cgrt = $_GET[id_ppra] AND cod_setor = $_GET[setor] AND cod_cliente = $_GET[cliente]";
	$rfl = pg_query($sql);
	
	if (!empty($setor) && !empty($cliente)){
	
	  if(pg_num_rows($rfl) > 0 && empty($row_cli[func_terc]) && $cod_f){
        //LISTA POR FUNÇÃO
		$sql_epi = "SELECT * FROM funcao_epi  
					WHERE cod_epi={$cod_f}";
		$result_epi = pg_query($sql_epi);

        $sql_medi = "SELECT * FROM funcao_medi
					WHERE cod_medi={$cod_f}";
		$result_medi = pg_query($sql_medi);
		
		$sql_curso = "SELECT * FROM funcao_curso  
					WHERE cod_curso={$cod_f}";
		$result_curso = pg_query($sql_curso);
			
		$sql_ambiental = "SELECT * FROM funcao_ambiental  
					WHERE cod_funcao={$cod_f}";
		$result_ambiental = pg_query($sql_ambiental);

		$sql_prog = "SELECT * FROM funcao_programas  
					WHERE cod_funcao={$cod_f}";
		$result_prog = pg_query($sql_prog);
      }
		//LISTA POR SETORES
		$sql = "SELECT * FROM setor_epi
					WHERE cod_setor = $setor";
		$r_setor_epi = pg_query($sql);
		
        $sql = "SELECT * FROM setor_medi
					WHERE cod_setor = $setor";
		$r_setor_medi = pg_query($sql);
		
		$sql = "SELECT * FROM setor_curso
					WHERE cod_setor = $setor";
		$r_setor_curso = pg_query($sql);
		
		$sql = "SELECT * FROM setor_ambiental
					WHERE cod_setor = $setor";
		$r_setor_ambiental = pg_query($sql);
		
		$sql = "SELECT * FROM setor_programas
					WHERE cod_setor = $setor";
		$r_setor_programas = pg_query($sql);

		echo "<table width=\"760\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" align=\"center\">
			   <tr>
			 	<td colspan=3 bgcolor=\"#009966\"><center><h2 class=\"style3\" >Medidas Preventivas</h2></center></td>
	 		  </tr><br>
				<tr>
				<td align=\"left\" class=\"fontebranca12\">";
			
			    $aepi = array();
			    $amedi = array();
			    $acurso = array();
			    $aambiental = array();
			    $aprogramas = array();
			    //EPI FUNÇÃO
				while($row_epi=@pg_fetch_array($result_epi)){
					//$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_epi[id]} and EXTRACT(year from data) = {$ano}";
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_epi[id]} and id_ppra = {$_GET[id_ppra]}";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					$aepi[] = trim($row_epi[descricao]);
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">&nbsp;$row_epi[descricao]<br></td>
					<td class=fontebranca12><select name=plano_acao[]>
					<option value=0";
					   if($row_sql[plano_acao] == 0){ echo " selected ";} 
					echo ">Sugerido</option>
					<option value=1";
					   if($row_sql[plano_acao] == 1){ echo " selected ";} 
					echo ">Existente</option>
					</select></td>
					<td><input tipe=text size=8 name=data[] value=";
					if($row_sql[data] && $row_sql[plano_acao] != 0){
					    echo date("m/Y", strtotime($row_sql[data]));
					}
					echo "></td>
					<input type=hidden name=tmp[] value=$row_epi[id]></tr>";
				}
                //EPI SETOR
				while($setor_epi=pg_fetch_array($r_setor_epi)){
					//$sql = "SELECT * FROM sugestao WHERE cod_cliente = $cliente and cod_setor = $setor and med_prev = {$setor_epi[id]} and EXTRACT(year from data) = {$ano}";
					$sql = "SELECT * FROM sugestao WHERE cod_cliente = $cliente and cod_setor = $setor and med_prev = {$setor_epi[id]} and id_ppra = $_GET[id_ppra]";
					$result_sql = pg_query($sql);
					$row_sql = pg_fetch_array($result_sql);
                    if(!in_array(trim($setor_epi[descricao]), $aepi)){
					    echo "<tr>
    					<td align=\"left\" class=\"fontebranca12\">&nbsp;$setor_epi[descricao]<br></td>
    					<td class=fontebranca12><select name=plano_acao[]>
    					<option value=0";
    					   if($row_sql[plano_acao] == 0){ echo " selected ";}
    					echo ">Sugerido</option>
    					<option value=1";
    					   if($row_sql[plano_acao] == 1){ echo " selected ";}
    					echo ">Existente</option>
    					</select></td>
    					<td><input tipe=text size=8 name=data[] value=";
    					if($row_sql[data] && $row_sql[plano_acao] == 0){
    					    echo date("m/Y", strtotime($row_sql[data]));
    					}
    					echo "></td>
    					<input type=hidden name=tmp[] value=$setor_epi[id]></tr>";
					}
				}
                //FUNÇÃO CURSO
				while($row_curso=@pg_fetch_array($result_curso)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_curso[id]} and id_ppra = $_GET[id_ppra]";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					$acurso[] = trim($row_curso[descricao]);
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">&nbsp;$row_curso[descricao]<br></td>
					<td class=fontebranca12><select name=plano_acao[]>
					<option value=0";
					   if($row_sql[plano_acao] == 0){ echo " selected ";} 
					echo ">Sugerido</option>
					<option value=1";
					   if($row_sql[plano_acao] == 1){ echo " selected ";} 
					echo ">Existente</option>
					</select></td>
					<td><input tipe=text size=8 name=data[] value=";
					if($row_sql[data] && $row_sql[plano_acao] == 0){
					    echo date("m/Y", strtotime($row_sql[data]));
					}
					echo "></td>
					<input type=hidden name=tmp[] value=$row_curso[id]></tr>";
				}
				//SETOR CURSO
				while($setor_curso=pg_fetch_array($r_setor_curso)){
					$sql = "SELECT * FROM sugestao WHERE cod_cliente = $cliente and cod_setor = $setor and med_prev = {$setor_curso[id]} and id_ppra = $_GET[id_ppra]";
					$result_sql = pg_query($sql);
					$row_sql = pg_fetch_array($result_sql);
                    if(!in_array(trim($setor_curso[descricao]), $acurso)){
					    echo "<tr>
    					<td align=\"left\" class=\"fontebranca12\">&nbsp;$setor_curso[descricao]<br></td>
    					<td class=fontebranca12><select name=plano_acao[]>
    					<option value=0";
    					   if($row_sql[plano_acao] == 0){ echo " selected ";}
    					echo ">Sugerido</option>
    					<option value=1";
    					   if($row_sql[plano_acao] == 1){ echo " selected ";}
    					echo ">Existente</option>
    					</select></td>
    					<td><input tipe=text size=8 name=data[] value=";
    					if($row_sql[data] && $row_sql[plano_acao] == 0){
    					    echo date("m/Y", strtotime($row_sql[data]));
    					}
    					echo "></td>
    					<input type=hidden name=tmp[] value=$setor_curso[id]></tr>";
					}
				}
				//FUNÇÃO AMBIENTAL
				while($row_ambiental=@pg_fetch_array($result_ambiental)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_ambiental[id]} and id_ppra = $_GET[id_ppra]";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					$aambiental[] = trim($row_ambiental[descricao]);
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">&nbsp;$row_ambiental[descricao]<br></td>
					<td class=fontebranca12><select name=plano_acao[]>
					<option value=0";
					   if($row_sql[plano_acao] == 0){ echo " selected ";} 
					echo ">Sugerido</option>
					<option value=1";
					   if($row_sql[plano_acao] == 1){ echo " selected ";} 
					echo ">Existente</option>
					</select></td>
					<td><input tipe=text size=8 name=data[] value=";
					if($row_sql[data] && $row_sql[plano_acao] == 0){
					    echo date("m/Y", strtotime($row_sql[data]));
					}
					echo "></td>
					<input type=hidden name=tmp[] value=$row_ambiental[id]></tr>";
				}
                //SETOR AMBIENTAL
				while($setor_ambiental=@pg_fetch_array($r_setor_ambiental)){
					$sql = "SELECT * FROM sugestao WHERE cod_cliente = $cliente and cod_setor = $setor and med_prev = {$setor_ambiental[id]} and id_ppra = $_GET[id_ppra]";
					$result_sql = pg_query($sql);
					$row_sql = pg_fetch_array($result_sql);
                    if(!in_array(trim($setor_ambiental[descricao]), $aambiental)){
					    echo "<tr>
    					<td align=\"left\" class=\"fontebranca12\">&nbsp;$setor_ambiental[descricao]<br></td>
    					<td class=fontebranca12><select name=plano_acao[]>
    					<option value=0";
    					   if($row_sql[plano_acao] == 0){ echo " selected ";}
    					echo ">Sugerido</option>
    					<option value=1";
    					   if($row_sql[plano_acao] == 1){ echo " selected ";}
    					echo ">Existente</option>
    					</select></td>
    					<td><input tipe=text size=8 name=data[] value=";
    					if($row_sql[data] && $row_sql[plano_acao] == 0){
    					    echo date("m/Y", strtotime($row_sql[data]));
    					}
    					echo "></td>
    					<input type=hidden name=tmp[] value=$setor_ambiental[id]></tr>";
					}
				}
				//FUNÇÃO PROGRAMAS
				while($row_prog=@pg_fetch_array($result_prog)){
					$sql = "SELECT * FROM sugestao WHERE cod_funcao={$cod_f} and med_prev = {$row_prog[id]} and id_ppra = $_GET[id_ppra]";
					$result_sql = pg_query($connect, $sql);
					$row_sql = pg_fetch_array($result_sql);
					$aprogramas[] = trim($row_prog[descricao]);
					echo "<tr>
					<td align=\"left\" class=\"fontebranca12\">&nbsp;$row_prog[descricao]<br></td>
					<td class=fontebranca12><select name=plano_acao[]>
					<option value=0";
					   if($row_sql[plano_acao] == 0){ echo " selected ";}
					echo ">Sugerido</option>
					<option value=1";
					   if($row_sql[plano_acao] == 1){ echo " selected ";}
					echo ">Existente</option>
					</select></td>
					<td><input tipe=text size=8 name=data[] value=";
					if($row_sql[data] && $row_sql[plano_acao] == 0){
					    echo date("m/Y", strtotime($row_sql[data]));
					}
					echo "></td>
					<input type=hidden name=tmp[] value=$row_prog[id]></tr>";
				}
				//SETOR PROGRAMAS
				while($setor_programas=pg_fetch_array($r_setor_programas)){
					$sql = "SELECT * FROM sugestao WHERE cod_cliente = $cliente and cod_setor = $setor and med_prev = {$setor_programas[id]} and id_ppra = $_GET[id_ppra]";
					$result_sql = pg_query($sql);
					$row_sql = pg_fetch_array($result_sql);
                    if(!in_array(trim($setor_programas[descricao]), $aprogramas)){
					    echo "<tr>
    					<td align=\"left\" class=\"fontebranca12\">&nbsp;$setor_programas[descricao]<br></td>
    					<td class=fontebranca12><select name=plano_acao[]>
    					<option value=0";
    					   if($row_sql[plano_acao] == 0){ echo " selected ";}
    					echo ">Sugerido</option>
    					<option value=1";
    					   if($row_sql[plano_acao] == 1){ echo " selected ";}
    					echo ">Existente</option>
    					</select></td>
    					<td><input tipe=text size=8 name=data[] value=";
    					if($row_sql[data] && $row_sql[plano_acao] == 0){
    					    echo date("m/Y", strtotime($row_sql[data]));
    					}
    					echo "></td>
    					<input type=hidden name=tmp[] value=$setor_programas[id]></tr>";
					}
				}
			echo "	 </td>";
			echo "  </tr> </table>";
	}
?>
</table>
<table align="center" width="760" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" >
	<tr>
		<td align="center">
			<br><input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="location.href='ppra3.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>&y=<?php echo $_GET['y']; ?>';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_mais" value="Gravar" style="width:100px;" >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  name="btn_voltar" value="Cancelar" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="btn_concluir" value="Avançar &gt;&gt;" style="width:100px;" onClick="location.href='ppra3_epc.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>&y=<?php echo $ano; ?>';" title="Clique aqui para avançar">
			<br>&nbsp;
		</td>
	</tr>
<input type="hidden" name="cliente" value="<?php echo $cliente; ?>" />
<input type="hidden" name="setor"   value="<?php echo $setor;   ?>" />
</table>
</form>
</body>
</html>
